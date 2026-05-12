<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $blog->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if($blog->featured_image)
                    <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}"
                        class="w-full h-64 md:h-96 object-cover">
                @endif
                <div class="p-6">
                    <div class="text-sm text-gray-500 mb-4">
                        {{ $blog->published_at->format('F j, Y') }} •
                        {{ __('By') }} {{ $blog->user->name }}
                    </div>
                    @if($blog->excerpt)
                        <div class="text-lg text-gray-600 italic mb-6 border-l-4 border-indigo-400 pl-4">
                            {{ $blog->excerpt }}
                        </div>
                    @endif
                    <div class="prose max-w-none">
                        {!! nl2br(e($blog->content)) !!}
                    </div>
                    <div class="mt-8 pt-4 border-t">
                        <a href="{{ route('blog.index') }}" class="text-indigo-600 hover:text-indigo-900">
                            ← {{ __('Back to all posts') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>