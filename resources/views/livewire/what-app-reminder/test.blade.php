<div class="p-4 border rounded space-y-4">
    <form wire:submit.prevent="sendReminder">
        <div>
            <label class="block">Nomor WA (628xxxx)</label>
            <input type="text" wire:model.defer="phone" class="border p-2 w-full" placeholder="628xxxxx">
        </div>

        <div>
            <label class="block">Pesan</label>
            <textarea wire:model.defer="message" class="border p-2 w-full" rows="4"></textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Kirim

            <div wire:loading wire:target='sendReminder'
                class="h-5 w-5 animate-spin rounded-full border-4 border-solid border-white border-t-transparent">
            </div>
        </button>
    </form>

    @if ($response)
        <div class="mt-4 p-2 bg-green-100 text-green-800 rounded">
            <strong>Respon Fonte:</strong>
            <pre>{{ json_encode($response, JSON_PRETTY_PRINT) }}</pre>
        </div>
    @endif
</div>
