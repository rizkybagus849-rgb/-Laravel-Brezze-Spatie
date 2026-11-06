<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <p class="text-gray-900">Halo, <strong>{{ auth()->user()->name }}</strong>!</p>
                <p class="mt-2 text-sm text-gray-600">
                    Role Anda:
                    @foreach (auth()->user()->getRoleNames() as $r)
                        <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded text-xs">{{ $r }}</span>
                    @endforeach
                </p>
                <p class="mt-2 text-sm text-gray-600">
                    Permission: {{ auth()->user()->getAllPermissions()->pluck('name')->implode(', ') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @can('book.view')
                    <a href="{{ route('books.index') }}" class="block bg-white shadow-sm sm:rounded-lg p-6 hover:bg-gray-50">
                        <h3 class="font-semibold text-gray-800">📚 Data Buku</h3>
                        <p class="text-sm text-gray-500">Lihat dan kelola koleksi buku.</p>
                    </a>
                @endcan
                @can('user.manage-roles')
                    <a href="{{ route('admin.users.index') }}" class="block bg-white shadow-sm sm:rounded-lg p-6 hover:bg-gray-50">
                        <h3 class="font-semibold text-gray-800">👥 Kelola Role Pengguna</h3>
                        <p class="text-sm text-gray-500">Ubah role Admin / Dosen / Mahasiswa.</p>
                    </a>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>
