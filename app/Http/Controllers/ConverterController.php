<?php

namespace App\Http\Controllers;

use App\Services\ImageToPdfService;
use App\Services\PdfToImageService;
use App\Services\PdfToWordService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ConverterController extends Controller
{
    //
    public function home()
    {
        return view('pages.home');
    }
    public function imageToPdfPage()
    {
        return view('pages.image-to-pdf');
    }

    public function pdfToImagePage()
    {
        return view('pages.pdf-to-image');
    }


    public function pdfToWordPage()
    {
        return view('pages.pdf-to-word');
    }


    public function convertImageToPdf(Request $request, ImageToPdfService $imageToPdfService): BinaryFileResponse
    {

        $request->validate([
            'file' => ['required', 'file', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ]);

        $result = $imageToPdfService->convert($request->file('file'));

        return response()->download(
            $result['output_path'],
            $result['output_name'],

        )->deleteFileAfterSend(true);
    }


    public function convertPdfToImage(Request $request, PdfToImageService $pdfToImageService): BinaryFileResponse
    {

        $request->validate([
            'file' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $result = $pdfToImageService->convert($request->file('file'));

        return response()->download(
            $result['output_path'],
            $result['output_name'],

        )->deleteFileAfterSend(true);
    }




    public function convertPdfToWord(Request $request, PdfToWordService $pdfToWordService ): BinaryFileResponse{
        
        
        $request->validate([
            'file' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $result = $pdfToWordService->convert($request->file('file'));

        return response()->download(
            $result['output_path'],
            $result['output_name'],

        )->deleteFileAfterSend(true);
        

    }


}
