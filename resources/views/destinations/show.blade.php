<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $destination->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Hero image (first gallery image) -->
                @if($destination->photo_gallery && count($destination->photo_gallery) > 0)
                    <img src="{{ asset('storage/' . $destination->photo_gallery[0]) }}" alt="{{ $destination->name }}"
                        class="w-full h-64 md:h-96 object-cover">
                @endif

                <div class="p-6">
                    <!-- Type badge -->
                    <div class="mb-4">
                        <span class="inline-block bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded">
                            {{ ucfirst(str_replace('_', ' ', $destination->type)) }}
                        </span>
                    </div>

                    <!-- Overview -->
                    @if($destination->overview)
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-2">Overview</h3>
                            <p class="text-gray-700">{{ $destination->overview }}</p>
                        </div>
                    @endif

                    <!-- History -->
                    @if($destination->history)
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-2">History</h3>
                            <p class="text-gray-700">{{ $destination->history }}</p>
                        </div>
                    @endif

                    <!-- Things to do -->
                    @if($destination->things_to_do)
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-2">Things to do</h3>
                            <div class="text-gray-700">{!! nl2br(e($destination->things_to_do)) !!}</div>
                        </div>
                    @endif

                    <!-- Best restaurants -->
                    @if($destination->best_restaurants)
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-2">Best restaurants</h3>
                            <div class="text-gray-700">{!! nl2br(e($destination->best_restaurants)) !!}</div>
                        </div>
                    @endif

                    <!-- Hotels -->
                    @if($destination->hotels)
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-2">Hotels & accommodation</h3>
                            <div class="text-gray-700">{!! nl2br(e($destination->hotels)) !!}</div>
                        </div>
                    @endif

                    <!-- Weather -->
                    @if($destination->weather)
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-2">Weather</h3>
                            <p class="text-gray-700">{{ $destination->weather }}</p>
                        </div>
                    @endif

                    <!-- Transportation -->
                    @if($destination->transportation)
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-2">Transportation</h3>
                            <p class="text-gray-700">{{ $destination->transportation }}</p>
                        </div>
                    @endif

                    <!-- Best season -->
                    @if($destination->best_season)
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-2">Best season to visit</h3>
                            <p class="text-gray-700">{{ $destination->best_season }}</p>
                        </div>
                    @endif

                    <!-- Local foods -->
                    @if($destination->local_foods)
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-2">Local foods</h3>
                            <div class="text-gray-700">{!! nl2br(e($destination->local_foods)) !!}</div>
                        </div>
                    @endif

                    <!-- Budget estimate -->
                    @if($destination->budget_estimate)
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-2">Budget estimate</h3>
                            <p class="text-gray-700">{{ $destination->budget_estimate }}</p>
                        </div>
                    @endif

                    <!-- Safety info -->
                    @if($destination->safety_info)
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-2">Safety information</h3>
                            <p class="text-gray-700">{{ $destination->safety_info }}</p>
                        </div>
                    @endif

                    <!-- Map -->
                    @if($destination->map_url)
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-2">Location map</h3>
                            <div class="aspect-video">
                                {!! $destination->map_url !!}
                            </div>
                        </div>
                    @endif

                    <!-- Photo gallery (all images) -->
                    @if($destination->photo_gallery && count($destination->photo_gallery) > 1)
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-2">Photo gallery</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($destination->photo_gallery as $index => $image)
                                    @if($index > 0) <!-- skip first, already shown -->
                                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $destination->name }} gallery"
                                            class="w-full h-40 object-cover rounded">
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- FAQs -->
                    @if($destination->faqs && count($destination->faqs) > 0)
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-2">Frequently asked questions</h3>
                            <div class="space-y-4">
                                @foreach($destination->faqs as $faq)
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $faq['question'] }}</h4>
                                        <p class="text-gray-700">{{ $faq['answer'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Nearby attractions -->
                    @if($destination->nearby_attractions)
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-2">Nearby attractions</h3>
                            <div class="text-gray-700">{!! nl2br(e($destination->nearby_attractions)) !!}</div>
                        </div>
                    @endif

                    <!-- Back link -->
                    <div class="mt-8 pt-4 border-t">
                        <a href="{{ route('destinations.index') }}" class="text-indigo-600 hover:text-indigo-900">
                            ← Back to all destinations
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>