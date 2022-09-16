<x-app-layout>
    <div class="py-8 flex flex-col gap-y-8">
        @foreach($threads as $thread)
            <x-thread-card :thread="$thread"/>
        @endforeach
    </div>
</x-app-layout>
