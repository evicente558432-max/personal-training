@extends('layouts.app')
@section('content')
<div style="max-width:420px;margin:60px auto">
    <div class="card">
        <h2 style="text-align:center;margin-bottom:20px">Personal Training System<br><small>Log In</small></h2>

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <form action="/login" method="POST">
            @csrf
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="your@email.com" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%">Log In</button>
        </form>

        <p style="text-align:center;margin-top:14px;font-size:0.85rem">
            No account? <a href="{{ route('register') }}">Register here</a>
        </p>
    </div>
</div>
@endsection