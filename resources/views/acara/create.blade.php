@section('title', 'Tambah Data Acara')

<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <a href="{{ route('acara.index') }}">
                    <button class="btn bg-red-primary text-white">
                        <i class="fa-solid fa-arrow-left"></i>
                        Kembali
                    </button>
                </a>
                <x-card.card-default
                    class="static bg-gradient-to-tr from-red-primary to-red-secondary shadow-lg border-4 border-white mx-auto mt-5">


                    <x-form action="{{ route('acara.store') }}" class="md:grid md:grid-cols-3 gap-4"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="mt-4">
                            <x-input.input-label for="name" class="text-white" :value="__('Nama Acara')" />
                            <x-input.text-input id="name" class="mt-1 w-full" type="text" name="name"
                                :value="old('name')" required autofocus autocomplete="name" />
                            <x-input.input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4 ">
                            <x-input.input-label for="description" class="text-white" :value="__('Deskripsi Acara')" />
                            <x-input.text-input id="description" class="mt-1 w-full" type="text" name="description"
                                :value="old('description')" required autofocus autocomplete="description" />
                            <x-input.input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input.input-label for="tanggal_pelaksanaan" class="text-white" :value="__('Tanggal Pelaksanaan')" />
                            <x-input.text-input id="tanggal_pelaksanaan" class="mt-1 w-full" type="date"
                                name="tanggal_pelaksanaan" :value="old('tanggal_pelaksanaan')" required autofocus
                                autocomplete="tanggal_pelaksanaan" />
                            <x-input.input-error :messages="$errors->get('tanggal_pelaksanaan')" class="mt-2" />
                        </div>

                        <div class="col-span-2">
                            <x-button.primary-button type="submit">
                                {{ __('Simpan') }}
                            </x-button.primary-button>
                        </div>

                    </x-form>
                </x-card.card-default>
            </div>
        </div>
    </div>

</x-app-layout>
