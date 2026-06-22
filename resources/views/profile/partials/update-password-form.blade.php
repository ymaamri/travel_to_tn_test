<section>
    <header class="section-header">
        <h2>Update Password</h2>
        <p>Ensure your account is using a long, random password to stay secure.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="profile-form">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="update_password_current_password">Current Password</label>
            <input type="password" id="update_password_current_password" name="current_password" class="form-control"
                autocomplete="current-password">
            @error('current_password', 'updatePassword') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="update_password_password">New Password</label>
            <input type="password" id="update_password_password" name="password" class="form-control"
                autocomplete="new-password">
            @error('password', 'updatePassword') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="update_password_password_confirmation">Confirm Password</label>
            <input type="password" id="update_password_password_confirmation" name="password_confirmation"
                class="form-control" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword') <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">Save</button>
            @if (session('status') === 'password-updated')
                <span class="save-success">✓ Saved.</span>
            @endif
        </div>
    </form>
</section>

<style>
    .section-header {
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--gray-300);
    }

    .section-header h2 {
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--med-blue);
        margin-bottom: 0.3rem;
    }

    .section-header p {
        font-size: 0.85rem;
        color: var(--gray-600);
    }

    .profile-form {
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }

    .form-group label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--gray-800);
    }

    .form-control {
        padding: 0.7rem 1rem;
        border: 1px solid var(--gray-300);
        border-radius: 12px;
        font-family: inherit;
        font-size: 0.9rem;
        transition: 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--tunisia-red);
        box-shadow: 0 0 0 3px rgba(231, 0, 10, 0.1);
    }

    .error-message {
        font-size: 0.75rem;
        color: var(--tunisia-red);
    }

    .form-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 0.5rem;
    }

    .save-success {
        font-size: 0.85rem;
        color: #2E7D32;
        background: #E8F5E9;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
    }
</style>