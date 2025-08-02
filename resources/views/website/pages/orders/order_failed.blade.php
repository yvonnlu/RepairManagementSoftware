@extends('website.layout.app')

@section('content')
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white shadow-lg rounded-lg p-8 text-center">
            <h1 class="text-3xl font-bold text-red-600 mb-4">
                @if (isset($payment_method) && $payment_method === 'cod')
                    Order Failed!
                @else
                    Payment Failed!
                @endif
            </h1>
            <p class="mb-2">Sorry, your payment could not be processed.</p>
            @if (isset($error))
                <div class="text-gray-700 mb-2">
                    <span class="font-semibold">Reason:</span> {{ $error }}
                </div>
            @endif
            @if (isset($vnp_ResponseCode))
                <div class="text-gray-500 text-sm mb-4">
                    (VNPay Code: <span class="font-mono">{{ $vnp_ResponseCode }}</span>)
                </div>
            @endif
            <a href="{{ route('home.index') }}" class="mt-6 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg">Back to
                Home</a>
        </div>
    </div>
@endsection
