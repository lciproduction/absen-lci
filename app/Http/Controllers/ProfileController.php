<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }



    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $student = Student::where('user_id', $user->id)->first();
        $validatedData = $request->validated();
        $path = 'student/photo';

        // Check if a new photo file is uploaded
        if ($request->hasFile('photo')) {
            // Delete the old photo if it exists
            if ($student && $student->photo) {
                $oldPhotoPath = $path . '/' . $student->photo;
                // Log::info('pathdelete potooooo:', ['status' => Storage::disk('public')->exists($oldPhotoPath)]);
                // Log::info('oldPhotoPath:', ['status' => $oldPhotoPath]);

                if (Storage::disk('public')->exists($oldPhotoPath)) {
                    Storage::disk('public')->delete($oldPhotoPath);
                }
            }

            // Save the new photo with a unique name
            $photoName = time() . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->storeAs($path, $photoName, 'public');
            $validatedData['photo'] = $photoName;
        }

        // Update student data with validated data
        $student->update($validatedData);

        return Redirect::route('student.siswa.profile.edit')->with('success', 'Profile updated successfully.');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
