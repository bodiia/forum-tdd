@props(['thread'])

<x-card>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <a href="{{ route('threads.show', ['channel' => $thread->channel, 'thread' => $thread]) }}">
                <h2 class="hover:underline hover:underline-offset-8">{{ $thread->title }}</h2>
            </a>
            @if(! request()->routeIs('threads.show'))
                <span class="text-xs">{{ $thread->replies_count }} {{ Str::plural('reply', $thread->replies_count) }}</span>
            @endif
        </div>
    </x-slot>

    <x-slot name="body">
        <p>{{ $thread->body }}</p>
    </x-slot>
</x-card>
