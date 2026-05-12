<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Activity') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.activities.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Title -->
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Activity Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                                :value="old('title')" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <x-input-label for="category" :value="__('Category')" />
                            <select name="category" id="category"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="beaches">Beaches</option>
                                <option value="desert_tours">Desert Tours</option>
                                <option value="museums">Museums</option>
                                <option value="roman_ruins">Roman Ruins</option>
                                <option value="hiking">Hiking</option>
                                <option value="diving">Diving</option>
                                <option value="nightlife">Nightlife</option>
                                <option value="shopping">Shopping</option>
                                <option value="traditional_markets">Traditional Markets</option>
                                <option value="food_tours">Food Tours</option>
                                <option value="festivals">Festivals</option>
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <!-- Price Range -->
                        <div class="mb-4">
                            <x-input-label for="price_range" :value="__('Price range (e.g., $$ (20-50 TND) )')" />
                            <x-text-input type="text" name="price_range" class="block mt-1 w-full"
                                :value="old('price_range')" />
                        </div>

                        <!-- Duration -->
                        <div class="mb-4">
                            <x-input-label for="duration" :value="__('Duration (e.g., 2-3 hours)')" />
                            <x-text-input type="text" name="duration" class="block mt-1 w-full"
                                :value="old('duration')" />
                        </div>

                        <!-- Difficulty -->
                        <div class="mb-4">
                            <x-input-label for="difficulty" :value="__('Difficulty')" />
                            <select name="difficulty" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Select</option>
                                <option value="Easy">Easy</option>
                                <option value="Moderate">Moderate</option>
                                <option value="Hard">Hard</option>
                            </select>
                        </div>

                        <!-- Location -->
                        <div class="mb-4">
                            <x-input-label for="location" :value="__('Location (city/region)')" />
                            <x-text-input type="text" name="location" class="block mt-1 w-full"
                                :value="old('location')" />
                        </div>

                        <!-- Photos (multiple) -->
                        <div class="mb-4">
                            <x-input-label for="photos" :value="__('Photos (multiple)')" />
                            <input type="file" name="photos[]" id="photos" multiple accept="image/*"
                                class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm" />
                            <p class="text-sm text-gray-500 mt-1">You can select multiple images. First image will be
                                the cover.</p>
                            <x-input-error :messages="$errors->get('photos.*')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea name="description" rows="6"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('description') }}</textarea>
                        </div>

                        <!-- Booking Info -->
                        <div class="mb-4">
                            <x-input-label for="booking_info" :value="__('Booking / Contact information')" />
                            <textarea name="booking_info" rows="4"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                placeholder="Phone, email, website, booking link, etc.">{{ old('booking_info') }}</textarea>
                        </div>

                        <!-- SEO Meta -->
                        <div class="mb-4">
                            <x-input-label for="meta_title" :value="__('Meta title (SEO)')" />
                            <x-text-input type="text" name="meta_title" class="block mt-1 w-full"
                                :value="old('meta_title')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="meta_description" :value="__('Meta description')" />
                            <textarea name="meta_description" rows="2"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('meta_description') }}</textarea>
                        </div>

                        <!-- Publish status -->
                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_published" value="1"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ms-2 text-sm text-gray-600">Publish immediately</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.activities.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-400">Cancel</a>
                            <x-primary-button class="ms-3">Create Activity</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>