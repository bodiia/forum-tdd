@props(['message'])

<div class="fixed right-4 bottom-4" id="alert" x-data="{ show: true }">
    <div x-show="show" class="flex justify-between items-center gap-x-4 bg-blue-500 border text-white px-4 py-3 rounded-md" role="alert">
        <span class="block sm:inline">{{ $message }}</span>
        <svg  class="w-5 h-5 cursor-pointer" @click="show = false" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </div>
</div>
