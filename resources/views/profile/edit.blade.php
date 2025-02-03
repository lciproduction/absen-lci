@section('title', 'Profile')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="h-full py-12 p-2 ">
        <x-card.card-default
            class="bg-gradient-to-tr from-red-primary to-red-secondary shadow-lg w-[90%] border-4 border-white text-white  pb-8 mx-auto">
            <div class="flex flex-col items-center -mt-20">
                @if (Auth::user()->student->photo)
                    <div>
                        <img src="{{ asset('storage/student/photo/' . Auth::user()->student->photo) }}" id="imgReal"
                            class="h-32 w-32 object-cover object-center border-4 border-white rounded-full">

                    </div>
                @else
                    @if (Auth::user()->student->gender == 'Laki - Laki')
                        <img src="{{ asset('assets/images/male.png') }}" id="imgReal"
                            class="w-40 border-4 bg-base-100 border-base-100 rounded-full">
                    @else
                        <img src="{{ asset('assets/images/female.png') }}" id="imgReal"
                            class="w-40 border-4 bg-base-100 border-base-100 rounded-full">
                    @endif
                @endif
                <img class="imgPreview border-4 h-32 w-32 object-cover object-center bg-base-100 border-base-100 rounded-full hidden"
                    alt="image">
                <div class="flex items-center space-x-2 mt-2">
                    <p class="md:text-2xl text-xl text-center">{{ Auth::user()->student->name }}</p>
                </div>
                <p>
                    @if (Auth::user()->student->divisi == 'Govrel')
                        Government and Stakeholder Relations
                    @elseif (Auth::user()->student->divisi == 'Comprel')
                        Community and Corporate Relations
                    @else
                        {{ Auth::user()->student->divisi }}
                    @endif
                </p>

                {{-- <p class="text-sm text-yellow-500">{{ Auth::user()->student->point ?? '-' }}</p> --}}
            </div>
        </x-card.card-default>

        <div class="my-4 ">
            <div
                class=" w-[97%] lg:w-[90%] mx-auto flex flex-col 2xl:w-1/3 bg-gradient-to-tr from-red-primary to-red-secondary border-4 border-white shadow-lg text-white  rounded-xl py-5 space-y-5">
                <h4 class="text-xl font-bold px-3 text-center">Catatan Profile</h4>

                <div class="flex-1 static px-5">


                    @if (Auth::user()->student->address)
                        <div class="capitalize text-center">{{ Auth::user()->student->address }}</div>
                    @else
                        <div>-</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="my-4 ">
            <div
                class=" w-[97%] lg:w-[90%] mx-auto flex flex-col 2xl:w-1/3 bg-gradient-to-tr from-red-primary to-red-secondary border-4 border-white shadow-lg text-white  rounded-xl py-5 space-y-5">
                @if (session()->has('success'))
                    <x-alert.success :message="session('success')" />
                @endif

                <h4 class="text-xl font-bold px-5">Personal Info</h4>
                <x-form action="{{ route('student.profile.update') }}" enctype="multipart/form-data" class="px-5">
                    @csrf
                    <input type="hidden" name="oldImage" value="{{ Auth::user()->student->photo }}">
                    <div class="mt-4">
                        <x-input.input-label for="photo" :value="__('Foto')" class="text-white" />
                        <x-input.input-file id="photo" class="mt-1 w-full text-black" type="file" name="photo"
                            onchange="previewImage()" :value="old('photo')" />
                        <x-input.input-error :messages="$errors->get('photo')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input.input-label for="address" :value="__('Catatan Profile')" class="text-white" />
                        {{-- <x-input.text-input id="address" class="mt-1 w-full" type="text" name="address"
                                :value="old('address', Auth::user()->student->address ?? '')" autofocus autocomplete="address" /> --}}
                        <x-input.input-error :messages="$errors->get('address')" class="mt-2" />
                        <textarea id="address" class="mt-1 w-full textarea text-black" name="address" autofocus autocomplete="address">{{ old('address', Auth::user()->student->address ?? '') }}</textarea>


                    </div>

                    <div class="mt-4">
                        <x-button.primary-button type="submit" class="text-white border border-white">
                            {{ __('Simpan') }}
                        </x-button.primary-button>
                    </div>
                </x-form>
            </div>
        </div>



    </div>
    <x-slot name="script">
        <script>
            function previewImage() {
                const image = document.querySelector('#photo')
                const imageReal = document.querySelector('#imgReal')
                const imgPreview = document.querySelector('.imgPreview')

                imageReal.classList.add('hidden');
                imgPreview.classList.remove('hidden');
                imgPreview.classList.add('block');

                const oFReader = new FileReader()
                oFReader.readAsDataURL(image.files[0])
                oFReader.onload = function(oFREvent) {
                    imgPreview.src = oFREvent.target.result
                }
            }
        </script>
    </x-slot>
</x-app-layout>
