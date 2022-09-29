<x-slot name="header">
    <a class="underline underline-offset-4" href="{{ route('threads.show', ['channel' => $record->subject->favorited->thread->channel, 'thread' => $record->subject->favorited->thread]) }}">
        {{ $user->name }} favorited a reply
    </a>
</x-slot>

<x-slot name="body">
    <p>{{ $record->subject->favorited->body }}</p>
</x-slot>
