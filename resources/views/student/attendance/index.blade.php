<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div id="toast-top-left" class="hidden toast toast-top toast-start z-[999] top-16 left-0">
                <div class="alert alert-info">
                    <span id="notif"></span>
                </div>
            </div>
            <div
                class="bg-gradient-to-tr from-red-primary to-red-secondary rounded-lg shadow-inner shadow-white p-2 mx-auto w-[90%]">
                <div class="pb-2 px-2 border-b-2 border-white text-white">
                    <h1 class="text-[18px] font-semibold">Form Absensi</h1>
                    <p class="text-[12px] italic text-white/80">Silahkan pilih status kehadiran anda</p>
                </div>
                <div class="flex flex-col p-2 lg:p-6 text-center w-full ">

                    @include('student.attendance.selector')
                    <div id="locationIframe"></div>
                    <span class="loading loading-spinner text-primary hidden" id="loading"></span>

                    <!-- Buttons for Absen Masuk (Hadir) and Absen Pulang -->
                    <x-button.primary-button id="AbsenHadir" class="mt-3 hidden">Absen Hadir
                    </x-button.primary-button>
                    <x-button.primary-button id="AbsenPulang" class="mt-3 hidden">Absen Pulang</x-button.primary-button>


                    <button id="sendPermit" class="mt-3 btn bg-[#ffad01] hover:bg-[#ffad01]/90 hidden text-white">Absen
                        Izin</button>
                    <x-button.warning-button id="sendSick" class="mt-3 hidden">Absen Sakit</x-button.warning-button>

                    <!-- Error message for location permission -->
                    <p id="note-error" class="hidden font-light text-gray-500 sm:text-lg dark:text-gray-400">
                        Anda Tidak Bisa Melakukan Absen, Silahkan Refresh Browser Lalu Aktifkan / Izinkan / Allow Lokasi
                        Anda.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        @include('student.attendance.script')
    </x-slot>
</x-app-layout>
