<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Establishment (Hotel / Restaurant / Cafe)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.establishments.store') }}"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Name -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Establishment Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <x-input-label for="category" :value="__('Category')" />
                            <select name="category" id="category"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="hotel">Hotel</option>
                                <option value="resort">Resort</option>
                                <option value="hostel">Hostel</option>
                                <option value="guest_house">Guest House</option>
                                <option value="cafe">Café</option>
                                <option value="traditional_restaurant">Traditional Restaurant</option>
                                <option value="luxury_dining">Luxury Dining</option>
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea name="description" id="description" rows="5"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('description') }}</textarea>
                            <p class="text-sm text-gray-500 mt-1">Detailed description of the place.</p>
                        </div>

                        <!-- Address, City, Region -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <x-input-label for="address" :value="__('Address (street)')" />
                                <x-text-input type="text" name="address" class="block mt-1 w-full"
                                    :value="old('address')" />
                            </div>
                            <div>
                                <x-input-label for="city" :value="__('City')" />
                                <x-text-input type="text" name="city" class="block mt-1 w-full" :value="old('city')" />
                            </div>
                            <div>
                                <x-input-label for="region" :value="__('Region / Governorate')" />
                                <x-text-input type="text" name="region" class="block mt-1 w-full"
                                    :value="old('region')" />
                            </div>
                        </div>

                        <!-- Latitude & Longitude (optional) -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="latitude" :value="__('Latitude')" />
                                <x-text-input type="text" name="latitude" class="block mt-1 w-full"
                                    :value="old('latitude')" step="any" />
                            </div>
                            <div>
                                <x-input-label for="longitude" :value="__('Longitude')" />
                                <x-text-input type="text" name="longitude" class="block mt-1 w-full"
                                    :value="old('longitude')" step="any" />
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-4">
                            <x-input-label for="price_range" :value="__('Price range (e.g., $$ (50-100 TND) or €€)')" />
                            <x-text-input type="text" name="price_range" class="block mt-1 w-full"
                                :value="old('price_range')" />
                        </div>

                        <!-- Amenities (multiple checkboxes) -->
                        <div class="mb-4">
                            <x-input-label :value="__('Amenities (select all that apply)')" />
                            <div class="mt-2 grid grid-cols-2 md:grid-cols-3 gap-2">
                                @php
                                    $amenitiesList = ['wifi', 'parking', 'air conditioning', 'restaurant', 'pool', 'spa', 'gym', 'pet friendly', 'family friendly', 'wheelchair accessible', 'breakfast included', 'room service', 'bar', 'beachfront', 'free cancellation'];
                                @endphp
                                @foreach($amenitiesList as $amenity)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="amenities[]" value="{{ $amenity }}"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                            {{ in_array($amenity, old('amenities', [])) ? 'checked' : '' }}>
                                        <span class="ms-2 text-sm text-gray-600">{{ ucfirst($amenity) }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Contact Info -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <x-input-label for="contact_phone" :value="__('Phone Number')" />
                                <x-text-input type="text" name="contact_phone" class="block mt-1 w-full"
                                    :value="old('contact_phone')" />
                            </div>
                            <div>
                                <x-input-label for="contact_email" :value="__('Email Address')" />
                                <x-text-input type="email" name="contact_email" class="block mt-1 w-full"
                                    :value="old('contact_email')" />
                            </div>
                            <div>
                                <x-input-label for="website" :value="__('Website URL')" />
                                <x-text-input type="url" name="website" class="block mt-1 w-full"
                                    :value="old('website')" placeholder="https://..." />
                            </div>
                        </div>

                        <!-- Map URL (Google Maps embed) -->
                        <div class="mb-4">
                            <x-input-label for="map_url" :value="__('Google Maps Embed URL (iframe src)')" />
                            <x-text-input type="url" name="map_url" class="block mt-1 w-full" :value="old('map_url')"
                                placeholder="https://www.google.com/maps/embed?pb=..." />
                            <p class="text-sm text-gray-500 mt-1">From Google Maps: Share → Embed a map → Copy the src
                                URL.</p>
                        </div>

                        <!-- Photos (multiple) -->
                        <div class="mb-4">
                            <x-input-label for="photos" :value="__('Photos (multiple)')" />
                            <input type="file" name="photos[]" id="photos" multiple accept="image/*"
                                class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm" />
                            <p class="text-sm text-gray-500 mt-1">You can select multiple images. First image will be
                                the cover photo.</p>
                            <x-input-error :messages="$errors->get('photos.*')" class="mt-2" />
                        </div>

                        <!-- Rating (optional, admin can set initial rating) -->
                        <div class="mb-4">
                            <x-input-label for="rating" :value="__('Initial Rating (0-5, optional)')" />
                            <x-text-input type="number" step="0.1" min="0" max="5" name="rating"
                                class="block mt-1 w-full" :value="old('rating', 0)" />
                        </div>

                        <!-- Publish status -->
                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_published" value="1"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ms-2 text-sm text-gray-600">Publish immediately (visible to public)</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.establishments.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-400">Cancel</a>
                            <x-primary-button class="ms-3">Add Establishment</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>