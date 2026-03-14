@props([
    'title',
    'description',
    'href',

])

<a href="{{ $href}}" class="group block rounded-2xl border border-slate-800 bg-slate-900 p-6 transition hover:translate-y-0.5 hover:border-slate-600 hover:bg-slate-800/80">
    <div class="space-y-2">
        <h2 class="text-xl font-semibold text-white"> {{ $title }}</h2>
        <p class="text-sm leading-6 text-slate-600"> {{ $description }}</p>
    </div>
    <div class="mt-5 text-sm font-medium text-sky-400 group-hover:text-sky-300">
        Open tool →
    </div>

</a>