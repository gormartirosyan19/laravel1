<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\EmailVerification;
use App\Models\Activity;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth/login');
    }

    public function showRegisterForm()
    {
        return view('auth/register');
    }

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        $user = $this->userRepository->findByEmail($validated['email']);

        $remember = $request->has('remember');

        if (!$user) {
            return back()->withErrors([
                'email' => 'The email address is not registered.',
            ])->onlyInput('email');
        }

        if (!$user->email_verified_at) {
            return back()->withErrors([
                'email' => 'Please verify your email before logging in.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($validated, $remember)) {
            Activity::create([
                'user_id' => Auth::id(),
                'activity_type' => 'user_logged_in',
                'activity_details' => 'has been logged in',
            ]);
            return redirect()->intended('/profile');
        }

        return back()->withErrors([
            'password' => 'The provided password is incorrect.',
        ])->onlyInput('email');
    }

    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();

        $existingUser = $this->userRepository->findByEmail($validatedData['email']);

        if ($existingUser) {
            return back()->withErrors([
                'email' => 'The email address is already registered.',
            ])->onlyInput('email');
        }

        $verificationToken = mt_rand(10000000, 99999999);
        $validatedData['verification_token'] = $verificationToken;
        $validatedData['verification_token_expires_at'] = now()->addHours(1);

        $user = $this->userRepository->create($validatedData);
        $user->assignRole('user');

        Mail::to($user->email)->send(new EmailVerification($user));

        return redirect()->route('email.verify.form')
            ->with('status', 'Please check your email to verify your account.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'You have been logged out.');
    }
}
