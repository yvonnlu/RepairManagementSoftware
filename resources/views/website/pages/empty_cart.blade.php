@extends('website.layout.app')
@section('content')
    <div class="container mx-auto px-4 py-20 flex flex-col items-center justify-center min-h-[60vh]">
        <div class="bg-white rounded-xl shadow-lg p-10 flex flex-col items-center">
            <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="Empty Cart"
                class="w-32 h-32 mb-6 opacity-80">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Your cart is empty</h2>
            <p class="text-gray-500 mb-6 text-center">You have not added any services to your cart yet.<br>Start exploring
                and add services to place an order.</p>
            <a href="{{ route('service.index') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition">Browse
                Services</a>
        </div>
    </div>
@endsection
