@extends('layouts.app')
@section('content')
<h1 style="margin-bottom:20px">Generate Reports</h1>

<div class="card">
    <h2>Filter</h2>
    <form action="{{ route('admin.reports') }}" method="GET">
        <div class="grid-2">
            <div class="form-group">
                <label>Report Type</label>
                <select name="type">
                    <option value="all">All Sessions</option>
                    <option value="bookings">Bookings Only</option>
                </select>
            </div>
            <div class="form-group"></div>
            <div class="form-group">
                <label>From Date</label>
                <input type="date" name="from" value="{{ request('from') }}">
            </div>
            <div class="form-group">
                <label>To Date</label>
                <input type="date" name="to" value="{{ request('to') }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Generate Report</button>
    </form>
</div>

@if(isset($schedules))
<div class="card">
    <h2>Results ({{ $schedules->count() }} records)</h2>
    <table>
        <thead>
            <tr><th>Trainer</th><th>Date</th><th>Time</th><th>Status</th><th>Client</th></tr>
        </thead>
        <tbody>
        @forelse($schedules as $s)
            <tr>
                <td>{{ $s->trainer->user->name ?? '?' }}</td>
                <td>{{ $s->date }}</td>
                <td>{{ $s->start_time }} – {{ $s->end_time }}</td>
                <td><span class="badge {{ $s->status === 'available' ? 'badge-success' : 'badge-warning' }}">{{ ucfirst($s->status) }}</span></td>
                <td>{{ $s->booking->user->name ?? '—' }}</td>
            </tr>
        @empty
            <tr><td colspan="5" style="text-align:center;color:#999">No records found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endif
@endsection