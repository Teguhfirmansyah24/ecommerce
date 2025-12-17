<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function redirectTo(): string
    {
        // ================================================
        // LOGIKA REDIRECT DINAMIS
        // ================================================

        // Ambil user yang sedang login saat ini
        $user = auth()->user();

        // Jika role-nya admin, arahkan ke dashboard admin
        if ($user->role === 'admin') {
            return route('admin.dashboard');
            // ↑ Menggunakan route helper lebih aman daripada hardcode URL '/admin/dashboard'
        }

        // Jika customer biasa, arahkan ke home landing page
        return route('home');
    }

    /**
     * Override untuk custom validation rules.
     *
     * Method ini mengatur aturan validasi input dari form login.
     * Jika validasi gagal, user dikembalikan ke form dengan pesan error.
     *
     * @param \Illuminate\Http\Request $request
     */
    protected function validateLogin($request): void
    {
        // ================================================
        // VALIDASI INPUT LOGIN
        // ================================================

        $request->validate([
            // $this->username() defaultnya return 'email'
            // Kita bisa ubah method username() jika ingin login pakai username/no hp
            $this->username() => 'required|string|email',
            // ↑ required = wajib diisi
            // ↑ email    = format harus valid (ada @ dan .)

            'password' => 'required|string|min:6',
            // ↑ min:6 = minimal 6 karakter (opsional, untuk security dasar)
        ], [
            // ================================================
            // CUSTOM ERROR MESSAGES (Bahasa Indonesia)
            // ================================================
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid (harus ada @).',
            'password.required' => 'Password wajib diisi.',
            'password.min'   => 'Password minimal 6 karakter.',
        ]);
    }
}
