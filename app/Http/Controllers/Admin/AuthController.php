<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function showLogin()
    {
        $this->generateCaptcha();
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $email = strtolower(trim((string) $request->input('email')));
        $key = 'admin-login:' . $email . ':' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam ' . $seconds . ' detik.',
            ])->onlyInput('email');
        }

        RateLimiter::hit($key, 300);

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha_answer' => ['required', 'integer', function ($attribute, $value, $fail) {
                if ((int) $value !== (int) session('login_captcha_answer')) {
                    $fail('Captcha salah.');
                }
            }],
        ]);

        $user = User::where('email', $email)->first();
        if ($user && Hash::check($credentials['password'], $user->password)) {
            RateLimiter::clear($key);
            $request->session()->forget(['admin_id', 'admin_name', 'login_captcha_answer', 'login_captcha_question']);
            $request->session()->put('admin_id', $user->id);
            $request->session()->put('admin_name', $user->name);
            return redirect()->route('admin.dashboard');
        }

        $this->generateCaptcha();
        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['admin_id', 'admin_name', 'login_captcha_answer', 'login_captcha_question']);
        return redirect()->route('admin.login');
    }

    public function showPasswordForm()
    {
        $user = User::find(session('admin_id'));

        if (! $user) {
            return redirect()->route('admin.login');
        }

        return view('admin.password', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $user = User::find(session('admin_id'));

        if (! $user) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.current_password' => 'Password lama tidak sesuai.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return redirect()->route('admin.password.edit')->with('success', 'Password berhasil diperbarui.');
    }

    protected function generateCaptcha(): void
    {
        $first = random_int(2, 9);
        $second = random_int(2, 9);
        session(['login_captcha_question' => $first . ' + ' . $second]);
        session(['login_captcha_answer' => $first + $second]);
    }
}