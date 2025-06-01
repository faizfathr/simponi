<div x-data="{ item: @entangle('idMonitoring') }">
    @foreach ($subsektor as $sb)
        <button wire:click="updateItem('{{ $sb->id }}')"
            class="inline-flex items-center gap-2d px-2 py-2 text-xs font-medium  transition rounded-lg {{ $sb->id == $idMonitoring ? 'bg-brand-500 text-white' : 'border border-primary text-brand-500 hover:bg-brand-600 hover:text-white' }} shadow-theme-xs  mb-3">
            {{ $sb->nama }}
        </button>
    @endforeach
    <livewire:monitoring.submonitoring idMonitoring='3'/>
</div>
