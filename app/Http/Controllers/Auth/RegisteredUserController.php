<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'sosial_media' => 'required|string|max:255',
            'no_hp' => 'required|max:255',
            'referral_code' => 'nullable|exists:users,referral_code',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'sosial_media' => $request->sosial_media,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'referred_by' => $request->referral_code,
            'referral_code' => strtoupper(Str::random(8)), // Generate kode unik
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'JMH7E2kvnrJ9nv3JrdCu',
        ])->post('https://api.fonnte.com/send', [
            'target' => $user->no_hp,
            'message' => "Selamat Datang di Bisnis dan Hukum, Anda sudah registrasi fitur free membership. Anda bisa mempelajari beberapa konten secara gratis. Silahkan login pada link berikut: https://bisnisdanhukum.com/login"
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect('/');
    }
}
