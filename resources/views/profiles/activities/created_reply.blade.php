<x-slot name="header">
    {{ $user->name }} replied to <a class="underline underline-offset-4" href="{{ route('threads.show', ['channel' => $record->subject->thread->channel, 'thread' => $record->subject->thread]) }}">{{ $record->subject->thread->title }}</a>
</x-slot>

<x-slot name="body">
    <p>{{ $record->subject->body }}</p>
</x-slot>
