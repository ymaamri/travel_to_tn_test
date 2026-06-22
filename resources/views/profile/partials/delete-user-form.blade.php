<section class="delete-section">
    <header class="section-header delete-header">
        <h2>Delete Account</h2>
        <p>Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your
            account, please download any data or information that you wish to retain.</p>
    </header>

    <div class="delete-actions">
        <button type="button" class="btn-danger" x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
            <i class="fas fa-trash-alt"></i> Delete Account
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="delete-modal-form">
            @csrf
            @method('delete')

            <div class="modal-header">
                <i class="fas fa-exclamation-triangle"></i>
                <h3>Are you sure you want to delete your account?</h3>
            </div>

            <p class="modal-description">Once your account is deleted, all of its resources and data will be permanently
                deleted. Please enter your password to confirm you would like to permanently delete your account.</p>

            <div class="modal-form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control"
                    placeholder="Enter your password" required>
                <x-input-error :messages="$errors->userDeletion->get('password')" class="error-message" />
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-secondary" x-on:click="$dispatch('close')">Cancel</button>
                <button type="submit" class="btn-danger">Delete Account</button>
            </div>
        </form>
    </x-modal>
</section>

<style>
    .delete-section {
        border-top: 1px solid var(--gray-300);
        padding-top: 0.5rem;
    }

    .delete-header h2 {
        color: var(--tunisia-red);
    }

    .delete-actions {
        margin-top: 1rem;
    }

    .btn-danger {
        background: var(--tunisia-red);
        color: white;
        border: none;
        padding: 0.7rem 1.5rem;
        border-radius: 40px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-danger:hover {
        background: var(--tunisia-red-dark);
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: var(--gray-300);
        color: var(--gray-800);
        border: none;
        padding: 0.6rem 1.3rem;
        border-radius: 40px;
        font-weight: 500;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-secondary:hover {
        background: var(--gray-400);
    }

    /* Modal styles (replacing x-modal default) */
    .delete-modal-form {
        padding: 1rem;
    }

    .modal-header {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        margin-bottom: 1rem;
    }

    .modal-header i {
        font-size: 1.8rem;
        color: var(--tunisia-red);
    }

    .modal-header h3 {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--med-blue);
        margin: 0;
    }

    .modal-description {
        font-size: 0.85rem;
        color: var(--gray-600);
        margin-bottom: 1.2rem;
        line-height: 1.5;
    }

    .modal-form-group {
        margin-bottom: 1.2rem;
    }

    .modal-form-group label {
        display: block;
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 0.3rem;
    }

    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 0.8rem;
        margin-top: 1.5rem;
    }
</style>