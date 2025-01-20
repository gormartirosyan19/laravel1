<?php
namespace App\Http\Controllers;

use App\Http\Requests\SendResetLinkRequest;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\PasswordResetService;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    protected $passwordResetService;

    public function __construct(PasswordResetService $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }

    public function sendResetLink(SendResetLinkRequest $request)
    {

        $status = $this->passwordResetService->sendResetLink($request->email);

        switch ($status) {
            case 'user_not_found':
                return back()->withErrors(['email' => 'This email is not registered.']);
            case 'token_still_valid':
                return back()->withErrors(['token' => 'Reset link is still valid. Please check your email.']);
            case 'email_sent':
                return back()->with('status', 'Password reset link has been sent to your email.');
            case 'error':
            default:
                return back()->withErrors(['error' => 'An error occurred while sending the reset link.']);
        }
    }

    public function showResetForm($token)
    {
        $resetRecord = PasswordReset::where('token', $token)->first();

        if (!$resetRecord) {
            return back()->withErrors(['token' => 'Invalid or expired token.']);
        }

        return view('auth.newPassword', compact('token'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $passwordReset = PasswordReset::where('email', $request->email)
            ->where('token', $request->token)
            ->where('expires_at', '>', now())
            ->first();

        if (!$passwordReset) {
            return redirect()->route('login')->withErrors(['token' => 'Invalid or expired token.']);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'No user found with this email address.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        $passwordReset->delete();

        session()->flash('status', 'Password has been updated successfully.');
        return redirect()->route('login')->with('status', 'Password has been reset successfully.');
    }
}
