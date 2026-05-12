<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Activity') }}: {{ $activity->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.activities.update', $activity) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <!-- Title -->
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Activity Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                                :value="old('title', $activity->title)" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <x-input-label for="category" :value="__('Category')" />
                            <select name="category" id="category"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="beaches" {{ $activity->category == 'beaches' ? 'selected' : '' }}>Beaches
                                </option>
                                <option value="desert_tours" {{ $activity->category == 'desert_tours' ? 'selected' : '' }}>Desert Tours</option>
                                <option value="museums" {{ $activity->category == 'museums' ? 'selected' : '' }}>Museums
                                </option>
                                <option value="roman_ruins" {{ $activity->category == 'roman_ruins' ? 'selected' : '' }}>
                                    Roman Ruins</option>
                                <option value="hiking" {{ $activity->category == 'hiking' ? 'selected' : '' }}>Hiking
                                </option>
                                <option value="diving" {{ $activity->category == 'diving' ? 'selected' : '' }}>Diving
                                </option>
                                <option value="nightlife" {{ $activity->category == 'nightlife' ? 'selected' : '' }}>
                                    Nightlife</option>
                                <option value="shopping" {{ $activity->category == 'shopping' ? 'selected' : '' }}>
                                    Shopping</option>
                                <option value="traditional_markets" {{ $activity->category == 'traditional_markets' ? 'selected' : '' }}>Traditional Markets</option>
                                <option value="food_tours" {{ $activity->category == 'food_tours' ? 'selected' : '' }}>
                                    Food Tours</option>
                                <option value="festivals" {{ $activity->category == 'festivals' ? 'selected' : '' }}>
                                    Festivals</option>
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <!-- Price Range -->
                        <div class="mb-4">
                            <x-input-label for="price_range" :value="__('Price range')" />
                            <x-text-input type="text" name="price_range" class="block mt-1 w-full"
                                :value="old('price_range', $activity->price_range)" />
                        </div>

                        <!-- Duration -->
                        <div class="mb-4">
                            <x-input-label for="duration" :value="__('Duration')" />
                            <x-text-input type="text" name="duration" class="block mt-1 w-full" :value="old('duration', $activity->duration)" />
                        </div>

                        <!-- Difficulty -->
                        <div class="mb-4">
                            <x-input-label for="difficulty" :value="__('Difficulty')" />
                            <select name="difficulty" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Select</option>
                                <option value="Easy" {{ $activity->difficulty == 'Easy' ? 'selected' : '' }}>Easy</option>
                                <option value="Moderate" {{ $activity->difficulty == 'Moderate' ? 'selected' : '' }}>
                                    Moderate</option>
                                <option value="Hard" {{ $activity->difficulty == 'Hard' ? 'selected' : '' }}>Hard</option>
                            </select>
                        </div>

                        <!-- Location -->
                        <div class="mb-4">
                            <x-input-label for="location" :value="__('Location')" />
                            <x-text-input type="text" name="location" class="block mt-1 w-full" :value="old('location', $activity->location)" />
                        </div>

                        <!-- Existing photos display -->
                        @if($activity->photos && count($activity->photos) > 0)
                            <div class="mb-4">
                                <x-input-label :value="__('Current photos')" />
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @foreach($activity->photos as $photo)
                                        <div class="relative">
                                            <img src="{{ asset('storage/' . $photo) }}" class="w-20 h-20 object-cover rounded">
                                            <form method="POST" action="{{ route('admin.activities.remove-image', $activity) }}"
                                                class="absolute top-0 right-0">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="image" value="{{ $photo }}">
                                                <button type="submit"
                                                    class="bg-red-600 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center hover:bg-red-800">×</button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Add new photos -->
                        <div class="mb-4">
                            <x-input-label for="photos" :value="__('Add more photos')" />
                            <input type="file" name="photos[]" id="photos" multiple accept="image/*"
                                class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm" />
                            <p class="text-sm text-gray-500 mt-1">Select images to add to the gallery.</p>
                            <x-input-error :messages="$errors->get('photos.*')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea name="description" rows="6"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $activity->description) }}</textarea>
                        </div>

                        <!-- Booking Info -->
                        <div class="mb-4">
                            <x-input-label for="booking_info" :value="__('Booking / Contact information')" />
                            <textarea name="booking_info" rows="4"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('booking_info', $activity->booking_info) }}</textarea>
                        </div>

                        <!-- SEO Meta -->
                        <div class="mb-4">
                            <x-input-label for="meta_title" :value="__('Meta title (SEO)')" />
                            <x-text-input type="text" name="meta_title" class="block mt-1 w-full"
                                :value="old('meta_title', $activity->meta_title)" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="meta_description" :value="__('Meta description')" />
                            <textarea name="meta_description" rows="2"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('meta_description', $activity->meta_description) }}</textarea>
                        </div>

                        <!-- Publish status -->
                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_published" value="1"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ $activity->is_published ? 'checked' : '' }}>
                                <span class="ms-2 text-sm text-gray-600">Published</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.activities.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-400">Cancel</a>
                            <x-primary-button class="ms-3">Update Activity</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>