<x-app-layout>
    <x-slot name="header">
        Add New Establishment (Hotel / Restaurant / Cafe)
    </x-slot>

    <div class="admin-form-container">
        <div class="admin-form-card">
            <form method="POST" action="{{ route('admin.establishments.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name">Establishment Name <span class="required">*</span></label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required
                        autofocus>
                    @error('name') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <!-- Category -->
                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category" id="category" class="form-control">
                        <option value="hotel">Hotel</option>
                        <option value="resort">Resort</option>
                        <option value="hostel">Hostel</option>
                        <option value="guest_house">Guest House</option>
                        <option value="cafe">Café</option>
                        <option value="traditional_restaurant">Traditional Restaurant</option>
                        <option value="luxury_dining">Luxury Dining</option>
                    </select>
                    @error('category') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="5"
                        class="form-control">{{ old('description') }}</textarea>
                    <p class="form-hint">Detailed description of the place.</p>
                </div>

                <!-- Address, City, Region (3 columns) -->
                <div class="form-row-3">
                    <div class="form-group">
                        <label for="address">Address (street)</label>
                        <input type="text" name="address" id="address" class="form-control"
                            value="{{ old('address') }}">
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" name="city" id="city" class="form-control" value="{{ old('city') }}">
                    </div>
                    <div class="form-group">
                        <label for="region">Region / Governorate</label>
                        <input type="text" name="region" id="region" class="form-control" value="{{ old('region') }}">
                    </div>
                </div>

                <!-- Latitude & Longitude (2 columns) -->
                <div class="form-row">
                    <div class="form-group half">
                        <label for="latitude">Latitude</label>
                        <input type="text" name="latitude" id="latitude" class="form-control"
                            value="{{ old('latitude') }}" step="any">
                    </div>
                    <div class="form-group half">
                        <label for="longitude">Longitude</label>
                        <input type="text" name="longitude" id="longitude" class="form-control"
                            value="{{ old('longitude') }}" step="any">
                    </div>
                </div>

                <!-- Price Range -->
                <div class="form-group">
                    <label for="price_range">Price range (e.g., $$ (50-100 TND) or €€)</label>
                    <input type="text" name="price_range" id="price_range" class="form-control"
                        value="{{ old('price_range') }}">
                </div>

                <!-- Amenities (multiple checkboxes) -->
                <div class="form-group">
                    <label>Amenities (select all that apply)</label>
                    <div class="amenities-grid">
                        @php
                            $amenitiesList = ['wifi', 'parking', 'air conditioning', 'restaurant', 'pool', 'spa', 'gym', 'pet friendly', 'family friendly', 'wheelchair accessible', 'breakfast included', 'room service', 'bar', 'beachfront', 'free cancellation'];
                            $oldAmenities = old('amenities', []);
                        @endphp
                        @foreach($amenitiesList as $amenity)
                            <label class="checkbox-label">
                                <input type="checkbox" name="amenities[]" value="{{ $amenity }}" {{ in_array($amenity, $oldAmenities) ? 'checked' : '' }}>
                                <span>{{ ucfirst($amenity) }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Contact Info (3 columns) -->
                <div class="form-row-3">
                    <div class="form-group">
                        <label for="contact_phone">Phone Number</label>
                        <input type="text" name="contact_phone" id="contact_phone" class="form-control"
                            value="{{ old('contact_phone') }}">
                    </div>
                    <div class="form-group">
                        <label for="contact_email">Email Address</label>
                        <input type="email" name="contact_email" id="contact_email" class="form-control"
                            value="{{ old('contact_email') }}">
                    </div>
                    <div class="form-group">
                        <label for="website">Website URL</label>
                        <input type="url" name="website" id="website" class="form-control" value="{{ old('website') }}"
                            placeholder="https://...">
                    </div>
                </div>

                <!-- Map URL -->
                <div class="form-group">
                    <label for="map_url">Google Maps Embed URL (iframe src)</label>
                    <input type="url" name="map_url" id="map_url" class="form-control" value="{{ old('map_url') }}"
                        placeholder="https://www.google.com/maps/embed?pb=...">
                    <p class="form-hint">From Google Maps: Share → Embed a map → Copy the src URL.</p>
                </div>

                <!-- Photos (multiple) -->
                <div class="form-group">
                    <label for="photos">Photos (multiple)</label>
                    <input type="file" name="photos[]" id="photos" multiple accept="image/*" class="form-file">
                    <p class="form-hint">You can select multiple images. First image will be the cover photo. JPEG, PNG,
                        JPG, GIF (max 2MB each).</p>
                    @error('photos.*') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <!-- Initial Rating -->
                <div class="form-group">
                    <label for="rating">Initial Rating (0-5, optional)</label>
                    <input type="number" step="0.1" min="0" max="5" name="rating" id="rating" class="form-control"
                        value="{{ old('rating', 0) }}">
                </div>

                <!-- Publish status -->
                <div class="form-group checkbox-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                        <span>Publish immediately (visible to public)</span>
                    </label>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('admin.establishments.index') }}" class="btn-outline">Cancel</a>
                    <button type="submit" class="btn-gold">Add Establishment</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<style>
    .admin-form-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    .admin-form-card {
        background: var(--white);
        border-radius: var(--radius-xl);
        padding: 2.5rem;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-lighter);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
    }

    .required {
        color: var(--tunisia-red);
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-light);
        border-radius: var(--radius-sm);
        font-family: inherit;
        font-size: 0.9rem;
        transition: var(--transition);
        background: var(--sand-light);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--tunisia-gold);
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15);
        background: white;
    }

    textarea.form-control {
        resize: vertical;
    }

    .form-file {
        width: 100%;
        padding: 0.5rem 0;
        font-size: 0.9rem;
    }

    .form-hint {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 0.3rem;
    }

    .form-row {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .form-row-3 {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .half {
        flex: 1;
        margin-bottom: 0;
    }

    .form-row-3 .form-group {
        flex: 1;
        margin-bottom: 0;
    }

    .amenities-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 0.5rem;
        margin-top: 0.5rem;
        background: var(--sand-light);
        padding: 1rem;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-light);
    }

    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        font-size: 0.85rem;
    }

    .checkbox-label input {
        width: auto;
        cursor: pointer;
    }

    .checkbox-group {
        margin-top: 0.5rem;
    }

    .error-message {
        display: block;
        font-size: 0.75rem;
        color: var(--tunisia-red);
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
        .admin-form-card {
            padding: 1.5rem;
        }

        .form-row,
        .form-row-3 {
            flex-direction: column;
            gap: 1rem;
        }

        .form-row-3 .form-group {
            margin-bottom: 0;
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

        .amenities-grid {
            grid-template-columns: 1fr 1fr;
        }
    }
</style>