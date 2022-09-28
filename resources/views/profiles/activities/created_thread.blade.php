<x-slot name="header">
    {{ $user->name }} published <a class="underline underline-offset-4" href="{{ route('threads.show', ['channel' => $record->subject->channel, 'thread' => $record->subject]) }}">{{ $record->subject->title }}</a>
</x-slot>

<x-slot name="body">
    <p>{{ $record->subject->body }}</p>
</x-slot>
