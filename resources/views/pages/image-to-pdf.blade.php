@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-3xl rounded-2xl border border-slate-800 bg-slate-900 p-8">
        <div class="rounded-2xl border border-slate-800 bg-slate-900 p-8 shadow-2xl">
            <h1 class="text-3xl font-bold tracking-tight">Image → PDF</h1>
            <p class="mt-2 text-slate-400">
                Upload a JPG, PNG, or WEBP image and convert it into a PDF file.
            </p>

            <form action="{{ route('image-to-pdf.convert') }}" method="POST" enctype="multipart/form-data" class="mt-8 space-y-6">
                @csrf

                <div>
                    <label for="file" class="mb-2 block text-sm font-medium text-slate-200">
                        Select image
                    </label>

                    <input
                        id="file" 
                        name="file"
                        type="file"
                        accept=".jpg,.jpeg,.png,.webp"
                        class="block w-full rounded-xl border border-slate-700 bg-slate-500 px-4 py-3 text-sm text-slate-200 
                        file:mr-4 file:rounded-lg file:border-0 file:bg-sky-500 file:px-4 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-sky-400"
                        required
                    >
                    @error('file')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror

                </div>

                <button type="submit" class="inline-flex items-center rounded-xl bg-sky-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-sky-400 ">
                    Convert to PDF

                </button>

            </form>

        </div>
        
    </div>



@endsection