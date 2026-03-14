@extends('layouts.app')


@section('content')

<div class="mx-auto max-w-3xl rounded-2xl border border-slate-800 bg-slate-900 p-8">
    <div class="rounded-2xl border border-slate-800 bg-slate-900 p-8 shadow-2xl">
        <h1 class="text-3xl font-bold tracking-tight">PDF → Word</h1>
        <p class="mt-2 text-slate-400">
            Upload a PDF and convert its extracted text into a DOCX file.
        </p>

        <form action="{{ route('pdf-to-word.convert') }}" method="POST" enctype="multipart/form-data" class="mt-8 space-y-6" onsubmit="handleConvertSubmit(this)">
            @csrf

            <div>
                <label for="file" class="mb-2 block text-sm font-medium text-slate-200">
                    Select PDF
                </label>

                <input
                    id="file"
                    name="file"
                    type="file"
                    accept=".pdf"
                    class="block w-full rounded-xl border border-slate-700 bg-slate-500 px-4 py-3 text-sm text-slate-200 
                        file:mr-4 file:rounded-lg file:border-0 file:bg-sky-500 file:px-4 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-sky-400"
                    required>

                @error('file')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                data-submit-button
                class="inline-flex items-center rounded-xl bg-sky-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-sky-400 disabled:cursor-not-allowed disabled:opacity-60"
            >
                <span data-default-text>Convert to Word</span>
                <span data-loading-text class="hidden">Converting...</span>
            </button>


            <p class="text-sm text-slate-400">
                Please wait while your file is being processed. Do not close this tab.
            </p>

        </form>
    </div>
</div>
@endsection