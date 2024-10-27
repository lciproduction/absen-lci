@section('title', 'Detail Absen')

<x-app-layout>

    <div class="py-12">
        <div class="flex justify-between items-center px-5">
                    <a href="{{ route('student.history.index') }}">
                        <button class="btn bg-gradient-to-tr from-red-950 to-red-700 shadow-inner shadow-yellow-500 text-white">
                            <i class="fa-solid fa-arrow-left"></i>
                            Kembali
                        </button>
                    </a>
                        @php
                            $timeInEarly = Carbon\Carbon::createFromFormat('H:i:s', $waktuAbsen->time_in_early);
                            $timeInLate = Carbon\Carbon::createFromFormat('H:i:s', $waktuAbsen->time_in_lately);
                            $timeOutEarly = Carbon\Carbon::createFromFormat('H:i:s', $waktuAbsen->time_out_early);
                            $timeOutLate = Carbon\Carbon::createFromFormat('H:i:s', $waktuAbsen->time_out_lately);
                            $currentTime = Carbon\Carbon::now();
                        @endphp

                                            @if (
                            $currentTime->between($timeInEarly, $timeInLate) ||
                            $currentTime->between($timeOutEarly, $timeOutLate)
                        )
                            <x-button.danger-button class="btn text-white" onclick="my_modal_1.showModal()">
                                <i class="fa-regular fa-trash-can"></i>
                                Hapus
                            </x-button.danger-button>
                        <dialog id="my_modal_1" class="modal bg-base-200">
                            <div class="modal-box p-4">
                                <h3 class="text-lg font-bold">Halo {{ auth()->user()->student->name }}</h3>

                                <p class="mt-4">Note : Absen yang bisa dihapus hanya absen masuk </p>
                                <p>jika kamu menghapus absen masuk di jam setelah absen masuk berakhir </p>
                                <p>lalu kamu melakukan absen lagi, maka status absen masuk kamu berubah menjadi
                                    terlambat.</p>
                                <p>Penghapusan Absen dilakukan hanya jika kamu salah menginput status absen.</p>
                                <p class="py-4">Apakah kamu yakin ingin menghapus absen ini?</p>
                                <div class="modal-action flex justify-start mt-4 space-x-4">
                                    <x-form action="{{ route('student.history.destroy', $attendance->id) }}"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <x-button.danger-button type="submit" class="text-white"
                                            onclick="return confirm('Kamu Yakin Ingin Menghapus Absen Ini?')">
                                            Yakin
                                        </x-button.danger-button>
                                    </x-form>
                                    <x-form method="dialog" class="inline">
                                        <!-- if there is a button in form, it will close the modal -->
                                        <button class="btn">Tidak</button>
                                    </x-form>
                                </div>
                            </div>
                        </dialog>
                    @endif
                </div>
         <div class="static overflow-x-auto mx-auto px-5 mt-10">



                <div class="stats w-full text-white bg-gradient-to-tr from-red-950 to-red-700 shadow-inner shadow-yellow-500">

                    <div class="stat place-items-center">
                        <div class="stat-title text-lg text-yellow-500">Biodata</div>
                        <div class="stat-value text-base">{{ $attendance->student->name }}</div>
                        <div class="stat-desc text-white/80">{{ $attendance->student->divisi }} -
                            {{ $attendance->student->phone }} </div>
                    </div>

                    <div class="stat place-items-center">
                        <div class="stat-title text-lg text-yellow-500">Status</div>
                        <div class="stat-value text-base text-white">
                            {{  $attendance->status }}
                        </div>

                        <div class="stat-desc text-white/80">{{ $attendance->created_at }}</div>
                    </div>

                    @if ($attendance->status == 'Izin' || $attendance->status == 'Sakit')

                        <div class="stat place-items-center">
                            <div class="stat-title text-lg text-yellow-500">Keterangan</div>
                            <div class="stat-value text-base">
                                @if ($attendance->status == 'Izin')
                                    {{ $attendance->note }}
                                @else
                                    <a href="{{ asset('storage/attendance/' . $attendance->student->name . '/' . $attendance->note) }}"
                                        target="_blank">
                                        <span class="badge badge-primary">Surat Sakit</span>
                                    </a>
                                @endif
                            </div>

                        </div>

                    @endif

                </div>

            </div>
    </div>

</x-app-layout>
