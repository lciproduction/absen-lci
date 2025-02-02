<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Grade;
use App\Models\Group;
use App\Models\Major;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Exports\StudentExport;
use App\Imports\StudentImport;
use App\Http\Controllers\Controller;
use App\Models\Day;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            // Ambil data dari tabel students
            $students = Student::select(['id', 'name', 'email', 'divisi']);
            // Cek apakah ada input divisi untuk filtering
            if ($request->has('divisi') && $request->input('divisi') != 'All' && $request->input('divisi') != null) {
                $divisi = $request->input('divisi');
                $students->where('divisi', $divisi); // Filter berdasarkan divisi
            }

            return DataTables::of($students)
                ->addIndexColumn() // Menambahkan nomor urut
                ->addColumn('nama_mahasiswa', function ($row) {

                    return $row->name;
                })
                ->addColumn('email', function ($row) {
                    return $row->email;
                })
                ->addColumn('divisi', function ($row) {
                    // Menampilkan rombel statis atau sesuai relasi jika ada
                    return $row->divisi; // Gantilah dengan nilai terkait jika ada
                })
                ->addColumn('action', function ($row) {
                    // Action bisa berupa tombol edit atau delete
                    $editUrl = route('student.edit', $row->id); // Pastikan route edit sudah ada
                    $deleteUrl = route('student.destroy', $row->id); // Pastikan route delete sudah ada

                    return '<a href="' . $editUrl . '" class="btn btn-sm btn-primary">Edit</a>
                        <form action="' . $deleteUrl . '" method="POST" style="display:inline;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form>';
                })
                ->rawColumns(['action']) // Membuat kolom action menampilkan HTML
                ->make(true);
        }




        // Data universitas yang akan ditampilkan di form filter atau lainnya
        $university = [
            ['id' => 1, 'name' => 'Universitas Indonesia'],
            ['id' => 2, 'name' => 'Universitas Udayana'],
            ['id' => 3, 'name' => 'Universitas Diponegoro'],
            ['id' => 4, 'name' => 'Universitas Hasanuddin'],
            ['id' => 5, 'name' => 'Universitas Brawijaya'],
            ['id' => 5, 'name' => 'Universitas Muhammadiyah Yogyakarta'],
            ['id' => 5, 'name' => 'Universitas Negeri Jakarta'],
            ['id' => 5, 'name' => 'President University'],
            ['id' => 5, 'name' => 'Universitas Pembangunan Nasional Veteran Jakarta'],
            ['id' => 5, 'name' => 'Universitas Widyatama'],
            ['id' => 5, 'name' => 'Universitas Pembangunan Jaya'],
            ['id' => 5, 'name' => 'Universitas Mercu Buana'],
            ['id' => 5, 'name' => 'Universitas Gunadarma'],
            ['id' => 5, 'name' => 'Universitas Pendidikan Indonesia'],
            ['id' => 5, 'name' => 'UPN Veteran Jakarta'],
            ['id' => 5, 'name' => 'Universitas Airlangga'],
            ['id' => 5, 'name' => 'Universitas Padjadjaran'],
            ['id' => 5, 'name' => 'Universitas Katolik Parahyangan'],
            ['id' => 5, 'name' => 'Universitas Negeri Malang'],
        ];

        return view('dashboard.student.index', compact('university'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $grades = Grade::where('status', 1)->pluck('name', 'id');
        // $majors = Major::where('status', 1)->pluck('acronym', 'id');
        // $groups = Group::where('status', 1)->pluck('number', 'id');

        // $days = Day::all();  // Ambil daftar hari dari tabel days

        // Daftar Divisi
        $divisions = [
            ['id' => 1, 'name' => 'Project Management'],
            ['id' => 2, 'name' => 'Government and Stakeholder Relations '],
            ['id' => 3, 'name' => 'Community and Corporate Relations'],
            ['id' => 4, 'name' => 'Design Grafis'],
            ['id' => 5, 'name' => 'Social Media Specialist'],
        ];

        // $university = [
        //     ['id' => 1, 'name' => 'Universitas Indonesia'],
        //     ['id' => 2, 'name' => 'Universitas Udayana'],
        //     ['id' => 3, 'name' => 'Universitas Diponegoro'],
        //     ['id' => 4, 'name' => 'Universitas Hasanuddin'],
        //     ['id' => 5, 'name' => 'Universitas Brawijaya'],
        //     ['id' => 6, 'name' => 'Universitas Muhammadiyah Yogyakarta'],
        //     ['id' => 7, 'name' => 'Universitas Negeri Jakarta'],
        //     ['id' => 8, 'name' => 'President University'],
        //     [
        //         'id' => 9,
        //         'name' => 'Universitas Pembangunan Nasional Veteran Jakarta'
        //     ],
        //     ['id' => 10, 'name' => 'Universitas Widyatama'],
        //     ['id' => 11, 'name' => 'Universitas Pembangunan Jaya'],
        //     ['id' => 12, 'name' => 'Universitas Mercu Buana'],
        //     ['id' => 13, 'name' => 'Universitas Gunadarma'],
        //     ['id' => 14, 'name' => 'Universitas Pendidikan Indonesia'],
        //     ['id' => 15, 'name' => 'UPN Veteran Jakarta'],
        //     ['id' => 16, 'name' => 'Universitas Airlangga'],
        //     ['id' => 17, 'name' => 'Universitas Padjadjaran'],
        //     ['id' => 18, 'name' => 'Universitas Katolik Parahyangan'],
        //     ['id' => 19, 'name' => 'Universitas Negeri Malang'],
        // ];

        return view('dashboard.student.create', compact('divisions'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string',
            'gender' => 'required|in:Laki - Laki,Perempuan',
            'phone' => 'required',
            'rombel' => 'required',
            'photo' => 'nullable|image|max:4098',
            'email' => 'required|email',
            'jabatan' => 'required',
            'nisn' => 'required',
        ]);

        // Note : Rombel = Kelas yang diisi Divisi
        // Note : phone = nomor hp yang diisi Universitas


        // list($gradeId, $majorId, $groupId) = explode(' ', $validatedData['rombel']);
        $fileFilename = NULL;
        if ($request->hasFile('photo')) {
            $fileFilename = time() . '.' . $request->file('photo')->getClientOriginalExtension();
            $photoPath = $request->file('photo')->storeAs('student/photo', $fileFilename, 'public');
        }

        $user = new User([
            'username' => $request->username,
            'password' => bcrypt($request->nisn),
        ]);
        $user->assignRole('student');
        $user->save();

        $student = Student::create([

            'user_id' => $user->id,
            'name' => $validatedData['name'],
            'username' => $validatedData['username'],
            'jabatan' => $validatedData['jabatan'],
            'gender' => $validatedData['gender'],
            'divisi' => $validatedData['rombel'],
            'phone' => $validatedData['phone'],
            'email' => $validatedData['email'],
            'photo' => $fileFilename ?? NULL,
            'point' => 1000000
        ]);


        return redirect('/student')->with('success', 'Siswa Berhasil Ditambahkan!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        // $user = $student->user->password;

        // dd($user);


        $divisions = [
            ['id' => 1, 'name' => 'Project Management'],
            ['id' => 2, 'name' => 'Government and Stakeholder Relations '],
            ['id' => 3, 'name' => 'Community and Corporate Relations'],
            ['id' => 4, 'name' => 'Design Grafis'],
            ['id' => 5, 'name' => 'Social Media Specialist'],
        ];
        // $university = [
        //     ['id' => 1, 'name' => 'Universitas Indonesia'],
        //     ['id' => 2, 'name' => 'Universitas Udayana'],
        //     ['id' => 3, 'name' => 'Universitas Diponegoro'],
        //     ['id' => 4, 'name' => 'Universitas Hasanuddin'],
        //     ['id' => 5, 'name' => 'Universitas Brawijaya'],
        //     ['id' => 6, 'name' => 'Universitas Muhammadiyah Yogyakarta'],
        //     ['id' => 7, 'name' => 'Universitas Negeri Jakarta'],
        //     ['id' => 8, 'name' => 'President University'],
        //     [
        //         'id' => 9,
        //         'name' => 'Universitas Pembangunan Nasional Veteran Jakarta'
        //     ],
        //     ['id' => 10, 'name' => 'Universitas Widyatama'],
        //     ['id' => 11, 'name' => 'Universitas Pembangunan Jaya'],
        //     ['id' => 12, 'name' => 'Universitas Mercu Buana'],
        //     ['id' => 13, 'name' => 'Universitas Gunadarma'],
        //     ['id' => 14, 'name' => 'Universitas Pendidikan Indonesia'],
        //     ['id' => 15, 'name' => 'UPN Veteran Jakarta'],
        //     ['id' => 16, 'name' => 'Universitas Airlangga'],
        //     ['id' => 17, 'name' => 'Universitas Padjadjaran'],
        //     ['id' => 18, 'name' => 'Universitas Katolik Parahyangan'],
        //     ['id' => 19, 'name' => 'Universitas Negeri Malang'],
        // ];
        return view('dashboard.student.edit', compact('student', 'divisions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $rules = [
            'name' => 'required|string',
            'username' => 'required|string',
            'gender' => 'required|in:Laki - Laki,Perempuan',
            'phone' => 'required',
            'divisi' => 'required',
            'photo' => 'nullable|image|max:4098',
            'email' => 'required|email',
            'jabatan' => 'required',
            'password' => 'nullable',
        ];

        // dd($request->all());

        $validatedData = $request->validate($rules);
        $validatedData['photo'] = $request->oldImage;
        if ($request->file('photo')) {
            $path = 'student/photo';
            if ($request->oldImage) {
                Storage::delete($path . '/' . $request->oldImage);
            }
            $validatedData['photo'] = time() . '.' . $request->file('photo')->getClientOriginalExtension();
            $photoPath = $request->file('photo')->storeAs('student/photo', $validatedData['photo']);
        }


        User::findOrFail($student->user_id)->update([
            'username' => $validatedData['username'],
            'password' => $validatedData['password'] != null ? Hash::make($validatedData['password']) : $student->user->password,
        ]);

        Student::findOrFail($student->id)->update([
            'name' => $validatedData['name'],
            'gender' => $validatedData['gender'],
            'phone' => $validatedData['phone'],
            'photo' => $validatedData['photo'],
            'email' => $validatedData['email'],
            'divisi' => $validatedData['divisi'],
            'jabatan' => $validatedData['jabatan'],
        ]);

        return redirect('/student')->with('success', 'Siswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        if ($student->photo) {
            Storage::delete('student/photo/' . $student->photo);
        }
        $student->user->delete();
        Student::destroy($student->id);

        return redirect('/student')->with('success', 'Siswa Berhasil Dihapus!');
    }

    public function import(Request $request): RedirectResponse
    {
        $validator = $request->validate([
            'file' => 'file|mimes:csv,xls,xlsx'
        ]);
        $file = $request->file('file');
        // upload ke folder file_siswa di dalam folder public
        $validator['file'] = $file->store('files');
        Excel::import(new StudentImport, request()->file('file'));

        return redirect()->back()->with('success', 'Data Berhasil di Import');
    }

    public function export(Request $request): BinaryFileResponse
    {
        $major = $request->jurusanExport;
        $grade = $request->kelasExport;
        return Excel::download(new StudentExport($major, $grade), 'Data Siswa.xlsx');
    }
}
