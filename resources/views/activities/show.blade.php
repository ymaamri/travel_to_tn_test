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

                    <!-- ========== REVIEWS SECTION ========== -->
                    <div class="mt-12 pt-8 border-t">
                        <h3 class="text-2xl font-semibold mb-4">Customer Reviews</h3>

                        @php
                            $avgRating = $activity->reviews->avg('rating');
                            $reviewCount = $activity->reviews->count();
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
                                    <input type="hidden" name="reviewable_type" value="activity">
                                    <input type="hidden" name="reviewable_id" value="{{ $activity->id }}">

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
                        @foreach($activity->reviews()->with('user', 'images')->latest()->get() as $review)
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
                        <a href="{{ route('activities.index') }}" class="text-indigo-600 hover:text-indigo-900">
                            ← Back to all activities
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>