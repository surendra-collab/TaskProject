@extends('layout')

@section('content')
    <div class="panel">
        <div class="topbar">
            <h1 class="title">Generated Short URLs</h1>
            <a class="btn" href="{{ route('dashboard') }}">Back to Dashboard</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Original URL</th>
                    <th>Creator</th>
                    <th>Company</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($shortUrls as $shortUrl)
                    <tr>
                        <td>{{ $shortUrl->code }}</td>
                        <td>{{ $shortUrl->original_url }}</td>
                        <td>{{ $shortUrl->user->name }}</td>
                        <td>{{ $shortUrl->user->company?->name ?? 'none' }}</td>
                        <td><a class="btn secondary" href="{{ route('short-urls.resolve', $shortUrl->code) }}">Open</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5">No short URLs visible for your role.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
