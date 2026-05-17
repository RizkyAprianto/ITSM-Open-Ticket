<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Executive Dashboard - ITSM</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <!-- ApexCharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body class="bg-slate-50 font-sans antialiased text-gray-900">
    <div class="flex h-screen bg-slate-50">
        <!-- Sidebar -->
        <aside class="w-64 bg-indigo-900 text-white flex flex-col hidden sm:flex shadow-xl z-20">
            <div class="px-6 py-8 border-b border-indigo-800">
                <h2 class="text-2xl font-bold tracking-tight text-indigo-100"><span class="text-white">ITSM</span> Executive</h2>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('executive.dashboard') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('executive.dashboard') ? 'bg-indigo-800 text-white font-medium' : 'text-indigo-100 hover:bg-indigo-800 hover:text-white' }} rounded-lg transition-colors">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Analytics Overview
                </a>
                <a href="{{ route('executive.staff-work') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('executive.staff-work') ? 'bg-indigo-800 text-white font-medium' : 'text-indigo-100 hover:bg-indigo-800 hover:text-white' }} rounded-lg transition-colors">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    Detail Pekerjaan Staff
                </a>
            </nav>
            <div class="px-6 py-4 border-t border-indigo-800">
                <div class="flex items-center">
                    <div class="ml-3">
                        <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                        <p class="text-xs font-medium text-indigo-300 uppercase tracking-wider">{{ auth()->user()->role }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden relative">
            <!-- Header -->
            <header class="bg-white shadow-sm z-10">
                <div class="px-6 py-4 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-slate-800">Executive Insights</h2>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm px-4 py-2 bg-rose-50 text-rose-600 hover:bg-rose-100 hover:text-rose-700 font-semibold rounded-lg transition-colors">Logout</button>
                    </form>
                </div>
            </header>

            <!-- Main Scrollable Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-6 sm:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>
