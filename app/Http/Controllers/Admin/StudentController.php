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
            $students = Student::select(['id', 'nisn', 'name', 'phone', 'divisi']);
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
                ->addColumn('phone', function ($row) {
                    return $row->phone;
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
            ['id' => 2, 'name' => 'Institut Teknologi Bandung'],
            ['id' => 3, 'name' => 'Universitas Gadjah Mada'],
            ['id' => 4, 'name' => 'Universitas Airlangga'],
            ['id' => 5, 'name' => 'Universitas Brawijaya'],
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

        $days = Day::all();  // Ambil daftar hari dari tabel days

        // Daftar Divisi
        $divisions = [
            ['id' => 1, 'name' => 'Project Management'],
            ['id' => 2, 'name' => 'Govrel'],
            ['id' => 3, 'name' => 'Comprel'],
            ['id' => 4, 'name' => 'Design Grafis'],
            ['id' => 5, 'name' => 'Social Media Specialist'],
        ];

        $university = [
            ['id' => 1, 'name' => 'Universitas Indonesia'],
            ['id' => 2, 'name' => 'Institut Teknologi Bandung'],
            ['id' => 3, 'name' => 'Universitas Gadjah Mada'],
            ['id' => 4, 'name' => 'Universitas Airlangga'],
            ['id' => 5, 'name' => 'Universitas Brawijaya'],
        ];

        return view('dashboard.student.create', compact('divisions', 'days', 'university'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'nisn' => 'required',
            'name' => 'required|string',
            'username' => 'required|string',
            'gender' => 'required|in:Laki - Laki,Perempuan',
            'phone' => 'required',
            'rombel' => 'required',
            'photo' => 'nullable|image|max:4098',
            'days' => 'required|array', // Validasi untuk hari wajib
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
            'nisn' => $validatedData['nisn'],
            'name' => $validatedData['name'],
            'username' => $validatedData['username'],
            'gender' => $validatedData['gender'],
            'divisi' => $validatedData['rombel'],
            'phone' => $validatedData['phone'],
            'photo' => $fileFilename ?? NULL,
            'point' => 100
        ]);

        // Simpan hari wajib yang dipilih ke dalam tabel pivot student_days
        $student->days()->sync($validatedData['days']);  // Menyimpan hari wajib siswa

        return redirect('/student')->with('success', 'Siswa Berhasil Ditambahkan!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {


        $divisions = [
            ['id' => 1, 'name' => 'Project Management'],
            ['id' => 2, 'name' => 'Govrel'],
            ['id' => 3, 'name' => 'Comprel'],
            ['id' => 4, 'name' => 'Design Grafis'],
            ['id' => 5, 'name' => 'Social Media Specialist'],
        ];
        return view('dashboard.student.edit', compact('student', 'divisions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $rules = [
            'name' => 'required|string',
            'gender' => 'required|in:Laki - Laki,Perempuan',
            'phone' => 'required|numeric',
            'point' => 'required|numeric',
            'rombel' => 'required',
            'photo' => 'sometimes|image|max:4098',
        ];

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

        list($gradeId, $majorId, $groupId) = explode(' ', $validatedData['rombel']);

        Student::findOrFail($student->id)->update([
            'grade_id' => $gradeId,
            'major_id' => $majorId,
            'group_id' => $groupId,
            'name' => $validatedData['name'],
            'gender' => $validatedData['gender'],
            'phone' => $validatedData['phone'],
            'photo' => $validatedData['photo'],
            'point' => $validatedData['point']
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
