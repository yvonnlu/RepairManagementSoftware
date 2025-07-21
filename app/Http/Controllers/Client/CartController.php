<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\admin\Services;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index()
    {
        $cart = session()->get('cart', []);
        return view('website.pages.cart', ['cart' => $cart]);
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
}
