<?php

use App\Http\Controllers\ConverterController;
use Illuminate\Support\Facades\Route;


Route::get('/', [ConverterController::class, 'home'])->name('home');

Route::get('/image-to-pdf', [ConverterController::class, 'imageToPdfPage'])->name('image-to-pdf.page');
Route::post('image-to-pdf', [ConverterController::class, 'convertImageToPdf'])->name('image-to-pdf.convert');


Route::get('/pdf-to-image', [ConverterController::class, 'pdfToImagePage'])->name('pdf-to-image.page');
Route::post('/pdf-to-image', [ConverterController::class, 'convertPdfToImage'])->name('pdf-to-image.convert');

