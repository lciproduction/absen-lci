<?php

namespace App\Http\Controllers;

use App\Models\Acara;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class AcaraController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Fetch data from the 'acara' table
            $acaras = Acara::select(['id', 'name', 'description', 'tanggal_pelaksanaan']);

            return DataTables::of($acaras)
                ->addIndexColumn() // Add row numbers
                ->addColumn('action', function ($row) {
                    // Action buttons for edit and delete
                    $editUrl = route('acara.edit', $row->id); // Ensure edit route is correct
                    $deleteUrl = route('acara.destroy', $row->id); // Ensure delete route is correct

                    return '<a href="' . $editUrl . '" class="btn btn-sm btn-primary">Edit</a>
                    <form action="' . $deleteUrl . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                    </form>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('acara.index');
    }


    public function create()
    {


        return view('acara.create');
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'tanggal_pelaksanaan' => 'required',
        ]);

        $tanggalPelaksanaan = Carbon::parse($validatedData['tanggal_pelaksanaan'])->format('d-m-Y');

        $data = [

            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'tanggal_pelaksanaan' => $tanggalPelaksanaan,
        ];

        Acara::create($data);


        return redirect()->route('acara.index')->with('success', 'Acara berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $acara = Acara::findOrFail($id);
        $acara->tanggal_pelaksanaan = Carbon::createFromFormat('d-m-Y', $acara->tanggal_pelaksanaan)->format('Y-m-d');
        return view('acara.edit', compact('acara'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'tanggal_pelaksanaan' => 'required',
        ]);

        $acara = Acara::findOrFail($id);

        $tanggalPelaksanaan = Carbon::parse($validatedData['tanggal_pelaksanaan'])->format('d-m-Y');

        $data = [

            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'tanggal_pelaksanaan' => $tanggalPelaksanaan,
        ];

        $acara->update($data);

        return redirect()->route('acara.index')
            ->with('success', 'Acara berhasil diperbarui.');
    }

    public function destroy($id)
    {

        if (!Acara::where('id', $id)->exists()) {
            return response()->json(['message' => 'Acara not found'], 404);
        }
        // Mencari acara berdasarkan ID
        $acara = Acara::findOrFail($id);

        // Menghapus acara dari database
        $acara->delete();

        // Mengarahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('acara.index')->with('success', 'Acara berhasil dihapus.');
    }

    public function karyawan()
    {
        $acaras = Acara::all();
        return view('acara.karyawan', compact('acaras'));
    }
}
