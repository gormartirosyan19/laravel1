<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ProfileService
{
    public function updateProfile(Request $request): void
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
//            'email' => 'required|email|unique:users,email,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);


        $user->name = $validated['name'];
//        $user->email = $validated['email'];

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                $oldFilePath = public_path($user->profile_picture);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $file = $request->file('profile_picture');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'profile_pictures/' . $fileName;

            $file->move(public_path('profile_pictures'), $fileName);

            $user->profile_picture = $filePath;
        }

        $user->save();
    }

}
