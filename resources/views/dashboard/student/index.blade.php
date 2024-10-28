@section('title', 'Data Siswa')

<x-app-layout>

    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8 ">
            <x-card.card-default class="static mx-auto bg-gradient-to-tr from-red-950 to-red-700 shadow-inner shadow-yellow-500 w-[90%]">
                @if (session()->has('success'))
                    <x-alert.success :message="session('success')" />
                @endif

                <div class="flex  justify-start gap-2 ">

                    <a href="{{ route('student.create') }}">
                        <x-button.primary-button>
                            <i class="fa-solid fa-plus"></i>
                            Tambah Data
                        </x-button.primary-button>
                    </a>

                    {{-- ini untuk import data  --}}

                    {{-- <x-form action="{{ route('student.import') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="relative">
                            <x-input.input-file type="file" id="file" name="file" required />
                            <x-button.success-button>
                                <i class="fa-solid fa-file-import"></i>
                                Import
                            </x-button.success-button>
                        </div>
                    </x-form> --}}
                    <x-form id="export-form" action="{{ route('student.export') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="jurusanExport" name="jurusanExport" value="">
                        <input type="hidden" id="kelasExport" name="kelasExport" value="">
                        <button class="btn bg-gradient-to-tr from-red-950 to-red-700 shadow-inner shadow-yellow-500 text-white" id="export-button" type="submit">
                            Export
                        </button>
                    </x-form>

                </div>
                <div class="flex justify-start space-x-4">
                 <div class="mt-4">
                <x-input.select-input id="divisi" class="mt-1 w-full bg-red-primary text-white border border-white" name="divisi" >
                    <option value="All">Semua</option>
                    <option value="Project Management">Project Management</option>
                    <option value="Comprel">Comprel</option>
                    <option value="Govrel">Govrel</option>
                    <option value="Design Grafis">Design Grafis</option>
                    <option value="Social Media Specialist">Social Media Specialist</option>
                </x-input.select-input>
                </div>

                </div>
                <div class="relative overflow-x-auto mt-5"id="attendances">
                    <table id="students" class="table table-zebra" >
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nama Mahasiswa
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Universitas
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Divisi
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
         [name="students_length"] {
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
        let dataTable = $('#students').DataTable({
            processing: true,
            serverSide: true,
             ajax: {
                url: '{{ route('student.index') }}',
                data: function(d) {
                    d.divisi = $('#divisi').val(); // Kirim nilai divisi yang dipilih
                }
            },
            columns: [
                {
                    data: null,
                    name: 'no',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'nama_mahasiswa',
                    name: 'nama_mahasiswa'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'divisi',
                    name: 'divisi'
                },
                {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, full, meta) {
                                return `
                                <div class="flex  justify-center items-center gap-2">
                                    <a class="flex" href="{{ url('/student/${full.id}/edit') }}">
                                    <button type="button" class="btn-sm bg-blue-800 btn text-white"><i class="fa-regular fa-pen-to-square"></i></button>
                                </a>
                                <x-form action="{{ url('/student/${full.id}') }}" class="flex">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-sm btn bg-red-primary text-white" onclick="return confirm('Are you sure?')"><i class="fa-regular fa-trash-can"></i></button>
                                </x-form>
                                    </div>
                            `;
                            }
                        },
            ],
             language: {
                        lengthMenu: "Tampilkan _MENU_  per halaman",
                        search: "Cari:",
                        info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                         },
        });

        // Reload DataTable ketika dropdown divisi berubah
        $('#divisi').change(function() {
            dataTable.ajax.reload();
        });
    });
</script>

    </x-slot>
</x-app-layout>
