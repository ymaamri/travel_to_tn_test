<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Travel Blog') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6 text-gray-600">
                <p>{{ __('Discover the best places to visit, local foods, travel tips, and more about Tunisia.') }}</p>
            </div>

            @if($blogs->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($blogs as $blog)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                            @if($blog->featured_image)
                                <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}"
                                    class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                                    {{ __('No Image') }}
                                </div>
                            @endif
                            <div class="p-4">
                                <div class="text-xs text-gray-500 mb-1">
                                    {{ $blog->published_at ? $blog->published_at->format('F j, Y') : __('Draft') }}
                                </div>
                                <h3 class="font-semibold text-lg mb-2">
                                    <a href="{{ route('blog.show', $blog->slug) }}" class="hover:text-indigo-600">
                                        {{ $blog->title }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-600 mb-3">
                                    {{ $blog->excerpt ? Str::limit($blog->excerpt, 120) : Str::limit($blog->content, 120) }}
                                </p>
                                <div class="text-xs text-gray-400">
                                    {{ __('By') }} {{ $blog->user->name }}
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('blog.show', $blog->slug) }}"
                                        class="text-indigo-600 hover:text-indigo-900 text-sm">
                                        {{ __('Read More') }} →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $blogs->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                    <p class="text-gray-500">{{ __('No blog posts yet. Check back soon!') }}</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>