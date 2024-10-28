<x-card.card-default class="static bg-gradient-to-tr from-red-950 to-red-700 shadow-inner shadow-yellow-500 mx-auto">
    <div class="w-full h-full">
        <div class="flex gap-6 w-full flex-col justify-center items-center lg:flex-row">
            <img src="{{ asset('assets/images/admin1.svg') }}" class="md:max-w-sm max-w-40 rounded-lg object-cover" />
            <div class="w-full">
                <div>
                    <p class="text-left text-white">
                        "Data siswa yang terdaftar dalam sistem absensi. Pastikan semua informasi terkait siswa seperti
                        nama, nomor induk, kelas, dan detail lainnya sudah sesuai dengan data yang tercatat."
                    </p>
                </div>
                <div class="flex items-center justify-center mt-4">
                    <x-button.primary-button class="ms-3" type="button">
                        Data Siswa
                    </x-button.primary-button>
                </div>
            </div>
        </div>
    </div>
</x-card.card-default>

<section class="py-20">
    <div class="hero ">
        <div class="hero-content flex-col lg:flex-row-reverse">
            <img src="{{ asset('assets/images/admin2.svg') }}" class="md:max-w-sm max-w-40 rounded-lg object-cover" />
            <div>
                <p class="py-6 text-white">
                    "Daftar guru yang terdaftar dalam sistem absensi. Anda dapat melihat informasi seperti nama guru,
                    mata pelajaran yang diampu, dan kelas yang diajar. Pastikan data yang ditampilkan sudah sesuai
                    dengan catatan sekolah."
                </p>
                <div class="flex items-center justify-center mt-4">
                    <x-button.primary-button class="ms-3" type="button">
                        Data Guru
                    </x-button.primary-button>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-gradient-to-tr from-red-950 to-red-700 shadow-inner shadow-yellow-500 rounded p-8">
    <div class="grid lg:grid-cols-3 gap-6 grid-cols-1 md:grid-cols-2">
        <x-card.card-default class="static">
            <h2 class=" text-yellow-500 text-center font-bold text-lg">Matematika</h2>
            <p class="text-center text-white">Mata pelajaran ini mengajarkan kita untuk lebih memahami, menggunakan, dan
                menghargai Bahasa
                Indonesia sebagai alat komunikasi dan ekspresi diri.</p>
        </x-card.card-default>
        <x-card.card-default class="static">
            <h2 class=" text-yellow-500 text-center font-bold text-lg">Indonesia</h2>
            <p class="text-center text-white">Mata pelajaran ini mengajarkan kita untuk lebih memahami, menggunakan, dan
                menghargai Bahasa
                Indonesia sebagai alat komunikasi dan ekspresi diri.</p>
        </x-card.card-default>
        <x-card.card-default class="static">
            <h2 class=" text-yellow-500 text-center font-bold text-lg">Inggris</h2>
            <p class="text-center text-white">Mata pelajaran ini mengajarkan kita untuk lebih memahami, menggunakan, dan
                menghargai Bahasa
                Indonesia sebagai alat komunikasi dan ekspresi diri.</p>
        </x-card.card-default>
    </div>
    <div class="flex items-center justify-center mt-8">
        <x-button.primary-button class="ms-3" type="button">
            Data Mapel
        </x-button.primary-button>
    </div>
</section>

<section class="py-20 p-8">
    <div class="w-full h-full">
        <div class="flex gap-6 w-full flex-col justify-center items-center lg:flex-row">
            <img src="{{ asset('assets/images/admin3.svg') }}" class="md:max-w-sm max-w-40 rounded-lg object-cover" />
            <div class="w-full">
                <div>
                    <p class="text-left text-white">
                        "Data absensi harian yang mencakup daftar siswa/guru yang hadir, terlambat, atau absen. Data ini
                        akan diperbarui secara otomatis setiap kali absensi diisi. Silakan periksa dan pastikan semua
                        informasi telah tercatat dengan benar."
                    </p>
                </div>
                <div class="flex items-center justify-center mt-4">
                    <x-button.primary-button class="ms-3" type="button">
                        Data Absensi
                    </x-button.primary-button>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- <section class="py-20 p-8">
<div class="w-20">
    <canvas id="chart" width="10" height="10"></canvas>
                 <p>Hadir: {{ $hadir }}</p>
                <p>Sakit: {{ $sakit }}</p>
                <p>Izin: {{ $izin }}</p>
</div>

</section> --}}
