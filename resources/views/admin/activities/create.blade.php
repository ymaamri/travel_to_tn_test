<x-app-layout>
    <x-slot name="header">
        Create New Activity
    </x-slot>

    <div class="admin-form-container">
        <div class="admin-form-card">
            <form method="POST" action="{{ route('admin.activities.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Title -->
                <div class="form-group">
                    <label for="title">Activity Title <span class="required">*</span></label>
                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required>
                    @error('title') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <!-- Category -->
                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category" id="category" class="form-control">
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
                    @error('category') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <!-- Price Range -->
                <div class="form-group">
                    <label for="price_range">Price range (e.g., $$ (20-50 TND) )</label>
                    <input type="text" name="price_range" id="price_range" class="form-control"
                        value="{{ old('price_range') }}">
                </div>

                <!-- Duration -->
                <div class="form-group">
                    <label for="duration">Duration (e.g., 2-3 hours)</label>
                    <input type="text" name="duration" id="duration" class="form-control" value="{{ old('duration') }}">
                </div>

                <!-- Difficulty -->
                <div class="form-group">
                    <label for="difficulty">Difficulty</label>
                    <select name="difficulty" id="difficulty" class="form-control">
                        <option value="">Select</option>
                        <option value="Easy">Easy</option>
                        <option value="Moderate">Moderate</option>
                        <option value="Hard">Hard</option>
                    </select>
                </div>

                <!-- Location -->
                <div class="form-group">
                    <label for="location">Location (city/region)</label>
                    <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}">
                </div>

                <!-- Photos (multiple) -->
                <div class="form-group">
                    <label for="photos">Photos (multiple)</label>
                    <input type="file" name="photos[]" id="photos" multiple accept="image/*" class="form-file">
                    <p class="form-hint">You can select multiple images. First image will be the cover.</p>
                    @error('photos.*') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="6"
                        class="form-control">{{ old('description') }}</textarea>
                </div>

                <!-- Booking Info -->
                <div class="form-group">
                    <label for="booking_info">Booking / Contact information</label>
                    <textarea name="booking_info" id="booking_info" rows="4" class="form-control"
                        placeholder="Phone, email, website, booking link, etc.">{{ old('booking_info') }}</textarea>
                </div>

                <!-- SEO Meta -->
                <div class="form-group">
                    <label for="meta_title">Meta title (SEO)</label>
                    <input type="text" name="meta_title" id="meta_title" class="form-control"
                        value="{{ old('meta_title') }}">
                </div>
                <div class="form-group">
                    <label for="meta_description">Meta description</label>
                    <textarea name="meta_description" id="meta_description" rows="2"
                        class="form-control">{{ old('meta_description') }}</textarea>
                </div>

                <!-- Publish status -->
                <div class="form-group checkbox-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                        <span>Publish immediately</span>
                    </label>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('admin.activities.index') }}" class="btn-outline">Cancel</a>
                    <button type="submit" class="btn-gold">Create Activity</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<style>
    .admin-form-container {
        max-width: 800px;
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

    .checkbox-group {
        margin-top: 0.5rem;
    }

    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        font-weight: normal;
    }

    .checkbox-label input {
        width: auto;
        cursor: pointer;
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