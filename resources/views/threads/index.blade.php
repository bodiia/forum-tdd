<x-app-layout>
    <div class="mx-auto py-8 flex flex-col gap-y-8 w-2/3">
        @forelse ($threads as $thread)
            <x-thread-card :thread="$thread"/>
        @empty
            <h1 class="w-1/6 px-4 py-2 bg-blue-600 text-white text-sm flex items-center justify-center rounded-xl">No threads found</h1>
        @endforelse
    </div>
</x-app-layout>
