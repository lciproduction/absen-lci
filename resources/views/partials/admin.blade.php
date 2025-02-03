<x-card.card-default class="static bg-gradient-to-tr from-red-primary to-red-secondary border-4 border-white mx-auto">
    <div class="w-full h-full">
        <div class="flex gap-6 w-full flex-col justify-center items-center lg:flex-row">
            <img src="{{ asset('assets/images/admin1.svg') }}" class="md:max-w-sm max-w-40 rounded-lg object-cover" />
            <div class="w-full">
                <div>
                    <p class="text-left text-white">
                        "Data Karyawan yang terdaftar dalam sistem absensi. Pastikan semua informasi terkait siswa
                        seperti
                        nama, nomor induk, kelas, dan detail lainnya sudah sesuai dengan data yang tercatat."
                    </p>
                </div>
                <div class="flex items-center justify-center mt-4">
                    <x-button.primary-button class="ms-3" type="button">
                        Data Karyawan
                    </x-button.primary-button>
                </div>
            </div>
        </div>
    </div>
</x-card.card-default>



<section class="py-20 p-8">
    <div class="w-full h-full">
        <div class="flex gap-6 w-full flex-col-reverse justify-center items-center lg:flex-row">
            <div class="w-full">
                <div>
                    <p class="text-left text-red-secondary font-semibold">
                        "Data absensi harian yang mencakup daftar siswa/guru yang hadir, terlambat, atau absen. Data ini
                        akan diperbarui secara otomatis setiap kali absensi diisi. Silakan periksa dan pastikan semua
                        informasi telah tercatat dengan benar."
                    </p>
                </div>
                <div class="flex items-center justify-center mt-4">
                    <a href="{{ route('student.acara.karyawan') }}">
                        <x-button.primary-button class="ms-3" type="button">
                            Data Absensi
                        </x-button.primary-button>

                </div>
            </div>
            <img src="{{ asset('assets/images/admin3.svg') }}" class="md:max-w-sm max-w-40 rounded-lg object-cover" />

        </div>
    </div>
</section>

{{-- <section class="py-20 bg-gradient-to-tr from-red-primary to-red-secondary border-4 border-white rounded p-8">
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
</section> --}}
<x-card.card-default
    class="static bg-gradient-to-tr from-red-primary to-red-secondary shadow-lg border-4 border-white mx-auto">

    <div class="flex lg:flex-row flex-col  gap-6 w-full justify-center items-center  ">
        <div class=" lg:w-1/2 w-full mx-auto">

            <div class="flex items-center justify-around ">
                <div class="w-20 flex">
                    <canvas id="chart" width="10" height="10"></canvas>
                </div>

            </div>
        </div>
        <div class="lg:w-1/2 w-full text-center text-white">
            <h1 class="text-xl text-center font-semibold text-white px-5 mb-5 border-b border-white pb-1">Data Analytics
                Daily
            </h1>
            <p>"Setiap titik pada grafik mewakili jumlah karyawan yang hadir pada hari tertentu.
                Dengan informasi ini, Anda dapat mengambil langkah-langkah yang diperlukan untuk
                meningkatkan kehadiran, seperti mengadakan kegiatan motivasi atau memberikan
                pengingat kepada karyawan."</p>
        </div>


    </div>
</x-card.card-default>

<section class="py-20">
    <div class="hero ">
        <div class="hero-content flex-col lg:flex-row-reverse">
            <img src="{{ asset('assets/images/admin2.svg') }}" class="md:max-w-sm max-w-40 rounded-lg object-cover" />
            <div>
                <p class="py-6 text-red-secondary font-semibold ">
                    "Fitur ini memungkinkan Anda untuk menentukan jam masuk awal dan jam masuk akhir, serta jam pulang
                    awal dan jam pulang akhir. Dengan pengaturan ini, Anda dapat memastikan bahwa semua karyawan atau
                    siswa dapat mencatat kehadiran mereka dengan akurat sesuai dengan jadwal yang telah ditetapkan,
                    sehingga memudahkan dalam pengelolaan absensi dan meningkatkan disiplin waktu."
                </p>
                <div class="flex items-center justify-center mt-4">
                    <x-button.primary-button class="ms-3" type="button">
                        Waktu Absensi
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
