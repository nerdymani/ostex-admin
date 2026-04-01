<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation Complete – Ostex Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-[#0c214f] via-[#0e2a63] to-[#0c214f] flex flex-col items-center justify-center py-10 px-4">

    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-white tracking-tight">
            <span style="color:#fa5a0d">Ostex</span> Admin
        </h1>
        <p class="text-blue-200 mt-1 text-sm">Setup Wizard</p>
    </div>

    <div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden text-center">
        <div class="px-8 py-8 bg-gradient-to-r from-green-500 to-emerald-600">
            <div class="mx-auto w-20 h-20 bg-white rounded-full flex items-center justify-center mb-4">
                <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-white">Installation Complete!</h2>
            <p class="text-green-100 mt-2 text-sm">Ostex Admin is ready to go.</p>
        </div>

        <div class="px-8 py-8 space-y-4">
            <div class="p-4 bg-green-50 border border-green-200 rounded-lg text-left text-sm text-green-800">
                <ul class="space-y-1">
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Database migrated and seeded
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Admin account created
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Application configured
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        REST API ready
                    </li>
                </ul>
            </div>

            <a href="{{ url('/admin') }}"
               class="block w-full px-6 py-3 text-white rounded-lg font-semibold text-sm transition text-center"
               style="background:#0c214f">
                Go to Admin Panel →
            </a>

            <p class="text-xs text-gray-400">For security, the setup wizard is now locked.</p>
        </div>
    </div>

    <p class="mt-6 text-blue-300 text-xs">&copy; {{ date('Y') }} Ostex Global Technologies. All rights reserved.</p>
</body>
</html>
