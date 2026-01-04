<?php

namespace App\Filament\Imports;

use App\Models\EmailRecipient;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class EmailRecipientImporter extends Importer
{
    protected static ?string $model = EmailRecipient::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('email')
                ->requiredMappingForNewRecordsOnly()
                ->rules(['required', 'unique:email_recipients,email'])
                ->example('email@example.com')
                ->exampleHeader('Email')
        ];
    }

    public function resolveRecord(): ?EmailRecipient
    {
        return EmailRecipient::firstOrNew([
            // Update existing records, matching them by `$this->data['column_name']`
            'email' => $this->data['email'],
        ]);

        return new EmailRecipient();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your email recipient import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
