<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div id="toast-top-left" class="hidden toast toast-top toast-start">
                <div class="alert alert-info">
                    <span id="notif"></span>
                </div>
            </div>
            <div class="bg-gradient-to-tr from-red-950 to-red-700 rounded-lg shadow-inner shadow-yellow-500 p-2 mx-auto w-[90%]">
                <div class="flex flex-col p-2 lg:p-6 text-center w-full ">
                    @include('student.attendance.selector')
                    <div id="locationIframe"></div>
                    <span class="loading loading-spinner text-primary hidden" id="loading"></span>

                    <!-- Buttons for Absen Masuk (Hadir) and Absen Pulang -->
                    <x-button.primary-button id="HadirWFO" class="mt-3 hidden">Absen Hadir WFO</x-button.primary-button>
                    <x-button.primary-button id="HadirWFH" class="mt-3 hidden">Absen Hadir WFH</x-button.primary-button>
                    <x-button.primary-button id="PulangWFO" class="mt-3 hidden">Absen Pulang WFO</x-button.primary-button>
                    <x-button.primary-button id="PulangWFH" class="mt-3 hidden">Absen Pulang WFH</x-button.primary-button>

                    <button id="sendPermit" class="mt-3 btn bg-gradient-to-tr from-red-950 to-red-700 hidden text-white">Absen Izin</button>
                    <x-button.warning-button id="sendSick" class="mt-3 hidden">Absen Sakit</x-button.warning-button>

                    <!-- Error message for location permission -->
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
