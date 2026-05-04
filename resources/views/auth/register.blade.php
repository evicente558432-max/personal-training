@extends('layouts.app')
@section('content')
<div style="max-width:420px;margin:60px auto">
    <div class="card">
        <h2 style="text-align:center;margin-bottom:20px">Personal Training System<br><small>Register</small></h2>

        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $err)
                    <div>{{ $err }}</div>
                @endforeach
            </div>
        @endif

        <form action="/register" method="POST">
            @csrf
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="Your full name" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="you@email.com" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Create password" required>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="Repeat password" required>
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="role">
                    <option value="client">Client</option>
                    <option value="trainer">Trainer</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%">Create Account</button>
        </form>

        <p style="text-align:center;margin-top:14px;font-size:0.85rem">
            Already have an account? <a href="{{ route('login') }}">Log in</a>
        </p>
    </div>
</div>
@endsection