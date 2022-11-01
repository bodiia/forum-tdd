@props(['thread'])

<x-card>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <a href="{{ route('threads.show', ['channel' => $thread->channel, 'thread' => $thread]) }}">
                @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                    <h2 class="hover:underline hover:underline-offset-8 font-bold">{{ $thread->title }}</h2>
                @else
                    <h2 class="hover:underline hover:underline-offset-8">{{ $thread->title }}</h2>
                @endif
            </a>
            @if(! request()->routeIs('threads.show'))
                <span class="text-xs">{{ $thread->replies_count }} {{ Str::plural('reply', $thread->replies_count) }}</span>
            @else
                @can('delete', $thread)
                    <form action="{{ route('threads.channel.destroy', ['channel' => $thread->channel, 'thread' => $thread]) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hover:stroke-red-700">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </button>
                    </form>
                @endcan
            @endif
        </div>
    </x-slot>

    <x-slot name="body">
        <p>{{ $thread->body }}</p>
    </x-slot>
</x-card>
