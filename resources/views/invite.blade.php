<x-app-layout>
    <x-slot name="header">
        <h2 class="panel-title red">Invite New Team Member</h2>
    </x-slot>

    <div class="dashboard-grid">
        <div class="stack">
            <div class="panel">
                <div class="card-row">
                    <h3 class="panel-title blue">Send Invitation</h3>
                </div>

                @if(session('success'))
                    <p>{{ session('success') }}</p>
                @endif

                @if(session('invite_link'))
                    <p>
                        Invite Link:
                        <a href="{{ session('invite_link') }}" target="_blank">{{ session('invite_link') }}</a>
                    </p>
                @endif

                <form method="POST" action="{{ route('invite.store') }}" class="stack">
                    @csrf

                    @if(auth()->user()->role == 'SuperAdmin')
                        <div>
                            <label>Company Name</label>
                            <input type="text" name="company_name" placeholder="Company Name" required>
                        </div>
                    @endif

                    <div>
                        <label>Email</label>
                        <input type="email" name="email" placeholder="Email" required>
                    </div>

                    <div>
                        <label>Role</label>
                        @if(auth()->user()->role == 'SuperAdmin')
                            <select name="role" required>
                                <option value="Admin">Admin</option>
                            </select>
                        @else
                            <select name="role" required>
                                <option value="">Select Role</option>
                                <option value="Admin">Admin</option>
                                <option value="Member">Member</option>
                            </select>
                        @endif
                    </div>

                    <button type="submit" class="btn">Send Invitation</button>
                </form>
            </div>
        </div>

        <div class="stack">
            <div class="panel">
                <div class="card-row">
                    <h3 class="panel-title green">Invitations</h3>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invitations as $invite)
                            <tr>
                                <td>{{ $invite->email }}</td>
                                <td>{{ $invite->role }}</td>
                                <td>{{ $invite->status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No invitations found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
