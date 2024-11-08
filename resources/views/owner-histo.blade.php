@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Owner's History</h1>

    <!-- Custom Tabs for Navigation -->
    <div class="tab-navigation">
        <button class="tab-button active" onclick="openTab(event, 'tenants')">Past Tenants</button>
        <button class="tab-button" onclick="openTab(event, 'bookings')">Bookings</button>
        <button class="tab-button" onclick="openTab(event, 'payments')">Payments</button>
    </div>

    <div class="tab-content">
        <!-- Past Tenants Tab -->
        <div id="tenants" class="tab-pane active">
            <h3>Past Tenants</h3>
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Tenant Name</th>
                        <th>Dorm Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pastTenants as $tenant)
                        <tr>
                            <td>{{ $tenant->user->name }}</td>
                            <td>{{ $tenant->dorm->name }}</td>
                            <td>{{ $tenant->start_date }}</td>
                            <td>{{ $tenant->end_date }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No past tenants found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Bookings Tab with Status Filter -->
        <div id="bookings" class="tab-pane">
            <h3>Bookings</h3>
            <!-- Booking Status Filter -->
            <label for="bookingFilter">Filter by Status:</label>
            <select id="bookingFilter" onchange="filterBookings()">
                <option value="all">All</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Canceled</option>
            </select>

            <table class="custom-table" id="bookingsTable">
                <thead>
                    <tr>
                        <th>Tenant Name</th>
                        <th>Dorm Name</th>
                        <th>Booking Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr class="booking-row" data-status="{{ $booking->status }}">
                            <td>{{ $booking->user->name }}</td>
                            <td>{{ $booking->dorm->name }}</td>
                            <td>{{ $booking->created_at->format('F d, Y') }}</td>
                            <td class="{{ 'status-' . $booking->status }}">
                                {{ ucfirst($booking->status) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div id="payments" class="tab-pane">
            <h3>Payments</h3>
            <!-- Month-Year Filter for Payments -->
            <label for="monthFilter">Select Month:</label>
            <input type="month" id="monthFilter" onchange="filterPaymentsByMonth()">

            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Tenant Name</th>
                        <th>Dorm Name</th>
                        <th>Amount</th>
                        <th>Billing Date</th>
                        <th>Paid Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="paymentsTable">
                    @forelse ($payments as $payment)
                        <tr class="payment-row" data-date="{{ \Carbon\Carbon::parse($payment->paid_at)->format('Y-m') }}"
                            data-status="{{ $payment->status }}">
                            <td>{{ $payment->rentForm->user->name }}</td>
                            <td>{{ $payment->rentForm->dorm->name }}</td>
                            <td>${{ number_format($payment->amount, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->billing_date)->format('F d, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->paid_at)->format('F d, Y') }}</td>
                            <td class="{{ $payment->status == 'paid' ? 'status-paid' : 'status-unpaid' }}">
                                {{ ucfirst($payment->status) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No payment history found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Custom CSS -->
<style>
    .tab-navigation {
        display: flex;
        margin-bottom: 20px;
    }

    .tab-button {
        background-color: #f1f1f1;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        font-size: 16px;
        margin-right: 5px;
        transition: background-color 0.3s ease;
    }

    .tab-button.active,
    .tab-button:hover {
        background: linear-gradient(to left, rgba(11, 136, 147, 0.712), rgba(54, 0, 51, 0.74));
        color: white;
        font-weight: bold;
    }

    .tab-pane {
        display: none;
    }

    .tab-pane.active {
        display: block;
        animation: fadeEffect 0.3s ease;
    }

    @keyframes fadeEffect {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th,
    th:last-child {
        background: none;
        color: black;
        border: none;
    }

    .custom-table td {
        padding: 10px;
        border: none;
        text-align: left;

    }

    .status-confirmed {
        color: green;
    }

    .status-pending {
        color: orange;
    }

    .status-paid {
        color: green;
    }

    .status-unpaid {
        color: red;
    }
</style>

<!-- Custom JavaScript -->
<script>
    function openTab(event, tabName) {
        const tabPanes = document.querySelectorAll(".tab-pane");
        const tabButtons = document.querySelectorAll(".tab-button");

        tabPanes.forEach(pane => pane.classList.remove("active"));
        tabButtons.forEach(button => button.classList.remove("active"));

        document.getElementById(tabName).classList.add("active");
        event.currentTarget.classList.add("active");
    }

    // Booking Filter Function
    function filterBookings() {
        const filter = document.getElementById("bookingFilter").value;
        const bookingRows = document.querySelectorAll(".booking-row");

        bookingRows.forEach(row => {
            row.style.display = (filter === "all" || row.dataset.status === filter) ? "" : "none";
        });
    }

    // Payment Filter by Selected Month
    function filterPaymentsByMonth() {
        const selectedMonth = document.getElementById("monthFilter").value;
        const paymentRows = document.querySelectorAll(".payment-row");

        paymentRows.forEach(row => {
            row.style.display = (row.getAttribute("data-date") === selectedMonth) ? "" : "none";
        });
    }

</script>
@endsection