<x-app-layout>
    <x-slot name="header">
        Profile Settings
    </x-slot>

    <div class="profile-container">
        <!-- Update Profile Information -->
        <div class="profile-card">
            <div class="card-header">
                <h3>Profile Information</h3>
                <p>Update your account's profile information and email address.</p>
            </div>

            <form method="POST" action="{{ route('profile.update') }}" class="profile-form">
                @csrf
                @method('patch')

                <!-- Name -->
                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required autofocus>
                    @error('name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror

                    @if (Auth::user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! Auth::user()->hasVerifiedEmail())
                        <div class="verification-notice">
                            <p>Your email address is unverified.</p>
                            <button form="send-verification" class="btn-outline-sm">Resend Verification Email</button>
                        </div>
                        @if (session('status') === 'verification-link-sent')
                            <p class="success-message">A new verification link has been sent to your email address.</p>
                        @endif
                    @endif
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-gold">Save</button>
                </div>
            </form>
        </div>

        <!-- Update Password -->
        <div class="profile-card">
            <div class="card-header">
                <h3>Update Password</h3>
                <p>Ensure your account is using a long, random password to stay secure.</p>
            </div>

            <form method="POST" action="{{ route('password.update') }}" class="profile-form">
                @csrf
                @method('put')

                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input id="current_password" type="password" name="current_password" required>
                    @error('current_password', 'updatePassword')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">New Password</label>
                    <input id="password" type="password" name="password" required>
                    @error('password', 'updatePassword')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required>
                    @error('password_confirmation', 'updatePassword')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-gold">Save</button>
                </div>
            </form>
        </div>

        <!-- Delete Account -->
        <div class="profile-card danger-zone">
            <div class="card-header">
                <h3>Delete Account</h3>
                <p>Once your account is deleted, all of its resources and data will be permanently deleted.</p>
            </div>

            <button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                class="btn-red-outline"
            >Delete Account</button>

            <!-- Modal (kept from Breeze, unchanged functionality) -->
            <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                    @csrf
                    @method('delete')

                    <h2 class="modal-title">Are you sure?</h2>
                    <p class="modal-description">Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.</p>

                    <div class="form-group">
                        <label for="password-delete">Password</label>
                        <input id="password-delete" type="password" name="password" placeholder="Password" required>
                        @error('password', 'userDeletion')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="modal-actions">
                        <button type="button" x-on:click="$dispatch('close-modal', 'confirm-user-deletion')" class="btn-outline">Cancel</button>
                        <button type="submit" class="btn-red">Delete Account</button>
                    </div>
                </form>
            </x-modal>
        </div>
    </div>
</x-app-layout>

<style>
    .profile-container {
        max-width: 700px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .profile-card {
        background: var(--white);
        border-radius: var(--radius-xl);
        padding: 2.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-lighter);
    }

    .card-header {
        margin-bottom: 2rem;
    }

    .card-header h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--med-blue);
        margin-bottom: 0.5rem;
    }

    .card-header p {
        color: var(--text-muted);
        font-size: 0.9rem;
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
    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-light);
        border-radius: var(--radius-sm);
        font-family: inherit;
        font-size: 0.9rem;
        transition: var(--transition);
        background: var(--sand-light);
    }

    input:focus {
        outline: none;
        border-color: var(--tunisia-gold);
        box-shadow: 0 0 0 3px rgba(212,175,55,0.15);
        background: white;
    }

    .error-message {
        color: var(--tunisia-red);
        font-size: 0.75rem;
        margin-top: 0.3rem;
    }

    .success-message {
        color: #2B5E22;
        font-size: 0.8rem;
        margin-top: 0.5rem;
    }

    .verification-notice {
        background: var(--sand-light);
        padding: 1rem;
        border-radius: var(--radius-sm);
        margin-top: 0.8rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .verification-notice p {
        font-size: 0.85rem;
        color: var(--text-secondary);
    }

    .btn-outline-sm {
        background: transparent;
        border: 1px solid var(--border-light);
        padding: 0.4rem 1rem;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.8rem;
        cursor: pointer;
        color: var(--text-primary);
        transition: all var(--transition);
    }

    .btn-outline-sm:hover {
        background: var(--sand-light);
        border-color: var(--tunisia-gold);
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 1rem;
    }

    .btn-gold {
        background: linear-gradient(135deg, var(--tunisia-gold) 0%, #E5B73B 100%);
        color: var(--charcoal);
        padding: 0.7rem 1.8rem;
        border-radius: 40px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
        transition: all var(--transition);
        box-shadow: 0 4px 12px rgba(212,175,55,0.25);
        letter-spacing: 0.3px;
    }

    .btn-gold:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(212,175,55,0.4);
    }

    .btn-outline {
        background: transparent;
        border: 1px solid var(--border-light);
        color: var(--text-primary);
        padding: 0.65rem 1.8rem;
        border-radius: 40px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all var(--transition);
    }

    .btn-outline:hover {
        background: var(--sand);
        border-color: var(--tunisia-gold);
    }

    .btn-red {
        background: var(--tunisia-red);
        color: white;
        padding: 0.7rem 1.8rem;
        border-radius: 40px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all var(--transition);
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(193,18,31,0.2);
    }

    .btn-red:hover {
        background: var(--tunisia-red-dark);
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(193,18,31,0.35);
    }

    .btn-red-outline {
        background: transparent;
        border: 1px solid var(--tunisia-red);
        color: var(--tunisia-red);
        padding: 0.65rem 1.8rem;
        border-radius: 40px;
        font-weight: 600;
        cursor: pointer;
        transition: all var(--transition);
    }

    .btn-red-outline:hover {
        background: var(--tunisia-red);
        color: white;
    }

    .danger-zone {
        border: 1px solid rgba(193,18,31,0.2);
    }

    /* Modal styles (for delete confirmation) */
    .modal-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--med-blue);
        margin-bottom: 1rem;
    }

    .modal-description {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }

    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    @media (max-width: 768px) {
        .profile-card {
            padding: 1.5rem;
        }
        .verification-notice {
            flex-direction: column;
        }
        .modal-actions {
            flex-direction: column;
        }
    }
</style>