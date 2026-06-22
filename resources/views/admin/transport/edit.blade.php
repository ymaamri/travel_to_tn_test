<x-app-layout>
    <x-slot name="header">
        Edit Transportation Guide: {{ $transportInfo->title }}
    </x-slot>

    <div class="admin-form-container">
        <div class="admin-form-card">
            <form method="POST" action="{{ route('admin.transport.update', $transportInfo) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- Title -->
                <div class="form-group">
                    <label for="title">Title (e.g., Airports in Tunisia, Taxis, Louage, etc.) <span
                            class="required">*</span></label>
                    <input type="text" id="title" name="title" class="form-control"
                        value="{{ old('title', $transportInfo->title) }}" required autofocus>
                    @error('title') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <!-- Content (HTML allowed) -->
                <div class="form-group">
                    <label for="content">Content (HTML allowed)</label>
                    <textarea id="content" name="content" rows="12"
                        class="form-control font-mono">{{ old('content', $transportInfo->content) }}</textarea>
                    <p class="form-hint">Tip: Use the Google Maps "Embed a map" iframe code for the map_url field below.
                    </p>
                    @error('content') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <!-- Current Featured Image -->
                @if($transportInfo->featured_image)
                    <div class="form-group">
                        <label>Current Featured Image</label>
                        <div class="current-image">
                            <img src="{{ asset('storage/' . $transportInfo->featured_image) }}" alt="Featured image">
                        </div>
                    </div>
                @endif

                <!-- New Featured Image -->
                <div class="form-group">
                    <label for="featured_image">Change Featured Image (optional)</label>
                    <input type="file" id="featured_image" name="featured_image" accept="image/*" class="form-file">
                    <p class="form-hint">JPEG, PNG, JPG, GIF (max 2MB). Leave empty to keep current.</p>
                    @error('featured_image') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <!-- Current Gallery Images -->
                @if($transportInfo->gallery && count($transportInfo->gallery) > 0)
                    <div class="form-group">
                        <label>Current Gallery Images</label>
                        <div class="photo-grid">
                            @foreach($transportInfo->gallery as $image)
                                <div class="photo-thumb">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Gallery image">
                                    <form method="POST" action="{{ route('admin.transport.remove-image', $transportInfo) }}"
                                        class="remove-form">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="image" value="{{ $image }}">
                                        <button type="submit" class="remove-btn"
                                            onclick="return confirm('Remove this image?')">×</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                        <p class="form-hint">Click × to remove an image. Images cannot be recovered.</p>
                    </div>
                @endif

                <!-- Add new gallery images -->
                <div class="form-group">
                    <label for="gallery">Add More Gallery Images</label>
                    <input type="file" id="gallery" name="gallery[]" multiple accept="image/*" class="form-file">
                    <p class="form-hint">Select multiple images to add to the gallery. JPEG, PNG, JPG, GIF (max 2MB
                        each).</p>
                    @error('gallery.*') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <!-- Map URL (Google Maps embed) -->
                <div class="form-group">
                    <label for="map_url">Google Maps Embed URL (optional)</label>
                    <input type="url" name="map_url" id="map_url" class="form-control"
                        value="{{ old('map_url', $transportInfo->map_url) }}"
                        placeholder="https://www.google.com/maps/embed?pb=...">
                    <p class="form-hint">From Google Maps: Share → Embed a map → Copy the src URL.</p>
                    @error('map_url') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <!-- Contact Info -->
                <div class="form-group">
                    <label for="contact_info">Contact Info (optional)</label>
                    <textarea name="contact_info" id="contact_info" rows="3" class="form-control"
                        placeholder="Phone: +216 XX XXX XXX&#10;Email: info@example.com&#10;Website: https://...">{{ old('contact_info', $transportInfo->contact_info) }}</textarea>
                    @error('contact_info') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <!-- Published Status -->
                <div class="form-group checkbox-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="is_published" value="1" {{ $transportInfo->is_published ? 'checked' : '' }}>
                        <span>Published (visible to public)</span>
                    </label>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('admin.transport.index') }}" class="btn-outline">Cancel</a>
                    <button type="submit" class="btn-gold">Update Guide</button>
                </div>
            </form>
        </div>
    </div>
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

    .font-mono {
        font-family: 'Courier New', monospace;
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

    .current-image {
        margin-top: 0.5rem;
    }

    .current-image img {
        max-width: 200px;
        max-height: 150px;
        object-fit: cover;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border-light);
    }

    .photo-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 0.8rem;
        margin-top: 0.5rem;
    }

    .photo-thumb {
        position: relative;
        width: 80px;
        height: 80px;
    }

    .photo-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border-light);
    }

    .remove-form {
        position: absolute;
        top: -6px;
        right: -6px;
    }

    .remove-btn {
        background: var(--tunisia-red);
        color: white;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 14px;
        line-height: 1;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
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

        .current-image img {
            max-width: 150px;
        }
    }
</style>