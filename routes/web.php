<?php

use App\Http\Controllers\ConverterController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [ConverterController::class, 'home'])->name('home');
Route::get('/image-to-pdf', [ConverterController::class, 'imageToPdfPage'])->name('image-to-pdf.page');
Route::get('/pdf-to-image', [ConverterController::class, 'pdfToImagePage'])->name('pdf-to-image.page');