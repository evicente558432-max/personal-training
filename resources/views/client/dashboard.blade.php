@extends('layouts.app')
@section('content')
<h1 style="margin-bottom:20px">Client Dashboard</h1>

<div class="stat-row">
    <div class="stat-box"><div class="num">{{ $openSlots }}</div><div class="lbl">Open Slots</div></div>
    <div class="stat-box"><div class="num">{{ $myBookings }}</div><div class="lbl">My Bookings</div></div>
</div>

<div class="card">
    <h2>Welcome, {{ auth()->user()->name }}!</h2>
    <p style="color:#666;margin-bottom:14px">Browse trainers and book your session today.</p>
    <a href="{{ route('client.schedule') }}" class="btn btn-success">Browse Sessions</a>
    <a href="{{ route('client.bookings') }}" class="btn btn-primary" style="margin-left:8px">My Bookings</a>
</div>
@endsection