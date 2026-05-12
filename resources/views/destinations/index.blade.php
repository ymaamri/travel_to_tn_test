<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Explore Destinations in Tunisia') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter by type (optional) -->
            <div class="mb-6 flex flex-wrap gap-2">
                <a href="{{ route('destinations.index') }}"
                    class="px-4 py-2 rounded-full text-sm {{ !request('type') ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    All
                </a>
                @foreach(['city', 'region', 'beach', 'historical_place', 'island', 'desert_area', 'village'] as $type)
                    <a href="{{ route('destinations.index', ['type' => $type]) }}"
                        class="px-4 py-2 rounded-full text-sm {{ request('type') == $type ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        {{ ucfirst(str_replace('_', ' ', $type)) }}
                    </a>
                @endforeach
            </div>

            @if($destinations->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($destinations as $destination)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                            @if($destination->photo_gallery && count($destination->photo_gallery) > 0)
                                <img src="{{ asset('storage/' . $destination->photo_gallery[0]) }}" alt="{{ $destination->name }}"
                                    class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                                    No image
                                </div>
                            @endif
                            <div class="p-4">
                                <div class="text-xs text-gray-500 mb-1">
                                    {{ ucfirst(str_replace('_', ' ', $destination->type)) }}
                                </div>
                                <h3 class="font-semibold text-lg mb-2">
                                    <a href="{{ route('destinations.show', $destination->slug) }}"
                                        class="hover:text-indigo-600">
                                        {{ $destination->name }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-600 mb-3">
                                    {{ Str::limit($destination->overview ?? 'No description yet.', 120) }}
                                </p>
                                <a href="{{ route('destinations.show', $destination->slug) }}"
                                    class="text-indigo-600 hover:text-indigo-900 text-sm">
                                    Learn more →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $destinations->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                    <p class="text-gray-500">No destinations found.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>