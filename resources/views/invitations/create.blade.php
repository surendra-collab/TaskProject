@extends('layout')

@section('content')
    <div class="panel">
        <div class="topbar">
            @if ( auth()->user()->role === 'super_admin')
                <h1 class="title">Invite Admin</h1>
            @else
                <h1 class="title">Invite Member</h1>
            @endif
            <a class="btn secondary" href="{{ route('dashboard') }}">Dashboard</a>
        </div>
        <form method="POST" action="{{ route('invitations.store') }}">
            @csrf
            <p>
                <label>Name</label><br>
                <input name="name" required value="{{ old('name') }}">
            </p>
            <p>
                <label>Email</label><br>
                <input type="email" name="email" required value="{{ old('email') }}">
            </p>

            @if ( auth()->user()->role === 'super_admin')
                <input type="hidden" name="role" value="admin">
            @elseif (auth()->user()->role === 'admin')
                <input type="hidden" name="role" value="member">
            @endif

            @if (auth()->user()->role === 'super_admin')
                <p>
                    <label>Company Name</label><br>
                    <input name="new_company_name" value="{{ old('new_company_name') }}">
                </p>
            @else
                <input type="hidden" name="company_id" value="{{ auth()->user()->company_id }}">
            @endif

            <button type="submit">Send Invitation</button>
        </form>
    </div>
@endsection
