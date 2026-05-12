<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Establishment') }}: {{ $establishment->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.establishments.update', $establishment) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <!-- Name -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Establishment Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name', $establishment->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <x-input-label for="category" :value="__('Category')" />
                            <select name="category" id="category"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="hotel" {{ $establishment->category == 'hotel' ? 'selected' : '' }}>Hotel
                                </option>
                                <option value="resort" {{ $establishment->category == 'resort' ? 'selected' : '' }}>Resort
                                </option>
                                <option value="hostel" {{ $establishment->category == 'hostel' ? 'selected' : '' }}>Hostel
                                </option>
                                <option value="guest_house" {{ $establishment->category == 'guest_house' ? 'selected' : '' }}>Guest House</option>
                                <option value="cafe" {{ $establishment->category == 'cafe' ? 'selected' : '' }}>Café
                                </option>
                                <option value="traditional_restaurant" {{ $establishment->category == 'traditional_restaurant' ? 'selected' : '' }}>Traditional
                                    Restaurant</option>
                                <option value="luxury_dining" {{ $establishment->category == 'luxury_dining' ? 'selected' : '' }}>Luxury Dining</option>
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea name="description" id="description" rows="5"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $establishment->description) }}</textarea>
                        </div>

                        <!-- Address, City, Region -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <x-input-label for="address" :value="__('Address (street)')" />
                                <x-text-input type="text" name="address" class="block mt-1 w-full"
                                    :value="old('address', $establishment->address)" />
                            </div>
                            <div>
                                <x-input-label for="city" :value="__('City')" />
                                <x-text-input type="text" name="city" class="block mt-1 w-full" :value="old('city', $establishment->city)" />
                            </div>
                            <div>
                                <x-input-label for="region" :value="__('Region / Governorate')" />
                                <x-text-input type="text" name="region" class="block mt-1 w-full" :value="old('region', $establishment->region)" />
                            </div>
                        </div>

                        <!-- Latitude & Longitude -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="latitude" :value="__('Latitude')" />
                                <x-text-input type="text" name="latitude" class="block mt-1 w-full"
                                    :value="old('latitude', $establishment->latitude)" step="any" />
                            </div>
                            <div>
                                <x-input-label for="longitude" :value="__('Longitude')" />
                                <x-text-input type="text" name="longitude" class="block mt-1 w-full"
                                    :value="old('longitude', $establishment->longitude)" step="any" />
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-4">
                            <x-input-label for="price_range" :value="__('Price range')" />
                            <x-text-input type="text" name="price_range" class="block mt-1 w-full"
                                :value="old('price_range', $establishment->price_range)" />
                        </div>

                        <!-- Amenities (multiple checkboxes) -->
                        <div class="mb-4">
                            <x-input-label :value="__('Amenities (select all that apply)')" />
                            <div class="mt-2 grid grid-cols-2 md:grid-cols-3 gap-2">
                                @php
                                    $amenitiesList = ['wifi', 'parking', 'air conditioning', 'restaurant', 'pool', 'spa', 'gym', 'pet friendly', 'family friendly', 'wheelchair accessible', 'breakfast included', 'room service', 'bar', 'beachfront', 'free cancellation'];
                                    $currentAmenities = old('amenities', $establishment->amenities ?? []);
                                @endphp
                                @foreach($amenitiesList as $amenity)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="amenities[]" value="{{ $amenity }}"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                            {{ in_array($amenity, $currentAmenities) ? 'checked' : '' }}>
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
                                    :value="old('contact_phone', $establishment->contact_phone)" />
                            </div>
                            <div>
                                <x-input-label for="contact_email" :value="__('Email Address')" />
                                <x-text-input type="email" name="contact_email" class="block mt-1 w-full"
                                    :value="old('contact_email', $establishment->contact_email)" />
                            </div>
                            <div>
                                <x-input-label for="website" :value="__('Website URL')" />
                                <x-text-input type="url" name="website" class="block mt-1 w-full" :value="old('website', $establishment->website)" placeholder="https://..." />
                            </div>
                        </div>

                        <!-- Map URL -->
                        <div class="mb-4">
                            <x-input-label for="map_url" :value="__('Google Maps Embed URL (iframe src)')" />
                            <x-text-input type="url" name="map_url" class="block mt-1 w-full" :value="old('map_url', $establishment->map_url)" />
                        </div>

                        <!-- Existing photos display -->
                        @if($establishment->photos && count($establishment->photos) > 0)
                            <div class="mb-4">
                                <x-input-label :value="__('Current photos')" />
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @foreach($establishment->photos as $photo)
                                        <div class="relative">
                                            <img src="{{ asset('storage/' . $photo) }}" class="w-20 h-20 object-cover rounded">
                                            <form method="POST"
                                                action="{{ route('admin.establishments.remove-image', $establishment) }}"
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

                        <!-- Rating -->
                        <div class="mb-4">
                            <x-input-label for="rating" :value="__('Rating (0-5)')" />
                            <x-text-input type="number" step="0.1" min="0" max="5" name="rating"
                                class="block mt-1 w-full" :value="old('rating', $establishment->rating)" />
                        </div>

                        <!-- Publish status -->
                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_published" value="1"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ $establishment->is_published ? 'checked' : '' }}>
                                <span class="ms-2 text-sm text-gray-600">Published (visible to public)</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.establishments.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-400">Cancel</a>
                            <x-primary-button class="ms-3">Update Establishment</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>