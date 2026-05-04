@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Dashboard</h1>

<!-- CARDS -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">

    <div class="bg-white p-5 rounded-xl shadow">
        <h2 class="text-gray-500">Total Sessions</h2>
        <p class="text-2xl font-bold">120</p>
    </div>

    <div class="bg-white p-5 rounded-xl shadow">
        <h2 class="text-gray-500">Completed</h2>
        <p class="text-2xl font-bold">95</p>
    </div>

    <div class="bg-white p-5 rounded-xl shadow">
        <h2 class="text-gray-500">Pending</h2>
        <p class="text-2xl font-bold">25</p>
    </div>

    <div class="bg-white p-5 rounded-xl shadow">
        <h2 class="text-gray-500">Active Clients</h2>
        <p class="text-2xl font-bold">18</p>
    </div>

</div>

<!-- CHARTS -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- Line Chart -->
    <div class="bg-white p-5 rounded-xl shadow">
        <h2 class="mb-4 font-semibold">Sessions Overview</h2>
        <canvas id="lineChart"></canvas>
    </div>

    <!-- Pie Chart -->
    <div class="bg-white p-5 rounded-xl shadow">
        <h2 class="mb-4 font-semibold">Booking Status</h2>
        <canvas id="pieChart"></canvas>
    </div>

</div>

<script>
    // LINE CHART
    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
            datasets: [{
                label: 'Sessions',
                data: [5, 10, 7, 12, 9],
                borderColor: '#22c55e',
                fill: true
            }]
        }
    });

    // PIE CHART
    new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: {
            labels: ['Completed', 'Pending'],
            datasets: [{
                data: [95, 25],
                backgroundColor: ['#22c55e', '#f59e0b']
            }]
        }
    });
</script>

@endsection