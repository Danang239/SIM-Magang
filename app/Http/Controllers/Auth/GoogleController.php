<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    /**
     * Redirect user to Google OAuth page.
     */
    public function redirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    /**
     * Handle Google OAuth callback.
     * Cari user berdasarkan email, jika tidak ada buat baru dengan role Pengguna.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Login dengan Google gagal. Silakan coba lagi.');
        }

        // Cari user berdasarkan email
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // Buat akun baru otomatis dengan role Pengguna
            $user = User::create([
                'name'              => $googleUser->getName(),
                'email'             => $googleUser->getEmail(),
                'password'          => bcrypt(Str::random(24)), // password acak (tidak bisa login pakai password)
                'google_id'         => $googleUser->getId(),
                'foto_profil'       => null,
                'no_hp'             => null,
                'instansi'          => null,
                'program_studi'     => null,
                'email_verified_at' => now(),
            ]);

            $user->assignRole('Pengguna');
        } else {
            // Update google_id jika belum ada
            if (!$user->google_id) {
                $user->update(['google_id' => $googleUser->getId()]);
            }
        }

        Auth::login($user, true);

        // Jika data profil (no_hp, instansi, atau program_studi) belum lengkap, arahkan ke edit profil dengan notifikasi
        if (empty($user->no_hp) || empty($user->instansi) || empty($user->program_studi)) {
            return redirect()->route('profile.edit')
                ->with('info', 'Selamat datang! Silakan lengkapi Nomor HP, Asal Sekolah/Kampus, dan Program Studi Anda agar data pemohon dapat diproses oleh petugas.');
        }

        return redirect()->intended(route('home'));
    }
}
