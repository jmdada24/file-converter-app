@extends('layouts.app')

@section('content')
<section class="mx-auto max-w-3xl text-center">
    <h1 class="text-4xl font-extrabold tracking-light sm:text-5xl">
        Private File Converter
    </h1>
    <p class="mt-4 text-lg text-slate-400">
        Upload, convert, download, and remove temporary files automatically.
    </p>

</section>
<section class="mx-auto mt-12 grid max-w-4xl gap-6 md:grid-cols-2">
    <x-converter-card
        title="Image → PDF"
        description="Convert JPG, JPEG, PNG, and WEBP images into PDF files."
        :href="route('image-to-pdf.page')" />

    <x-converter-card
        title="PDF → Image"
        description="Convert a PDF page into an image for preview or export."
        :href="route('pdf-to-image.page')" />


    <x-converter-card
        title="PDF → Word"
        description="Convert PDF text into a DOCX file."
        :href="route('pdf-to-word.page')" />

    
</section>
@endsection