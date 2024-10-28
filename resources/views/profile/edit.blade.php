@section('title', 'Profile')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="h-full py-12 p-2 ">
        <x-card.card-default class="bg-gradient-to-tr from-red-950 to-red-700 shadow-inner shadow-yellow-500 w-[90%] text-white  pb-8 mx-auto">
            <div class="flex flex-col items-center -mt-20">
                @if (!Auth::user()->student->photo)
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
                <img class="imgPreview border-4 h-32 w-32 object-cover object-center bg-base-100 border-base-100 rounded-full hidden" alt="image">
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

                <p class="text-sm text-yellow-500">{{ Auth::user()->student->point ?? '-' }}</p>
            </div>
        </x-card.card-default>

        <div class="my-4 flex flex-col 2xl:flex-row space-y-4 2xl:space-y-0 2xl:space-x-4 ">
            <div class="w-full flex flex-col 2xl:w-1/3">
                <x-card.card-default class="flex-1 glass static p-8 mx-auto bg-gradient-to-tr from-red-950 to-red-700 shadow-inner shadow-yellow-500 text-white">
                    @if (session()->has('success'))
                        <x-alert.success :message="session('success')" />
                    @endif

                    <h4 class="text-xl font-bold">Personal Info (Incomming...🚀)</h4>
                    <x-form action="{{ route('profile.update') }}" enctype="multipart/form-data" >
                        @csrf
                        <input type="hidden" name="oldImage" value="{{ Auth::user()->student->photo }}" disabled>
                        <div class="mt-4">
                            <x-input.input-label for="photo" :value="__('Foto')" class="text-white" />
                            <x-input.input-file id="photo" class="mt-1 w-full" type="file" name="photo"
                                onchange="previewImage()" :value="old('photo')" disabled />
                            <x-input.input-error :messages="$errors->get('photo')" class="mt-2" disabled />
                        </div>
                        <div class="mt-4">
                            <x-input.input-label for="phone" :value="__('No Telpon')" class="text-white"  disabled/>
                            <x-input.text-input id="phone" class="mt-1 w-full" type="number" name="phone"
                                :value="old('phone', Auth::user()->student->phone ?? '')" autofocus autocomplete="phone" disabled/>
                            <x-input.input-error :messages="$errors->get('phone')" class="mt-2" disabled/>
                        </div>
                        <div class="mt-4">
                            <x-input.input-label for="address" :value="__('Alamat')" class="text-white"  disabled/>
                            <x-input.text-input id="address" class="mt-1 w-full" type="text" name="address"
                                :value="old('address', Auth::user()->student->address ?? '')" autofocus autocomplete="address" disabled/>
                            <x-input.input-error :messages="$errors->get('address')" class="mt-2"disabled />
                        </div>

                        <div class="mt-4">
                            <x-button.primary-button type="submit" disabled class="text-white border border-white">
                                {{ __('Simpan') }}
                            </x-button.primary-button>
                        </div>
                    </x-form>
                </x-card.card-default>
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
