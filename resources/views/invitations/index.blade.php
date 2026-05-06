@extends('layout')

@section('content')
    <div class="panel">
        <div class="topbar">
            <h1 class="title">Invitations</h1>
            <div class="nav-links">
                <a class="btn" href="{{ route('invitations.create') }}">Create Invitation</a>
                <a class="btn secondary" href="{{ route('dashboard') }}">Dashboard</a>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Company</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invitations as $invitation)
                    <tr>
                        <td>{{ $invitation->name }}</td>
                        <td>{{ $invitation->email }}</td>
                        <td>{{ $invitation->role }}</td>
                        <td>{{ $invitation->company?->name ?? 'none' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4">No invitations yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
