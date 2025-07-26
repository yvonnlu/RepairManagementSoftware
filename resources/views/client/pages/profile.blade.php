@extends('client.layout.layout')

@section('sidebar')
    @include('client.blocks.sidebar')
@endsection

@section('content')
    <div class="max-w-4xl mx-auto mt-24">
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <div class="flex items-center space-x-6 mb-6">
                <div
                    class="w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                    <i data-lucide="user" class="w-12 h-12 text-white"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-gray-600">Customer since {{ $user->created_at->format('M d, Y') }}</p>
                    <div class="flex items-center space-x-1 mt-2">
                        <span class="text-sm text-gray-600">VIP Customer</span>
                    </div>
                </div>
            </div>
            @if (session('success'))
                <div id="modal-success" class="fixed inset-0 z-50 flex items-center justify-center">
                    <div class="fixed inset-0 bg-black opacity-30"></div>
                    <div class="bg-white rounded-lg shadow-lg p-8 border text-center relative z-10" tabindex="0"
                        autofocus>
                        <div class="text-green-600 text-3xl mb-2"><i data-lucide="check-circle"></i></div>
                        <div class="text-lg font-semibold mb-2">{{ session('success') }}</div>
                        <button onclick="document.getElementById('modal-success').remove()"
                            class="mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold">OK</button>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div id="modal-error" class="fixed inset-0 z-50 flex items-center justify-center">
                    <div class="fixed inset-0 bg-black opacity-30"></div>
                    <div class="bg-white rounded-lg shadow-lg p-8 border text-center relative z-10" tabindex="0"
                        autofocus>
                        <div class="text-red-600 text-3xl mb-2"><i data-lucide="x-circle"></i></div>
                        <div class="text-lg font-semibold mb-2">{{ session('error') }}</div>
                        <button onclick="document.getElementById('modal-error').remove()"
                            class="mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold">OK</button>
                    </div>
                </div>
            @endif
            <form method="POST" action="{{ route('client.profile.update') }}" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="tel" name="phone" value="{{ old('phone', $user->phone_number) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror">
                                @error('phone')
                                    <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" value="{{ $user->email }}" readonly
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed">
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 mt-6">
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                                <input type="password" name="current_password" autocomplete="current-password"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('current_password') border-red-500 @enderror">
                                @error('current_password')
                                    <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                <input type="password" name="new_password" autocomplete="new-password"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('new_password') border-red-500 @enderror">
                                @error('new_password')
                                    <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" autocomplete="new-password"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('new_password_confirmation') border-red-500 @enderror">
                                @error('new_password_confirmation')
                                    <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                <textarea name="address" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('address') border-red-500 @enderror">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex space-x-3 mt-6">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">Save</button>
                </div>
            </form>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    if (window.lucide) window.lucide.createIcons();
                });
            </script>
        </div>
    </div>
@endsection
