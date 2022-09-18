<x-app-layout>
    <div class="py-8">
        <x-thread-card :thread="$thread"/>
    </div>

    <div class="pb-12">
        <x-card>
            <x-slot name="header">
                <h2>Replies</h2>
            </x-slot>

            <x-slot name="body">
                @forelse ($thread->replies as $reply)
                    <div class="mb-6">
                        <div class="pb-4 pt-2">
                            <p>{{ $reply->body }}</p>
                        </div>

                        <span class="block text-right border-b border-b-gray-200 text-xs pb-2">
                            <a href="#" class="font-semibold hover:text-gray-900 hover:underline hover:underline-offset-4">{{ $reply->owner->name }}</a> said {{ $reply->created_at->diffForHumans() }}
                        </span>
                    </div>
                @empty
                    <div class="flex justify-center mb-8">
                        <h2 class="underline underline-offset-8">Be the first to reply in this thread!</h2>
                    </div>
                @endforelse

                @auth
                    <x-reply-form :thread="$thread"/>
                @else
                    <div class="flex justify-center">
                        <div class="h-8 px-4 py-2 mx-auto bg-blue-600 text-white text-sm inline-flex items-center rounded-xl">
                            <h2>Please <a href="{{ route('login') }}" class="underline underline-offset-4">sign in</a> to participate in this discussion</h2>
                        </div>
                    </div>
                @endauth
            </x-slot>
        </x-card>
    </div>
</x-app-layout>
