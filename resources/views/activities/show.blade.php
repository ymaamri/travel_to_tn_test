<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $activity->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Hero image (first photo) -->
                @if($activity->photos && count($activity->photos) > 0)
                    <img src="{{ asset('storage/' . $activity->photos[0]) }}" alt="{{ $activity->title }}"
                        class="w-full h-64 md:h-96 object-cover">
                @endif

                <div class="p-6">
                    <!-- Category badge -->
                    <div class="mb-4">
                        <span class="inline-block bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded">
                            {{ ucfirst(str_replace('_', ' ', $activity->category)) }}
                        </span>
                    </div>

                    <!-- Quick info grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
                        @if($activity->price_range)
                            <div>
                                <span class="font-semibold text-gray-700">💰 Price range:</span>
                                <p class="text-gray-600">{{ $activity->price_range }}</p>
                            </div>
                        @endif
                        @if($activity->duration)
                            <div>
                                <span class="font-semibold text-gray-700">⏱️ Duration:</span>
                                <p class="text-gray-600">{{ $activity->duration }}</p>
                            </div>
                        @endif
                        @if($activity->difficulty)
                            <div>
                                <span class="font-semibold text-gray-700">⚙️ Difficulty:</span>
                                <p class="text-gray-600">{{ $activity->difficulty }}</p>
                            </div>
                        @endif
                        @if($activity->location)
                            <div>
                                <span class="font-semibold text-gray-700">📍 Location:</span>
                                <p class="text-gray-600">{{ $activity->location }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Description -->
                    @if($activity->description)
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-2">About this activity</h3>
                            <div class="text-gray-700">{!! nl2br(e($activity->description)) !!}</div>
                        </div>
                    @endif

                    <!-- Photo gallery (all images) -->
                    @if($activity->photos && count($activity->photos) > 1)
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-2">Gallery</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($activity->photos as $index => $photo)
                                    @if($index > 0) <!-- skip first (already hero) -->
                                        <img src="{{ asset('storage/' . $photo) }}" alt="{{ $activity->title }} gallery"
                                            class="w-full h-40 object-cover rounded">
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Booking / contact info -->
                    @if($activity->booking_info)
                        <div class="mb-8 p-4 bg-green-50 border-l-4 border-green-500 rounded">
                            <h3 class="text-lg font-semibold mb-2">📞 Booking & Contact</h3>
                            <div class="text-gray-700">{!! nl2br(e($activity->booking_info)) !!}</div>
                        </div>
                    @endif

                    <!-- Back link -->
                    <div class="mt-8 pt-4 border-t">
                        <a href="{{ route('activities.index') }}" class="text-indigo-600 hover:text-indigo-900">
                            ← Back to all activities
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>