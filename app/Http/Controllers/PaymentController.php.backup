<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function checkout()
    {
        // You can pass data to the view as needed
        return view('website.pages.orders.checkout');
    }

    public function submit(Request $request)
    {
        // Here you would handle validation, order creation, etc.
        // For now, just redirect home with a success message.
        return redirect()->route('home.index')->with('success', 'Order placed successfully!');
    }
}
