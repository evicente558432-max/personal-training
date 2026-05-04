@extends('layouts.app')
@section('content')
<h1 style="margin-bottom:20px">Manage Trainers</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <h2>Add New Trainer</h2>
    <form action="{{ route('admin.trainers.add') }}" method="POST">
        @csrf
        <div class="grid-2">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="Trainer name" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="trainer@email.com" required>
            </div>
            <div class="form-group">
                <label>Specialty</label>
                <input type="text" name="specialty" placeholder="e.g. Strength, Yoga">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Set password" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Add Trainer</button>
    </form>
</div>

<div class="card">
    <h2>Trainer List</h2>
    <table>
        <thead>
            <tr><th>#</th><th>Name</th><th>Email</th><th>Specialty</th><th>Action</th></tr>
        </thead>
        <tbody>
        @forelse($trainers as $i => $t)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $t->name }}</td>
                <td>{{ $t->email }}</td>
                <td>{{ $t->trainer->specialty ?? '—' }}</td>
                <td>
                    <form action="{{ route('admin.trainers.delete', $t->id) }}" method="POST"
                          onsubmit="return confirm('Delete this trainer?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" style="text-align:center;color:#999">No trainers yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection