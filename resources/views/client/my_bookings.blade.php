@extends('layouts.app')
@section('content')
<h1 style="margin-bottom:20px">My Bookings</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <table>
        <thead>
            <tr><th>Trainer</th><th>Date</th><th>Time</th><th>Status</th><th>Action</th></tr>
        </thead>
        <tbody>
        @forelse($bookings as $b)
            <tr>
                <td>{{ $b->schedule->trainer->user->name ?? '?' }}</td>
                <td>{{ $b->schedule->date ?? '—' }}</td>
                <td>{{ $b->schedule->start_time ?? '' }} – {{ $b->schedule->end_time ?? '' }}</td>
                <td>
                    <span class="badge {{ $b->status === 'booked' ? 'badge-success' : 'badge-danger' }}">
                        {{ ucfirst($b->status) }}
                    </span>
                </td>
                <td>
                    @if($b->status === 'booked')
                    <form action="{{ route('client.cancel', $b->id) }}" method="POST"
                          onsubmit="return confirm('Cancel this booking?')">
                        @csrf
                        <button type="submit" class="btn btn-danger">Cancel</button>
                    </form>
                    @else
                        <span style="color:#999;font-size:0.8rem">Cancelled</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="5" style="text-align:center;color:#999">No bookings yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection