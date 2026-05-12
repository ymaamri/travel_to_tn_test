<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Things To Do in Tunisia') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Category filter -->
            <div class="mb-6 flex flex-wrap gap-2">
                <a href="{{ route('activities.index') }}"
                    class="px-4 py-2 rounded-full text-sm {{ !request('category') ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    All
                </a>
                @foreach(['beaches', 'desert_tours', 'museums', 'roman_ruins', 'hiking', 'diving', 'nightlife', 'shopping', 'traditional_markets', 'food_tours', 'festivals'] as $cat)
                    <a href="{{ route('activities.index', ['category' => $cat]) }}"
                        class="px-4 py-2 rounded-full text-sm {{ request('category') == $cat ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        {{ ucfirst(str_replace('_', ' ', $cat)) }}
                    </a>
                @endforeach
            </div>

            @if($activities->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($activities as $activity)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                            @if($activity->photos && count($activity->photos) > 0)
                                <img src="{{ asset('storage/' . $activity->photos[0]) }}" alt="{{ $activity->title }}"
                                    class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                                    No image
                                </div>
                            @endif
                            <div class="p-4">
                                <div class="text-xs text-gray-500 mb-1">
                                    {{ ucfirst(str_replace('_', ' ', $activity->category)) }}
                                </div>
                                <h3 class="font-semibold text-lg mb-2">
                                    <a href="{{ route('activities.show', $activity->slug) }}" class="hover:text-indigo-600">
                                        {{ $activity->title }}
                                    </a>
                                </h3>
                                @if($activity->price_range)
                                    <div class="text-sm text-gray-600 mb-1">
                                        <span class="font-medium">Price:</span> {{ $activity->price_range }}
                                    </div>
                                @endif
                                @if($activity->duration)
                                    <div class="text-sm text-gray-600 mb-1">
                                        <span class="font-medium">Duration:</span> {{ $activity->duration }}
                                    </div>
                                @endif
                                <p class="text-sm text-gray-600 mb-3">
                                    {{ Str::limit($activity->description ?? 'No description yet.', 100) }}
                                </p>
                                <a href="{{ route('activities.show', $activity->slug) }}"
                                    class="text-indigo-600 hover:text-indigo-900 text-sm">
                                    View details →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $activities->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                    <p class="text-gray-500">No activities found.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>