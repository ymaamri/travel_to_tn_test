<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Destination') }}: {{ $destination->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.destinations.update', $destination) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <!-- Basic info -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Destination Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name', $destination->name)" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="type" :value="__('Type')" />
                            <select name="type" id="type"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="city" {{ $destination->type == 'city' ? 'selected' : '' }}>City</option>
                                <option value="region" {{ $destination->type == 'region' ? 'selected' : '' }}>Region
                                </option>
                                <option value="beach" {{ $destination->type == 'beach' ? 'selected' : '' }}>Beach</option>
                                <option value="historical_place" {{ $destination->type == 'historical_place' ? 'selected' : '' }}>Historical Place</option>
                                <option value="island" {{ $destination->type == 'island' ? 'selected' : '' }}>Island
                                </option>
                                <option value="desert_area" {{ $destination->type == 'desert_area' ? 'selected' : '' }}>
                                    Desert Area</option>
                                <option value="village" {{ $destination->type == 'village' ? 'selected' : '' }}>Village
                                </option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <!-- Overview -->
                        <div class="mb-4">
                            <x-input-label for="overview" :value="__('Overview')" />
                            <textarea name="overview" id="overview" rows="4"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('overview', $destination->overview) }}</textarea>
                        </div>

                        <!-- History -->
                        <div class="mb-4">
                            <x-input-label for="history" :value="__('History')" />
                            <textarea name="history" id="history" rows="4"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('history', $destination->history) }}</textarea>
                        </div>

                        <!-- Things to do -->
                        <div class="mb-4">
                            <x-input-label for="things_to_do" :value="__('Things to do')" />
                            <textarea name="things_to_do" id="things_to_do" rows="4"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('things_to_do', $destination->things_to_do) }}</textarea>
                        </div>

                        <!-- Best restaurants -->
                        <div class="mb-4">
                            <x-input-label for="best_restaurants" :value="__('Best restaurants')" />
                            <textarea name="best_restaurants" id="best_restaurants" rows="3"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('best_restaurants', $destination->best_restaurants) }}</textarea>
                        </div>

                        <!-- Hotels -->
                        <div class="mb-4">
                            <x-input-label for="hotels" :value="__('Hotels & accommodation')" />
                            <textarea name="hotels" id="hotels" rows="3"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('hotels', $destination->hotels) }}</textarea>
                        </div>

                        <!-- Weather -->
                        <div class="mb-4">
                            <x-input-label for="weather" :value="__('Weather')" />
                            <x-text-input type="text" name="weather" class="block mt-1 w-full" :value="old('weather', $destination->weather)" />
                        </div>

                        <!-- Transportation -->
                        <div class="mb-4">
                            <x-input-label for="transportation" :value="__('Transportation')" />
                            <x-text-input type="text" name="transportation" class="block mt-1 w-full"
                                :value="old('transportation', $destination->transportation)" />
                        </div>

                        <!-- Best season -->
                        <div class="mb-4">
                            <x-input-label for="best_season" :value="__('Best season to visit')" />
                            <x-text-input type="text" name="best_season" class="block mt-1 w-full"
                                :value="old('best_season', $destination->best_season)" />
                        </div>

                        <!-- Local foods -->
                        <div class="mb-4">
                            <x-input-label for="local_foods" :value="__('Local foods')" />
                            <textarea name="local_foods" id="local_foods" rows="3"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('local_foods', $destination->local_foods) }}</textarea>
                        </div>

                        <!-- Budget estimate -->
                        <div class="mb-4">
                            <x-input-label for="budget_estimate" :value="__('Budget estimate (e.g., $50-100/day)')" />
                            <x-text-input type="text" name="budget_estimate" class="block mt-1 w-full"
                                :value="old('budget_estimate', $destination->budget_estimate)" />
                        </div>

                        <!-- Safety info -->
                        <div class="mb-4">
                            <x-input-label for="safety_info" :value="__('Safety information')" />
                            <textarea name="safety_info" rows="3"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('safety_info', $destination->safety_info) }}</textarea>
                        </div>

                        <!-- Map embed URL -->
                        <div class="mb-4">
                            <x-input-label for="map_url" :value="__('Google Maps embed URL (iframe src)')" />
                            <x-text-input type="url" name="map_url" class="block mt-1 w-full" :value="old('map_url', $destination->map_url)" placeholder="https://www.google.com/maps/embed?pb=..." />
                        </div>

                        <!-- Latitude/Longitude -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="latitude" :value="__('Latitude')" />
                                <x-text-input type="text" name="latitude" class="block mt-1 w-full"
                                    :value="old('latitude', $destination->latitude)" step="any" />
                            </div>
                            <div>
                                <x-input-label for="longitude" :value="__('Longitude')" />
                                <x-text-input type="text" name="longitude" class="block mt-1 w-full"
                                    :value="old('longitude', $destination->longitude)" step="any" />
                            </div>
                        </div>

                        <!-- Existing gallery display -->
                        @if($destination->photo_gallery && count($destination->photo_gallery) > 0)
                            <div class="mb-4">
                                <x-input-label :value="__('Current gallery images')" />
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @foreach($destination->photo_gallery as $image)
                                        <div class="relative">
                                            <img src="{{ asset('storage/' . $image) }}" class="w-20 h-20 object-cover rounded">
                                            <form method="POST"
                                                action="{{ route('admin.destinations.remove-image', $destination) }}"
                                                class="absolute top-0 right-0">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="image" value="{{ $image }}">
                                                <button type="submit"
                                                    class="bg-red-600 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center hover:bg-red-800">×</button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Add new images -->
                        <div class="mb-4">
                            <x-input-label for="photo_gallery" :value="__('Add more images')" />
                            <input type="file" name="photo_gallery[]" id="photo_gallery" multiple accept="image/*"
                                class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm" />
                            <p class="text-sm text-gray-500 mt-1">Select images to add to the gallery.</p>
                            <x-input-error :messages="$errors->get('photo_gallery.*')" class="mt-2" />
                        </div>

                        <!-- FAQs (dynamic) -->
                        <div class="mb-4">
                            <x-input-label :value="__('Frequently Asked Questions')" />
                            <div id="faqs-container">
                                @if($destination->faqs && count($destination->faqs) > 0)
                                    @foreach($destination->faqs as $index => $faq)
                                        <div class="faq-item mb-3 p-3 border rounded">
                                            <input type="text" name="faq_question[]" value="{{ $faq['question'] }}"
                                                placeholder="Question"
                                                class="block w-full mb-2 border-gray-300 rounded-md shadow-sm" />
                                            <textarea name="faq_answer[]" placeholder="Answer" rows="2"
                                                class="block w-full border-gray-300 rounded-md shadow-sm">{{ $faq['answer'] }}</textarea>
                                            <button type="button" class="remove-faq text-red-600 text-sm mt-1">Remove</button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="faq-item mb-3 p-3 border rounded">
                                        <input type="text" name="faq_question[]" placeholder="Question"
                                            class="block w-full mb-2 border-gray-300 rounded-md shadow-sm" />
                                        <textarea name="faq_answer[]" placeholder="Answer" rows="2"
                                            class="block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                                        <button type="button" class="remove-faq text-red-600 text-sm mt-1">Remove</button>
                                    </div>
                                @endif
                            </div>
                            <button type="button" id="add-faq" class="text-indigo-600 text-sm mt-1">+ Add another
                                FAQ</button>
                        </div>

                        <!-- Nearby attractions -->
                        <div class="mb-4">
                            <x-input-label for="nearby_attractions" :value="__('Nearby attractions')" />
                            <textarea name="nearby_attractions" rows="3"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('nearby_attractions', $destination->nearby_attractions) }}</textarea>
                        </div>

                        <!-- SEO meta -->
                        <div class="mb-4">
                            <x-input-label for="meta_title" :value="__('Meta title (SEO)')" />
                            <x-text-input type="text" name="meta_title" class="block mt-1 w-full"
                                :value="old('meta_title', $destination->meta_title)" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="meta_description" :value="__('Meta description (SEO)')" />
                            <textarea name="meta_description" rows="2"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('meta_description', $destination->meta_description) }}</textarea>
                        </div>

                        <!-- Publish status -->
                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_published" value="1"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ $destination->is_published ? 'checked' : '' }}>
                                <span class="ms-2 text-sm text-gray-600">Published</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.destinations.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-400">Cancel</a>
                            <x-primary-button class="ms-3">Update Destination</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for dynamic FAQs -->
    <script>
        document.getElementById('add-faq').addEventListener('click', function () {
            let container = document.getElementById('faqs-container');
            let newItem = document.createElement('div');
            newItem.className = 'faq-item mb-3 p-3 border rounded';
            newItem.innerHTML = `
                <input type="text" name="faq_question[]" placeholder="Question" class="block w-full mb-2 border-gray-300 rounded-md shadow-sm" />
                <textarea name="faq_answer[]" placeholder="Answer" rows="2" class="block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                <button type="button" class="remove-faq text-red-600 text-sm mt-1">Remove</button>
            `;
            container.appendChild(newItem);
            attachRemoveEvents();
        });

        function attachRemoveEvents() {
            document.querySelectorAll('.remove-faq').forEach(btn => {
                btn.removeEventListener('click', removeFaq);
                btn.addEventListener('click', removeFaq);
            });
        }

        function removeFaq(e) {
            e.target.closest('.faq-item').remove();
        }

        attachRemoveEvents();
    </script>
</x-app-layout>