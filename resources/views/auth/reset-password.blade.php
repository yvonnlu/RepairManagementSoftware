@extends('layouts.auth')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-violet-50 flex items-center justify-center p-4">
        {{-- Background decorations --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute -top-40 -right-40 w-80 h-80 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse">
            </div>
            <div
                class="absolute -bottom-40 -left-40 w-80 h-80 bg-violet-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse delay-1000">
            </div>
            <div
                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-indigo-100 rounded-full mix-blend-multiply filter blur-xl opacity-50 animate-pulse delay-500">
            </div>
        </div>

        <div class="relative w-full max-w-md">
            {{-- Reset Password Card --}}
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl border border-purple-100 p-8 space-y-6">
                {{-- Header --}}
                <div class="text-center space-y-3">
                    <div
                        class="w-16 h-16 mx-auto bg-gradient-to-br from-purple-500 to-violet-600 rounded-2xl flex items-center justify-center shadow-lg">
                        {{-- Shield Check icon --}}
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            <path d="M9 12l2 2l4-4"></path>
                        </svg>
                    </div>
                    <h2
                        class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-violet-600 bg-clip-text text-transparent">
                        Set New Password
                    </h2>
                    <p class="text-gray-600 font-medium">
                        Create a strong password for your account
                    </p>
                </div>

                {{-- Reset Password Form --}}
                <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                    @csrf

                    {{-- Hidden Token --}}
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    {{-- Email Field (Read-only) --}}
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-semibold text-gray-700">
                            Email address
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                {{-- Mail icon --}}
                                <svg class="h-5 w-5 text-purple-500" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                                    <polyline points="3 7 12 13 21 7"></polyline>
                                </svg>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="username" required autofocus
                                readonly value="{{ old('email', $request->email) }}"
                                class="block w-full pl-12 pr-4 py-3 border-2 border-purple-200 bg-purple-50/50 rounded-xl shadow-sm text-gray-600 cursor-not-allowed" />
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                {{-- Lock icon --}}
                                <svg class="h-4 w-4 text-purple-400" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <rect x="3" y="11" width="18" height="11" rx="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </div>
                        </div>
                        @if ($errors->get('email'))
                            <div class="flex items-center gap-1 text-red-600 text-sm">
                                {{-- AlertCircle icon --}}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="12"></line>
                                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                </svg>
                                {{ $errors->get('email')[0] }}
                            </div>
                        @endif
                    </div>

                    {{-- New Password Field --}}
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-semibold text-gray-700">
                            New password
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                {{-- Lock icon --}}
                                <svg class="h-5 w-5 text-gray-400 transition-colors" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="11" width="18" height="11" rx="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="new-password" required
                                class="block w-full pl-12 pr-12 py-3 border-2 rounded-xl shadow-sm placeholder-gray-400 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-purple-500/20 {{ $errors->has('password') ? 'border-red-300 focus:border-red-500' : 'border-gray-200 focus:border-purple-500 hover:border-purple-300' }}"
                                placeholder="Enter your new password" />
                            {{-- Eye icon for password toggle --}}
                            <button type="button"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-purple-500 transition-colors password-toggle"
                                data-toggle="password">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        @if ($errors->get('password'))
                            <div class="flex items-center gap-1 text-red-600 text-sm">
                                {{-- AlertCircle icon --}}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="12"></line>
                                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                </svg>
                                {{ $errors->get('password')[0] }}
                            </div>
                        @endif
                    </div>

                    {{-- Confirm Password Field --}}
                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">
                            Confirm new password
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                {{-- Lock icon --}}
                                <svg class="h-5 w-5 text-gray-400 transition-colors" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="11" width="18" height="11" rx="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </div>
                            <input id="password_confirmation" name="password_confirmation" type="password"
                                autocomplete="new-password" required
                                class="block w-full pl-12 pr-12 py-3 border-2 rounded-xl shadow-sm placeholder-gray-400 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-purple-500/20 {{ $errors->has('password_confirmation') ? 'border-red-300 focus:border-red-500' : 'border-gray-200 focus:border-purple-500 hover:border-purple-300' }}"
                                placeholder="Confirm your new password" />
                            {{-- Eye icon for password toggle --}}
                            <button type="button"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-purple-500 transition-colors password-toggle"
                                data-toggle="password_confirmation">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        @if ($errors->get('password_confirmation'))
                            <div class="flex items-center gap-1 text-red-600 text-sm">
                                {{-- AlertCircle icon --}}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="12"></line>
                                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                </svg>
                                {{ $errors->get('password_confirmation')[0] }}
                            </div>
                        @endif
                    </div>

                    {{-- Password Requirements --}}
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            {{-- Shield icon --}}
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                            <div class="text-sm text-blue-700">
                                <p class="font-medium mb-1">Password requirements:</p>
                                <ul class="text-xs space-y-1 text-blue-600">
                                    <li>• At least 8 characters long</li>
                                    <li>• Mix of uppercase and lowercase letters</li>
                                    <li>• Include numbers and special characters</li>
                                    <li>• Avoid common words or personal info</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Reset Password Button --}}
                    <button type="submit"
                        class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-semibold text-white bg-gradient-to-r from-purple-600 to-violet-600 hover:from-purple-700 hover:to-violet-700 focus:outline-none focus:ring-4 focus:ring-purple-500/50 disabled:opacity-50 disabled:cursor-not-allowed transform transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]">
                        {{-- Check icon --}}
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M9 12l2 2l4-4"></path>
                            <circle cx="12" cy="12" r="10"></circle>
                        </svg>
                        Update Password
                    </button>
                </form>

                {{-- Back to Login Link --}}
                <div class="text-center pt-4 border-t border-gray-100">
                    <p class="text-sm text-gray-600">
                        Remember your password?
                        <a href="{{ route('login') }}"
                            class="font-semibold text-purple-600 hover:text-purple-800 transition-colors hover:underline inline-flex items-center gap-1">
                            {{-- ArrowLeft icon --}}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M19 12H5m7-7l-7 7 7 7"></path>
                            </svg>
                            Back to Sign In
                        </a>
                    </p>
                </div>
            </div>

            {{-- Footer --}}
            <div class="text-center mt-8">
                <p class="text-xs text-gray-500">
                    Your password will be encrypted and stored securely
                </p>
            </div>
        </div>
    </div>

    {{-- JS for password toggle and icon animations --}}
    <script>
        // Password toggle functionality
        document.querySelectorAll('.password-toggle').forEach(btn => {
            btn.addEventListener('click', function() {
                const inputId = btn.getAttribute('data-toggle');
                const input = document.getElementById(inputId);
                const icon = btn.querySelector('svg');

                if (input.type === 'password') {
                    input.type = 'text';
                    // Change to eye-off icon
                    icon.innerHTML = `
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                    <line x1="1" y1="1" x2="23" y2="23"></line>
                `;
                } else {
                    input.type = 'password';
                    // Change back to eye icon
                    icon.innerHTML = `
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                `;
                }
            });
        });

        // Icon color changes on focus/blur for password fields
        document.getElementById('password').addEventListener('focus', function() {
            const icon = this.previousElementSibling.querySelector('svg');
            icon.classList.remove('text-gray-400');
            icon.classList.add('text-purple-500');
        });

        document.getElementById('password').addEventListener('blur', function() {
            if (!this.value) {
                const icon = this.previousElementSibling.querySelector('svg');
                icon.classList.remove('text-purple-500');
                icon.classList.add('text-gray-400');
            }
        });

        document.getElementById('password_confirmation').addEventListener('focus', function() {
            const icon = this.previousElementSibling.querySelector('svg');
            icon.classList.remove('text-gray-400');
            icon.classList.add('text-purple-500');
        });

        document.getElementById('password_confirmation').addEventListener('blur', function() {
            if (!this.value) {
                const icon = this.previousElementSibling.querySelector('svg');
                icon.classList.remove('text-purple-500');
                icon.classList.add('text-gray-400');
            }
        });

        // Form submission feedback
        document.querySelector('form').addEventListener('submit', function() {
            const button = this.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;

            button.disabled = true;
            button.innerHTML = `
            <svg class="w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M21 12a9 9 0 1 1-6.219-8.56"></path>
            </svg>
            Updating...
        `;

            // Reset after 3 seconds if no redirect occurs
            setTimeout(() => {
                button.disabled = false;
                button.innerHTML = originalText;
            }, 3000);
        });

        // Password strength indicator (basic)
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const confirmField = document.getElementById('password_confirmation');

            // Simple password strength visual feedback
            if (password.length >= 8) {
                this.classList.remove('border-red-300');
                this.classList.add('border-green-300');
            } else if (password.length > 0) {
                this.classList.remove('border-green-300');
                this.classList.add('border-yellow-300');
            }

            // Check password confirmation match
            if (confirmField.value && confirmField.value === password) {
                confirmField.classList.remove('border-red-300');
                confirmField.classList.add('border-green-300');
            } else if (confirmField.value) {
                confirmField.classList.remove('border-green-300');
                confirmField.classList.add('border-red-300');
            }
        });

        // Password confirmation matching
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmation = this.value;

            if (confirmation && confirmation === password) {
                this.classList.remove('border-red-300');
                this.classList.add('border-green-300');
            } else if (confirmation) {
                this.classList.remove('border-green-300');
                this.classList.add('border-red-300');
            }
        });
    </script>
@endsection
