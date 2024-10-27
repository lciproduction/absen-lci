@section('title', 'Riwayat Absen')

<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card.card-default class="static mt-8 mx-auto bg-gradient-to-tr from-red-950 to-red-700 shadow-inner shadow-yellow-500">
                @if (session()->has('success'))
                    <x-alert.success :message="session('success')" />
                @endif


                <div class="md:flex justify-start lg:space-x-4 mb-4 mt-4">
                    <div class="mt-4">
                        <x-input.select-input id="from" class="mt-1 w-full select2" name="from">
                            <option value="" disabled selected>Pilih Tanggal Awal</option>
                            <option value="All">Semua</option>
                            @foreach ($dates as $key => $date)
                                <option value="{{ $date['key'] }}">{{ $date['value'] }}</option>
                            @endforeach
                        </x-input.select-input>
                    </div>
                    <div class="mt-4">
                        <x-input.select-input id="to" class="mt-1 w-full select2" name="to">
                            <option value="" disabled selected>Pilih Tanggal Akhir</option>
                            <option value="All">Semua</option>
                            @foreach ($dates as $key => $date)
                                <option value="{{ $date['key'] }}">{{ $date['value'] }}</option>
                            @endforeach
                        </x-input.select-input>
                    </div>
                </div>
                <div class="relative overflow-x-auto mt-5">
                    <table id="attendances" class="table table-zebra">
                        <thead>
                            <tr class="text-red-950">
                                <th scope="col" class="px-6 py-3">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Tanggal
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </x-card.card-default>
        </div>
    </div>
<style>
    /* CSS untuk teks di baris genap */
    #attendances tbody tr:nth-child(1n) td {
        color: white;
    }
    #attendances tbody tr:nth-child(2n) td {
        color: #450a0a;
    }
</style>

    <x-slot name="script">

        <script>
            $(document).ready(function() {

                let dataTable = $('#attendances').DataTable({
                    buttons: [
                        // 'copy', 'excel', 'csv', 'pdf', 'print',
                        'colvis'
                    ],
                    processing: true,
                    search: {
                        return: true,

                    },
                    serverSide: true,
                    ajax: {
                        url: '{{ route('student.history.index') }}',
                        data: function(d) {
                            d.from = $('#from').val();
                            d.to = $('#to').val();
                        },
                        error: function(xhr, error, code) {
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                alert(xhr.responseJSON.message);
                            }
                        }
                    },
                    columns: [{
                            data: null,
                            name: 'no',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            orderable: false,
                            searchable: false,
                            render: function(data) {
                                return new Date(data).toLocaleDateString() + ' ' + new Date(data)
                                    .toLocaleTimeString('id-ID');
                            }
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: null,
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, full, meta) {
                                if (full.status == 1) {
                                    return '';
                                } else {
                                    return `
                                   <div class="flex justify-center items-center">
                                     <a href="{{ url('/siswa/history/${full.id}') }}">
                                        <button type="button" class="btn btn-sm text-white bg-gradient-to-tr from-red-950 to-red-700 shadow-inner shadow-yellow-500"><i class="fa-regular fa-eye"></i></button>
                                    </a>
                                    </div>
                                `;
                                }
                            }
                        },
                    ],
                    language: {
                        lengthMenu: "Tampilkan _MENU_  per halaman",
                        search: "Cari:",
                        info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                         },
                });

                $('#from, #to').change(function() {
                    dataTable.ajax.reload();
                });
            });
        </script>
    </x-slot>




</x-app-layout>
