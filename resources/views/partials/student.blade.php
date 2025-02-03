    <section class="py-20">
        <x-card.card-default
            class="static bg-gradient-to-tr from-red-primary to-red-secondary mx-auto shadow-inner shadow-white">
            <div class="w-full h-full">
                <div class="flex gap-6 w-full flex-col justify-center items-center lg:flex-row">
                    <img src="{{ asset('assets/images/student1.svg') }}"
                        class="md:max-w-sm max-w-40 rounded-lg object-cover" />
                    <div class="w-full">
                        <div>
                            <p class="text-left font-bold text-white">
                                Sistem Absensi Karyawan Local Champion Production

                            </p>
                            <p class="mt-4 text-gray-300">
                                Sistem ini mempermudah Karyawan untuk mencatat kehadiran mereka secara online dan
                                real-time.
                            </p>
                        </div>
                        <div class="flex items-center justify-center mt-4">
                            <a href="{{ route('student.attendance.index') }}">
                                <button class="ms-3 btn bg-[#3674B5] text-white hover:bg-[#3674B5]/80 hover:text-white"
                                    type="button">
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
                <img src="{{ asset('assets/images/student3.svg') }}"
                    class="md:max-w-sm max-w-40 rounded-lg object-cover" />
                <div class="w-full">
                    <div>
                        <p class="text-left text-[#3674B5] font-semibold">
                            Jangan lewatkan kesempatan untuk menjadi bagian dari acara-acara menarik yang akan datang!
                            Di bawah ini, Anda akan menemukan tabel lengkap yang menampilkan semua acara yang akan
                            diselenggarakan, termasuk tanggal dan deskripsi. Pastikan untuk memeriksa jadwal yang Anda
                            minati. Bergabunglah dengan kami dan jadikan setiap momen berharga !
                        </p>
                    </div>
                    <div class="flex items-center justify-center mt-4">
                        <a href="{{ route('student.acara.karyawan') }}">
                            <button
                                class="ms-3 btn bg-gradient-to-tr from-red-primary to-red-secondary text-white hover:bg-red-secondary/80 hover:text-white"
                                type="button">
                                Agenda Kami
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
