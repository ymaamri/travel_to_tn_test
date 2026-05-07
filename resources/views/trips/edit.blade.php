<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Trip') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('trips.update', $trip) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <!-- Title -->
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                                :value="old('title', $trip->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Destination -->
                        <div class="mb-4">
                            <x-input-label for="destination" :value="__('Destination')" />
                            <x-text-input id="destination" class="block mt-1 w-full" type="text" name="destination"
                                :value="old('destination', $trip->destination)" required />
                            <x-input-error :messages="$errors->get('destination')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="4"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>{{ old('description', $trip->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Price -->
                        <div class="mb-4">
                            <x-input-label for="price" :value="__('Price (TND)')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01" name="price"
                                :value="old('price', $trip->price)" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <!-- Date -->
                        <div class="mb-4">
                            <x-input-label for="date" :value="__('Date')" />
                            <x-text-input id="date" class="block mt-1 w-full" type="date" name="date"
                                :value="old('date', $trip->date->format('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        <!-- Departure Time -->
                        <div class="mb-4">
                            <x-input-label for="departure_time" :value="__('Departure Time')" />
                            <x-text-input id="departure_time" class="block mt-1 w-full" type="time"
                                name="departure_time" :value="old('departure_time', $trip->departure_time)" required />
                            <x-input-error :messages="$errors->get('departure_time')" class="mt-2" />
                        </div>

                        <!-- Return Time -->
                        <div class="mb-4">
                            <x-input-label for="return_time" :value="__('Return Time')" />
                            <x-text-input id="return_time" class="block mt-1 w-full" type="time" name="return_time"
                                :value="old('return_time', $trip->return_time)" required />
                            <x-input-error :messages="$errors->get('return_time')" class="mt-2" />
                        </div>

                        <!-- Available Seats -->
                        <div class="mb-4">
                            <x-input-label for="available_seats" :value="__('Available Seats')" />
                            <x-text-input id="available_seats" class="block mt-1 w-full" type="number"
                                name="available_seats" :value="old('available_seats', $trip->available_seats)" required
                                min="1" />
                            <x-input-error :messages="$errors->get('available_seats')" class="mt-2" />
                        </div>

                        <!-- Image (optional) -->
                        <div class="mb-4">
                            <x-input-label for="image" :value="__('Image (optional)')" />
                            @if($trip->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $trip->image) }}"
                                        class="h-32 w-32 object-cover rounded">
                                </div>
                            @endif
                            <input type="file" id="image" name="image"
                                class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-secondary-button class="ms-3" onclick="location.href='{{ route('dashboard') }}'">
                                {{ __('Cancel') }}
                            </x-secondary-button>
                            <x-primary-button class="ms-3">
                                {{ __('Update Trip') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>