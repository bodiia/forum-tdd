<x-app-layout>
    <div class="w-[60rem] mx-auto">
        <div class="flex items-end gap-x-8 px-8 pt-12 pb-8">
            <h1 class="text-6xl">{{ $user->name }}</h1>
            <span class="text-2xl text-gray-500">since {{ $user->created_at->diffForHumans() }}</span>
        </div>

        <div class="py-12">
            <div class="flex flex-col gap-y-8">
                @forelse ($activities as $date => $activity)
                    <h3 class="text-lg border-b border-gray-800 pb-4">{{ $date }}</h3>
                    @foreach ($activity as $record)
                        <x-card>
                            @include("profiles.activities.$record->type")
                        </x-card>
                    @endforeach
                @empty
                    <h3 class="text-lg border-b border-gray-800 pb-4">No activities</h3>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
