@section('title', 'Absensi Siswa')

<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card.card-default class="static mx-auto bg-gradient-to-tr from-red-950 to-red-700 shadow-inner shadow-yellow-500">
                @if (session()->has('success'))
                    <x-alert.success :message="session('success')" />
                @endif

                <div class="flex justify-start space-x-4">
                    <x-form id="export-form" action="{{ route('attendance.export') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="fromExport" name="fromExport" value="">
                        <input type="hidden" id="toExport" name="toExport" value="">
                        <button class="bg-gradient-to-tr from-red-950 to-red-700 shadow-inner shadow-yellow-500 btn text-white" id="export-button" type="submit">
                            Export
                        </button>
                    </x-form>
                </div>

                <div class="flex flex-col lg:flex-row justify-start lg:space-x-4">
                    <div class="mt-4">
                        <x-input.text-input id="from" class="mt-1 w-full bg-red-primary text-white border border-white" type="date" name="from"  required />
                    </div>
                    <div class="mt-4">
                        <x-input.text-input id="to" class="mt-1 w-full bg-red-primary text-white border border-white" type="date" name="to" required />
                    </div>
                </div>

                <div class="relative overflow-x-auto mt-5">
                    <table id="attendances" class="table table-zebra">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nama Siswa
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>

                                <th scope="col" class="px-6 py-3">
                                    Lokasi / File
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
       /* Mengubah warna teks elemen DataTable ke putih */
        .dt-length,.dt-search,.dt-info,.dt-paging {
            color: white !important;
        }
         [name="attendances_length"] {
            background-color: #7f1d1d !important;
            color: white !important; /* Supaya teks terlihat jelas di latar belakang merah */
        }

        /* Mengubah warna teks dan latar belakang di dropdown `select` */
    .select2-container--default .select2-selection--single {
        background-color: #7f1d1d !important; /* Latar belakang merah */
        color: white !important; /* Warna teks putih */
        border: 1px solid #666 !important; /* Border abu-abu */
    }

    /* Untuk elemen dropdown opsi saat dibuka */
    .select2-container--default .select2-results__option {
        background-color: #7f1d1d !important;
        color: white !important;
    }

    /* Untuk memastikan setiap elemen dropdown select yang aktif dan terpilih */
    .select2-container--default .select2-results__option--highlighted {
        background-color: #450a0a !important; /* Lebih gelap saat dipilih */
        color: white !important;
    }
        /* CSS untuk mengubah warna latar belakang dan teks input */
    input[type="text"],
    input[type="search"],
    .select2-container .select2-search--inline .select2-search__field {
        background-color: #7f1d1d !important; /* Latar belakang merah */
        color: white !important; /* Warna teks putih */
        border: 1px solid #666 !important; /* Border abu-abu */
    }

    /* Mengubah warna placeholder input agar terlihat di latar belakang merah */
    input[type="text"]::placeholder,
    input[type="search"]::placeholder,
    .select2-container .select2-search--inline .select2-search__field::placeholder {
        color: #dddddd !important; /* Placeholder berwarna abu terang */
    }
     /* Mengubah warna teks dan latar belakang di dropdown `select` */
    .select2-container--default .select2-selection--single {
        background-color: #7f1d1d !important; /* Latar belakang merah */
        color: white !important; /* Warna teks putih */
        border: 1px solid #666 !important; /* Border abu-abu */
    }

    /* Mengubah warna teks dan latar belakang opsi yang dipilih di dropdown */
    .select2-container--default .select2-results__option {
        background-color: #7f1d1d !important;
        color: white !important;
    }

    /* Untuk opsi aktif saat disorot atau dipilih */
    .select2-container--default .select2-results__option--highlighted,
    .select2-container--default .select2-selection__rendered {
       /* Lebih gelap untuk opsi aktif */
        color: white !important;
    }
      /* CSS untuk menghilangkan warna border biru saat fokus */
    input[type="text"]:focus,
    input[type="search"]:focus,
    .select2-container--default .select2-selection--single:focus {
        outline: none !important; /* Menghilangkan outline biru */
        border-color: #7f1d1d !important; /* Ubah warna border menjadi merah */
        box-shadow: 0 0 0 2px #7f1d1d !important; /* Efek shadow merah sebagai pengganti */
    }

    /* Mengatur warna border saat opsi dipilih pada elemen select2 */
    .select2-container--default .select2-selection--single .select2-selection__rendered:focus {
        border-color: #7f1d1d !important; /* Border merah saat fokus */
    }
     .dt-length select:focus {
        outline: none !important; /* Menghilangkan outline biru */
        border-color: #7f1d1d !important; /* Ubah warna border menjadi merah */
        box-shadow: 0 0 0 2px #7f1d1d !important; /* Shadow merah untuk konsistensi tema */
    }
     /* Mengubah grid menjadi satu kolom untuk menumpuk elemen secara vertikal */
    #attendances_wrapper .grid.grid-cols-2 {
        grid-template-columns: 1fr; /* Mengubah grid menjadi satu kolom */
    }

    /* Menempatkan elemen "Tampilkan per halaman" di atas dan "Cari" di bawahnya */
    #attendances_wrapper .dt-length {
        order: 1; /* Tetap di posisi pertama */
    }

    #attendances_wrapper .dt-search {
        order: 2; /* Pindah ke posisi kedua */
        margin-top: 10px; /* Tambahkan jarak antara elemen */
    }

    /* Mengatur lebar input "Cari" agar lebih serasi */
     /* Lebar default untuk desktop */
    #attendances_wrapper .dt-search input[type="search"] {
        width: 20%; /* Lebar 20% untuk desktop */
    }

    /* Lebar untuk tablet */
    @media (max-width: 1024px) {
        #attendances_wrapper .dt-search input[type="search"] {
            width: 50%; /* Lebar 50% untuk tablet */
        }
    }

    /* Lebar untuk ponsel */
    @media (max-width: 640px) {
        #attendances_wrapper .dt-search input[type="search"] {
            width: 100%; /* Lebar penuh untuk ponsel */
        }
    }

</style>

    <x-slot name="script">
        <script>
            $(document).ready(function() {
                $('#export-button').on('click', function() {
                    let from = $('#from').val();
                    let to = $('#to').val();

                    $('#export-form #fromExport').val(from);
                    $('#export-form #toExport').val(to);
                });

                let dataTable = $('#attendances').DataTable({
                    buttons: [
                        // 'copy', 'excel', 'csv', 'pdf', 'print',
                        'colvis'
                    ],
                    processing: true,
                    search: {
                        return: true
                    },
                    serverSide: true,
                    ajax: {
                        url: '{{ route('attendance.index') }}',
                        data: function(d) {
                            d.from = $('#from').val();
                            d.to = $('#to').val();
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
                            data: null,
                            render: function(data) {
                                return data.student.name;
                            },
                            orderable: false,
                            searchable: false,
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },

                        {
                            data: null,
                            render: function(data, type, full, meta) {
                                if (full.status != 'Izin' || full.status != 'Sakit') {
                                    let link = `https://maps.google.com/?q=${full.coordinate}`
                                    return `<div class="flex justify-center">
                                        <a target="_blank" href="${link}">
                                        <x-button.info-button type="button" class="btn-sm text-white"><i class="fa-regular fa-eye"></i></x-button.info-button>
                                    </a>
                                        </div>`
                                } else {
                                    if (full.status == 'Sakit') {
                                        let link =
                                            `{{ asset('storage/attendance/${full.student.name}/${full.note}') }}`
                                        return `<div class="flex justify-center">
                                            <a target="_blank" href="${link}">
                                            <x-button.info-button type="button" class="btn-sm text-white"><i class="fa-regular fa-eye"></i></x-button.info-button>
                                        </a>
                                            </div>`
                                    } else {
                                        return `${full.note}`
                                    }
                                }
                            },
                            orderable: false,
                            searchable: false,
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
                                   <div class=" flex justify-center>
                                     <a href="{{ url('/attendance/${full.id}') }}">
                                        <x-button.info-button type="button" class="btn-sm text-white"><i class="fa-regular fa-eye"></i></x-button.info-button>
                                    </a>
                                    </div>
                                `;
                                }
                            }
                        },
                    ]
                });

                $('#from, #to').change(function() {
                    dataTable.ajax.reload();
                });
            });
        </script>
    </x-slot>
</x-app-layout>
