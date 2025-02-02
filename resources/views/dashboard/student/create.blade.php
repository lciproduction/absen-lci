@section('title', 'Tambah Data Siswa')

<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <a href="{{ route('student.index') }}">
                    <button class="btn bg-red-primary text-white">
                        <i class="fa-solid fa-arrow-left"></i>
                        Kembali
                    </button>
                </a>
                <x-card.card-default
                    class="static bg-gradient-to-tr from-red-primary to-red-secondary shadow-lg border-4 border-white mx-auto mt-5">


                    <x-form action="{{ route('student.store') }}" class="md:grid md:grid-cols-2 gap-4"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="mt-4">
                            <x-input.input-label for="photo" class="text-white" :value="__('Foto')" />
                            <x-input.input-file id="photo" class="mt-1 w-full" type="file" name="photo"
                                :value="old('photo')" autofocus autocomplete="photo" />
                            <x-input.input-error :messages="$errors->get('photo')" class="mt-2" />
                        </div>

                        <div class="mt-4 ">
                            <x-input.input-label for="nisn" class="text-white" :value="__('Password')" />
                            <x-input.text-input id="nisn" class="mt-1 w-full" type="password" name="nisn"
                                :value="old('nisn')" required autofocus autocomplete="nisn" />
                            <x-input.input-error :messages="$errors->get('nisn')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input.input-label for="name" class="text-white" :value="__('User Name')" />
                            <x-input.text-input id="username" class="mt-1 w-full" type="text" name="username"
                                :value="old('username')" required autofocus autocomplete="username" />
                            <x-input.input-error :messages="$errors->get('username')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input.input-label for="name" class="text-white" :value="__('Nama')" />
                            <x-input.text-input id="name" class="mt-1 w-full" type="text" name="name"
                                :value="old('name')" required autofocus autocomplete="name" />
                            <x-input.input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input.input-label for="email" class="text-white" :value="__('Email')" />
                            <x-input.text-input id="email" class="mt-1 w-full" type="text" name="email"
                                :value="old('email')" required autofocus autocomplete="email" />
                            <x-input.input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input.input-label for="rombel" class="text-white" :value="__('Divisi')" />
                            <x-input.select-input id="rombel" class="mt-1 w-full" type="text" name="rombel"
                                required autofocus autocomplete="rombel">
                                <option value="" disabled selected>Pilih Divisi</option>
                                @foreach ($divisions as $rombel)
                                    <option value="{{ $rombel['name'] }}"
                                        {{ old('rombel') == $rombel['name'] ? ' selected' : ' ' }}>
                                        {{ $rombel['name'] }}</option>
                                @endforeach
                            </x-input.select-input>
                        </div>

                        <div class="mt-4">
                            <x-input.input-label for="gender" class="text-white" :value="__('Jenis Kelamin')" />
                            <x-input.select-input id="gender" class="mt-1 w-full" type="text" name="gender"
                                required autofocus autocomplete="gender">
                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                <option value="Laki - Laki" {{ old('gender') == 'Laki - Laki' ? ' selected' : ' ' }}>
                                    Laki -
                                    Laki
                                </option>
                                <option value="Perempuan" {{ old('gender') == 'Perempuan' ? ' selected' : ' ' }}>
                                    Perempuan
                                </option>
                            </x-input.select-input>
                        </div>


                        <div class="mt-4">
                            <x-input.input-label for="phone" class="text-white" :value="__('Telepon')" />
                            <x-input.text-input id="phone" class="mt-1 w-full" type="text" name="phone"
                                :value="old('phone')" required autofocus autocomplete="phone" />
                            <x-input.input-error :messages="$errors->get('phone')" class="mt-2" />

                        </div>

                        <div class="mt-4">
                            <x-input.input-label for="jabatan" class="text-white" :value="__('Jabatan')" />
                            <x-input.text-input id="jabatan" class="mt-1 w-full" type="text" name="jabatan"
                                :value="old('jabatan')" required autofocus autocomplete="jabatan" />
                            <x-input.input-error :messages="$errors->get('jabatan')" class="mt-2" />
                        </div>

                        <!-- Checkbox untuk Hari Wajib -->
                        {{-- <div class="mt-4">
                            <x-input.input-label for="days[]" class="text-white" :value="__('Hari Wajib')" />
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 mt-2">
                                @foreach ($days as $day)
                                    <div class="form-control">
                                        <label class=" cursor-pointer ">
                                            <input type="checkbox" name="days[]" value="{{ $day->id }}"
                                                class="checkbox"
                                                {{ in_array($day->id, old('days', [])) ? 'checked' : '' }}>
                                            <span
                                                class="label-text text-[16px] text-white pl-2">{{ $day->name }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <x-input.input-error :messages="$errors->get('days')" class="mt-2" />
                        </div> --}}

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
