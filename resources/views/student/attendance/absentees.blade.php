<x-app-layout>
   <div class=" min-h-screen flex justify-center items-center">
     <div class="w-[97%] md:w-[80%] lg:w-[70%] mx-auto py-8 px-6 bg-gradient-to-tr from-red-800 to-red-600 shadow-inner shadow-yellow-400 rounded-lg">
        <!-- Tampilkan tanggal hari ini -->
        <h2 class="text-lg font-medium text-gray-100 mb-4">
            Tanggal: {{ $formattedDate }}
        </h2>

        <h1 class="text-3xl font-bold text-white mb-6">Daftar Mahasiswa yang Belum Hadir Hari Ini</h1>

        @if($absentStudents->isEmpty())
            <div class="alert alert-success shadow-lg mb-4">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Semua mahasiswa sudah hadir hari ini.</span>
                </div>
            </div>
        @else
            <!-- Tabel Daftar Mahasiswa -->
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr class="bg-red-900 text-white">
                            <th class="px-4 py-2 text-left">No</th>
                            <th class="px-4 py-2 text-left">Nama</th>
                            <th class="px-4 py-2 text-left">Divisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($absentStudents as $index => $student)
                            <tr class="{{ $index % 2 == 0 ? 'text-white' : 'text-gray-700' }} hover:bg-red-700">
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2">{{ $student->name }}</td>
                                <td class="px-4 py-2">{{ $student->divisi }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="mt-6">
            <a href="{{ route('attendance.index') }}" class="btn bg-yellow-500 text-black hover:bg-yellow-500/90">
                Kembali
            </a>
            <div>
                <form action="{{ route('attendance.save_absentees') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Simpan Ketidakhadiran Hari Ini</button>
              </form>

            </div>
        </div>
    </div>
   </div>
</x-app-layout>
