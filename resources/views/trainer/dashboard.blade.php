@extends('layouts.app')
@section('content')
<h1 style="margin-bottom:20px">Trainer Dashboard</h1>

<div class="stat-row">
    <div class="stat-box"><div class="num">{{ $total }}</div><div class="lbl">My Sessions</div></div>
    <div class="stat-box"><div class="num">{{ $available }}</div><div class="lbl">Available</div></div>
    <div class="stat-box"><div class="num">{{ $booked }}</div><div class="lbl">Booked</div></div>
</div>

<div class="card">
    <h2>Welcome, {{ auth()->user()->name }}!</h2>
    <p style="color:#666">Use <strong>Set Schedule</strong> in the menu to add your availability.</p>
</div>
@endsection