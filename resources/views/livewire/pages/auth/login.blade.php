<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.split')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="min-h-screen grid grid-cols-1 lg:grid-cols-2 bg-white">
    <!-- Left Side: Branding / Visual (Hidden on mobile) -->
    <div class="hidden lg:flex relative bg-blue-700 items-center justify-center overflow-hidden">
        <!-- Abstract Shapes -->
        <div class="absolute inset-0 z-0 opacity-20 pointer-events-none">
            <svg class="absolute left-0 top-0 h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <polygon fill="currentColor" points="0,0 100,0 50,100" class="text-blue-600" />
            </svg>
            <div class="absolute top-1/4 right-1/4 w-64 h-64 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
            <div class="absolute bottom-1/4 left-1/4 w-64 h-64 bg-cyan-400 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
        </div>

        <div class="relative z-10 text-center px-12">
            <!-- Using public logo if available, or just icon -->
            <div class="flex justify-center mb-8">
                <div class="w-24 h-24 bg-white rounded-2xl shadow-xl flex items-center justify-center">
                    <svg class="w-12 h-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>
            
            <h1 class="text-4xl font-extrabold text-white tracking-tight mb-4">
                ITSM Campus Service
            </h1>
            <p class="text-lg text-blue-100 font-medium max-w-md mx-auto">
                Platform terpusat untuk pelaporan dan penanganan kendala IT kampus. Melayani dengan cepat dan tepat.
            </p>
        </div>
    </div>

    <!-- Right Side: Login Form -->
    <div class="flex flex-col justify-center px-8 py-12 sm:px-12 lg:px-16 xl:px-24 bg-white z-10 shadow-[-20px_0_30px_-15px_rgba(0,0,0,0.1)]">
        <div class="w-full max-w-sm mx-auto">
            
            <div class="mb-10 text-center lg:text-left">
                <!-- Mobile Logo -->
                <div class="lg:hidden flex justify-center mb-6">
                    <div class="w-16 h-16 bg-blue-600 rounded-xl shadow-lg flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>
                
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Welcome Back</h2>
                <p class="text-slate-500 mt-2 font-medium">Silakan masuk ke portal Staf & Eksekutif.</p>
            </div>

            <x-auth-session-status class="mb-6" :status="session('status')" />

            <form wire:submit="login" class="space-y-6">
                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-bold text-slate-700 mb-1">Email / Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input wire:model="form.email" id="email" type="email" class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow" required autofocus autocomplete="username" placeholder="admin@kampus.ac.id" />
                    </div>
                    <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-rose-500 text-xs font-semibold" />
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="password" class="block text-sm font-bold text-slate-700">Password</label>
                        @if (Route::has('password.request'))
                            <a class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors" href="{{ route('password.request') }}" wire:navigate>
                                Lupa password?
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input wire:model="form.password" id="password" type="password" class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow" required autocomplete="current-password" placeholder="••••••••" />
                    </div>
                    <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-rose-500 text-xs font-semibold" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input wire:model="form.remember" id="remember" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                    <label for="remember" class="ml-2 block text-sm text-slate-600 cursor-pointer font-medium">
                        Ingat sesi saya
                    </label>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <span wire:loading.remove wire:target="login">Sign In</span>
                        <span wire:loading wire:target="login" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Memproses...
                        </span>
                    </button>
                </div>
            </form>
            
            <div class="mt-10 pt-6 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-400 font-medium">
                    &copy; {{ date('Y') }} Campus IT Department. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</div>
