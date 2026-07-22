<x-app-layout>
    @php
        $role = auth()->user()->role;
        $title = 'Client Member Dashboard';

        if ($role == 'SuperAdmin') {
            $title = 'Super Admin Dashboard';
        } elseif ($role == 'Admin') {
            $title = 'Client Admin Dashboard';
        }
    @endphp

    <x-slot name="header">
        <h2 class="panel-title {{ $role == 'SuperAdmin' ? 'red' : 'blue' }}">
            {{ $title }}
        </h2>
    </x-slot>

    @if($role == 'SuperAdmin')
        <div class="stats">
            <div class="stat">
                <div class="label">Clients</div>
                <div class="value">{{ $clients->count() }}</div>
            </div>
            <div class="stat">
                <div class="label">Short URLs</div>
                <div class="value">{{ $urls->count() }}</div>
            </div>
            <div class="stat">
                <div class="label">Role</div>
                <div class="value">SuperAdmin</div>
            </div>
        </div>
    @else
        <div class="stats">
            <div class="stat">
                <div class="label">Short URLs</div>
                <div class="value">{{ $urls->count() }}</div>
            </div>
            <div class="stat">
                <div class="label">Members</div>
                <div class="value">{{ $members->count() }}</div>
            </div>
            <div class="stat">
                <div class="label">Role</div>
                <div class="value">{{ $role }}</div>
            </div>
        </div>
    @endif

    <div class="dashboard-grid">
        <div class="stack">
            <div class="panel">
                <div class="card-row">
                    <h3 class="panel-title blue">Generated Short URLs</h3>
                    <a href="{{ route('url.create') }}" class="btn">Generate</a>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Short URL</th>
                            <th>Long URL</th>
                            @if($role == 'SuperAdmin')
                                <th>Company</th>
                            @elseif($role == 'Admin')
                                <th>Created By</th>
                            @endif
                            <th>Created On</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($urls as $url)
                            <tr>
                                <td>
                                    <a href="{{ url('/u/' . $url->short_code) }}" target="_blank">
                                        {{ url('/u/' . $url->short_code) }}
                                    </a>
                                </td>
                                <td>{{ $url->original_url }}</td>
                                @if($role == 'SuperAdmin')
                                    <td>{{ $url->company_name ?? '-' }}</td>
                                @elseif($role == 'Admin')
                                    <td>{{ $url->user_name ?? '-' }}</td>
                                @endif
                                <td>{{ $url->created_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $role == 'SuperAdmin' || $role == 'Admin' ? 4 : 3 }}">No short urls found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($role == 'SuperAdmin')
                <div class="panel">
                    <div class="card-row">
                        <h3 class="panel-title green">Clients</h3>
                        <a href="{{ route('invite.create') }}" class="btn">Invite</a>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Client Name</th>
                                <th>Users</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clients as $client)
                                <tr>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ $client->users_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">No clients found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @elseif($role == 'Admin')
                <div class="panel">
                    <div class="card-row">
                        <h3 class="panel-title green">Team Members</h3>
                        <a href="{{ route('invite.create') }}" class="btn">Invite</a>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($members as $member)
                                <tr>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->email }}</td>
                                    <td>{{ $member->role }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">No team members found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="stack">
            @if($role == 'SuperAdmin')
                <div class="panel">
                    <h3 class="panel-title orange">Invite New Client</h3>
                    <p class="muted">SuperAdmin can create a new company and send an Admin invitation.</p>
                    <p><a href="{{ route('invite.create') }}" class="btn">Open Invite</a></p>
                </div>
            @elseif($role == 'Admin')
                <div class="panel">
                    <h3 class="panel-title orange">Invite New Team Member</h3>
                    <p class="muted">Admin can invite another Admin or Member in the same company.</p>
                    <p><a href="{{ route('invite.create') }}" class="btn">Open Invite</a></p>
                </div>
            @else
                <div class="panel">
                    <h3 class="panel-title orange">Quick Action</h3>
                    <p class="muted">Member can create short URLs from the URL page.</p>
                    <p><a href="{{ route('url.create') }}" class="btn">Generate URL</a></p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
