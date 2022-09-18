@props(['thread'])

<x-card>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <a href="{{ route('threads.show', ['channel' => $thread->channel, 'thread' => $thread]) }}">
                <h2 class="hover:underline hover:underline-offset-8">{{ $thread->title }}</h2>
            </a>
            <span class="text-xs hover:underline hover:underline-offset-4">by <a href="#">{{ $thread->creator->name }}</a></span>
        </div>
    </x-slot>

    <x-slot name="body">
        <p>{{ $thread->body }}</p>
    </x-slot>
</x-card>
