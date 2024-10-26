@section('title', 'Data Siswa')

<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card.card-default class="static">
                @if (session()->has('success'))
                    <x-alert.success :message="session('success')" />
                @endif

                <div class="flex justify-start space-x-4">

                    <a href="{{ route('student.create') }}">
                        <x-button.primary-button>
                            <i class="fa-solid fa-plus"></i>
                            Tambah Data
                        </x-button.primary-button>
                    </a>
                    <x-form action="{{ route('student.import') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="relative">
                            <x-input.input-file type="file" id="file" name="file" required />
                            <x-button.success-button>
                                <i class="fa-solid fa-file-import"></i>
                                Import
                            </x-button.success-button>
                        </div>
                    </x-form>
                    <x-form id="export-form" action="{{ route('student.export') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="jurusanExport" name="jurusanExport" value="">
                        <input type="hidden" id="kelasExport" name="kelasExport" value="">
                        <x-button.info-button id="export-button" type="submit">
                            <i class="fa-regular fa-file-excel"></i>
                            Export
                        </x-button.info-button>
                    </x-form>

                </div>
                <div class="flex justify-start space-x-4">
                 <div class="mt-4">
                <x-input.select-input id="divisi" class="mt-1 w-full" name="divisi">
                    <option value="All">Semua</option>
                    <option value="Project Management">Project Management</option>
                    <option value="Comprel">Comprel</option>
                    <option value="Govrel">Govrel</option>
                    <option value="Design Grafis">Design Grafis</option>
                    <option value="Social Media Specialist">Social Media Specialist</option>
                </x-input.select-input>
                </div>
                    {{-- <div class="mt-4">
                        <x-input.select-input id="jurusan" class="mt-1 w-full" type="text" name="jurusan">
                            <option value="" disabled selected>Pilih Jurusan</option>
                            <option value="All">Semua
                            </option>
                            @foreach ($university as $university)
                                <option value="{{ $university->name }}">{{ $university->acronym }}
                                </option>
                            @endforeach
                        </x-input.select-input>
                    </div> --}}
                </div>
                <div class="relative overflow-x-auto mt-5">
                    <table id="students" class="table">
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
                                <a href="{{ url('/student/${full.id}/edit') }}">
                                    <x-button.info-button type="button" class="btn-sm text-white"><i class="fa-regular fa-pen-to-square"></i>Edit</x-button.info-button>
                                </a>
                                <x-form action="{{ url('/student/${full.id}') }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <x-button.danger-button type="submit" class="btn-sm text-white" onclick="return confirm('Are you sure?')"><i class="fa-regular fa-trash-can"></i>Hapus</x-button.danger-button>
                                </x-form>
                            `;
                            }
                        },
            ]
        });

        // Reload DataTable ketika dropdown divisi berubah
        $('#divisi').change(function() {
            dataTable.ajax.reload();
        });
    });
</script>

    </x-slot>
</x-app-layout>
