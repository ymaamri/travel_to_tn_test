<section>
    <header class="section-header">
        <h2>Profile Information</h2>
        <p>Update your account's profile information and email address.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="profile-form">
        @csrf
        @method('patch')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                required autofocus>
            @error('name') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}"
                required>
            @error('email') <span class="error-message">{{ $message }}</span> @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="verification-notice">
                    <p>Your email address is unverified.</p>
                    <button type="submit" form="send-verification" class="verification-link">Click here to re-send the
                        verification email.</button>
                    @if (session('status') === 'verification-link-sent')
                        <p class="verification-success">A new verification link has been sent to your email address.</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">Save</button>
            @if (session('status') === 'profile-updated')
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

    .verification-notice {
        background: var(--off-white);
        padding: 0.8rem;
        border-radius: 12px;
        margin-top: 0.5rem;
        font-size: 0.8rem;
    }

    .verification-link {
        background: none;
        border: none;
        color: var(--tunisia-red);
        font-weight: 500;
        cursor: pointer;
        text-decoration: underline;
        margin-top: 0.2rem;
    }

    .verification-success {
        color: #2E7D32;
        margin-top: 0.5rem;
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