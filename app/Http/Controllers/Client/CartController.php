<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\OrderEmailAdmin;
use App\Mail\OrderEmailCustomer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPaymentMethod;
use App\Models\Services;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    /**
     * Map VNPay response code to human-readable description
     */
    private function mapVnpayResponseCode($code)
    {
        $map = [
            '00' => 'Transaction successful',
            '01' => 'Transaction failed: Invalid merchant',
            '02' => 'Transaction failed: Insufficient balance',
            '04' => 'Transaction failed: Card expired',
            '05' => 'Transaction failed: Incorrect password',
            '06' => 'Transaction failed: Exceeded withdrawal limit',
            '07' => 'Transaction failed: Suspicious transaction',
            '09' => 'Transaction failed: Card/account not registered for InternetBanking',
            '10' => 'Transaction failed: Incorrect authentication',
            '11' => 'Transaction failed: Transaction timeout',
            '12' => 'Transaction failed: Invalid transaction',
            '13' => 'Transaction failed: Incorrect amount',
            '24' => 'Transaction canceled by customer',
            '51' => 'Transaction failed: Insufficient funds',
            '65' => 'Transaction failed: Exceeded withdrawal frequency',
            '75' => 'Transaction failed: Exceeded number of password attempts',
            '79' => 'Transaction failed: Card not registered for service',
            '99' => 'Transaction failed: Other error',
        ];
        return $map[$code] ?? 'Unknown VNPay response code';
    }

    public function vnpayReturn(\Illuminate\Http\Request $request)
    {
        $vnp_TxnRef = $request->input('vnp_TxnRef');
        $vnp_ResponseCode = $request->input('vnp_ResponseCode');
        $orderPayment = \App\Models\OrderPaymentMethod::where('order_id', $vnp_TxnRef)->first();
        if (!$orderPayment) {
            return 'Order not found!';
        }
        $description = $this->mapVnpayResponseCode($vnp_ResponseCode);
        if ($vnp_ResponseCode === '00') {
            $orderPayment->status = 'success';
            $orderPayment->reason_failed = null;
        } else {
            $orderPayment->status = 'failed';
            $orderPayment->reason_failed = $description;
        }
        // Save response code and description if you have columns for them
        if (property_exists($orderPayment, 'vnp_response_code')) {
            $orderPayment->vnp_response_code = $vnp_ResponseCode;
        }
        if (property_exists($orderPayment, 'vnp_response_desc')) {
            $orderPayment->vnp_response_desc = $description;
        }
        $orderPayment->save();
        // Optionally, update order status as well
        $order = $orderPayment->order;
        if ($order) {
            $order->status = $orderPayment->status;
            $order->save();
        }
        // Pass description to view for user feedback
        if ($vnp_ResponseCode === '00') {
            return view('website.pages.orders.order_success', [
                'order' => $order
            ]);
        } else {
            return view('website.pages.orders.order_failed', [
                'message' => 'Order not found or payment verification failed'
            ]);
        }
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        return view('website.pages.cart.cart', ['cart' => $cart]);
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();
        $serviceId = $request->query('service_id');
        if ($serviceId) {
            $service = Services::findOrFail($serviceId);
            $cart = [
                $service->id => [
                    'device_type_name' => $service->device_type_name,
                    'issue_category_name' => $service->issue_category_name,
                    'qty' => 1,
                    'price' => $service->base_price,
                ]
            ];
        } else {
            $cart = session()->get('cart', []);
        }

        if (empty($cart)) {
            return view('website.pages.cart.empty_cart');
        }
        return view('website.pages.orders.checkout', ['user' => $user, 'cart' => $cart]);
    }

    public function addServiceToCart(Services $service)
    {
        $cart = session()->get('cart', []);

        $cart[$service->id] = [
            'device_type_name' => $service->device_type_name,
            'issue_category_name' => $service->issue_category_name,
            'price' => $service->base_price,
            'qty' => ($cart[$service->id]['qty'] ?? 0) + 1,
        ];

        session()->put('cart', $cart);

        $totalQty = array_sum(array_column($cart, 'qty'));
        $serviceQty = $cart[$service->id]['qty'];

        return response()->json([
            'message' => 'Add service to cart successfully',
            'service_qty' => $serviceQty,
            'total_qty' => $totalQty,
        ]);
    }

    public function removeFromCart(Services $service)
    {
        $cart = session()->get('cart', []);
        unset($cart[$service->id]);
        session()->put('cart', $cart);

        $totalQty = array_sum(array_column($cart, 'qty'));
        $serviceQty = isset($cart[$service->id]) ? $cart[$service->id]['qty'] : 0;

        return response()->json([
            'message' => 'Removed from cart',
            'service_qty' => $serviceQty,
            'total_qty' => $totalQty,
            'service_id' => $service->id,
        ]);
    }

    public function updateQty(Request $request, Services $service)
    {
        $cart = session()->get('cart', []);
        $qty = max(1, (int)$request->input('qty', 1));
        if (isset($cart[$service->id])) {
            $cart[$service->id]['qty'] = $qty;
            session()->put('cart', $cart);
        }
        $totalQty = array_sum(array_column($cart, 'qty'));
        $subtotal = $cart[$service->id]['qty'] * $cart[$service->id]['price'];
        $total = array_sum(array_map(function ($item) {
            return $item['qty'] * $item['price'];
        }, $cart));
        return response()->json([
            'service_qty' => $cart[$service->id]['qty'],
            'total_qty' => $totalQty,
            'subtotal' => $subtotal,
            'total' => $total,
        ]);
    }
    public function placeOrder(Request $request)
    {
        $startTime = microtime(true);

        // Debug: Log request info
        Log::info('Checkout started', [
            'service_id' => $request->input('service_id'),
            'payment_method' => $request->input('payment_method'),
            'has_cart' => !empty(session()->get('cart', []))
        ]);

        //Validation
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'address'       => 'required|string|max:255',
            'phone_number'  => 'required|string|max:20',
            'email'         => 'required|email|max:255',
            'note'          => 'nullable|string|max:1000',
            'payment_method' => 'required|in:vnpay,cod',
        ]);
        try {
            DB::beginTransaction();

            $total = 0;
            $cart = session()->get('cart', []);

            // Optimize: Handle service_id case more efficiently
            if (empty($cart) && $request->has('service_id')) {
                $serviceId = $request->input('service_id');

                // Use select to get only needed fields
                $service = Services::select('id', 'device_type_name', 'issue_category_name', 'base_price')
                    ->findOrFail($serviceId);

                $cart = [
                    $service->id => [
                        'device_type_name' => $service->device_type_name,
                        'issue_category_name' => $service->issue_category_name,
                        'qty' => 1,
                        'price' => $service->base_price,
                    ]
                ];
            }

            // Early exit if still no cart
            if (empty($cart)) {
                DB::rollBack();
                return view('website.pages.cart.empty_cart');
            }
            foreach ($cart as $item) {
                $total += $item['price'] * $item['qty'];
            }

            //Eloquent - insert record to order table
            $order = new Order();
            $order->user_id = Auth::user()->id;
            $order->address = $request->address;
            $order->note = $request->note;
            $order->status = 'pending';
            $order->subtotal = $total;
            $order->total = $total;
            $order->save(); //insert record
            if (!$order->id) {
                throw new \Exception('Order not saved!');
            }
            foreach ($cart as $serviceId => $item) {
                // - insert record to order item table
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->service_id = $serviceId;
                $orderItem->price = $item['price'];
                $orderItem->name = $item['device_type_name'] . ' - ' . $item['issue_category_name'];
                $orderItem->qty = $item['qty'];
                $orderItem->save(); //insert record
            }

            //Eloquent - Mass Assignment - insert record to order payment method table
            $orderPaymentMethod = OrderPaymentMethod::create([
                'order_id' => $order->id,
                'payment_method' => $request->payment_method,
                'total' => $total,
                'status' => 'pending'
            ]);

            //Update phone of User
            $user = User::find(Auth::user()->id);
            $user->phone_number = $request->phone_number;
            $user->address = $request->address;
            $user->save(); //update

            DB::commit();

            // Gửi mail background để không block checkout
            try {
                // Use sync send instead of queue for faster processing
                Mail::to('nguyetnghialu@gmail.com')->send(new OrderEmailCustomer($order));
                Mail::to('lunguyetnghia@gmail.com')->send(new OrderEmailAdmin($order));
            } catch (\Exception $mailEx) {
                Log::error('Mail send failed: ' . $mailEx->getMessage());
                // Don't block checkout if email fails
            }

            //Empty cart
            session()->put('cart', []);

            if ($request->payment_method === 'vnpay') {
                $processTime = round((microtime(true) - $startTime) * 1000, 2);
                Log::info('Order processed, redirecting to VNPay', [
                    'order_id' => $order->id,
                    'process_time_ms' => $processTime
                ]);

                // Optimize VNPay redirect
                return $this->redirectToVnpay($order);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order failed: ' . $e->getMessage());
            return view('website.pages.orders.order_failed', ['error' => $e->getMessage()]);
        }

        // For COD, show order_success with correct heading
        return view('website.pages.orders.order_success', [
            'message' => 'Your order has been placed successfully.',
            'payment_method' => 'cod',
        ]);
    }

    // Trang lịch sử đơn hàng
    public function orderShow()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->with(['orderItems.product'])
            ->orderByDesc('created_at')
            ->get();

        $orderList = [];
        $stt = 1;
        foreach ($orders as $order) {
            $mainItem = $order->orderItems->first();
            $deviceType = $mainItem && $mainItem->product ? $mainItem->product->device_type_name ?? '' : '';
            $issueCategory = $mainItem && $mainItem->product ? $mainItem->product->issue_category_name ?? '' : '';
            $orderList[] = [
                'stt' => $stt++,
                'updated_at' => $order->updated_at,
                'device_type_name' => $deviceType,
                'issue_category_name' => $issueCategory,
                'service_step' => $order->service_step ?? 'Not Started',
                'payment_status' => $order->status ?? 'Pending',
                'total' => $order->total,
            ];
        }

        return view('client.pages.orders', [
            'orderList' => $orderList,
        ]);
    }

    /**
     * Optimized VNPay redirect method
     */
    private function redirectToVnpay(Order $order)
    {
        try {
            $vnp_TxnRef = $order->id;
            $vnp_Amount = $order->total * 100 * 23500; // Convert to VND
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

            $inputData = [
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => env('VNPAY_TMNCODE'),
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => "vn",
                "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef,
                "vnp_OrderType" => "other",
                "vnp_ReturnUrl" => env('VNPAY_RETURNURL'),
                "vnp_TxnRef" => $vnp_TxnRef,
                "vnp_ExpireDate" => date('YmdHis', strtotime('+15 minutes')),
                "vnp_BankCode" => "VNBANK",
            ];

            ksort($inputData);
            $hashdata = http_build_query($inputData);
            $query = http_build_query($inputData);

            $vnp_Url = env('VNPAY_URL') . "?" . $query;

            $vnp_HashSecret = env('VNPAY_HASHSECRET');
            if ($vnp_HashSecret) {
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                $vnp_Url .= '&vnp_SecureHash=' . $vnpSecureHash;
            }

            // Log for debugging
            Log::info('VNPay redirect URL generated', [
                'order_id' => $order->id,
                'amount' => $vnp_Amount,
                'url_length' => strlen($vnp_Url)
            ]);

            return redirect()->to($vnp_Url);
        } catch (\Exception $e) {
            Log::error('VNPay redirect failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);

            // Fallback to order success page with error message
            return view('website.pages.orders.order_failed', [
                'error' => 'Payment gateway error. Please try again or contact support.',
                'payment_method' => 'vnpay',
            ]);
        }
    }
}
