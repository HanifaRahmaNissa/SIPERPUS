<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Book') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="post" action="{{ route('book.update', $book->id) }}" enctype="multipart/form-data"
                        class="mt-6 space-y6">
                        @method('PATCH')
                        @csrf
                        <div class="max-w-xl">
                            <x-input-label for="title" value="Judul" />
                            <x-text-input id="title" type="text" name="title" class="mt-1 block w-full"
                                value="{{ old('title', $book->title) }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>
                        <div class="max-w-xl">
                            <x-input-label for="author" value="Penulis" />
                            <x-text-input id="author" type="text" name="author" class="mt-1 block w-full"
                                value="{{ old('author', $book->author) }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('author')" />
                        </div>
                        <div class="max-w-xl">
                            <x-input-label for="year" value="Tahun Terbit" />
                            <x-text-input id="year" type="number" name="year" class="mt-1 block w-full"
                                value="{{ old('year', $book->year) }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('year')" />
                        </div>
                        <div class="max-w-xl">
                            <x-input-label for="publisher" value="Penerbit" />
                            <x-text-input id="publisher" type="text" name="publisher" class="mt-1 block w-full"
                                value="{{ old('publisher', $book->publisher) }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('publisher')" />
                        </div>
                        <div class="max-w-xl">
                            <x-input-label for="city" value="Kota Terbit" />
                            <x-text-input id="city" type="text" name="city" class="mt-1 block w-full"
                                value="{{ old('city', $book->city) }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('city')" />
                        </div>
                        <div class="max-w-xl">
                            <x-input-label for="bookshelf" value="Kategori Rak Buku" />
                            <x-select-input id="bookshelf" name="bookshelf_id" class="mt-1 block w-full" required>
                                <option value="">Open this select menu</option>
                                @foreach ($bookshelves as $key => $value)
                                    @if (old('bookshelf_id' == $book->bookshelf_id) == $value->id)
                                        <option value="{{ $value->id }}" selected>{{ $value->code.' - '.$value->name }}</option>
                                    @else
                                        <option value="{{ $value->id }}" selected>{{ $value->code.' - '.$value->name }}</option>
                                    @endif
                                @endforeach
                            </x-select-input>
                        </div>
                        <div class="max-w-xl">
                            <x-input-label for="cover" value="Halaman Sampul Depan" />
                            <x-file-input id="cover" name="cover" class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('cover')" />
                            <x-text-input type="hidden" name="old_cover"value="{{ $book->cover }}" />
                        </div>
                        <x-secondary-button tag="a" href="{{ route('book') }}">Cancel</x-secondary-button>
                        <x-primary-button value="true">Update</x-primary-button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>