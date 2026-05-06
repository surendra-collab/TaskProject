@extends('layout')

@section('content')
    @php($user = auth()->user())
    @php($canCreateShortUrl = in_array($user->role, ['admin', 'member'], true))
    @php($roleLabel = str_replace('_', ' ', $user->role))

    <div class="panel">
        <div class="topbar">
            <div>
                <h1 class="title">{{ ucwords($roleLabel) }} Dashboard</h1>
                <div class="muted">Logged in as {{ $user->name }}</div>
            </div>
            <div class="nav-links">
                <a class="btn secondary" href="{{ route('dashboard') }}">Dashboard</a>
                <!-- <a class="btn secondary" href="{{ route('short-urls.index') }}">Short URLs</a> -->
                @if($user->role !== 'member')        
                    <a class="btn secondary" href="{{ route('invitations.index') }}">Invitations</a>
                @endif
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn">Logout</button>
                </form>
            </div>
        </div>
    </div>

    @if($user->role !== 'super_admin')        

        <div class="panel">
            <h3>Generate Short URL</h3>
            @if ($canCreateShortUrl)
                <form method="POST" action="{{ route('short-urls.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label>Original URL</label>
                            <input type="url" name="original_url" placeholder="https://example.com" required>
                        </div>
                        <div class="col" style="align-self: end;">
                            <button type="submit">Generate</button>
                        </div>
                    </div>
                </form>
            @else
                <p class="muted">You are not allowed to create short URLs for this role.</p>
                <button disabled>Generate</button>
            @endif
        </div>

        <div class="panel">
            <h3>Short URLs Created by You</h3>
            <table>
                <thead>
                <tr>
                    <th>Short URL</th>
                    <th>Original URL</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($shortUrls as $shortUrl)
                    <tr>
                        <td>{{ $shortUrl->code }}</td>
                        <td>{{ $shortUrl->original_url }}</td>
                        <td><a class="btn secondary" target="_blank" href="{{ route('short-urls.resolve', $shortUrl->code) }}">Open</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No short URLs created by you.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    @endif

    @if ($user->role === 'admin')
        <div class="panel">
            <div class="topbar">
                <h3>Team Members</h3>
                <a class="btn" href="{{ route('invitations.create') }}">Invite</a>
            </div>
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
                </thead>
                <tbody>
                @forelse($teamMembers as $member)
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

    @if ($user->role === 'super_admin')
        <div class="panel">
            <h3>Short URLs Created by Admin/Member</h3>
            <table>
                <thead>
                <tr>
                    <th>Short URL</th>
                    <th>Original URL</th>
                    <th>User</th>
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
                        <td>{{ $shortUrl->user->company?->name ?? 'N/A' }}</td>
                        <td><a class="btn secondary" target="_blank" href="{{ route('short-urls.resolve', $shortUrl->code) }}">Open</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No short URLs created by admin/member.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    @endif
@endsection
