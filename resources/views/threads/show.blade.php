<x-app-layout>
    <div class="py-8">
        <x-thread-card :thread="$thread"/>
    </div>

    <div class="pb-8">
        <x-card>
            <x-slot name="header">
                <h2>Replies</h2>
            </x-slot>

            <x-slot name="body">
                @foreach($thread->replies as $reply)
                    <div class="mb-4">
                        <div class="pb-4 pt-2">
                            <p>{{ $reply->body }}</p>
                        </div>

                        <span class="block text-right border-b border-b-gray-200 text-xs pb-2">
                            <a href="#" class="font-semibold hover:text-gray-900 hover:underline hover:underline-offset-4">{{ $reply->owner->name }}</a> said {{ $reply->created_at->diffForHumans() }}
                        </span>
                    </div>
                @endforeach
            </x-slot>
        </x-card>
    </div>
</x-app-layout>
