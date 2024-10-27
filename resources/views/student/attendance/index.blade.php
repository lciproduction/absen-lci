<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div id="toast-top-left" class="hidden toast toast-top toast-start">
                <div class="alert alert-info">
                    <span id="notif"></span>
                </div>
            </div>
            <div class=" bg-gradient-to-tr from-red-950 to-red-700 rounded-lg shadow-inner shadow-yellow-500  p-2 mx-auto w-[90%]">

                <div class="flex flex-col p-2 lg:p-6  text-center w-full ">
                    @include('student.attendance.selector')
                    <div id="locationIframe"></div>

                    <span class="loading loading-spinner text-primary hidden" id="loading"></span>
                    <x-button.primary-button id="HadirWFO" class="mt-3 hidden">Absen</x-button.primary-button>
                    <x-button.primary-button id="HadirWFH" class="mt-3 hidden">Absen</x-button.primary-button>
                    <button id="sendPermit" class="mt-3 btn bg-gradient-to-tr from-red-950 to-red-700 hidden text-white">Absen</button>
                    <x-button.warning-button id="sendSick" class="mt-3 hidden">Absen</x-button.warning-button>
                    <p id="note-error" class="hidden font-light text-gray-500 sm:text-lg dark:text-gray-400">
                        Anda Tidak Bisa Melakukan Absen, Silahkan Refresh Browser Lalu Aktifkan / Izinkan / Allow Lokasi Anda.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        @include('student.attendance.script')
    </x-slot>
</x-app-layout>

{{-- <div class="mt-4 mb-4">
    <x-input.input-label for="status" :value="__('Status')" />
    <x-input.select-input id="status" class="mt-1 w-full" type="text" name="status" required autofocus autocomplete="status">
        <option value="" disabled selected>Pilih Status Kehadiran</option>
        <option value="HadirWFO">Hadir WFOoozx</option>
        <option value="HadirWFH">Hadir WFH</option>
        <option value="Izin">Izin</option>
        <option value="Sakit">Sakit</option>
    </x-input.select-input>
</div>
<div class="hidden" id="permit">
    <x-input.input-label for="izin" :value="__('Keterangan')" />
    <x-input.text-input id="izin" name="permit" class="mt-1 w-full" type="text" maxlength="50" placeholder="Acara Keluarga" required />
</div>
<div class="hidden" id="fileUpload">
    <x-input.input-label for="sickFile" :value="__('Surat Keterangan')" />
    <x-input.text-input id="sickFile" name="sickFile" class="mt-1 w-full" type="file" maxlength="50" required />
</div> --}}
