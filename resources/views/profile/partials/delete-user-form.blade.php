<section class="profile-section">
    <header>
        <h2 class="panel-title red">
            {{ __('Delete Account') }}
        </h2>

        <p class="muted">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <details>
        <summary>Delete Account</summary>

        <form method="post" action="{{ route('profile.destroy') }}" class="form-stack">
            @csrf
            @method('delete')

            <h2 class="section-heading">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="muted">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="field">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" />
            </div>

            <div class="form-actions end">
                <x-danger-button>
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </details>
</section>
