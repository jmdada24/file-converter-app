<?php

namespace App\Http\Controllers;

use App\Services\ImageToPdfService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ConverterController extends Controller
{
    //
    public function home(){
        return view('pages.home');
    }
    public function imageToPdfPage(){
        return view('pages.image-to-pdf');

    }

    public function pdfToImagePage(){
        return view('pages.pdf-to-image');
    }

    public function convertImageToPdf(Request $request, ImageToPdfService $imageToPdfService): BinaryFileResponse{

        $request->validate([
            'file' => ['required', 'file', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ]);
        
        $result = $imageToPdfService->convert($request->file('file'));

        return response()->download(
            $result['output_path'],
            $result['output_name'],

            )->deleteFileAfterSend(true);
        }


}
