<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Training System</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f4f6f9; color: #333; }
        .navbar {
            background: #1e3a5f; color: #fff;
            display: flex; align-items: center; justify-content: space-between;
            padding: 14px 24px;
        }
        .navbar a { color: #fff; text-decoration: none; font-weight: bold; font-size: 1.2rem; }
        .navbar .nav-links a {
            color: #ccc; margin-left: 18px; font-size: 0.9rem; font-weight: normal;
        }
        .navbar .nav-links a:hover { color: #fff; }
        .container { max-width: 900px; margin: 30px auto; padding: 0 20px; }
        .card {
            background: #fff; border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 24px; margin-bottom: 20px;
        }
        .card h2 { margin-bottom: 16px; font-size: 1.1rem; color: #1e3a5f; }
        table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
        th { background: #1e3a5f; color: #fff; padding: 10px 12px; text-align: left; }
        td { padding: 10px 12px; border-bottom: 1px solid #eee; }
        tr:last-child td { border-bottom: none; }
        .btn {
            display: inline-block; padding: 8px 16px; border: none; border-radius: 6px;
            cursor: pointer; font-size: 0.85rem; font-weight: bold; text-decoration: none;
        }
        .btn-primary  { background: #1e3a5f; color: #fff; }
        .btn-success  { background: #28a745; color: #fff; }
        .btn-danger   { background: #dc3545; color: #fff; }
        .btn-warning  { background: #f5a623; color: #000; }
        .form-group { margin-bottom: 14px; }
        label { display: block; font-size: 0.82rem; font-weight: bold; margin-bottom: 4px; color: #555; }
        input, select {
            width: 100%; padding: 9px 12px; border: 1px solid #ccc;
            border-radius: 6px; font-size: 0.9rem;
        }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .alert { padding: 10px 14px; border-radius: 6px; margin-bottom: 16px; font-size: 0.9rem; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error   { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .stat-row { display: flex; gap: 16px; flex-wrap: wrap; margin-bottom: 20px; }
        .stat-box {
            flex: 1; min-width: 120px; background: #fff; border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 20px; text-align: center;
        }
        .stat-box .num { font-size: 2rem; font-weight: bold; color: #1e3a5f; }
        .stat-box .lbl { font-size: 0.78rem; color: #888; margin-top: 4px; }
        .badge {
            display: inline-block; padding: 3px 8px; border-radius: 12px;
            font-size: 0.75rem; font-weight: bold;
        }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-danger  { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
<nav class="navbar">
    <a href="#">⚡ Personal Training</a>
    @auth
    <div class="nav-links">
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.trainers') }}">Trainers</a>
            <a href="{{ route('admin.schedules') }}">Schedules</a>
            <a href="{{ route('admin.reports') }}">Reports</a>
        @elseif(auth()->user()->role === 'trainer')
            <a href="{{ route('trainer.dashboard') }}">Dashboard</a>
            <a href="{{ route('trainer.schedule') }}">Set Schedule</a>
        @else
            <a href="{{ route('client.dashboard') }}">Dashboard</a>
            <a href="{{ route('client.schedule') }}">Book Session</a>
            <a href="{{ route('client.bookings') }}">My Bookings</a>
        @endif
        <span style="color:#aaa;margin-left:18px">{{ auth()->user()->name }}</span>
        <form action="{{ route('logout') }}" method="POST" style="display:inline">
            @csrf
            <button type="submit" class="btn btn-danger" style="margin-left:12px;padding:5px 12px">Logout</button>
        </form>
    </div>
    @endauth
</nav>

<div class="container">
    @yield('content')
</div>
</body>
</html>