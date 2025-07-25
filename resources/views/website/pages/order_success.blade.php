@extends('website.layout.app')

@section('content')
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white shadow-lg rounded-lg p-8 text-center">
            <svg class="mx-auto mb-4 w-16 h-16 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2l4 -4m5 2a9 9 0 1 1-18 0a9 9 0 0 1 18 0z" />
            </svg>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Payment Successful!</h2>
            <p class="text-gray-600 mb-6">Thank you for your order. We have received your order and will contact you as soon
                as possible.</p>
            <a href="{{ route('home.index') }}"
                class="inline-block px-6 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition">Back to
                Home</a>
        </div>
    </div>
@endsection
