<section>
    <details>
        <summary>Change Password</summary>

        <form method="post" action="{{ route('password.update') }}" style="margin-top: 15px;">
            @csrf
            @method('put')

            <div>
                <label for="password">New Password</label>
                <input id="password" name="password" type="password" autocomplete="new-password">
                @error('password', 'updatePassword')
                    <p style="color: red; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit">Save</button>

            @if(session('status') === 'password-updated')
                <p>Saved.</p>
            @endif
        </form>
    </details>
</section>
