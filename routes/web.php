<?php

use App\Http\Controllers\EbookController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\LiveCourseController;
use App\Http\Controllers\OfflineEventController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontController::class, 'index'])->name('index');

Route::get('/landing', [FrontController::class, 'landing'])->name('landing');

Route::get('/articles', [FrontController::class, 'articles'])->name('articles.index');
Route::get('/articles/{slug}', [FrontController::class, 'detailArticle'])->name('articles.show');

Route::get('/category/{slug}', [FrontController::class, 'articlesByCategory'])->name('category');

Route::prefix('ebooks')->name('ebooks.')->group(function () {
    Route::get('/', [EbookController::class, 'index'])->name('index');
    Route::get('/{id}/download', [EbookController::class, 'download'])->name('download')->middleware('auth');
    Route::get('/{id}/buy', [EbookController::class, 'buy'])->name('buy')->middleware('auth');
    Route::post('/{id}/download-form', [EbookController::class, 'downloadForm'])->name('download-form');
    Route::post('/{id}/purchase-form', [EbookController::class, 'purchaseForm'])->name('purchase-form');
    Route::get('/checkout/{trxId}', [EbookController::class, 'checkout'])->name('checkout');
    Route::get('/{id}', [EbookController::class, 'show'])->name('show');
});

// CALLBACK MIDTRANS (TIDAK PAKAI CSRF)
Route::post('/midtrans/callback', [PaymentController::class, 'callback'])
    ->withoutMiddleware([VerifyCsrfToken::class]);
Route::get('/payment/finish', [PaymentController::class, 'finish'])->name('payment.finish');

// CALLBACK MIDTRANS EBOOK (TIDAK PAKAI CSRF)
Route::post('/ebooks/midtrans/callback', [EbookController::class, 'callback'])
    ->withoutMiddleware([VerifyCsrfToken::class]);
Route::get('/ebooks/check-status/{trxId}', [EbookController::class, 'checkStatus'])->name('ebooks.check-status');

use App\Http\Controllers\EbookClaimDiscountController;

Route::post('/ebooks/{ebook}/claim-discount', [EbookClaimDiscountController::class, 'store'])
    ->name('ebooks.claim-discount');



Route::prefix('live-courses')->name('live-courses.')->group(function () {
    Route::get('/', [LiveCourseController::class, 'index'])->name('index');
    Route::get('/{id}', [LiveCourseController::class, 'show'])->name('show');
    Route::get('/{id}/buy', [LiveCourseController::class, 'buy'])->name('buy')->middleware('auth');
    Route::get('/access/{trx_id}', [LiveCourseController::class, 'access'])->name('access')->middleware('auth');
    Route::post('/midtrans/callback', [LiveCourseController::class, 'callback']);
});

Route::prefix('events')->name('events.')->group(function () {
    Route::get('/', [OfflineEventController::class, 'index'])->name('index');
    Route::get('/{id}', [OfflineEventController::class, 'show'])->name('show');
    Route::get('/{id}/buy', [OfflineEventController::class, 'buy'])->name('buy')->middleware('auth');
    Route::get('/ticket/{trx_id}', [OfflineEventController::class, 'ticket'])->name('ticket')->middleware('auth');
});
Route::get('/events/check-in/{code}', [OfflineEventController::class, 'checkIn'])
    ->name('events.check-in');
Route::get('/materi', [FrontController::class, 'learn'])->name('learn');

Route::get('/pricing', [FrontController::class, 'pricing'])->name('pricing');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/materi/{moduleId}/{subModuleId}', [FrontController::class, 'learning'])->name('learning');
    Route::post('/submodule/{subModuleId}/complete', [FrontController::class, 'completeSubModule'])->name('submodule.complete');

    Route::get('/dashboard', [FrontController::class, 'dashboard'])->name('dashboard');

    Route::get('/todos', [FrontController::class, 'getTodoList'])->name('todos.get');
    Route::post('/todos/update', [FrontController::class, 'updateProgress'])->name('todos.update');

    Route::post('/create-invoice', [FrontController::class, 'createInvoice'])->name('create-invoice');
    Route::get('/checkout/{trxID}', [FrontController::class, 'showCheckout'])->name('checkout');
    Route::post('/checkout/store', [FrontController::class, 'checkout_store'])->name('checkout.store');

    Route::post('/commissions/withdraw', [FrontController::class, 'withdraw'])->name('commissions.withdraw');
});

require __DIR__ . '/auth.php';
