<?php

namespace App\Services;

use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetLink;
use Illuminate\Support\Facades\Log;

class PasswordResetService
{
    public function sendResetLink(string $email)
    {
        try {
            $user = User::query()->where('email', $email)->first();

            if (!$user) {
                return 'user_not_found';
            }

            $token = Str::random(60);

            $passwordReset = PasswordReset::query()->where('email', $email)->first();

            if ($passwordReset) {
                if ($passwordReset->expires_at->isPast()) {
                    $passwordReset->token = $token;
                    $passwordReset->expires_at = now()->addHours(1);
                    $passwordReset->updated_at = now();
                    $passwordReset->save();
                } else {
                    Log::info('Token still valid, no need to regenerate.');
                    return 'token_still_valid';
                }
            } else {
                PasswordReset::query()->create([
                    'email' => $email,
                    'token' => $token,
                    'user_id' => $user->id,
                    'expires_at' => now()->addHours(1),
                ]);
            }


            $resetUrl = route('password.reset.form', ['token' => $token]);

            Mail::to($email)->send(new PasswordResetLink($resetUrl));

            Log::info('Password reset link sent to: ' . $email);
            return 'email_sent';
        } catch (\Exception $e) {
            Log::error('Error sending password reset link: ' . $e->getMessage());
        }
    }
}
