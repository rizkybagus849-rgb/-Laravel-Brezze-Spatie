<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Buku</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                {{-- Tombol disembunyikan sesuai hak akses (hanya tampilan; keamanan sebenarnya di middleware server) --}}
                @can('book.create')
                    <a href="{{ route('books.create') }}"
                       class="inline-block mb-4 px-4 py-2 bg-gray-800 text-white rounded-md text-xs uppercase font-semibold hover:bg-gray-700">
                        + Tambah Buku
                    </a>
                @endcan

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="border-b font-semibold text-gray-700">
                            <tr>
                                <th class="py-2 pr-4">Judul</th>
                                <th class="py-2 pr-4">Penulis</th>
                                <th class="py-2 pr-4">Penerbit</th>
                                <th class="py-2 pr-4">Tahun</th>
                                <th class="py-2 pr-4">ISBN</th>
                                <th class="py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse ($books as $book)
                                <tr class="border-b">
                                    <td class="py-2 pr-4">{{ $book->judul }}</td>
                                    <td class="py-2 pr-4">{{ $book->penulis }}</td>
                                    <td class="py-2 pr-4">{{ $book->penerbit }}</td>
                                    <td class="py-2 pr-4">{{ $book->tahun_terbit }}</td>
                                    <td class="py-2 pr-4">{{ $book->isbn }}</td>
                                    <td class="py-2 flex gap-3">
                                        @can('book.edit')
                                            <a href="{{ route('books.edit', $book) }}" class="text-indigo-600 hover:underline">Edit</a>
                                        @endcan
                                        @can('book.delete')
                                            <form method="POST" action="{{ route('books.destroy', $book) }}"
                                                  onsubmit="return confirm('Hapus buku ini?')">
                                                @csrf @method('DELETE')
                                                <button class="text-red-600 hover:underline">Hapus</button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="py-4 text-center text-gray-500">Belum ada data buku.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $books->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
