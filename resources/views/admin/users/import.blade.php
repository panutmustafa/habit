<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Import Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <p class="text-sm text-gray-600">Anda dapat mengunduh template CSV untuk impor pengguna:</p>
                        <a href="{{ route('admin.users.import.template') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Unduh Template CSV
                        </a>
                    </div>
                    <form method="POST" action="{{ route('admin.users.import.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Import File -->
                        <div>
                            <x-input-label for="import_file" :value="__('File Impor (CSV)')" />
                            <x-text-input id="import_file" class="block mt-1 w-full" type="file" name="import_file" required autofocus />
                            <x-input-error :messages="$errors->get('import_file')" class="mt-2" />
                        </div>

                        <!-- Class Selection -->
                        <div class="mt-4">
                            <x-input-label for="kela_id" :value="__('Pilih Kelas untuk Pengguna')" />
                            <select id="kela_id" name="kela_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="">{{ __('Pilih Kelas') }}</option>
                                @foreach($kelas as $kela)
                                    <option value="{{ $kela->id }}">{{ $kela->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('kela_id')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Impor Pengguna') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
