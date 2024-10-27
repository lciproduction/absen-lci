    <section class="py-20">
    <x-card.card-default class="static bg-gradient-to-tr from-red-950 to-red-700 mx-auto shadow-inner shadow-yellow-500">
        <div class="w-full h-full">
            <div class="flex gap-6 w-full flex-col justify-center items-center lg:flex-row">
                <img src="{{ asset('assets/images/student1.svg') }}"
                    class="md:max-w-sm max-w-40 rounded-lg object-cover" />
                <div class="w-full">
                    <div>
                        <p class="text-left font-bold text-white">
                            Sistem Absensi MSIB Batch 7 Muda Berkreaksi ID Next Leader x KEMENPORA

                        </p>
                        <p class="mt-4 text-gray-300">
                            Sistem ini mempermudah siswa untuk mencatat kehadiran mereka secara online dan real-time.
                        </p>
                    </div>
                    <div class="flex items-center justify-center mt-4">
                        <a href="{{ route('student.attendance.index') }}">
                            <button class="ms-3 btn bg-gradient-to-tr from-yellow-800 to-red-700 text-white hover:bg-red-900/80 hover:text-white" type="button">
                                Absen
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-card.card-default>
</section>
{{-- <section class="py-20">
    <x-card.card-default class="static bg-green-100">
        <div class="w-full h-full">
            <div class="flex gap-6 w-full flex-col justify-center items-center lg:flex-row">
                <img src="{{ asset('assets/images/student2.svg') }}"
                    class="md:max-w-sm max-w-40 rounded-lg object-cover" />
                <div class="w-full">
                    <div>
                        <p class="text-left">
                            "Pendidikan adalah paspor untuk masa depan, karena hari esok adalah milik mereka yang
                            mempersiapkannya hari ini."
                        </p>
                    </div>
                    <div class="flex items-center justify-center mt-4">
                        <a href="{{ route('student.subject.index') }}">
                            <x-button.primary-button class="ms-3" type="button">
                                Mapel
                            </x-button.primary-button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-card.card-default>
</section> --}}
<section class="py-20 p-8">
    <div class="w-full h-full">
        <div class="flex gap-6 w-full flex-col justify-center items-center lg:flex-row-reverse">
            <img src="{{ asset('assets/images/student3.svg') }}" class="md:max-w-sm max-w-40 rounded-lg object-cover" />
            <div class="w-full">
                <div>
                    <p class="text-left text-white">
                        Berikut adalah catatan lengkap kehadiran Anda. Pastikan untuk memeriksa dan menjaga kehadiran
                        Anda tetap konsisten.
                    </p>
                </div>
                <div class="flex items-center justify-center mt-4">
                    <a href="{{ route('student.history.index') }}">
                        <button class="ms-3 btn bg-gradient-to-tr from-red-950 to-red-700 text-white hover:bg-red-900/80 hover:text-white" type="button">
                            Riwayat Kehadiran
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
