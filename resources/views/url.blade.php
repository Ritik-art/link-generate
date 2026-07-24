@extends('layouts.app')

@section('header')
    <h2 class="panel-title blue">Generated Short URL</h2>
@endsection

@section('content')
    <div class="dashboard-grid">
        <div class="stack">
            <div class="panel">
                <h3 class="panel-title blue">Generate Short URL</h3>

                @if($canCreate)
                    <form method="POST" action="{{ route('url.store') }}">
                        @csrf

                        <div>
                            <label for="original_url">Original URL</label>
                            <input
                                id="original_url"
                                type="url"
                                name="original_url"
                                value="{{ old('original_url') }}"
                                placeholder="https://example.com"
                                required
                            >

                            @error('original_url')
                                <p style="color: red; margin-top: 6px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="btn" style="margin-top: 16px;">Generate</button>
                    </form>
                @else
                    <p class="muted">SuperAdmin can only view short URLs.</p>
                @endif

                @if(session('success'))
                    <p>{{ session('success') }}</p>
                @endif

                @if(session('generated_url'))
                    <p>
                        Generated URL:
                        <a href="{{ session('generated_url') }}" target="_blank">{{ session('generated_url') }}</a>
                    </p>
                @endif

                @if(session('original_url'))
                    <p>Original URL: {{ session('original_url') }}</p>
                @endif

                <table class="table">
                    <thead>
                        <tr>
                            <th>Short URL</th>
                            <th>Long URL</th>
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
                                <td>{{ $url->created_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No short urls found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="stack">
            <div class="panel">
                <h3 class="panel-title orange">Quick Note</h3>
                <p class="muted">Click Generate to create a new short URL automatically.</p>
                <p class="muted">The short link will redirect to https://example.com.</p>
            </div>
        </div>
    </div>
@endsection
