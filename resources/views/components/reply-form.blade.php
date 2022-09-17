@props(['thread'])

<div class="my-12 overflow-hidden flex flex-col">
    <header class="h-8 px-4 py-2 bg-blue-600 text-white text-sm flex items-center rounded-t-xl">
        <h2>Give your reply</h2>
    </header>

    <section class="flex-1 bg-white p-6 border-b border-l border-r border-blue-600 rounded-b-xl">
        <form action="{{ route('threads.replies.store', $thread) }}" method="POST" class="flex flex-col justify-between gap-y-4">
            @csrf

            <div>
                <textarea class="text-sm w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="body" rows="5">{{ old('body') }}</textarea>

                @error('body')
                    <span class="ml-4 text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <x-primary-button class="ml-auto bg-blue-600 hover:bg-blue-700 active:bg-blue-900 focus:border-transparent">Reply</x-primary-button>
        </form>
    </section>
</div>
