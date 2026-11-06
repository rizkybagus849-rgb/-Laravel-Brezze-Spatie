@php $b = $book ?? null; @endphp

<div class="space-y-4">
    <div>
        <x-input-label for="judul" value="Judul" />
        <x-text-input id="judul" name="judul" class="block mt-1 w-full" :value="old('judul', $b?->judul)" required />
        <x-input-error :messages="$errors->get('judul')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="penulis" value="Penulis" />
        <x-text-input id="penulis" name="penulis" class="block mt-1 w-full" :value="old('penulis', $b?->penulis)" required />
        <x-input-error :messages="$errors->get('penulis')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="penerbit" value="Penerbit" />
        <x-text-input id="penerbit" name="penerbit" class="block mt-1 w-full" :value="old('penerbit', $b?->penerbit)" />
        <x-input-error :messages="$errors->get('penerbit')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="tahun_terbit" value="Tahun Terbit" />
        <x-text-input id="tahun_terbit" name="tahun_terbit" type="number" class="block mt-1 w-full" :value="old('tahun_terbit', $b?->tahun_terbit)" />
        <x-input-error :messages="$errors->get('tahun_terbit')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="isbn" value="ISBN" />
        <x-text-input id="isbn" name="isbn" class="block mt-1 w-full" :value="old('isbn', $b?->isbn)" required />
        <x-input-error :messages="$errors->get('isbn')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="deskripsi" value="Deskripsi" />
        <textarea id="deskripsi" name="deskripsi" rows="4"
                  class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('deskripsi', $b?->deskripsi) }}</textarea>
        <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
    </div>
    <div class="flex items-center gap-3">
        <x-primary-button>Simpan</x-primary-button>
        <a href="{{ route('books.index') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
    </div>
</div>
