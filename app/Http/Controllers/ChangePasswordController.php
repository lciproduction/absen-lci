<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return view('student.setting.change-password');
    }

    public function update(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'new_password' => 'required',
            'confirm_password' => 'required',

        ]);

        // dd($validatedData);


        // Menangkap pengguna yang sedang login
        $user = Auth::user();



        if (!$user) {
            return redirect()->back()
                ->with('error', 'User tidak ditemukan.');
        }

        // Mengganti password
        // $user->password = Hash::make($request->input('new_password'));
        $userUpdate = User::where('id', $user->id)->first();


        $userUpdate->password = Hash::make($request->input('new_password'));
        $userUpdate->save();

        return redirect()->back()
            ->with('success', 'Password berhasil diperbarui.');
    }
}
