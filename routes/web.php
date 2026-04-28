<?php

use App\Http\Controllers\CsvImportController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CsvImportController::class, 'index'])->name('csv.index');
Route::post('/csv/upload', [CsvImportController::class, 'upload'])->name('csv.upload');
Route::get('/csv/verify', [CsvImportController::class, 'verify'])->name('csv.verify');
Route::post('/csv/confirm', [CsvImportController::class, 'confirm'])->name('csv.confirm');
Route::delete('/csv/delete', [CsvImportController::class, 'destroy'])->name('csv.destroy');

require __DIR__.'/auth.php';
