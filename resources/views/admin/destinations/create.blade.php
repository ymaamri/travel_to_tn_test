<x-app-layout>
    <x-slot name="header">
        Create New Destination
    </x-slot>

    <div class="admin-form-container">
        <div class="admin-form-card">
            <form method="POST" action="{{ route('admin.destinations.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Basic info -->
                <div class="form-group">
                    <label for="name">Destination Name <span class="required">*</span></label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" id="type" class="form-control">
                        <option value="city">City</option>
                        <option value="region">Region</option>
                        <option value="beach">Beach</option>
                        <option value="historical_place">Historical Place</option>
                        <option value="island">Island</option>
                        <option value="desert_area">Desert Area</option>
                        <option value="village">Village</option>
                    </select>
                    @error('type') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <!-- Overview -->
                <div class="form-group">
                    <label for="overview">Overview</label>
                    <textarea name="overview" id="overview" rows="4"
                        class="form-control">{{ old('overview') }}</textarea>
                    <p class="form-hint">A general introduction to the destination.</p>
                </div>

                <!-- History -->
                <div class="form-group">
                    <label for="history">History</label>
                    <textarea name="history" id="history" rows="4" class="form-control">{{ old('history') }}</textarea>
                </div>

                <!-- Things to do -->
                <div class="form-group">
                    <label for="things_to_do">Things to do</label>
                    <textarea name="things_to_do" id="things_to_do" rows="4"
                        class="form-control">{{ old('things_to_do') }}</textarea>
                </div>

                <!-- Best restaurants -->
                <div class="form-group">
                    <label for="best_restaurants">Best restaurants</label>
                    <textarea name="best_restaurants" id="best_restaurants" rows="3"
                        class="form-control">{{ old('best_restaurants') }}</textarea>
                </div>

                <!-- Hotels -->
                <div class="form-group">
                    <label for="hotels">Hotels & accommodation</label>
                    <textarea name="hotels" id="hotels" rows="3" class="form-control">{{ old('hotels') }}</textarea>
                </div>

                <!-- Weather -->
                <div class="form-group">
                    <label for="weather">Weather</label>
                    <input type="text" name="weather" id="weather" class="form-control" value="{{ old('weather') }}">
                </div>

                <!-- Transportation -->
                <div class="form-group">
                    <label for="transportation">Transportation</label>
                    <input type="text" name="transportation" id="transportation" class="form-control"
                        value="{{ old('transportation') }}">
                </div>

                <!-- Best season -->
                <div class="form-group">
                    <label for="best_season">Best season to visit</label>
                    <input type="text" name="best_season" id="best_season" class="form-control"
                        value="{{ old('best_season') }}">
                </div>

                <!-- Local foods -->
                <div class="form-group">
                    <label for="local_foods">Local foods</label>
                    <textarea name="local_foods" id="local_foods" rows="3"
                        class="form-control">{{ old('local_foods') }}</textarea>
                </div>

                <!-- Budget estimate -->
                <div class="form-group">
                    <label for="budget_estimate">Budget estimate (e.g., $50-100/day)</label>
                    <input type="text" name="budget_estimate" id="budget_estimate" class="form-control"
                        value="{{ old('budget_estimate') }}">
                </div>

                <!-- Safety info -->
                <div class="form-group">
                    <label for="safety_info">Safety information</label>
                    <textarea name="safety_info" id="safety_info" rows="3"
                        class="form-control">{{ old('safety_info') }}</textarea>
                </div>

                <!-- Map embed URL -->
                <div class="form-group">
                    <label for="map_url">Google Maps embed URL (iframe src)</label>
                    <input type="url" name="map_url" id="map_url" class="form-control" value="{{ old('map_url') }}"
                        placeholder="https://www.google.com/maps/embed?pb=...">
                    <p class="form-hint">Paste the full embed URL from Google Maps.</p>
                </div>

                <!-- Latitude/Longitude -->
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

                <!-- Photo gallery (multiple) -->
                <div class="form-group">
                    <label for="photo_gallery">Photo gallery (multiple images)</label>
                    <input type="file" name="photo_gallery[]" id="photo_gallery" multiple accept="image/*"
                        class="form-file">
                    <p class="form-hint">You can select multiple images. First image will be the cover. JPEG, PNG, JPG,
                        GIF (max 2MB each).</p>
                    @error('photo_gallery.*') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <!-- FAQs (dynamic) -->
                <div class="form-group">
                    <label>Frequently Asked Questions</label>
                    <div id="faqs-container">
                        <div class="faq-item">
                            <input type="text" name="faq_question[]" placeholder="Question" class="form-control mb-2">
                            <textarea name="faq_answer[]" placeholder="Answer" rows="2" class="form-control"></textarea>
                            <button type="button" class="remove-faq btn-link-danger">Remove</button>
                        </div>
                    </div>
                    <button type="button" id="add-faq" class="btn-add">+ Add another FAQ</button>
                </div>

                <!-- Nearby attractions -->
                <div class="form-group">
                    <label for="nearby_attractions">Nearby attractions</label>
                    <textarea name="nearby_attractions" id="nearby_attractions" rows="3"
                        class="form-control">{{ old('nearby_attractions') }}</textarea>
                </div>

                <!-- SEO meta -->
                <div class="form-group">
                    <label for="meta_title">Meta title (SEO)</label>
                    <input type="text" name="meta_title" id="meta_title" class="form-control"
                        value="{{ old('meta_title') }}">
                </div>
                <div class="form-group">
                    <label for="meta_description">Meta description (SEO)</label>
                    <textarea name="meta_description" id="meta_description" rows="2"
                        class="form-control">{{ old('meta_description') }}</textarea>
                </div>

                <!-- Publish status -->
                <div class="form-group checkbox-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                        <span>Publish immediately</span>
                    </label>
                    <p class="form-hint">If unchecked, the destination will be saved as a draft.</p>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('admin.destinations.index') }}" class="btn-outline">Cancel</a>
                    <button type="submit" class="btn-gold">Create Destination</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('add-faq').addEventListener('click', function () {
            let container = document.getElementById('faqs-container');
            let newItem = document.createElement('div');
            newItem.className = 'faq-item';
            newItem.innerHTML = `
                <input type="text" name="faq_question[]" placeholder="Question" class="form-control mb-2">
                <textarea name="faq_answer[]" placeholder="Answer" rows="2" class="form-control"></textarea>
                <button type="button" class="remove-faq btn-link-danger">Remove</button>
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

<style>
    .admin-form-container {
        max-width: 900px;
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

    .half {
        flex: 1;
        margin-bottom: 0;
    }

    .faq-item {
        background: var(--sand-light);
        padding: 1rem;
        border-radius: var(--radius-md);
        margin-bottom: 1rem;
        border: 1px solid var(--border-light);
    }

    .faq-item .form-control {
        margin-bottom: 0.8rem;
    }

    .btn-link-danger {
        background: none;
        border: none;
        color: var(--tunisia-red);
        font-size: 0.75rem;
        cursor: pointer;
        padding: 0;
        margin-top: 0.3rem;
    }

    .btn-add {
        background: none;
        border: none;
        color: var(--med-blue);
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        margin-top: 0.5rem;
    }

    .btn-add:hover {
        color: var(--tunisia-red);
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

        .form-row {
            flex-direction: column;
            gap: 1rem;
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