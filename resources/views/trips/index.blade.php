<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Available Trips') }}
    </div>

    @if(session('success'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('success') }}
        </div>
    @endif

    @if($trips->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($trips as $trip)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    @if($trip->image)
                        <img src="{{ asset('storage/' . $trip->image) }}" alt="{{ $trip->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                            {{ __('No Image') }}
                        </div>
                    @endif
                    <div class="p-4">
                        <h3 class="font-semibold text-lg">{{ $trip->title }}</h3>
                        <p class="text-sm text-gray-600">{{ $trip->destination }}</p>
                        <p class="text-sm mt-2">{{ Str::limit($trip->description, 100) }}</p>
                        <div class="mt-3 flex justify-between items-center">
                            <span class="font-bold text-indigo-600">{{ number_format($trip->price, 2) }} TND</span>
                            <span class="text-sm text-gray-500">{{ $trip->date->format('d/m/Y') }}</span>
                        </div>
                        <div class="mt-2 text-sm text-gray-500">
                            {{ __('Departs') }}: {{ $trip->departure_time }} — {{ __('Returns') }}: {{ $trip->return_time }}
                        </div>
                        <div class="mt-2 text-sm">
                            {{ $trip->available_seats }} {{ __('seats available') }}
                        </div>
                        <div class="mt-2 text-xs text-gray-400">
                            {{ __('Posted by') }} {{ $trip->user->name ?? 'Unknown' }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $trips->links() }}
        </div>
    @else
        <p class="text-gray-500">{{ __('No trips found.') }}</p>
    @endif
</x-guest-layout>