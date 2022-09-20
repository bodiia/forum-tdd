<x-app-layout>
    <div class="ml-16 py-8 flex flex-col gap-y-8 w-2/3">
        @foreach($threads as $thread)
            <x-thread-card :thread="$thread"/>
        @endforeach
    </div>
</x-app-layout>
