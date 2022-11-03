<x-app-layout>
    <div class="w-[60rem] mx-auto">
        <div class="flex flex-col items-start gap-y-2 px-8 pt-12 pb-8">
            <div class="flex gap-x-4 items-center">
                <img src="{{ asset($user->avatar()) }}" alt="User profile image" class="rounded-md w-16 h-16">
                <h1 class="text-4xl">{{ $user->name }}</h1>
            </div>
        @can('update', $user)
                <form action="{{ route('user.avatar.update', $user) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <input type="file" name="avatar" class="block mb-4">
                    <x-primary-button class="inline-block">Update avatar</x-primary-button>
                </form>
            @endcan
        </div>

        <div class="py-4">
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
