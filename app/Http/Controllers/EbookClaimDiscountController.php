<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use Illuminate\Http\Request;

class EbookClaimDiscountController extends Controller
{
    public function store(Request $request, Ebook $ebook)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email' => ['required', 'email'],
            'no_hp' => ['required|max:255'],
        ]);

        // OPTIONAL: normalisasi nomor WA jadi angka saja
        $data['whatsapp'] = preg_replace('/\D+/', '', $data['whatsapp']);

        // OPSI A (paling cepat): simpan ke session dulu (tanpa DB)
        session([
            'claim_discount' => [
                'ebook_id' => $ebook->id,
                'name'      => $data['name'],
                'email' => $data['email'],
                'no_hp' => $data['no_hp'],
            ]
        ]);

        // Lalu arahkan user daftar/login
        return redirect()->route('register')
            ->with('success', 'Diskon 100% berhasil diklaim. Silakan daftar untuk lanjut download.');
    }
}
