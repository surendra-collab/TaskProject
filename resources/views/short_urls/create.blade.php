@extends('layout')

@section('content')
    <h1>Create Short URL</h1>

    <form method="POST" action="{{ route('short-urls.store') }}">
        @csrf
        <p>
            <label>Original URL</label><br>
            <input type="url" name="original_url" required value="{{ old('original_url') }}">
        </p>
        <button type="submit">Create</button>
    </form>
@endsection
