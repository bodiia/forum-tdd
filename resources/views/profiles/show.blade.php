<x-app-layout>
    <div class="w-[60rem] mx-auto">
        <div class="flex items-end gap-x-8 border-b border-gray-700 px-8 pt-12 pb-8">
            <h1 class="text-6xl">{{ $user->name }}</h1>
            <span class="text-2xl text-gray-500">since {{ $user->created_at->diffForHumans() }}</span>
        </div>

        <div class="py-12">
            <div class="flex flex-col gap-y-8">
                @foreach($threads as $thread)
                    <x-thread-card :thread="$thread" />
                @endforeach
            </div>
            <div class="py-12">
                {{ $threads->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
