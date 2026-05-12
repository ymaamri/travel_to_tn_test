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

                    <!-- ========== REVIEWS SECTION ========== -->
                    <div class="mt-12 pt-8 border-t">
                        <h3 class="text-2xl font-semibold mb-4">Customer Reviews</h3>

                        @php
                            $avgRating = $establishment->reviews->avg('rating');
                            $reviewCount = $establishment->reviews->count();
                        @endphp

                        <div class="flex items-center gap-4 mb-6">
                            <div class="text-3xl font-bold">{{ number_format($avgRating, 1) }}</div>
                            <div class="flex text-yellow-500 text-xl">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($avgRating)) ★ @else ☆ @endif
                                @endfor
                            </div>
                            <div class="text-gray-600">({{ $reviewCount }} {{ Str::plural('review', $reviewCount) }})</div>
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
                                    <input type="hidden" name="reviewable_type" value="establishment">
                                    <input type="hidden" name="reviewable_id" value="{{ $establishment->id }}">

                                    <div class="mb-3">
                                        <label class="block text-sm font-medium mb-1">Rating *</label>
                                        <select name="rating" class="border rounded p-2" required>
                                            <option value="">Select rating</option>
                                            @for($i=1;$i<=5;$i++)
                                                <option value="{{ $i }}">{{ $i }} star{{ $i>1 ? 's' : '' }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="block text-sm font-medium mb-1">Review Title (optional)</label>
                                        <input type="text" name="title" class="w-full border rounded p-2" value="{{ old('title') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="block text-sm font-medium mb-1">Your Review</label>
                                        <textarea name="content" rows="3" class="w-full border rounded p-2">{{ old('content') }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="block text-sm font-medium mb-1">Upload Photos (optional)</label>
                                        <input type="file" name="images[]" multiple accept="image/*" class="w-full">
                                        <p class="text-xs text-gray-500 mt-1">You can select multiple images (JPEG, PNG, JPG, GIF up to 2MB each).</p>
                                    </div>

                                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Submit Review</button>
                                </form>
                            </div>
                        @else
                            <p class="mb-6 text-gray-500"><a href="{{ route('login') }}" class="text-indigo-600">Log in</a> to write a review.</p>
                        @endauth

                        <!-- List of reviews -->
                        @foreach($establishment->reviews()->with('user', 'images')->latest()->get() as $review)
                            <div class="border rounded-lg p-4 mb-4">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <div class="flex text-yellow-500">
                                                @for($i=1;$i<=5;$i++)
                                                    @if($i <= $review->rating) ★ @else ☆ @endif
                                                @endfor
                                            </div>
                                            @if($review->is_verified)
                                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">✓ Verified Traveler</span>
                                            @endif
                                            @if($review->user->hasVerifiedTravel() && !$review->is_verified)
                                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">Eligible for verification</span>
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
                                                    <img src="{{ asset('storage/' . $img->image_path) }}" class="w-16 h-16 object-cover rounded">
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    @if(auth()->check() && (auth()->id() === $review->user_id || auth()->user()->role === 'admin'))
                                        <div class="ml-4">
                                            <form action="{{ route('reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Delete this review?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 text-sm hover:underline">Delete</button>
                                            </form>
                                            @if(auth()->user()->role === 'admin' && !$review->is_verified)
                                                <form action="{{ route('reviews.verify', $review) }}" method="POST" class="mt-1">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-green-600 text-sm hover:underline">Verify</button>
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
                        <a href="{{ route('directory.index') }}" class="text-indigo-600 hover:text-indigo-900">
                            ← Back to Directory
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>