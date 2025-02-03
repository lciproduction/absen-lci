@section('title', 'Edit Data Siswa')

<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <a href="{{ route('karyawan.index') }}">
                    <x-button.info-button>
                        <i class="fa-solid fa-arrow-left"></i>
                        Kembali
                    </x-button.info-button>
                </a>

                <x-card.card-default
                    class="static bg-gradient-to-tr from-red-primary to-red-secondary shadow-lg border-4 border-white mx-auto mt-5">

                    <x-form action="{{ route('karyawan.update', $student->id) }}" class="md:grid md:grid-cols-2 gap-4"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <input type="hidden" name="oldImage" value="{{ $student->photo }}">
                        @if ($student->photo)
                            <div class="avatar">
                                <div class="w-12 rounded-xl">
                                    <img src="{{ asset('storage/student/photo/' . $student->photo) }}" />
                                </div>
                            </div>
                        @endif
                        <div class="mt-4">
                            <x-input.input-label for="photo" class="text-white" :value="__('Foto')" />
                            <x-input.input-file id="photo" class="mt-1 w-full" type="file" name="photo"
                                :value="old('photo', $student->photo)" />
                            <x-input.input-error :messages="$errors->get('photo')" class="mt-2" />
                        </div>
                        <div class="mt-4 ">
                            <x-input.input-label for="password" class="text-white" :value="__('New Password')" />
                            <x-input.text-input id="password" class="mt-1 w-full" type="password" name="password"
                                :value="old('password')" autofocus autocomplete="password" />
                            <x-input.input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input.input-label for="name" class="text-white" :value="__('User Name')" />
                            <x-input.text-input id="username" class="mt-1 w-full" type="text" name="username"
                                :value="old('username', $student->username)" required autofocus autocomplete="username" />
                            <x-input.input-error :messages="$errors->get('username')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input.input-label for="name" class="text-white" :value="__('Nama')" />
                            <x-input.text-input id="name" class="mt-1 w-full" type="text" name="name"
                                :value="old('name', $student->name)" required autofocus autocomplete="name" />
                            <x-input.input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input.input-label for="email" class="text-white" :value="__('Email')" />
                            <x-input.text-input id="email" class="mt-1 w-full" type="text" name="email"
                                :value="old('email', $student->email)" required autofocus autocomplete="email" />
                            <x-input.input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input.input-label for="divisi" class="text-white" :value="__('Divisi')" />
                            <x-input.select-input id="divisi" class="mt-1 w-full" type="text" name="divisi"
                                required autofocus autocomplete="divisi">
                                <option value="" disabled selected>Pilih Divisi</option>
                                @foreach ($divisions as $rombel)
                                    <option value="{{ $rombel['name'] }}"
                                        {{ old('divisi', $student->divisi) == $rombel['name'] ? ' selected' : ' ' }}>
                                        {{ $rombel['name'] }}</option>
                                @endforeach
                            </x-input.select-input>
                        </div>

                        <div class="mt-4">
                            <x-input.input-label for="gender" class="text-white" :value="__('Jenis Kelamin')" />
                            <x-input.select-input id="gender" class="mt-1 w-full" type="text" name="gender"
                                required autofocus autocomplete="gender">
                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                <option value="Laki - Laki"
                                    {{ old('gender', $student->gender) == 'Laki - Laki' ? ' selected' : ' ' }}>Laki -
                                    Laki
                                </option>
                                <option value="Perempuan"
                                    {{ old('gender', $student->gender) == 'Perempuan' ? ' selected' : ' ' }}>
                                    Perempuan</option>
                            </x-input.select-input>
                        </div>
                        {{-- <div class="mt-4">
                            <x-input.input-label for="phone" class="text-white" :value="__('Asal Universitas')" />
                            <x-input.select-input id="phone" class="mt-1 w-full" type="text" name="phone"
                                required autofocus autocomplete="phone">
                                <option value="" disabled selected>Pilih Universitas</option>
                                @foreach ($university as $phone)
                                    <option value="{{ $phone['name'] }}"
                                        {{ old('phone') == $phone['name'] ? ' selected' : ' ' }}>
                                        {{ $phone['name'] }}</option>
                                @endforeach

                            </x-input.select-input>
                            <x-input.input-error :messages="$errors->get('phone')" class="mt-2" />

                        </div> --}}

                        <div class="mt-4">
                            <x-input.input-label for="phone" class="text-white" :value="__('Telepon')" />
                            <x-input.text-input id="phone" class="mt-1 w-full" type="text" name="phone"
                                :value="old('phone', $student->phone)" required autofocus autocomplete="phone" />
                            <x-input.input-error :messages="$errors->get('phone')" class="mt-2" />

                        </div>

                        <div class="mt-4">
                            <x-input.input-label for="jabatan" class="text-white" :value="__('Jabatan')" />
                            <x-input.text-input id="jabatan" class="mt-1 w-full" type="text" name="jabatan"
                                :value="old('jabatan', $student->jabatan)" required autofocus autocomplete="jabatan" />
                            <x-input.input-error :messages="$errors->get('jabatan')" class="mt-2" />
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
