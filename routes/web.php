<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosyanduController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('posyandu.index');
});

// Posyandu Routes
Route::prefix('posyandu')->name('posyandu.')->group(function () {
    Route::get('/', [PosyanduController::class, 'index'])->name('index');
    Route::post('/store', [PosyanduController::class, 'store'])->name('store');
    Route::get('/result/{id}', [PosyanduController::class, 'result'])->name('result');
    Route::get('/riwayat', [PosyanduController::class, 'riwayat'])->name('riwayat');
    Route::get('/edit/{id}', [PosyanduController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [PosyanduController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [PosyanduController::class, 'destroy'])->name('destroy');
    Route::get('/export/csv', [PosyanduController::class, 'exportCSV'])->name('export.csv');
    Route::get('/export/pdf', [PosyanduController::class, 'exportPDF'])->name('export.pdf');
});
