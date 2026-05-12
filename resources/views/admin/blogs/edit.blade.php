<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Blog Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.blogs.update', $blog) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                                :value="old('title', $blog->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="excerpt" :value="__('Excerpt (short summary)')" />
                            <textarea id="excerpt" name="excerpt" rows="3"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('excerpt', $blog->excerpt) }}</textarea>
                            <p class="text-sm text-gray-500 mt-1">{{ __('Optional: A short summary of the post (max 500 characters)') }}</p>
                            <x-input-error :messages="$errors->get('excerpt')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="content" :value="__('Content')" />
                            <textarea id="content" name="content" rows="15"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>{{ old('content', $blog->content) }}</textarea>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="featured_image" :value="__('Featured Image')" />
                            @if($blog->featured_image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $blog->featured_image) }}" class="h-32 w-32 object-cover rounded">
                                </div>
                            @endif
                            <input type="file" id="featured_image" name="featured_image"
                                class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm" />
                            <p class="text-sm text-gray-500 mt-1">{{ __('Optional: JPEG, PNG, JPG, GIF (max 2MB)') }}</p>
                            <x-input-error :messages="$errors->get('featured_image')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_published" value="1"
                                    {{ old('is_published', $blog->is_published) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ms-2 text-sm text-gray-600">{{ __('Publish immediately') }}</span>
                            </label>
                            <p class="text-sm text-gray-500 mt-1">{{ __('If unchecked, the post will be saved as a draft.') }}</p>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-secondary-button class="ms-3" onclick="location.href='{{ route('admin.blogs.index') }}'">
                                {{ __('Cancel') }}
                            </x-secondary-button>
                            <x-primary-button class="ms-3">
                                {{ __('Update Post') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>