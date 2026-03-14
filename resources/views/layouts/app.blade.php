<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'File Converter' }}</title>
    @vite(['resources/css/app.css' , 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-white">
    <header class="border-b border-slate-800 bg-slate-900/80 backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
            <a href="{{ route('home') }}" class="text-lg font-bold tracking-tight">JM's File Converter</a>
            <nav class="flex items-center gap-4 text-sm text-slate-300">
                <a href="{{ route('home') }}" >Home</a>
                <a href="{{ route('image-to-pdf.page') }}">Image → PDF</a>
                <a href="{{ route('pdf-to-image.page') }}">PDF → Image</a>
            </nav>
        </div>

    </header>

    <main class="mx-auto max-w-6xl px-6 py-10">
        @yield('content')

    </main>

    
</body>
</html>