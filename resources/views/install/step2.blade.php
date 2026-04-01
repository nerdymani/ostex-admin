<x-install-layout :currentStep="2" pageTitle="Database Configuration" pageSubtitle="Enter your MySQL database connection details.">
    @if($errors->any())
    <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-lg">
        @foreach($errors->all() as $error)
            <p class="text-red-700 text-sm">{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <form action="{{ route('install.database.store') }}" method="POST" class="space-y-5">
        @csrf
        <div class="grid grid-cols-3 gap-4">
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Database Host</label>
                <input type="text" name="db_host" value="{{ old('db_host', $progress['db_host'] ?? '127.0.0.1') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#fa5a0d]" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Port</label>
                <input type="text" name="db_port" value="{{ old('db_port', $progress['db_port'] ?? '3306') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#fa5a0d]" required>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Database Name</label>
            <input type="text" name="db_name" value="{{ old('db_name', $progress['db_name'] ?? '') }}"
                placeholder="ostex_admin"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#fa5a0d]" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Database Username</label>
            <input type="text" name="db_username" value="{{ old('db_username', $progress['db_username'] ?? '') }}"
                placeholder="root"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#fa5a0d]" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Database Password</label>
            <input type="password" name="db_password"
                placeholder="Leave blank if no password"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#fa5a0d]">
            <p class="text-xs text-gray-400 mt-1">Leave blank if your database has no password.</p>
        </div>

        <div class="flex justify-between pt-2">
            <a href="{{ route('install.index') }}" class="px-5 py-2 rounded-lg border border-gray-300 text-gray-600 text-sm hover:bg-gray-50">Back</a>
            <button type="submit" class="px-6 py-2 bg-[#fa5a0d] hover:bg-[#e04e09] text-white rounded-lg text-sm font-semibold">
                Test & Continue →
            </button>
        </div>
    </form>
</x-install-layout>
