<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hotels & Restaurants Directory') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Category filter -->
            <div class="mb-6 flex flex-wrap gap-2">
                <a href="{{ route('directory.index') }}"
                    class="px-4 py-2 rounded-full text-sm {{ !request('category') ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    All
                </a>
                @foreach([
                    'hotel' => 'Hotels',
                    'resort' => 'Resorts',
                    'hostel' => 'Hostels',
                    'guest_house' => 'Guest Houses',
                    'cafe' => 'Cafés',
                    'traditional_restaurant' => 'Traditional Restaurants',
                    'luxury_dining' => 'Luxury Dining'
                ] as $value => $label)
                    <a href="{{ route('directory.index', ['category' => $value]) }}"
                        class="px-4 py-2 rounded-full text-sm {{ request('category') == $value ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            @if($establishments->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($establishments as $item)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                            @if($item->photos && count($item->photos) > 0)
                                <img src="{{ asset('storage/' . $item->photos[0]) }}" alt="{{ $item->name }}"
                                    class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                                    No image
                                </div>
                            @endif
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-1">
                                    <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-700">
                                        {{ $item->category_label }}
                                    </span>
                                    @if($item->rating > 0)
                                        <div class="flex items-center text-yellow-500 text-sm">
                                            <span class="text-gray-700 mr-1">{{ number_format($item->rating, 1) }}</span>
                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        </div>
                                    @endif
                                </div>
                                <h3 class="font-semibold text-lg mb-1">
                                    <a href="{{ route('directory.show', $item->slug) }}" class="hover:text-indigo-600">
                                        {{ $item->name }}
                                    </a>
                                </h3>
                                @if($item->address)
                                    <p class="text-sm text-gray-500 mb-1">
                                        <svg class="inline w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $item->city ? $item->city . ', ' : '' }}{{ $item->region ?? '' }}
                                    </p>
                                @endif
                                @if($item->price_range)
                                    <div class="text-sm text-gray-600 mb-2">
                                        <span class="font-medium">Price:</span> {{ $item->price_range }}
                                    </div>
                                @endif
                                <p class="text-sm text-gray-600 mb-3">
                                    {{ Str::limit($item->description ?? 'No description yet.', 100) }}
                                </p>
                                <a href="{{ route('directory.show', $item->slug) }}"
                                    class="text-indigo-600 hover:text-indigo-900 text-sm">
                                    View details →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $establishments->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                    <p class="text-gray-500">No establishments found in this category.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>