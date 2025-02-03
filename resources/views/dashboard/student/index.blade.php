@section('title', 'Data Karyawan')

<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <x-card.card-default
                class="static mx-auto bg-gradient-to-tr from-red-primary to-red-secondary border-4 border-white shadow-lg w-[90%]">
                @if (session()->has('success'))
                    <x-alert.success :message="session('success')" />
                @endif
                <div class="flex justify-between mb-4">
                    <a href="{{ route('karyawan.create') }}">
                        <x-button.primary-button>
                            <i class="fa-solid fa-plus"></i>
                            Tambah Data
                        </x-button.primary-button>
                    </a>
                </div>

                <div class="relative overflow-x-auto ">
                    <table id="students" class="table table-zebra">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3">No</th>
                                <th scope="col" class="px-6 py-3">Nama</th>
                                <th scope="col" class="px-6 py-3">Email</th>
                                <th scope="col" class="px-6 py-3">Divisi</th>
                                <th scope="col" class="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </x-card.card-default>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let dataTable = $('#students').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('karyawan.index') }}', // Ganti dengan rute yang sesuai
                    type: 'GET',
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
                        data: 'email',
                        name: 'email'
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
                                <div class="flex justify-center items-center gap-2">
                                    <a href="{{ url('/karyawan/${full.id}/edit') }}" class="btn btn-sm bg-red-secondary text-white">Edit</a>
                                    <form action="{{ url('/karyawan/${full.id}') }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm bg-red-600 text-white" onclick="return confirm('Are you sure?')">Delete</button>
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
