@section('title', 'Acara Kami')
<x-app-layout>
    <div class="py-12 px-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-[#578FCA]">Acara Kami</h1>
                <p class="mt-2 text-sm lg:text-lg text-[#578FCA]/80">Temukan semua acara yang akan diadakan oleh kami.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 table-xs table">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-3 px-4 border-b text-left text-sm font-medium text-gray-600">No</th>
                            <th class="py-3 px-4 border-b text-left text-sm font-medium text-gray-600">Nama Acara</th>
                            <th class="py-3 px-4 border-b text-left text-sm font-medium text-gray-600">Deskripsi</th>
                            <th class="py-3 px-4 border-b text-left text-sm font-medium text-gray-600">Tanggal
                                Pelaksanaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($acaras as $index => $acara)
                            <tr class="{{ $index % 2 == 0 ? 'bg-[#ffff] text-[#578FCA]' : 'bg-[#578FCA] text-white' }}">
                                <td class="py-3 px-4 border-b">{{ $index + 1 }}</td>
                                <td class="py-3 px-4 border-b">{{ $acara->name }}</td>
                                <td class="py-3 px-4 border-b">{{ $acara->description }}</td>
                                <td class="py-3 px-4 border-b">{{ $acara->tanggal_pelaksanaan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
