<x-app-layout>
    <div class="mt-6">
        <x-card>
            <x-slot name="header">
                <h2>Create Thread</h2>
            </x-slot>

            <x-slot name="body">
                <form action="{{ route('threads.store') }}" method="POST" class="flex flex-col gap-y-4">
                    @csrf

                    <div>
                        <x-input-label value="Title" class="mb-2"/>
                        <x-text-input required class="block mt-1 w-full" value="{{ old('title') }}" name="title" id="title" type="text" />

                        @error('title')
                            <span class="ml-4 text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="channel" class="block mb-2 text-sm font-medium text-gray-900">Channel</label>
                        <select required id="channel" name="channel_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option selected value="">Choose a channel</option>
                            @foreach($channels as $channel)
                                <option value="{{ $channel->id }}" @selected(old('channel_id') == $channel->id)>{{ $channel->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label value="Body" class="mb-2"/>
                        <textarea required name="body" id="body" cols="30" rows="10" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('body') }}</textarea>

                        @error('body')
                            <span class="ml-4 text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <x-primary-button class="ml-auto bg-blue-600 hover:bg-blue-700 active:bg-blue-900 focus:border-transparent">Create</x-primary-button>
                </form>
            </x-slot>
        </x-card>
    </div>
</x-app-layout>
