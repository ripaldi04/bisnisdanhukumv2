<?php

namespace App\Filament\Resources\BroadcastEmailResource\Pages;

use App\Filament\Resources\BroadcastEmailResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;

class CreateBroadcastEmail extends CreateRecord
{
    protected static string $resource = BroadcastEmailResource::class;

    // public function afterCreate()
    // {
    //     $selectedRecipientIds = $this->data['recipients'];
    //     $this->record->emailRecipients()->sync($selectedRecipientIds);
    // }

    protected function getFormActions(): array
    {
        return [
            Actions\Action::make('send')
                ->label('Send') // Mengubah label tombol menjadi "Send"
                ->color('primary') // Warna tombol (opsional)
                ->icon('heroicon-o-paper-airplane') // Ikon (opsional)
                ->action(fn() => $this->createAndNotify()) // Aksi kustom saat diklik
                ->modalSubmitActionLabel(''), // Hapus submit label jika modal muncul
        ];
    }

    // Fungsi untuk membuat record dan menampilkan notifikasi sukses
    protected function createAndNotify()
    {
        $this->create(); // Proses pembuatan record

        // Gunakan notifikasi bawaan Filament
        // Notification::make()
        //     ->title('Email has been sent!')
        //     ->success()
        //     ->send();
    }
}
