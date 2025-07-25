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

    public function index()
    {
        $cart = session()->get('cart', []);
        return view('website.pages.cart', ['cart' => $cart]);
    }

    // public function checkout()
    // {
    //     $user = Auth::user();
    //     $cart = session()->get('cart');

    //     return view('website.pages.checkout', ['user' => $user, 'cart' => $cart]);
    // }
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
            return view('website.pages.empty_cart');
        }
        return view('website.pages.checkout', ['user' => $user, 'cart' => $cart]);
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
        // Debug: check cart and request data
        // dd($cart, $request->all());
        // dd($request->all(), session()->get('cart', []));
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
            // Nếu cart rỗng nhưng có service_id (đặt hàng trực tiếp từ service)
            if (empty($cart) && $request->has('service_id')) {
                $service = Services::findOrFail($request->input('service_id'));
                $cart = [
                    $service->id => [
                        'device_type_name' => $service->device_type_name,
                        'issue_category_name' => $service->issue_category_name,
                        'qty' => 1,
                        'price' => $service->base_price,
                    ]
                ];
            }
            // Nếu cart vẫn rỗng thì không tạo order, trả về view empty_cart và dừng hàm
            if (empty($cart)) {
                return view('website.pages.empty_cart');
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

            // Gửi mail cho customer và admin với mọi phương thức thanh toán
            try {
                Mail::to('nguyetnghialu@gmail.com')->send(new OrderEmailCustomer($order));
                Mail::to('lunguyetnghia@gmail.com')->send(new OrderEmailAdmin($order));
            } catch (\Exception $mailEx) {
                Log::error('Mail send failed: ' . $mailEx->getMessage());
            }

            //Empty cart
            session()->put('cart', []);

            //Minus qty of product
            foreach ($order->orderItems as $orderItem) {
                $service = Services::find($orderItem->service_id);
                // $service->qty -= $orderItem->qty;
                $service->save();
            }

            if ($request->payment_method === 'vnpay') {
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $startTime = date("YmdHis");
                $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

                $vnp_TxnRef = $order->id;
                $vnp_Amount = $order->total;
                $vnp_Locale = 'vn';
                $vnp_BankCode = 'VNBANK';
                $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
                $vnp_HashSecret = env('VNPAY_HASHSECRET');

                $inputData = array(
                    "vnp_Version" => "2.1.0",
                    "vnp_TmnCode" => env('VNPAY_TMNCODE'),
                    "vnp_Amount" => $vnp_Amount * 100 * 23500,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $vnp_IpAddr,
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef,
                    "vnp_OrderType" => "other",
                    "vnp_ReturnUrl" => env('VNPAY_RETURNURL'),
                    "vnp_TxnRef" => $vnp_TxnRef,
                    "vnp_ExpireDate" => $expire,
                    "vnp_BankCode" => $vnp_BankCode,
                );

                ksort($inputData);
                $query = "";
                $i = 0;
                $hashdata = "";
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                    } else {
                        $hashdata .= urlencode($key) . "=" . urlencode($value);
                        $i = 1;
                    }
                    $query .= urlencode($key) . "=" . urlencode($value) . '&';
                }

                $vnp_Url = env('VNPAY_URL') . "?" . $query;

                if (isset($vnp_HashSecret)) {
                    $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
                    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                }

                return redirect()->to($vnp_Url);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order failed: ' . $e->getMessage());
            return view('website.pages.order_failed', ['error' => $e->getMessage()]);
        }

        return redirect()->route('order.success');
    }
}
