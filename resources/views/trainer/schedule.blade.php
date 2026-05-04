@extends('layouts.app')
@section('content')
<h1 style="margin-bottom:20px">Set Schedule</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-error">
        @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
    </div>
@endif

<div class="card">
    <h2>Add Availability</h2>
    <form action="{{ route('trainer.schedule.save') }}" method="POST">
        @csrf
        <div class="grid-2">
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="date" required>
            </div>
            <div class="form-group">
                <label>Availability</label>
                <select name="status">
                    <option value="available">Available</option>
                    <option value="unavailable">Not Available</option>
                </select>
            </div>
            <div class="form-group">
                <label>Start Time</label>
                <input type="time" name="start_time" required>
            </div>
            <div class="form-group">
                <label>End Time</label>
                <input type="time" name="end_time" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save Schedule</button>
    </form>
</div>

<div class="card">
    <h2>My Schedules</h2>
    <table>
        <thead>
            <tr><th>Date</th><th>Time</th><th>Status</th><th>Booked By</th><th>Action</th></tr>
        </thead>
        <tbody>
        @forelse($schedules as $s)
            <tr>
                <td>{{ $s->date }}</td>
                <td>{{ $s->start_time }} – {{ $s->end_time }}</td>
                <td><span class="badge {{ $s->status === 'available' ? 'badge-success' : 'badge-warning' }}">{{ ucfirst($s->status) }}</span></td>
                <td>{{ $s->booking->user->name ?? '—' }}</td>
                <td>
                    @if($s->status === 'available')
                    <form action="{{ route('trainer.schedule.delete', $s->id) }}" method="POST"
                          onsubmit="return confirm('Delete this schedule?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    @else
                        <span style="color:#999;font-size:0.8rem">Booked</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="5" style="text-align:center;color:#999">No schedules yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection