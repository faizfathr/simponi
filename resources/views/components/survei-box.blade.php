@aware([
    $title,
    $link => '#'
])

<div class="border rounded-lg border-slate-200 p-3">
    <h1 class="font-semibold leading-5 text-blue-500 text-xl">
        {{ $title }}
    </h1>
    <a href="{{ $link }}" class="mt-3" action="submit">
        <div class="py-2 px-4 rounded-sm bg-blue-400 mt-5 text-white">
            selengkapnya
        </div>
    </a>
</div>