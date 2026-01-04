<?php

namespace App\Filament\Resources\SubscribeTransactionResource\Pages;

use App\Events\PaymentSuccessful;
use App\Filament\Resources\SubscribeTransactionResource;
use App\Models\ReferralCommission;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class EditSubscribeTransaction extends EditRecord
{
    protected static string $resource = SubscribeTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $user = Auth::user();
        // Memeriksa apakah status telah diubah menjadi "Success"
        if ($this->record->status === 'Success') {
            event(new PaymentSuccessful($this->record));
            $user = $this->record->user;
            $response = Http::withHeaders([
                'Authorization' => 'JMH7E2kvnrJ9nv3JrdCu',
            ])->post('https://api.fonnte.com/send', [
                'target' => $user->no_hp,
                'message' => "Selamat Anda sudah menyelesaikan registrasi di Bisnis dan Hukuum\n\nTerima Kasih atas Pembayaran Anda sebesar\n\nAnda bisa langsung menikmati pembelajaran praktis di Bisnis dan Hukum dengan login https://bisnisdanhukum.com/login"
            ]);

            // **LOGIKA ENTRY KOMISI REFERRAL**
            if ($user->referred_by) { // Pastikan ada field `referred_by` di tabel users
                $referrer = $user->referredBy; // Relasi user yang mereferensikan
                // Ambil persentase komisi sebagai bilangan bulat (misalnya 10 untuk 10%)
                $commissionPercentage = $referrer->referral_commission_percentage;
                $amount = (int)($this->record->total_amount * ($commissionPercentage / 100));

                // Masukkan data ke tabel referral_commissions
                ReferralCommission::create([
                    'referrer_id' => $referrer->id,
                    'referred_user_id' => $user->id,
                    'amount' => $amount,
                    'status' => 'Not Submitted', // Default status "Pending"
                    'nama_bank' => null, // Akan diisi oleh user nanti
                    'nama_rekening' => null, // Akan diisi oleh user nanti
                    'nomor_rekening' => null, // Akan diisi oleh user nanti
                    'proof' => null, // Akan diunggah admin setelah approval
                ]);

                // Notifikasi ke user yang mereferensikan (opsional)
                Http::withHeaders([
                    'Authorization' => 'JMH7E2kvnrJ9nv3JrdCu',
                ])->post('https://api.fonnte.com/send', [
                    'target' => $referrer->no_hp,
                    'message' => "Selamat! Anda telah mendapatkan komisi referral sebesar Rp " . number_format($amount, 0, ',', '.') . " dari pendaftaran user {$user->name}. Silakan ajukan pencairan komisi melalui dashboard Anda."
                ]);
            }
        }
    }
}
