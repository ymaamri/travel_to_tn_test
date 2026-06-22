<x-app-layout>
    <x-slot name="header">
        Create a New Trip
    </x-slot>

    <div class="form-container">
        <div class="form-card">
            <form method="POST" action="{{ route('trips.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Title -->
                <div class="form-group">
                    <label for="title">Title *</label>
                    <input id="title" type="text" name="title" value="{{ old('title') }}" required autofocus>
                    @error('title')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Destination -->
                <div class="form-group">
                    <label for="destination">Destination *</label>
                    <input id="destination" type="text" name="destination" value="{{ old('destination') }}" required>
                    @error('destination')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div class="form-group">
                    <label for="price">Price (TND) *</label>
                    <input id="price" type="number" step="0.01" name="price" value="{{ old('price') }}" required>
                    @error('price')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date -->
                <div class="form-group">
                    <label for="date">Date *</label>
                    <input id="date" type="date" name="date" value="{{ old('date') }}" required>
                    @error('date')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Departure Time -->
                <div class="form-group">
                    <label for="departure_time">Departure Time *</label>
                    <input id="departure_time" type="time" name="departure_time" value="{{ old('departure_time') }}"
                        required>
                    @error('departure_time')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Return Time -->
                <div class="form-group">
                    <label for="return_time">Return Time *</label>
                    <input id="return_time" type="time" name="return_time" value="{{ old('return_time') }}" required>
                    @error('return_time')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Available Seats -->
                <div class="form-group">
                    <label for="available_seats">Available Seats *</label>
                    <input id="available_seats" type="number" name="available_seats"
                        value="{{ old('available_seats') }}" required min="1">
                    @error('available_seats')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div class="form-group">
                    <label for="image">Image (optional)</label>
                    <input type="file" id="image" name="image" accept="image/*">
                    @error('image')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('dashboard') }}" class="btn-outline">Cancel</a>
                    <button type="submit" class="btn-gold">Create Trip</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<style>
    .form-container {
        max-width: 700px;
        margin: 0 auto;
    }

    .form-card {
        background: var(--white);
        border-radius: var(--radius-xl);
        padding: 2.5rem;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-lighter);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    label {
        display: block;
        font-weight: 600;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
    }

    input[type="text"],
    input[type="number"],
    input[type="date"],
    input[type="time"],
    textarea,
    input[type="file"] {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-light);
        border-radius: var(--radius-sm);
        font-family: inherit;
        font-size: 0.9rem;
        transition: var(--transition);
        background: var(--sand-light);
    }

    input:focus,
    textarea:focus {
        outline: none;
        border-color: var(--tunisia-gold);
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15);
        background: white;
    }

    textarea {
        resize: vertical;
        min-height: 100px;
    }

    .error-message {
        color: var(--tunisia-red);
        font-size: 0.75rem;
        margin-top: 0.3rem;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border-lighter);
    }

    @media (max-width: 768px) {
        .form-card {
            padding: 1.5rem;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .form-actions .btn-outline,
        .form-actions .btn-gold {
            width: 100%;
            text-align: center;
            justify-content: center;
        }
    }
</style>