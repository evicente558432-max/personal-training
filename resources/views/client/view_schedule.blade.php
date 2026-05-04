@extends('layouts.app')
@section('content')
<h1 style="margin-bottom:20px">Available Sessions</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>
@endif

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(230px,1fr));gap:16px">
@forelse($schedules as $s)
    <div class="card" style="margin-bottom:0">
        <h2 style="font-size:1.1rem">{{ $s->trainer->user->name ?? '?' }}</h2>
        <p style="color:#888;font-size:0.85rem;margin:6px 0">
            🕐 {{ $s->start_time }} – {{ $s->end_time }}
        </p>
        <p style="color:#888;font-size:0.85rem;margin-bottom:6px">
            📅 {{ $s->date }}
        </p>
        @if($s->trainer->specialty)
            <p style="color:#888;font-size:0.85rem;margin-bottom:14px">
                🏋️ {{ $s->trainer->specialty }}
            </p>
        @endif
        <form action="{{ route('client.book', $s->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success" style="width:100%">Book Session</button>
        </form>
    </div>
@empty
    <p style="color:#999">No available sessions at the moment.</p>
@endforelse
</div>
@endsection