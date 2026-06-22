<x-app-layout>
    <x-slot name="header">
        Create New Blog Post
    </x-slot>

    <div class="admin-form-container">
        <div class="admin-form-card">
            <form method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Title -->
                <div class="form-group">
                    <label for="title">Title <span class="required">*</span></label>
                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required
                        autofocus>
                    @error('title') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <!-- Excerpt -->
                <div class="form-group">
                    <label for="excerpt">Excerpt (short summary)</label>
                    <textarea id="excerpt" name="excerpt" rows="2" class="form-control"
                        placeholder="A short summary of the post (optional)">{{ old('excerpt') }}</textarea>
                    <p class="form-hint">Optional: A brief preview of the post (max 500 characters).</p>
                    @error('excerpt') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <!-- Content -->
                <div class="form-group">
                    <label for="content">Content <span class="required">*</span></label>
                    <textarea id="content" name="content" rows="12" class="form-control"
                        required>{{ old('content') }}</textarea>
                    <p class="form-hint">You can use HTML for formatting. Write your full blog post here.</p>
                    @error('content') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <!-- Featured Image -->
                <div class="form-group">
                    <label for="featured_image">Featured Image (optional)</label>
                    <input type="file" id="featured_image" name="featured_image" class="form-file">
                    <p class="form-hint">JPEG, PNG, JPG, GIF (max 2MB). Recommended size: 1200x800px.</p>
                    @error('featured_image') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <!-- Published Status -->
                <div class="form-group checkbox-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                        <span>Publish immediately</span>
                    </label>
                    <p class="form-hint">If unchecked, the post will be saved as a draft.</p>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('admin.blogs.index') }}" class="btn-outline">Cancel</a>
                    <button type="submit" class="btn-gold">Create Post</button>
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