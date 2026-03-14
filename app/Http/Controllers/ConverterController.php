<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

}
