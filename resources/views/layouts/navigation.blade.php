<nav class="topbar">
    <div class="brand">
        {{-- <span class="btn small">&gt;URL&lt;</span> --}}
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </div>

    <div class="nav-links">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout →</button>
        </form>
    </div>
</nav>
