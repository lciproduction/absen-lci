<x-app-layout>
    <div class="py-12 w-full">
        <div class=" mx-auto sm:px-6 lg:px-8 ">
            @hasrole('admin')
                @include('partials.admin')
                <p>Hadir: {{ $hadir }}</p>
                <p>Sakit: {{ $sakit }}</p>
                <p>Izin: {{ $izin }}</p>

            @endrole
            @hasrole('student')
                @include('partials.student')

                <!-- Tabel Absensi untuk Student -->
                <div class="bg-gradient-to-tr from-red-950 to-red-700 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                    <div class="p-6 bg-gradient-to-tr from-red-950 to-red-700 border-b border-gray-200">
                        <h2 class="font-semibold text-xl  leading-tight text-white">
                            Data Absensi
                        </h2>
                        <table class="table-auto w-full mt-4">
                            <thead>
                                <tr class="text-white text-[12px]">
                                    <th class="px-4 py-2">Nama Siswa</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Waktu Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attendances as $attendance)
                                    <tr class="text-white text-sm">
                                        <td class="border px-4 py-2">{{ $attendance->student->name }}</td>
                                        <td class="border px-4 py-2">{{ $attendance->status }}</td>
                                        <td class="border px-4 py-2">{{ $attendance->created_at->format('H:i:s') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center px-4 py-2 text-white">Tidak ada data absensi untuk hari ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="container mx-auto p-4 bg-gradient-to-tr from-red-950 to-red-700 border-b border-gray-200 mt-5 shadow-md rounded-lg">
                    <h3 class="text-2xl font-bold text-center mb-4 text-white">
                        Daftar Siswa Tidak Hadir pada Hari Wajib ({{ Carbon\Carbon::now()->isoFormat('dddd') }})
                    </h3>

                    <!-- Menampilkan pesan jika ada -->
                    @if (isset($message))
                        <div class="alert alert-warning bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 ">
                            {{ $message }}
                        </div>
                    @endif

                    @if ($studentsAbsent->isEmpty())
                        <p class="text-center text-white">Tidak ada siswa yang absen pada hari ini.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="table w-full border-collapse rounded-lg overflow-hidden shadow-lg">
                                <thead class="bg-red-900 text-white">
                                    <tr>
                                        <th class="p-3 text-left">Nama Siswa</th>
                                        <th class="p-3 text-left">Divisi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-50 text-red-950">
                                    @foreach($studentsAbsent as $student)
                                        <tr class="hover:bg-blue-50">
                                            <td class="p-3 border-b">{{ $student->name }}</td>
                                            <td class="p-3 border-b">{{ $student->divisi ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>





            @endrole
            @hasrole('teacher')
                @include('partials.teacher')
            @endrole
        </div>
    </div>

    <x-slot name="script">
        <script>
            const chart = $('#chart').get(0).getContext('2d');
            chart.canvas.parentNode.style.width = '300px';
            chart.canvas.parentNode.style.height = '300px';

            const labels = ['Hadir', 'Sakit', 'Izin'];
            const data = {
                labels: labels,
                datasets: [{
                    label: 'Persentasi Absensi Siswa',
                    data: [{{ $hadir }},
                        {{ $sakit }},
                        {{ $izin }}
                    ],
                    backgroundColor: [
                        'rgb(0, 224, 49)',
                        'rgb(2, 204, 174)',
                        'rgb(234, 237, 19)',
                    ],
                    color: '#ffff',
                    hoverOffset: 4
                }]
            };

            new Chart(chart, {
                type: 'doughnut',
                data: data,
            });
        </script>
    </x-slot>
</x-app-layout>
