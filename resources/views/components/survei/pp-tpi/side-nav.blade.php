@aware([
    $blok,
    $keterangan,
    $active => FALSE
])

<div class="flex flex-col uppercase text-base 
{{ $active ? 'bg-blue-400 text-white' : 'bg-white text-slate-600 hover:bg-blue-400 hover:text-white' }} rounded-md px-3 py-2  my-2 transition-all duration-150">
    <h3 class="font-bold">{{ $blok }}</h3>
    <span class="text-xs">{{ $keterangan }}</span>
</div>