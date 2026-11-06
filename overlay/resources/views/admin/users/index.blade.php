<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Role Pengguna</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            @error('role')
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ $message }}</div>
            @enderror

            <div class="bg-white shadow-sm sm:rounded-lg p-6 overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="border-b font-semibold text-gray-700">
                        <tr><th class="py-2 pr-4">Nama</th><th class="py-2 pr-4">Email</th><th class="py-2">Role</th></tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($users as $user)
                            <tr class="border-b">
                                <td class="py-2 pr-4">{{ $user->name }}</td>
                                <td class="py-2 pr-4">{{ $user->email }}</td>
                                <td class="py-2">
                                    <form method="POST" action="{{ route('admin.users.role', $user) }}" class="flex gap-2">
                                        @csrf @method('PATCH')
                                        <select name="role" class="border-gray-300 rounded-md text-sm">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role }}" @selected($user->hasRole($role))>{{ $role }}</option>
                                            @endforeach
                                        </select>
                                        <x-primary-button>Simpan</x-primary-button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
