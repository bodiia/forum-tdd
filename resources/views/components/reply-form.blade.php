@props(['thread'])

<div class="mt-12 mb-4 flex flex-col">
    <section class="flex-1 bg-white">
        <form action="{{ route('threads.replies.store', ['channel' => $thread->channel, 'thread' => $thread]) }}" method="POST">
            @csrf

                <textarea placeholder="Have something to say?" class="mb-4 text-sm w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="body" rows="5">{{ old('body') }}</textarea>

                @error('body')
                    <span class="ml-4 text-sm text-red-600">{{ $message }}</span>
                @enderror

            <div class="flex justify-end">
                <x-primary-button class="">Reply</x-primary-button>
            </div>
        </form>
    </section>
</div>
