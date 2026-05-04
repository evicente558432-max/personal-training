@extends('layouts.app')
@section('content')
<h1 style="margin-bottom:20px">Admin Dashboard</h1>

<div class="stat-row">
    <div class="stat-box"><div class="num">{{ $totalTrainers }}</div><div class="lbl">Trainers</div></div>
    <div class="stat-box"><div class="num">{{ $totalClients }}</div><div class="lbl">Clients</div></div>
    <div class="stat-box"><div class="num">{{ $totalSessions }}</div><div class="lbl">Sessions</div></div>
    <div class="stat-box"><div class="num">{{ $totalBooked }}</div><div class="lbl">Booked</div></div>
</div>

<div class="card">
    <h2>Quick Links</h2>
    <a href="{{ route('admin.trainers') }}" class="btn btn-primary" style="margin-right:8px">Manage Trainers</a>
    <a href="{{ route('admin.schedules') }}" class="btn btn-warning" style="margin-right:8px">Manage Schedules</a>
    <a href="{{ route('admin.reports') }}" class="btn btn-success">Generate Reports</a>
</div>
@endsection