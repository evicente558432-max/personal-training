@extends('layouts.app')
@section('content')
<h1 style="margin-bottom:20px">Manage Schedules</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <h2>All Sessions</h2>
    <table>
        <thead>
            <tr><th>Trainer</th><th>Date</th><th>Time</th><th>Status</th><th>Client</th><th>Action</th></tr>
        </thead>
        <tbody>
        @forelse($schedules as $s)
            <tr>
                <td>{{ $s->trainer->user->name ?? '?' }}</td>
                <td>{{ $s->date }}</td>
                <td>{{ $s->start_time }} – {{ $s->end_time }}</td>
                <td>
                    <span class="badge {{ $s->status === 'available' ? 'badge-success' : 'badge-warning' }}">
                        {{ ucfirst($s->status) }}
                    </span>
                </td>
                <td>{{ $s->booking->user->name ?? '—' }}</td>
                <td>
                    <form action="{{ route('admin.schedules.delete', $s->id) }}" method="POST"
                          onsubmit="return confirm('Delete this schedule?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" style="text-align:center;color:#999">No schedules yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection