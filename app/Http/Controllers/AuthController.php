<?php

namespace App\Http\Controllers;

use App\Models\FarmerProfile;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $r)
    {
        $data = $r->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $r->boolean('remember');

        if (Auth::attempt(
            [
                'email' => $data['email'],
                'password' => $data['password'],
                'status' => 'active',
            ],
            $remember
        )) {
            $r->session()->regenerate();

            return redirect()
                ->intended(route('dashboard'))
                ->with('success', 'Welcome back to MarketLink!');
        }

        Auth::logout();

        return back()
            ->withErrors([
                'email' => 'The email or password is incorrect, or the account is not active.',
            ])
            ->withInput($r->only('email'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $r)
    {
        $d = $r->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:255'],
            'password' => ['required', 'min:8', 'confirmed'],
            'role' => ['required', 'in:customer,farmer'],
        ]);

        $u = User::create($d);

        if ($d['role'] === 'farmer') {
            FarmerProfile::create([
                'user_id' => $u->id,
                'stall_name' => $d['name'] . ' Market Stall',
            ]);

            $u->update(['status' => 'pending']);

            return redirect()
                ->route('login')
                ->with('success', 'Registration received. Your farmer profile awaits admin approval.');
        }

        Auth::login($u);
        $r->session()->regenerate();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Welcome to MarketLink!');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send a one-time 6 digit password reset code.
     */
    public function sendResetLinkEmail(Request $r)
    {
        $data = $r->validate([
            'email' => ['required', 'email'],
        ]);

        $email = Str::lower(trim($data['email']));
        $user = User::whereRaw('LOWER(email) = ?', [$email])->first();

        // Keep the response generic so account existence is not disclosed.
        if (!$user) {
            return back()->with(
                'success',
                'If an account exists for that email, a 6-digit verification code has been sent.'
            );
        }

        // Clear old OTP requests for this email before creating a fresh code.
        PasswordResetOtp::where('email', $email)->delete();

        $otp = (string) random_int(100000, 999999);

        $reset = PasswordResetOtp::create([
            'email' => $email,
            'otp_hash' => Hash::make($otp),
            'expires_at' => now()->addMinutes(10),
            'attempts' => 0,
            'verified_at' => null,
        ]);

        $subject = 'MarketLink password reset code';
        $body = "Hello {$user->name},\n\n"
            . "Your MarketLink password reset code is: {$otp}\n\n"
            . "This code expires in 10 minutes.\n"
            . "If you did not request a password reset, you can ignore this email.\n\n"
            . "MarketLink";

        try {
            Mail::raw($body, function ($message) use ($email, $subject) {
                $message->to($email)->subject($subject);
            });
        } catch (Throwable $e) {
            $reset->delete();

            report($e);

            return back()
                ->withErrors([
                    'email' => 'The code could not be sent. Please check your SMTP/mail configuration and try again.',
                ])
                ->withInput(['email' => $data['email']]);
        }

        return redirect()
            ->route('password.otp', ['email' => $email])
            ->with('success', 'A 6-digit verification code has been sent to your email.');
    }

    public function showOtp(Request $r)
    {
        return view('auth.verify-otp', [
            'email' => $r->query('email', session('password_reset_email')),
        ]);
    }

    public function verifyOtp(Request $r)
    {
        $data = $r->validate([
            'email' => ['required', 'email'],
            'otp' => ['required', 'digits:6'],
        ]);

        $email = Str::lower(trim($data['email']));

        $reset = PasswordResetOtp::where('email', $email)
            ->whereNull('verified_at')
            ->latest('id')
            ->first();

        if (!$reset) {
            return back()
                ->withErrors(['otp' => 'This verification code is invalid. Please request a new code.'])
                ->withInput(['email' => $email]);
        }

        if ($reset->expires_at->isPast()) {
            $reset->delete();

            return back()
                ->withErrors(['otp' => 'This code has expired. Please request a new code.'])
                ->withInput(['email' => $email]);
        }

        if ($reset->attempts >= 5) {
            $reset->delete();

            return back()
                ->withErrors(['otp' => 'Too many incorrect attempts. Please request a new code.'])
                ->withInput(['email' => $email]);
        }

        if (!Hash::check($data['otp'], $reset->otp_hash)) {
            $reset->increment('attempts');

            return back()
                ->withErrors(['otp' => 'Incorrect verification code. Please try again.'])
                ->withInput(['email' => $email]);
        }

        $reset->update([
            'verified_at' => now(),
        ]);

        $r->session()->put('password_reset_otp_id', $reset->id);
        $r->session()->put('password_reset_email', $email);

        return redirect()->route('password.reset')->with(
            'success',
            'Email verified. You can now set a new password.'
        );
    }

    public function showResetPassword(Request $r)
    {
        $email = session('password_reset_email');
        $resetId = session('password_reset_otp_id');

        abort_unless($email && $resetId, 403, 'Your password reset session has expired.');

        $reset = PasswordResetOtp::whereKey($resetId)
            ->where('email', $email)
            ->first();

        abort_unless(
            $reset &&
            $reset->verified_at &&
            $reset->verified_at->gt(now()->subMinutes(10)),
            403,
            'Your password reset session has expired. Please request a new code.'
        );

        return view('auth.reset-password', [
            'email' => $email,
        ]);
    }

    public function resetPassword(Request $r)
    {
        $data = $r->validate([
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $email = $r->session()->get('password_reset_email');
        $resetId = $r->session()->get('password_reset_otp_id');

        abort_unless($email && $resetId, 403, 'Your password reset session has expired.');

        $reset = PasswordResetOtp::whereKey($resetId)
            ->where('email', $email)
            ->whereNotNull('verified_at')
            ->first();

        abort_unless(
            $reset && $reset->verified_at->gt(now()->subMinutes(10)),
            403,
            'Your password reset session has expired. Please request a new code.'
        );

        $user = User::whereRaw('LOWER(email) = ?', [$email])->firstOrFail();

        $user->forceFill([
            'password' => $data['password'],
            'remember_token' => Str::random(60),
        ])->save();

        $reset->delete();

        $r->session()->forget([
            'password_reset_otp_id',
            'password_reset_email',
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Your password has been reset. You can sign in now.');
    }

    public function logout(Request $r)
    {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();

        return redirect()->route('home');
    }
}
