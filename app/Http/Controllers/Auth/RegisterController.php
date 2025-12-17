<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers; // Trait Laravel untuk logic registrasi
use Illuminate\Support\Facades\Hash;    // Facade Hash untuk enkripsi password
use Illuminate\Support\Facades\Validator; // Facade Validator untuk validasi input


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role'     => 'customer',
        ], [
            // CUSTOM MESSAGES
            'name.required'     => 'Nama wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.unique'      => 'Email sudah terdaftar. Gunakan email lain.',
            'password.min'      => 'Password minimal 8 karakter agar aman.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data): User
    {
        // ================================================
        // CREATE USER + HASH PASSWORD
        // ================================================
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],

            // SECURITY CRITICAL: Password MENDATORY di-hash!
            // Jangan pernah menyimpan password plaintext.
            // Hash::make() menggunakan algoritma Bcrypt (default aman).
            'password' => Hash::make($data['password']),

            // Set role default. Pastikan 'customer', jangan 'admin'.
            'role'     => 'customer',
        ]);
    }
}
