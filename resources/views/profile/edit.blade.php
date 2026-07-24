<x-app-layout>
    <x-slot name="header">
        <h2 class="panel-title blue">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="dashboard-grid">
        <div class="stack">
            <div class="profile-card">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="stack">
            <div class="profile-card">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
