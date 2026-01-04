<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StockCardController;
use App\Http\Controllers\VisitorController;
use App\Models\StockCard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'index']);
Route::get('/login', [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // AuthController routes
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Items
    Route::get('/items', [ItemController::class, 'index'])->name('index.item');
    Route::get('/add-item', [ItemController::class, 'create'])->name('create.item');
    Route::post('/add-item', [ItemController::class, 'store'])->name('store.item');
    Route::get('/edit-item/{id}', [ItemController::class, 'edit'])->name('edit.item');
    Route::get('/view-item/{id}', [ItemController::class, 'show'])->name('show.item');
    Route::put('/update-item', [ItemController::class, 'update'])->name('update.item');
    Route::delete('/delete-item/{id}', [ItemController::class, 'destroy'])->name('destroy.item');
    Route::get('/released-items', [ItemController::class, 'released'])->name('released.items');

    // Stock Cards
    Route::get('/stock-cards', [StockCardController::class, 'index'])->name('index.stockcards');
    Route::get('/stock-card/{id}', [StockCardController::class, 'show'])->name('show.stockcard');

    // Release Item
    Route::get('/release-item', [ItemController::class, 'create_release'])->name('show.release');
    Route::post('/release-item', [ItemController::class, 'release'])->name('release.item');
    Route::get('/item/stock/{id}', [ItemController::class, 'get_item_stock'])->name('item.stock');

    // Report
    Route::get('/report-sami', [ReportController::class, 'report_sami'])->name('show.report');
});
