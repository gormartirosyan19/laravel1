<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EmailVerificationController extends Controller
{
    public function showVerifyForm()
    {
        return view('auth.verifyForm');
    }

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'verification_token' => 'required|digits:8',
        ]);

        $user = User::where('email', $request->email)
            ->where('verification_token', $request->verification_token)
            ->where('verification_token_expires_at', '>', now())
            ->first();

        if (!$user) {
            return back()->withErrors(['verification_token' => 'Invalid or expired verification code.']);
        }

        $user->email_verified_at = now();
        $user->verification_token= null;
        $user->verification_token_expires_at = null;
        $user->save();

        Activity::create([
            'user_id' => Auth::id(),
            'activity_type' => 'user_registered',
            'activity_details' => 'User registered a new account with email: ' . $user->email,
        ]);

        return redirect()->route('login')->with('status', 'Your email has been verified. You can now log in.');
    }
}
