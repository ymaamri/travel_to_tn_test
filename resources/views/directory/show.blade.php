<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $establishment->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Hero image (first photo) -->
                @if($establishment->photos && count($establishment->photos) > 0)
                    <img src="{{ asset('storage/' . $establishment->photos[0]) }}" alt="{{ $establishment->name }}"
                        class="w-full h-64 md:h-96 object-cover">
                @endif

                <div class="p-6">
                    <!-- Category badge and rating -->
                    <div class="flex justify-between items-start mb-4">
                        <span class="inline-block bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded">
                            {{ $establishment->category_label }}
                        </span>
                        @if($establishment->rating > 0)
                            <div class="flex items-center">
                                <div class="flex text-yellow-500">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($establishment->rating))
                                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @elseif($i - 0.5 <= $establishment->rating)
                                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @else
                                            <svg class="w-5 h-5 fill-current text-gray-300" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endif
                                    @endfor
                                </div>
                                <span class="ml-2 text-sm text-gray-600">({{ $establishment->review_count }} review{{ $establishment->review_count !== 1 ? 's' : '' }})</span>
                            </div>
                        @endif
                    </div>

                    <!-- Quick info grid: Location, Price, Contact -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
                        @if($establishment->address || $establishment->city)
                            <div>
                                <span class="font-semibold text-gray-700">📍 Location:</span>
                                <p class="text-gray-600">
                                    {{ $establishment->address ? $establishment->address . ', ' : '' }}
                                    {{ $establishment->city ? $establishment->city . ', ' : '' }}
                                    {{ $establishment->region ?? '' }}
                                </p>
                            </div>
                        @endif
                        @if($establishment->price_range)
                            <div>
                                <span class="font-semibold text-gray-700">💰 Price range:</span>
                                <p class="text-gray-600">{{ $establishment->price_range }}</p>
                            </div>
                        @endif
                        @if($establishment->contact_phone)
                            <div>
                                <span class="font-semibold text-gray-700">📞 Phone:</span>
                                <p class="text-gray-600">{{ $establishment->contact_phone }}</p>
                            </div>
                        @endif
                        @if($establishment->contact_email)
                            <div>
                                <span class="font-semibold text-gray-700">📧 Email:</span>
                                <p class="text-gray-600">{{ $establishment->contact_email }}</p>
                            </div>
                        @endif
                        @if($establishment->website)
                            <div>
                                <span class="font-semibold text-gray-700">🌐 Website:</span>
                                <p class="text-gray-600">
                                    <a href="{{ $establishment->website }}" target="_blank" class="text-indigo-600 hover:underline">{{ $establishment->website }}</a>
                                </p>
                            </div>
                        @endif
                    </div>

                    <!-- Description -->
                    @if($establishment->description)
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-2">About</h3>
                            <div class="text-gray-700">{!! nl2br(e($establishment->description)) !!}</div>
                        </div>
                    @endif

                    <!-- Amenities (display as tags) -->
                    @if($establishment->amenities && count($establishment->amenities) > 0)
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-2">Amenities</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($establishment->amenities as $amenity)
                                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">{{ ucfirst($amenity) }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Google Map (if map_url provided) -->
                    @if($establishment->map_url)
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-2">Location Map</h3>
                            <div class="aspect-video">
                                {!! $establishment->map_url !!}
                            </div>
                        </div>
                    @endif

                    <!-- Photo gallery (all images except the first) -->
                    @if($establishment->photos && count($establishment->photos) > 1)
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-2">Photo Gallery</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($establishment->photos as $index => $photo)
                                    @if($index > 0)
                                        <img src="{{ asset('storage/' . $photo) }}" alt="{{ $establishment->name }} gallery"
                                            class="w-full h-40 object-cover rounded">
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Back link -->
                    <div class="mt-8 pt-4 border-t">
                        <a href="{{ route('directory.index') }}" class="text-indigo-600 hover:text-indigo-900">
                            ← Back to Directory
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>