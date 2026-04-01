<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'Setup Wizard' }} – Ostex Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="min-h-screen bg-gradient-to-br from-[#0c214f] via-[#0e2a63] to-[#0c214f] flex flex-col items-center justify-center py-10 px-4">

    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-white tracking-tight">
            <span style="color:#fa5a0d">Ostex</span> Admin
        </h1>
        <p class="text-blue-200 mt-1 text-sm">Setup Wizard</p>
    </div>

    @php
        $steps   = [1 => 'Requirements', 2 => 'Database', 3 => 'Admin Account', 4 => 'Install'];
        $current = $currentStep ?? 1;
    @endphp
    <div class="flex items-center gap-0 mb-8 w-full max-w-2xl">
        @foreach($steps as $num => $label)
        <div class="flex-1 flex flex-col items-center">
            <div class="flex items-center w-full">
                @if(!$loop->first)
                    <div class="flex-1 h-1 {{ $num <= $current ? 'bg-orange-400' : 'bg-slate-600' }}"></div>
                @endif
                <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold shrink-0
                    {{ $num < $current ? 'bg-green-400 text-white' : ($num === $current ? 'bg-white text-[#0c214f] ring-4 ring-orange-300' : 'bg-slate-600 text-slate-300') }}">
                    @if($num < $current)
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    @else
                        {{ $num }}
                    @endif
                </div>
                @if(!$loop->last)
                    <div class="flex-1 h-1 {{ $num < $current ? 'bg-orange-400' : 'bg-slate-600' }}"></div>
                @endif
            </div>
            <span class="text-xs mt-1 {{ $num === $current ? 'text-white font-semibold' : 'text-blue-300' }}">{{ $label }}</span>
        </div>
        @endforeach
    </div>

    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-2xl overflow-hidden">
        <div class="px-8 py-6" style="background: linear-gradient(to right, #0c214f, #1a3a7a)">
            <h2 class="text-xl font-bold text-white">{{ $pageTitle ?? '' }}</h2>
            @if(isset($pageSubtitle))
                <p class="text-blue-200 text-sm mt-1">{{ $pageSubtitle }}</p>
            @endif
        </div>
        <div class="px-8 py-6">
            {{ $slot }}
        </div>
    </div>

    <p class="mt-6 text-blue-300 text-xs">&copy; {{ date('Y') }} Ostex Global Technologies. All rights reserved.</p>
</body>
</html>
