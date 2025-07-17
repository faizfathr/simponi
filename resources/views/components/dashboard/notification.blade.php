@aware([
    'showNotif' => true,
    'message' => '',
    'status' => '',
])
<div x-data = "{ progress: 0 }" x-show="{{ $showNotif }}"
    x-effect="
        if({{ $showNotif }}) {
            setTimeout(() => {
                {{ $showNotif }} = false
            }, 3000)
        }"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-full"
    x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-full"
    class="fixed top-20 right-5 max-w-sm w-full bg-white shadow-md rounded-lg overflow-hidden ml-3 z-100">
    <div class="inline-flex justify-start w-full">
        <div class="flex justify-center items-center w-12 bg-success-500">
            @if (false)
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            @else
                <svg class="h-6 w-6 fill-current text-white" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z" />
                </svg>
            @endif
        </div>

        <div class="-mx-3 py-2 px-4">
            <div class="mx-3 text-start">
                <span class="text-success-500 font-semibold">{{ $status }}</span>
                <p class="text-gray-600 text-sm">
                    {{ $message }}
                </p>
            </div>
        </div>
    </div>
    <div class="absolute -bottom-1 w-full bg-white rounded-full h-1.5">
        <div class="bg-success-500 h-1.5 rounded-full w-[0%] scale-x-100 transition duration-[3000ms] animate-progress">
        </div>
    </div>
</div>
