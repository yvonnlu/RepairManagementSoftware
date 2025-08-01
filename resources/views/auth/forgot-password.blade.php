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
            {{-- Forgot Password Card --}}
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl border border-purple-100 p-8 space-y-6">
                {{-- Header --}}
                <div class="text-center space-y-3">
                    <div
                        class="w-16 h-16 mx-auto bg-gradient-to-br from-purple-500 to-violet-600 rounded-2xl flex items-center justify-center shadow-lg">
                        {{-- Key icon --}}
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path
                                d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4">
                            </path>
                        </svg>
                    </div>
                    <h2
                        class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-violet-600 bg-clip-text text-transparent">
                        Reset Password
                    </h2>
                    <p class="text-gray-600 font-medium leading-relaxed">
                        No worries! Enter your email address and we'll send you a link to reset your password.
                    </p>
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

                {{-- Reset Password Form --}}
                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

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
                            <input id="email" name="email" type="email" autocomplete="email" required autofocus
                                value="{{ old('email') }}"
                                class="block w-full pl-12 pr-4 py-3 border-2 rounded-xl shadow-sm placeholder-gray-400 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-purple-500/20 {{ $errors->has('email') ? 'border-red-300 focus:border-red-500' : 'border-gray-200 focus:border-purple-500 hover:border-purple-300' }}"
                                placeholder="Enter your email address" />
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

                    {{-- Send Reset Link Button --}}
                    <button type="submit"
                        class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-semibold text-white bg-gradient-to-r from-purple-600 to-violet-600 hover:from-purple-700 hover:to-violet-700 focus:outline-none focus:ring-4 focus:ring-purple-500/50 disabled:opacity-50 disabled:cursor-not-allowed transform transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]">
                        {{-- Send icon --}}
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M22 2L11 13"></path>
                            <polygon points="22,2 15,22 11,13 2,9"></polygon>
                        </svg>
                        Send Reset Link
                    </button>

                    {{-- Help Text --}}
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            {{-- Info icon --}}
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 16v-4"></path>
                                <path d="M12 8h.01"></path>
                            </svg>
                            <div class="text-sm text-blue-700">
                                <p class="font-medium mb-1">What happens next?</p>
                                <ul class="text-xs space-y-1 text-blue-600">
                                    <li>• We'll send a secure link to your email</li>
                                    <li>• Click the link to create a new password</li>
                                    <li>• The link expires in 60 minutes for security</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>

                {{-- Back to Login Link --}}
                <div class="text-center pt-4 border-t border-gray-100">
                    <p class="text-sm text-gray-600">
                        Remember your password?
                        <a href="{{ route('login') }}"
                            class="font-semibold text-purple-600 hover:text-purple-800 transition-colors hover:underline inline-flex items-center gap-1">
                            {{-- ArrowLeft icon --}}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
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
                    Having trouble? Contact our support team for assistance
                </p>
            </div>
        </div>
    </div>

    {{-- JS for icon animations --}}
    <script>
        // Icon color changes on focus/blur
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

        // Form submission feedback
        document.querySelector('form').addEventListener('submit', function() {
            const button = this.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;

            button.disabled = true;
            button.innerHTML = `
            <svg class="w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M21 12a9 9 0 1 1-6.219-8.56"></path>
            </svg>
            Sending...
        `;

            // Reset after 3 seconds if no redirect occurs
            setTimeout(() => {
                button.disabled = false;
                button.innerHTML = originalText;
            }, 3000);
        });
    </script>
@endsection
