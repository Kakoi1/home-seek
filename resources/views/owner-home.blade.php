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

    .popup3 {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        visibility: hidden;
        /* Hidden by default */
        opacity: 0;
        /* Ensure it's invisible */
        transition: opacity 0.3s ease;
        /* Add transition for smooth appearance */
    }

    .popup3.show {
        visibility: visible;
        /* Make the popup visible */
        opacity: 1;
        /* Fade in the popup */
    }

    .popup3-content {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        height: 700px;
        width: 80%;
        max-width: 800px;
        overflow: auto;
    }

    .close3 {
        font-size: 24px;
        cursor: pointer;
        /* position: absolute;
        top: 80px;
        right: 10px; */
        float: right;
        color: red;
        font-weight: bolder;
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
        <div class="stat-box" onclick="showPopup('totalProperties')">
            <h2>{{ $totalProperties }}</h2>
            <p>Total Accommodations</p>
        </div>
        <div class="stat-box" onclick="showPopup('activeTenants')">
            <h2>{{ $tenants->count()}}</h2>
            <p>Active Tenants</p>
        </div>
        <div class="stat-box" onclick="showPopup('pendingRequests')">
            <h2>{{ $pendingRequests->count() ?? 0 }}</h2>
            <p>Pending Rent Requests</p>
        </div>
        <div class="stat-box" onclick="showPopup('monthlyEarnings')">
            <h2>₱{{ number_format($monthlyEarnings, 2) }}</h2>
            <p>Monthly Earnings</p>
        </div>
    </div>

    <!-- Booking Rate Graph -->
    <div class="stat-box1">
        <h2>Booking Rate of Each Accommodation</h2>
        <canvas id="bookingRateChart"></canvas>
        <p id="noDataMessage" style="display: none; text-align: center; color: #888;">No data found</p>
    </div>

</div>
<div id="popup3" class="popup3">
    <div class="popup3-content">
        <span onclick="closePopups()" class="close3">&times;</span>
        <h2 id="popup3-title"></h2>
        <table>
            <thead>
                <tr id="popup-table-headers"></tr>
            </thead>
            <tbody id="popup-table-body"></tbody>
        </table>
    </div>
</div>

@php

@endphp
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const bookingRates = @json($bookingRates);

    // Check if there's no data in the bookingRates array
    if (bookingRates.length === 0) {
        // Show the no data message and hide the canvas
        console.log('yawa');

        document.getElementById('bookingRateChart').style.display = 'none';
        document.getElementById('noDataMessage').style.display = 'block';
    } else {
        // Hide the "No data found" message and show the canvas
        document.getElementById('bookingRateChart').style.display = 'block';
        document.getElementById('noDataMessage').style.display = 'none';

        // Create the chart if there's data
        const ctx = document.getElementById('bookingRateChart').getContext('2d');
        const bookingRateChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: bookingRates.map(rate => rate.dorm),
                datasets: [{
                    label: 'Booking Rate (%)',
                    data: bookingRates.map(rate => rate.bookingRate),
                    backgroundColor: 'rgba(52, 152, 219, 0.5)',
                    borderColor: 'rgba(52, 152, 219, 1)',
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function (tooltipItem) {
                                const dataIndex = tooltipItem.dataIndex;
                                const bookingCount = bookingRates[dataIndex].bookingCount;
                                const bookingRate = tooltipItem.raw.toFixed(2);
                                return `${bookingRate}% (Bookings: ${bookingCount} Cancellation: ${bookingRates[dataIndex].cancellationCount})`;
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
    }


</script>
<script>
    const popupData = {
        totalProperties: {
            title: "Total Accommodations",
            headers: ["Property ID", "Accommodation Name", "Location"],
            rows: [
                @foreach($ownerDorms as $property)
                                                                                                                                                                                    {
                        Availability: "{{ $property->availability ? 'Occupied' : 'Available'}}",
                        Accommodation: "{{ $property->name }}",  // Accessing the 'name' property for each property
                        location: "{{ implode(', ', array_slice(explode(',', html_entity_decode($property->address)), 0, 4)) }}"  // Truncating the address in PHP
                    },
                @endforeach
            ]
        },

        activeTenants: {
            title: "Active Tenants",
            headers: ["Tenant Name", "Email", "Status"],
            rows: [
                @foreach($tenants as $tenant)
                                                                                                                                                                                            {
                        id: "{{ $tenant->tenant->name }}",
                        name: "{{ $tenant->tenant->email }}",
                        email: "{{ $tenant->status }}"
                    },
                @endforeach
            ]
        },
        pendingRequests: {
            title: "Pending Rent Requests",
            headers: ["Tenant Name", "Email", "Request Status"],
            rows: [
                @foreach($pendingRequests as $request)
                                                                                                                                                                                     {
                        tenant_id: "{{ $request->tenant->name}}",
                        tenant_name: "{{ $request->tenant->email }}",
                        status: "{{ $request->status }}"
                    },
                @endforeach
            ]
        },
        monthlyEarnings: {
            title: "Monthly Earnings",
            headers: ["Dorm ID", "Dorm Name", "Earnings"],
            rows: [
                @foreach($monthlyEarningsPerDorm as $dorm)
                                                                                                                                                                                        {
                        Accommodation: "{{ $dorm->name }}",
                        dorm_name: "{{  implode(', ', array_slice(explode(',', html_entity_decode($dorm->address)), 0, 4)) }}",
                        earnings: "₱{{ number_format($dorm->total_earnings, 2) }}"  // Assuming you have earnings in $dorm->earnings
                    },
                @endforeach
            ]
        }
    };
    // JavaScript function to show the popup with the corresponding data
    function showPopup(type) {
        const data = popupData[type];
        const popupTitle = document.getElementById('popup3-title');
        const headerRow = document.getElementById('popup-table-headers');
        const tableBody = document.getElementById('popup-table-body');

        // Clear previous table content
        headerRow.innerHTML = '';
        tableBody.innerHTML = '';

        // Check if the data exists for the given type
        if (!data) {
            // Set title and message for empty data
            popupTitle.innerText = "No Data Available";

            const noDataMessage = document.createElement('tr');
            const noDataCell = document.createElement('td');
            noDataCell.colSpan = 3; // Span across columns
            noDataCell.textContent = "No data to display for this category.";
            noDataCell.style.textAlign = "center"; // Center-align text
            noDataMessage.appendChild(noDataCell);
            tableBody.appendChild(noDataMessage);

        } else {
            // If data is available, populate title and table
            popupTitle.innerText = data.title;

            // Populate table headers dynamically
            data.headers.forEach(header => {
                const th = document.createElement('th');
                th.textContent = header;
                headerRow.appendChild(th);
            });

            // Populate table body rows dynamically
            data.rows.forEach(row => {
                const tr = document.createElement('tr');
                for (const key in row) {
                    const td = document.createElement('td');
                    td.textContent = row[key];
                    tr.appendChild(td);
                }
                tableBody.appendChild(tr);
            });
        }

        // Show the popup by adding the 'show' class
        document.getElementById('popup3').classList.add('show');
    }

    function closePopups() {
        document.getElementById('popup3').classList.remove('show');
    }




</script>
@endsection