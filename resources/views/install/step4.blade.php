<x-install-layout :currentStep="4" pageTitle="Installing..." pageSubtitle="Please wait while we set up your application.">
    <div x-data="installer()" x-init="runInstall()">
        <div class="bg-gray-900 rounded-lg p-4 font-mono text-sm h-64 overflow-y-auto" id="log-box">
            <template x-for="(line, i) in steps" :key="i">
                <div class="flex items-start gap-2 mb-1">
                    <span class="text-orange-400 select-none">›</span>
                    <span :class="line.includes('ERROR') ? 'text-red-400' : (line.includes('Warning') ? 'text-yellow-300' : 'text-green-300')" x-text="line"></span>
                </div>
            </template>
            <div x-show="running" class="flex items-center gap-2 text-yellow-300 mt-1">
                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                </svg>
                <span>Running...</span>
            </div>
        </div>

        <div x-show="error" x-cloak class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
            <strong>Installation Failed:</strong> <span x-text="error"></span>
            <p class="mt-2 text-xs text-red-500">Please go back and check your configuration, then retry.</p>
        </div>

        <div class="mt-5 flex justify-between items-center">
            <a href="{{ route('install.admin') }}" class="px-5 py-2 rounded-lg border border-gray-300 text-gray-600 text-sm hover:bg-gray-50">Back</a>
            <div x-show="!running && error" x-cloak>
                <button @click="runInstall()" class="px-6 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-sm font-semibold">
                    Retry Installation
                </button>
            </div>
        </div>
    </div>

    <script>
        function installer() {
            return {
                steps: [],
                running: false,
                error: null,
                async runInstall() {
                    this.running = true;
                    this.error   = null;
                    this.steps   = ['Starting installation...'];
                    try {
                        const res  = await fetch('{{ route('install.run') }}', {
                            method:  'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept':        'application/json',
                                'X-CSRF-TOKEN':  '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({}),
                        });
                        const data = await res.json();
                        if (data.steps) {
                            for (const step of data.steps) {
                                this.steps.push(step);
                                await new Promise(r => setTimeout(r, 80));
                                const box = document.getElementById('log-box');
                                if (box) box.scrollTop = box.scrollHeight;
                            }
                        }
                        if (data.success) {
                            this.running = false;
                            await new Promise(r => setTimeout(r, 800));
                            window.location.href = '{{ route('install.complete') }}';
                        } else {
                            this.error   = data.error || 'An unknown error occurred.';
                            this.running = false;
                        }
                    } catch (e) {
                        this.error   = e.message || 'Network error.';
                        this.running = false;
                    }
                }
            }
        }
    </script>
</x-install-layout>
