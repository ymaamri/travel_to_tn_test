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

                    <!-- ========== REVIEWS SECTION ========== -->
                    <div class="mt-12 pt-8 border-t">
                        <h3 class="text-2xl font-semibold mb-4">Traveler Reviews</h3>

                        @php
                            $avgRating = $destination->reviews->avg('rating');
                            $reviewCount = $destination->reviews->count();
                        @endphp

                        <div class="flex items-center gap-4 mb-6">
                            <div class="text-3xl font-bold">{{ number_format($avgRating, 1) }}</div>
                            <div class="flex text-yellow-500 text-xl">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($avgRating)) ★ @else ☆ @endif
                                @endfor
                            </div>
                            <div class="text-gray-600">({{ $reviewCount }} {{ Str::plural('review', $reviewCount) }})
                            </div>
                        </div>

                        @if(session('success'))
                            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                                {{ session('error') }}
                            </div>
                        @endif

                        @auth
                            <div class="bg-gray-50 p-4 rounded-lg mb-8">
                                <h4 class="font-semibold mb-3">Write a Review</h4>
                                <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="reviewable_type" value="destination">
                                    <input type="hidden" name="reviewable_id" value="{{ $destination->id }}">

                                    <div class="mb-3">
                                        <label class="block text-sm font-medium mb-1">Rating *</label>
                                        <select name="rating" class="border rounded p-2" required>
                                            <option value="">Select rating</option>
                                            @for($i = 1; $i <= 5; $i++)
                                                <option value="{{ $i }}">{{ $i }} star{{ $i > 1 ? 's' : '' }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="block text-sm font-medium mb-1">Review Title (optional)</label>
                                        <input type="text" name="title" class="w-full border rounded p-2"
                                            value="{{ old('title') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="block text-sm font-medium mb-1">Your Review</label>
                                        <textarea name="content" rows="3"
                                            class="w-full border rounded p-2">{{ old('content') }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="block text-sm font-medium mb-1">Upload Photos (optional)</label>
                                        <input type="file" name="images[]" multiple accept="image/*" class="w-full">
                                        <p class="text-xs text-gray-500 mt-1">You can select multiple images (JPEG, PNG,
                                            JPG, GIF up to 2MB each).</p>
                                    </div>

                                    <button type="submit"
                                        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Submit
                                        Review</button>
                                </form>
                            </div>
                        @else
                            <p class="mb-6 text-gray-500"><a href="{{ route('login') }}" class="text-indigo-600">Log in</a>
                                to write a review.</p>
                        @endauth

                        <!-- List of reviews -->
                        @foreach($destination->reviews()->with('user', 'images')->latest()->get() as $review)
                            <div class="border rounded-lg p-4 mb-4">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <div class="flex text-yellow-500">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating) ★ @else ☆ @endif
                                                @endfor
                                            </div>
                                            @if($review->is_verified)
                                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">✓
                                                    Verified Traveler</span>
                                            @endif
                                            @if($review->user->hasVerifiedTravel() && !$review->is_verified)
                                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">Eligible
                                                    for verification</span>
                                            @endif
                                        </div>
                                        @if($review->title)
                                            <h5 class="font-semibold mt-1">{{ $review->title }}</h5>
                                        @endif
                                        <p class="text-gray-700 mt-1">{{ $review->content }}</p>
                                        <div class="text-sm text-gray-500 mt-2">
                                            – {{ $review->user->name }} on {{ $review->created_at->format('M d, Y') }}
                                        </div>
                                        @if($review->images->count())
                                            <div class="flex gap-2 mt-3 flex-wrap">
                                                @foreach($review->images as $img)
                                                    <img src="{{ asset('storage/' . $img->image_path) }}"
                                                        class="w-16 h-16 object-cover rounded">
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    @if(auth()->check() && (auth()->id() === $review->user_id || auth()->user()->role === 'admin'))
                                        <div class="ml-4">
                                            <form action="{{ route('reviews.destroy', $review) }}" method="POST"
                                                onsubmit="return confirm('Delete this review?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 text-sm hover:underline">Delete</button>
                                            </form>
                                            @if(auth()->user()->role === 'admin' && !$review->is_verified)
                                                <form action="{{ route('reviews.verify', $review) }}" method="POST" class="mt-1">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="text-green-600 text-sm hover:underline">Verify</button>
                                                </form>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

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