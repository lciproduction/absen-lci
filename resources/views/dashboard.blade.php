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
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            Data Absensi Kamu
                        </h2>
                        <table class="table-auto w-full mt-4">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Nama Siswa</th>
                                    <th class="px-4 py-2">NISN</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Waktu Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attendances as $attendance)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $attendance->student->name }}</td>
                                        <td class="border px-4 py-2">{{ $attendance->student->nisn }}</td>
                                        <td class="border px-4 py-2">{{ $attendance->status }}</td>
                                        <td class="border px-4 py-2">{{ $attendance->created_at->format('H:i:s') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center px-4 py-2">Tidak ada data absensi untuk hari ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>



<div class="container">
    <h3>Daftar Siswa Tidak Hadir pada Hari Wajib ({{ Carbon\Carbon::now()->isoFormat('dddd') }})</h3>

    <!-- Menampilkan pesan jika ada -->
    @if (isset($message))
        <div class="alert alert-warning">
            {{ $message }}
        </div>
    @endif

    @if ($studentsAbsent->isEmpty())
        <p>Tidak ada siswa yang absen pada hari ini.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th>Hari Wajib</th>
                </tr>
            </thead>
            <tbody>
                @foreach($studentsAbsent as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->grade->name ?? '-' }}</td>
                        <td>{{ $student->major->name ?? '-' }}</td>
                        <td>{{ $student->days->firstWhere('is_mandatory', true)->name ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
