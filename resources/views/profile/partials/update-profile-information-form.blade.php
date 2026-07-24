<section>
    <header>
        <h2 class="panel-title blue">
            {{ __('Profile Information') }}
        </h2>

        <p class="muted">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="form-stack">
        @csrf
        @method('patch')

        <div class="field">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div class="field">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="form-actions">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p class="status-message">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
