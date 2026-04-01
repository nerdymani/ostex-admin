<x-install-layout :currentStep="3" pageTitle="Admin Account" pageSubtitle="Create your administrator account for the Ostex Admin panel.">
    @if($errors->any())
    <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-lg">
        @foreach($errors->all() as $error)
            <p class="text-red-700 text-sm">{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <form action="{{ route('install.admin.store') }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
            <input type="text" name="name" value="{{ old('name', $progress['admin_name'] ?? '') }}"
                placeholder="Admin User"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#fa5a0d]" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
            <input type="email" name="email" value="{{ old('email', $progress['admin_email'] ?? '') }}"
                placeholder="admin@example.com"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#fa5a0d]" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#fa5a0d]" required>
            <p class="text-xs text-gray-400 mt-1">Minimum 8 characters.</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#fa5a0d]" required>
        </div>

        <div class="flex justify-between pt-2">
            <a href="{{ route('install.database') }}" class="px-5 py-2 rounded-lg border border-gray-300 text-gray-600 text-sm hover:bg-gray-50">Back</a>
            <button type="submit" class="px-6 py-2 bg-[#fa5a0d] hover:bg-[#e04e09] text-white rounded-lg text-sm font-semibold">
                Continue →
            </button>
        </div>
    </form>
</x-install-layout>
