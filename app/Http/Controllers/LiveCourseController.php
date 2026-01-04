<?php

namespace App\Http\Controllers;

use App\Models\LiveCourse;
use App\Models\LiveCourseTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LiveCourseController extends Controller
{
    // List semua live course
    public function index()
    {
        $liveCourses = LiveCourse::orderBy('start_time', 'asc')->paginate(12);
        return view('live-courses.index', compact('liveCourses'));
    }

    // Detail live course
    public function show($id)
    {
        $liveCourse = LiveCourse::findOrFail($id);
        
        $userHasAccess = false;
        if (auth()->check()) {
            $user = auth()->user();
            
            // Check if user has paid for this course
            $hasPaid = LiveCourseTransaction::where('user_id', $user->id)
                ->where('live_course_id', $liveCourse->id)
                ->where('status', 'Paid')
                ->exists();
                
            // For free courses, grant immediate access
            if ($liveCourse->is_free && !$hasPaid) {
                // Create free access transaction
                $this->generateAccess($user, $liveCourse);
                $hasPaid = true;
            }
            
            $userHasAccess = $hasPaid;
        }
        
        return view('live-courses.show', compact('liveCourse', 'userHasAccess'));
    }

    // Daftar live course
    public function buy($id)
    {
        $liveCourse = LiveCourse::findOrFail($id);
        $user = Auth::user();

        // Live course gratis → langsung dapat akses
        if ($liveCourse->is_free) {
            return $this->generateAccess($user, $liveCourse);
        }

        // Jika sudah bayar, langsung ke akses
        $existing = LiveCourseTransaction::where('user_id', $user->id)
            ->where('live_course_id', $liveCourse->id)
            ->where('status', 'Paid')
            ->first();

        if ($existing) {
            return redirect()->route('live-courses.access', $existing->id);
        }

        // Buat transaksi baru
        $trx = LiveCourseTransaction::create([
            'user_id' => $user->id,
            'live_course_id' => $liveCourse->id,
            'amount' => $liveCourse->price,
            'trx_id' => 'LC-' . time() . rand(1000, 9999),
            'status' => 'Pending',
        ]);

        // MIDTRANS CONFIG
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // PARAMETER PAYMENT
        $params = [
            'transaction_details' => [
                'order_id' => $trx->trx_id,
                'gross_amount' => (int) $trx->amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => [
                [
                    'id' => $liveCourse->id,
                    'price' => (int) $liveCourse->price,
                    'quantity' => 1,
                    'name' => $liveCourse->title,
                ]
            ]
        ];

        // SNAP TOKEN
        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('live-courses.checkout', [
            'trx' => $trx,
            'liveCourse' => $liveCourse,
            'snapToken' => $snapToken,
        ]);
    }

    // Akses Zoom setelah bayar
    public function access($transactionId)
    {
        $trx = LiveCourseTransaction::findOrFail($transactionId);

        if ($trx->status !== 'Paid') {
            return redirect()->back()->with('error', 'Transaksi belum dibayar.');
        }

        return view('live-courses.access', compact('trx'));
    }

    // Generate akses untuk live course gratis
    private function generateAccess($user, $liveCourse)
    {
        $trx = LiveCourseTransaction::create([
            'user_id' => $user->id,
            'live_course_id' => $liveCourse->id,
            'amount' => 0,
            'trx_id' => 'LC-FREE-' . time() . rand(1000, 9999),
            'status' => 'Paid',
            'paid_at' => now(),
        ]);

        return redirect()->route('live-courses.access', $trx->id);
    }

    // Callback untuk payment
    public function callback(Request $request)
    {
        $notif = new \Midtrans\Notification();

        $trx = LiveCourseTransaction::where('trx_id', $notif->order_id)->first();

        if (!$trx)
            return;

        if ($notif->transaction_status == 'settlement') {
            $trx->status = 'Paid';
            $trx->paid_at = now();
            $trx->payment_type = $notif->payment_type;
            $trx->midtrans_transaction_id = $notif->transaction_id;
        } elseif ($notif->transaction_status == 'expire') {
            $trx->status = 'Expired';
        } elseif ($notif->transaction_status == 'cancel') {
            $trx->status = 'Failed';
        }

        $trx->save();
    }
}