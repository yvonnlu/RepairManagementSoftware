@extends('website.layout.app')
@section('content')
    <div class="container mx-auto px-4 py-12 mt-20">

        {{-- <form id="checkout-form" method="POST" action="{{ route('checkout.submit') }}"> --}}
        <form action="{{ route('cart.place-order') }}" method="post">
            @csrf
            @if (request()->has('service_id'))
                <input type="hidden" name="service_id" value="{{ request('service_id') }}">
            @endif
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Customer Info -->
                <div class="md:col-span-1 bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold mb-4">Customer Information</h2>
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Full Name</label>
                        <input type="text" name="name" value="{{ $user->name }}"
                            class="w-full border rounded-lg px-3 py-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Address</label>
                        <input type="text" name="address" value="{{ $user->address }}"
                            class="w-full border rounded-lg px-3 py-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Phone Number</label>
                        <input type="text" name="phone_number" value="{{ $user->phone_number }}"
                            class="w-full border rounded-lg px-3 py-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}"
                            class="w-full border rounded-lg px-3 py-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Note</label>
                        <textarea name="note" class="w-full border rounded-lg px-3 py-2" rows="3"
                            placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                    </div>
                </div>

                <!-- Order Info -->
                <div class="md:col-span-1 bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold mb-4">Order Information</h2>
                    <div class="divide-y">
                        @php $priceTotal = 0 @endphp
                        @foreach ($cart as $item)
                            @php
                                $priceItem = $item['price'] * $item['qty'];
                                $priceTotal += $priceItem;
                            @endphp
                            <div class="py-4 flex justify-between items-center">
                                <div>
                                    <div class="font-semibold">{{ $item['device_type_name'] }}</div>
                                    <div class="text-sm text-gray-500">{{ $item['issue_category_name'] ?? '' }}</div>
                                    <div class="text-sm text-gray-500">Qty: {{ $item['qty'] }}</div>
                                </div>
                                <div class="font-bold text-blue-600">${{ number_format($item['price'], 2) }}</div>
                            </div>
                        @endforeach
                    </div>
                    <div class="border-t pt-4 mt-4">
                        <div class="flex justify-between font-semibold">
                            <span>Subtotal</span>
                            <span>${{ number_format($priceTotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between font-bold text-lg mt-2">
                            <span>Total</span>
                            <span>${{ number_format($priceTotal, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="md:col-span-1 bg-white rounded-xl shadow-lg p-6 flex flex-col justify-between">
                    <div>
                        <h2 class="text-xl font-bold mb-4">Payment Method</h2>
                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="payment_method" value="vnpay" class="form-radio" required>
                                <span class="ml-2">VN Pay</span>
                            </label>
                        </div>
                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="payment_method" value="cod" class="form-radio" required>
                                <span class="ml-2">Cash on Delivery (COD)</span>
                            </label>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold text-lg mt-6 hover:bg-blue-700 transition">Place
                        Order</button>
                </div>
            </div>

        </form>
    </div>
@endsection
