@extends('website.layout.app')

@section('content')
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white shadow-lg rounded-lg p-8 text-center">
            <h1 class="text-3xl font-bold text-red-600 mb-4">Order Failed!</h1>
            <p>There was a problem processing your order. Please try again or contact support.</p>
            <a href="{{ route('home.index') }}" class="mt-6 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg">Back to Home</a>
        </div>
    </div>
@endsection
