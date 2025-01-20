<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ProfileService
{
    public function updateProfile(Request $request): void
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);


        $user->name = $validated['name'];

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                $oldFilePath = public_path($user->profile_picture);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $file = $request->file('profile_picture');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'storage/profile_pictures/' . $fileName;

            $file->move(public_path('storage/profile_pictures'), $fileName);

            $user->profile_picture = $filePath;
        }

        $user->save();
    }

}
