<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback(): RedirectResponse
    {
        $user = Socialite::driver('google')->user();
        $existingUser = User::where('google_id', $user->id)->first();
        if ($existingUser) {
            // Log in the existing user.
            auth()->login($existingUser, true);
        } else {
            // Create a new user.
            $newUser = new User();
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            $newUser->google_id = $user->id;
            $newUser->password = bcrypt("password"); // Set some random password
            // $newUser->save(); // Log in the new user.


            $email = $user->email; // Get email from Google
            $emailParts = explode('@', $email); // Split email into 2 parts, one before @ and one after @
            $emailUsername = $emailParts[0]; // Get username, which is before @
            $emailDomain = $emailParts[1]; // Get domain, which is after @

            if ($emailDomain == 'stis.ac.id') {
                // Mengecek apakah sebelum @ terdiri dari 9 digit dan angka
                if (preg_match('/^\d{9}$/', $emailUsername)) {
                    $newUser->save(); // Log in the new user.
                    $newUser->assignRole('mahasiswa');
                }
                // Mengecek apakah sebelum @ dimulai dengan "ukm"
                elseif (strpos($emailUsername, 'ukm') === 0) {
                    return redirect()->route('login')->withErrors(['email' => 'Email UKM tidak diperbolehkan untuk login.']);
                }
                // Jika tidak memenuhi kondisi di atas, dianggap sebagai dosen
                else {
                    $newUser->save(); // Log in the new user.
                    $newUser->assignRole('dosen');
                }
                auth()->login($newUser, true);
            } else if ($emailDomain == 'bps.go.id') {
                $patternEmailBPS = '/^bps\d{4}@bps\.go\.id$/';
                if (preg_match($patternEmailBPS, $email)) {
                    $newUser->save(); // Log in the new user.
                    $newUser->assignRole('pengguna_lulusan');
                } else {
                    return redirect()->route('login')->withErrors(['email' => 'Masih belum bisa dipastikan apakah mereka alumni atau hanya pegawai biasa bps']);
                }
                auth()->login($newUser, true);
            } else {
                return redirect()->route('login')->withErrors(['email' => 'Gunakan Email dengan domain stis.ac.id atau bps.go.id atau email instansi Anda']);
            }

            // auth()->login($newUser, true);
        } // Redirect to url as requested by user, if empty use /dashboard page as generated by Jetstream
        return redirect()->intended('/dashboard');
    }
}