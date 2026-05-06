@extends('layout')

@section('content')
    <div class="panel" style="max-width: 520px; margin: 56px auto;">
        <h1 class="title">Sembark URL Task</h1>
        <p class="muted">Login Screen</p>

        <form method="POST" action="{{ route('login.store') }}">
            @csrf
            <p>
                <label>Email</label><br>
                <input type="email" name="email" required value="{{ old('email') }}">
            </p>
            <p>
                <label>Password</label><br>
                <input type="password" name="password" required>
            </p>
            <button type="submit">Login</button>
        </form>
    </div>
@endsection
