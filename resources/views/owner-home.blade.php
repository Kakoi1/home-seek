@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    h1 {
        font-size: 2.5em;
        margin-bottom: 20px;
    }

    .dashboard {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-evenly;
        gap: 10px;
        padding: 10px;
        width: 90%;
        max-width: 1300px;
        margin: 0 auto;
    }

    .containers {
        height: 100%;
        padding: 15px;
    }

    .stat-box {
        background-color: #fff;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        width: 300px;
    }

    .stat-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .stat-box h2 {
        font-size: 3em;
        color: #3498db;
        margin-bottom: 10px;
    }

    .stat-box p {
        font-size: 1.2em;
        color: #7f8c8d;
    }

    .welcome-banner {
        background: linear-gradient(to right, rgb(11, 136, 147), rgb(54, 0, 51));
        color: white;
        padding: 40px;
        border-radius: 10px;
        margin-bottom: 30px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .welcome-banner h1 {
        margin-bottom: 15px;
        font-size: 2.5em;
    }

    .welcome-banner p {
        font-size: 1.2em;
        color: #ecf0f1;
    }

    /* Styling for stat-box1 */
    .stat-box1 {
        background-color: #fff;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        width: 80%;
        max-width: 1000px;
        margin: 0 auto;
        height: 100%;
    }

    /* Ensure canvas fills stat-box1 */
    .stat-box1 canvas {
        width: 100%;
        height: 100%;
    }
</style>

<br>
<div class="containers">
    <div class="welcome-banner">
        <h1>Welcome, {{ auth()->user()->name }}!</h1>
        <p>Here's an overview of your Accommodation statistics.</p>
    </div>

    <!-- Dashboard Stats -->
    <div class="dashboard">
        <div class="stat-box">
            <h2>{{ $totalProperties }}</h2>
            <p>Total Accommodations</p>
        </div>
        <div class="stat-box">
            <h2>{{ $totalTenants }}</h2>
            <p>Active Tenants</p>
        </div>
        <div class="stat-box">
            <h2>{{ $pendingRequests->count() ?? 0 }}</h2>
            <p>Pending Rent Requests</p>
        </div>
        <div class="stat-box">
            <h2>₱{{ number_format($monthlyEarnings, 2) }}</h2>
            <p>Monthly Earnings</p>
        </div>
    </div>

    <!-- Booking Rate Graph -->
    <div class="stat-box1">
        <h2>Booking Rate of Each Accommodation</h2>
        <canvas id="bookingRateChart"></canvas>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const bookingRates = @json($bookingRates); // Pass the booking rates and counts from PHP to JS

    const ctx = document.getElementById('bookingRateChart').getContext('2d');
    const bookingRateChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: bookingRates.map(rate => rate.dorm), // X-axis labels (Property Names)
            datasets: [{
                label: 'Booking Rate (%)',
                data: bookingRates.map(rate => rate.bookingRate), // Y-axis data (Booking Rate)
                backgroundColor: 'rgba(52, 152, 219, 0.5)', // Bar color
                borderColor: 'rgba(52, 152, 219, 1)', // Bar border color
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false // Hide the legend
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function (tooltipItem) {
                            const dataIndex = tooltipItem.dataIndex;
                            const bookingCount = bookingRates[dataIndex].bookingCount; // Get the booking count
                            const bookingRate = tooltipItem.raw.toFixed(2); // Get the booking rate
                            return `${bookingRate}% (Bookings: ${bookingCount})`; // Display booking rate and count
                        }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Accommodation Name'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Booking Rate (%)'
                    },
                    ticks: {
                        stepSize: 10,
                        max: 100,
                    }
                }
            }
        }
    });
</script>
@endsection