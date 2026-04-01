<x-install-layout :currentStep="1" pageTitle="Server Requirements" pageSubtitle="Please ensure all requirements are met before continuing.">
    <div class="space-y-3">
        @foreach($checks as $check)
        <div class="flex items-center justify-between p-3 rounded-lg {{ $check['pass'] ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
            <div class="flex items-center gap-3">
                @if($check['pass'])
                    <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                @else
                    <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                @endif
                <span class="font-medium text-gray-800">{{ $check['label'] }}</span>
            </div>
            <span class="text-sm font-mono {{ $check['pass'] ? 'text-green-700' : 'text-red-700' }}">{{ $check['value'] }}</span>
        </div>
        @endforeach
    </div>

    @if(!$allPassed)
    <div class="mt-5 p-4 bg-amber-50 border border-amber-200 rounded-lg text-amber-800 text-sm">
        <strong>Action required:</strong> Resolve the failing requirements above before continuing.
        Contact your hosting provider if you cannot enable an extension.
    </div>
    @endif

    <div class="mt-6 flex justify-end">
        <a href="{{ route('install.database') }}"
           class="inline-flex items-center gap-2 px-6 py-3 rounded-lg text-white font-semibold transition
               {{ $allPassed ? 'bg-[#fa5a0d] hover:bg-[#e04e09]' : 'bg-gray-300 cursor-not-allowed pointer-events-none' }}">
            Continue
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
            </svg>
        </a>
    </div>
</x-install-layout>
