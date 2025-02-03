@section('title', 'Data Acara')
<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8 ">
            <x-card.card-default
                class="static mx-auto bg-gradient-to-tr from-red-primary to-red-secondary border-4 border-white shadow-lg w-[90%]">
                @if (session()->has('success'))
                    <x-alert.success :message="session('success')" />
                @endif

                <div class="flex  justify-start gap-2 ">

                    <a href="{{ route('acara.create') }}">
                        <x-button.primary-button>
                            <i class="fa-solid fa-plus"></i>
                            Tambah Acara
                        </x-button.primary-button>
                    </a>

                    <x-form id="export-form" action="{{ route('student.export') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="jurusanExport" name="jurusanExport" value="">
                        <input type="hidden" id="kelasExport" name="kelasExport" value="">
                        <button class="btn bg-red-secondary text-white" id="export-button" type="submit">
                            Export
                        </button>
                    </x-form>

                </div>

                <div class="relative overflow-x-auto mt-5">
                    <table id="acara" class="table table-zebra">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nama
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Deskripsi
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Tanggal
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
        /* CSS for even row text */
        #acara tbody tr:nth-child(1n) td {
            color: white;
        }

        #acara tbody tr:nth-child(2n) td {
            color: #73c2fb;
        }

        /* Change text color of DataTable elements to white */
        .dt-length,
        .dt-search,
        .dt-info,
        .dt-paging {
            color: white !important;
        }

        [name="acara_length"] {
            background-color: #73c2fb !important;
            color: white !important;
            /* Text color white on red background */
        }

        /* Change text and background color of dropdown `select` */
        .select2-container--default .select2-selection--single {
            background-color: #73c2fb !important;
            /* Red background */
            color: white !important;
            /* White text */
            border: 1px solid #666 !important;
            /* Grey border */
        }

        /* For dropdown options when opened */
        .select2-container--default .select2-results__option {
            background-color: #73c2fb !important;
            color: white !important;
        }

        /* For active and selected dropdown options */
        .select2-container--default .select2-results__option--highlighted {
            background-color: #450a0a !important;
            /* Darker when selected */
            color: white !important;
        }

        /* CSS for input background and text color */
        input[type="text"],
        input[type="search"],
        .select2-container .select2-search--inline .select2-search__field {
            background-color: #73c2fb !important;
            /* Red background */
            color: white !important;
            /* White text */
            border: 1px solid #666 !important;
            /* Grey border */
        }

        /* Placeholder color for inputs to be visible on red background */
        input[type="text"]::placeholder,
        input[type="search"]::placeholder,
        .select2-container .select2-search--inline .select2-search__field::placeholder {
            color: #dddddd !important;
            /* Light grey placeholder */
        }

        /* Change text and background color of dropdown `select` */
        .select2-container--default .select2-selection--single {
            background-color: #73c2fb !important;
            /* Red background */
            color: white !important;
            /* White text */
            border: 1px solid #666 !important;
            /* Grey border */
        }

        /* Change text and background color of selected dropdown options */
        .select2-container--default .select2-results__option {
            background-color: #73c2fb !important;
            color: white !important;
        }

        /* For active options when hovered or selected */
        .select2-container--default .select2-results__option--highlighted,
        .select2-container--default .select2-selection__rendered {
            /* Darker for active options */
            color: white !important;
        }

        /* CSS to remove blue border on focus */
        input[type="text"]:focus,
        input[type="search"]:focus,
        .select2-container--default .select2-selection--single:focus {
            outline: none !important;
            /* Remove blue outline */
            border-color: #73c2fb !important;
            /* Red border on focus */
            box-shadow: 0 0 0 2px #73c2fb !important;
            /* Red shadow as focus effect */
        }

        /* Border color for selected options in select2 */
        .select2-container--default .select2-selection--single .select2-selection__rendered:focus {
            border-color: #73c2fb !important;
            /* Red border on focus */
        }

        .dt-length select:focus {
            outline: none !important;
            /* Remove blue outline */
            border-color: #73c2fb !important;
            /* Red border on focus */
            box-shadow: 0 0 0 2px #73c2fb !important;
            /* Red shadow for consistency */
        }

        /* Change grid to single column for vertical stacking */
        #acara_wrapper .grid.grid-cols-2 {
            grid-template-columns: 1fr;
            /* Single column grid */
        }

        /* Position "Show per page" above and "Search" below */
        #acara_wrapper .dt-length {
            order: 1;
            /* Stay first */
        }

        #acara_wrapper .dt-search {
            order: 2;
            /* Move second */
            margin-top: 10px;
            /* Add space between elements */
        }

        /* Adjust search input width */
        /* Default width for desktop */
        #acara_wrapper .dt-search input[type="search"] {
            width: 20%;
            /* 20% width for desktop */
        }

        /* Width for tablets */
        @media (max-width: 1024px) {
            #acara_wrapper .dt-search input[type="search"] {
                width: 50%;
                /* 50% width for tablets */
            }
        }

        /* Width for mobile */
        @media (max-width: 640px) {
            #acara_wrapper .dt-search input[type="search"] {
                width: 100%;
                /* Full width for mobile */
            }
        }
    </style>

    <script>
        $(document).ready(function() {

            let dataTable = $('#acara').DataTable({
                buttons: [
                    // 'copy', 'excel', 'csv', 'pdf', 'print',
                    'colvis'
                ],
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('acara.index') }}',
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
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'tanggal_pelaksanaan',
                        name: 'tanggal_pelaksanaan'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return `
                                <div class="flex justify-center items-center gap-2">
                                    <a class="flex" href="{{ url('/acara/${full.id}/edit') }}">
                                        <button type="button" class="btn-sm bg-blue-800 btn text-white"><i class="fa-regular fa-pen-to-square"></i></button>
                                    </a>
                                    <form action="{{ url('/acara/${full.id}') }}" method="POST" class="flex">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-sm btn bg-red-primary text-white" onclick="return confirm('Are you sure?')"><i class="fa-regular fa-trash-can"></i></button>
                                    </form>
                                </div>
                            `;
                        }
                    },
                ],
                language: {
                    lengthMenu: "_MENU_  per halaman",
                    search: "Cari:",
                    info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                },
            });
        });
    </script>
</x-app-layout>
