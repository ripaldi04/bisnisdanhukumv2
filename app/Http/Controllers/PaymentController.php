<?php

namespace App\Http\Controllers;

use App\Models\EbookTransaction;
use App\Models\LiveCourseTransaction;
use App\Models\OfflineEventTransaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function callback(Request $request)
    {
        $data = $request->all();

        $orderId = $data['order_id'] ?? null;
        $status = $data['transaction_status'] ?? null;

        // Cari transaksi Ebook atau Event
        $trx = EbookTransaction::where('trx_id', $orderId)->first()
            ?? OfflineEventTransaction::where('trx_id', $orderId)->first()
            ?? LiveCourseTransaction::where('trx_id', $orderId)->first();
        ;

        if (!$trx) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // Simpan data Midtrans
        $trx->payment_type = $data['payment_type'] ?? null;
        $trx->midtrans_transaction_id = $data['transaction_id'] ?? null;

        // Handle status
        if ($status == 'settlement' || $status == 'capture') {
            $trx->status = 'Paid';
            $trx->paid_at = now();
        }

        if ($status == 'pending') {
            $trx->status = 'Pending';
        }

        if ($status == 'expire') {
            $trx->status = 'Expired';
        }

        if ($status == 'deny' || $status == 'cancel') {
            $trx->status = 'Failed';
        }

        $trx->save();

        return response()->json(['message' => 'OK']);
    }


}
