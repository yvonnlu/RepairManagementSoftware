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
            {{-- Register Card --}}
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl border border-purple-100 p-8 space-y-6">
                {{-- Header --}}
                <div class="text-center space-y-3">
                    <div
                        class="w-16 h-16 mx-auto bg-gradient-to-br from-purple-500 to-violet-600 rounded-2xl flex items-center justify-center shadow-lg">
                        {{-- UserPlus icon --}}
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M15 19v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <line x1="19" y1="8" x2="19" y2="14"></line>
                            <line x1="22" y1="11" x2="16" y2="11"></line>
                        </svg>
                    </div>
                    <h2
                        class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-violet-600 bg-clip-text text-transparent">
                        Create account
                    </h2>
                    <p class="text-gray-600 font-medium">Join Fixicon and manage your repairs efficiently</p>
                </div>

                {{-- Session Status --}}
                @if (session('status'))
                    <div
                        class="flex items-center gap-3 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl">
                        {{-- CheckCircle2 icon --}}
                        <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 12l2 2l4-4"></path>
                            <circle cx="12" cy="12" r="10"></circle>
                        </svg>
                        <p class="text-green-700 text-sm font-medium">{{ session('status') }}</p>
                    </div>
                @endif

                {{-- Register Form --}}
                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    {{-- Full Name Field --}}
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-semibold text-gray-700">
                            Full name
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                {{-- User icon --}}
                                <svg class="h-5 w-5 {{ old('name') ? 'text-purple-500' : 'text-gray-400' }} transition-colors"
                                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M15 19v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <input id="name" name="name" type="text" autocomplete="name" required autofocus
                                value="{{ old('name') }}"
                                class="block w-full pl-12 pr-4 py-3 border-2 rounded-xl shadow-sm placeholder-gray-400 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-purple-500/20 {{ $errors->has('name') ? 'border-red-300 focus:border-red-500' : 'border-gray-200 focus:border-purple-500 hover:border-purple-300' }}"
                                placeholder="Enter your full name" />
                        </div>
                        @if ($errors->get('name'))
                            <div class="flex items-center gap-1 text-red-600 text-sm">
                                {{-- AlertCircle icon --}}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="12"></line>
                                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                </svg>
                                {{ $errors->get('name')[0] }}
                            </div>
                        @endif
                    </div>

                    {{-- Email Field --}}
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-semibold text-gray-700">
                            Email address
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                {{-- Mail icon --}}
                                <svg class="h-5 w-5 {{ old('email') ? 'text-purple-500' : 'text-gray-400' }} transition-colors"
                                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                                    <polyline points="3 7 12 13 21 7"></polyline>
                                </svg>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="username" required
                                value="{{ old('email') }}"
                                class="block w-full pl-12 pr-4 py-3 border-2 rounded-xl shadow-sm placeholder-gray-400 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-purple-500/20 {{ $errors->has('email') ? 'border-red-300 focus:border-red-500' : 'border-gray-200 focus:border-purple-500 hover:border-purple-300' }}"
                                placeholder="Enter your email" />
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

                    {{-- Password Field --}}
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-semibold text-gray-700">
                            Password
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
                                placeholder="Create a password" />
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
                            Confirm password
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
                                placeholder="Confirm your password" />
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

                    {{-- Register Button --}}
                    <button type="submit"
                        class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-semibold text-white bg-gradient-to-r from-purple-600 to-violet-600 hover:from-purple-700 hover:to-violet-700 focus:outline-none focus:ring-4 focus:ring-purple-500/50 disabled:opacity-50 disabled:cursor-not-allowed transform transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]">
                        Create account
                    </button>

                    {{-- Divider --}}
                    <div class="relative mt-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-500 font-medium">Or register with</span>
                        </div>
                    </div>

                    {{-- Google Register --}}
                    <a href="{{ route('client.google.redirect') }}"
                        class="w-full flex justify-center items-center py-3 px-4 border-2 border-gray-200 rounded-xl shadow-sm bg-white text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:border-purple-200 focus:outline-none focus:ring-4 focus:ring-purple-500/20 transition-all duration-200 hover:scale-[1.01] active:scale-[0.99]">
                        {{-- Google logo --}}
                        <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                            <path fill="#4285F4"
                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="#34A853"
                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="#FBBC05"
                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                            <path fill="#EA4335"
                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                        </svg>
                        Continue with Google
                    </a>
                </form>

                {{-- Sign In Link --}}
                <div class="text-center pt-4 border-t border-gray-100">
                    <p class="text-sm text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}"
                            class="font-semibold text-purple-600 hover:text-purple-800 transition-colors hover:underline">
                            Sign in instead
                        </a>
                    </p>
                </div>

                {{-- Support Contact Info --}}
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-4 mt-4">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-blue-900 mb-1">Need help with your account?</h4>
                            <p class="text-xs text-blue-700 mb-2">If you're having trouble accessing your account or need
                                assistance, our support team is here to help.</p>
                            <div class="space-y-1">
                                <p class="text-xs text-blue-800">
                                    <span class="font-medium">Email:</span>
                                    <a href="mailto:support@fixicon.com" class="hover:underline">support@fixicon.com</a>
                                </p>
                                <p class="text-xs text-blue-800">
                                    <span class="font-medium">Phone:</span>
                                    <a href="tel:+15551234567" class="hover:underline">(555) 123-4567</a>
                                </p>
                                <p class="text-xs text-blue-700">Available Monday-Friday, 9 AM - 6 PM EST</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="text-center mt-8">
                <p class="text-xs text-gray-500">
                    By creating an account, you agree to our Terms of Service and Privacy Policy
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

        // Icon color changes on focus/blur
        document.getElementById('name').addEventListener('focus', function() {
            const icon = this.previousElementSibling.querySelector('svg');
            icon.classList.remove('text-gray-400');
            icon.classList.add('text-purple-500');
        });

        document.getElementById('name').addEventListener('blur', function() {
            if (!this.value) {
                const icon = this.previousElementSibling.querySelector('svg');
                icon.classList.remove('text-purple-500');
                icon.classList.add('text-gray-400');
            }
        });

        document.getElementById('email').addEventListener('focus', function() {
            const icon = this.previousElementSibling.querySelector('svg');
            icon.classList.remove('text-gray-400');
            icon.classList.add('text-purple-500');
        });

        document.getElementById('email').addEventListener('blur', function() {
            if (!this.value) {
                const icon = this.previousElementSibling.querySelector('svg');
                icon.classList.remove('text-purple-500');
                icon.classList.add('text-gray-400');
            }
        });

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
    </script>
@endsection
