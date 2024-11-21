@extends('layouts.app')

@section('title', 'My Rent Forms')

@section('content')

<style>
    /* General Page Styling */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f7f7f7;
        color: #333;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    h2 {
        text-align: center;
        font-size: 2rem;
        margin-bottom: 30px;
        color: #444;
    }

    /* Tabs Styling */
    .tabs {
        display: flex;
        justify-content: center;
        margin-bottom: 40px;
    }

    .tab {
        padding: 15px 30px;
        background-color: #fafafa;
        border-radius: 50px;
        margin: 0 10px;
        cursor: pointer;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease, transform 0.2s;
        font-weight: 500;
        color: #666;
    }

    .tab:hover {
        transform: translateY(-3px);
        background-color: #eaeaea;
    }

    .tab-active {
        background: linear-gradient(to left, rgba(11, 136, 147, 0.712), rgba(54, 0, 51, 0.74));
        color: white;
        transform: translateY(-5px);
    }

    /* Section Styling */
    .rent-section {
        display: none;
        animation: fadeIn 0.5s ease-in-out;
    }

    .rent-section-active {
        display: block;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    /* Rent Form Cards Styling */
    .rent-form-card {
        background-color: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .rent-form-card:hover {
        transform: translateY(-10px);
        box-shadow: 0px 15px 30px rgba(0, 0, 0, 0.2);
    }

    .rent-form-card h3 {
        font-size: 1.5rem;
        margin-bottom: 15px;
        color: #00b4d8;
    }

    .rent-form-card p {
        margin-bottom: 10px;
        color: #777;
    }

    /* Button Styling */
    .btn {
        padding: 12px 25px;
        border: none;
        border-radius: 30px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease, box-shadow 0.2s;
        width: 200px;
    }

    .cancel-button {
        background-color: #ff595e;
        color: white;
    }

    .cancel-button:hover {
        background-color: #d83f44;
        box-shadow: 0px 10px 20px rgba(255, 89, 94, 0.3);
    }

    .edit-button {
        background-color: #06d6a0;
        color: white;

    }

    .btn-div {
        display: flex;
        justify-content: space-evenly;

    }

    .edit-button:hover {
        background-color: #05ba89;
        box-shadow: 0px 10px 20px rgba(6, 214, 160, 0.3);
    }

    .disabled-button {
        background-color: #ccc;
        cursor: not-allowed;
        color: #666;
    }

    /* Rent History Section Styling */
    .rent-history {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    .expand-button {
        background-color: transparent;
        border: none;
        cursor: pointer;
        font-size: 16px;
        display: flex;
        align-items: center;
    }

    .expand-button .arrow {
        margin-left: 10px;
        transition: transform 0.3s ease;
    }

    .extra-details {
        margin-top: 10px;
        border-top: 1px solid #ccc;
        padding-top: 10px;
    }

    .extra-details p {
        margin: 5px 0;
    }

    .rotate {
        transform: rotate(180deg);
    }

    .cancel-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
    }

    /* Modal Content */
    .cancel-modal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 20px;
        /* box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3); */
        border-radius: 10px;
        z-index: 1001;
        max-width: 400px;
        width: 100%;
    }

    /* Modal Textarea */
    .cancel-modal textarea {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        /* border: 1px solid #ccc; */
    }

    .

    /* Modal Close Button */
    .close-buttoner {}

    /* Button Styles */


    .btn.submit-cancel-button {
        background-color: green;
        color: white;
        padding: 10px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        margin-top: 10px;
    }

    .rent-section {
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .billing-title {
        margin-bottom: 20px;
        font-size: 24px;
        color: #333;
    }

    .filter-label {
        display: block;
        margin-bottom: 5px;
    }

    .filter-input {
        margin-bottom: 10px;
        padding: 8px;
        width: calc(100% - 16px);
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .filter-button {
        padding: 8px 15px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .tabs {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .tab-button {
        padding: 10px 15px;
        margin-right: 5px;
        background-color: #e9ecef;
        border: 1px solid #ccc;
        border-radius: 4px;
        cursor: pointer;
    }

    .tab-button.active {
        background: linear-gradient(to left, rgba(11, 136, 147, 0.712), rgba(54, 0, 51, 0.74));
        color: white;
    }

    .tab-content {
        border: 1px solid #ccc;
        padding: 15px;
        border-radius: 4px;
        background-color: #fff;
    }

    .payment-container {
        display: flex;
        flex-wrap: wrap;
    }

    .payment-card {
        background-color: #f1f1f1;
        padding: 15px;
        margin: 10px;
        border-radius: 4px;
        width: calc(50% - 20px);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .due-date,
    .paid-date {
        color: #666;
        font-size: 14px;
    }

    .pagination-controls {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
    }

    .pagination-controls button {
        background-color: #007bff;
        /* Button color */
        color: #fff;
        padding: 8px 12px;
        border: none;
        border-radius: 5px;
        margin: 0 5px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s;
    }

    .pagination-button:hover {
        background-color: #0056b3;
        /* Hover color */
    }

    .pagination-controls button:disabled {
        background-color: #e0e0e0;
        /* Lighter grey for disabled state */
        color: #888;
        /* Grey text color */
        cursor: not-allowed;
        box-shadow: none;
        /* Remove shadow if any */
        pointer-events: none;
        opacity: 0.6;
    }

    /* Remove background color from table headers */
    .rent-history-table thead th {
        background-color: transparent;
        /* Remove the background color */
        border: none;
        color: black;
        /* Remove borders */
    }

    /* Remove borders from all table rows and cells */
    .rent-history-table td,
    .rent-history-table th,
    .rent-history-table tr {
        border: none;
        text-align: start;
        /* Remove borders */
    }

    /* Optional: Add some padding to make it look cleaner */
    .rent-history-table td,
    .rent-history-table th {
        padding: 10px;
        /* Adjust padding as needed */
    }

    .modal-contenter {
        border: none !important;
        padding: 10px !important;
        width: ;
    }
</style>
<br>
<div class="container">
    <h2>Booked Property</h2>

    <!-- Tabs -->
    <div class="tabs">
        <div class="tab tab-active" id="currentTab">Current Booked Accommodation</div>
        <div class="tab" id="historyTab">Booking History</div>
        <div class="tab" id="billingTab">Billing
            @if ($billingCount != 0)
                <span class="badge badge-danger">{{$billingCount}}</span>
            @endif

        </div>
    </div>

    <!-- Current Rented Property -->
    <div id="currentSection" class="rent-section rent-section-active">
        @if ($currentRent)
                <div class="rent-form-card">
                    <h3>{{ $currentRent->dorm->name }}</h3>
                    <p>Check in Date: {{ $currentRent->start_date->format('F j, Y') }}</p>
                    <p>Check out Date: {{ $currentRent->end_date->format('F j, Y') }}</p>
                    <p>Status: <strong>{{ ucfirst($currentRent->status) }}</strong></p>
                    @if ($currentRent->status == 'active')
                            @php
                                $date2 = \Carbon\Carbon::now();
                                $date1 = \Carbon\Carbon::parse($currentRent->end_date); // Parse created_at to a Carbon instance
                                $date3 = \Carbon\Carbon::parse('');

                                // Calculate the difference in hours
                                $remainingTimeInHours = $date2->diffInHours($date1, false);

                                if ($remainingTimeInHours < 24) {
                                    $remainingTime = intval($remainingTimeInHours) . ' hour' . (intval($remainingTimeInHours) > 1 ? 's' : '');
                                    if ($remainingTime <= 0) {
                                        $remainingTime = 'today';
                                    }
                                } else {
                                    $remainingTimeInDays = $date2->diffInDays($date1, false);
                                    $remainingTime = intval($remainingTimeInDays) . ' day' . (intval($remainingTimeInDays) > 1 ? 's' : '');
                                }
                            @endphp
                            <p>Days before check out: <strong>{{ $remainingTime}}</strong></p>
                    @endif

                    <!-- Expandable Section -->
                    <div class="expandable-section">
                        <button id="expandButton" class="expand-button">
                            <span>Details</span>
                            <span class="arrow">▼</span>
                        </button>
                        <div id="extraDetails" class="extra-details" style="display: none;">
                            @php
                                $date1 = date_create($currentRent->start_date);
                                $date2 = date_create($currentRent->end_date);
                                $diff = date_diff($date1, $date2);
                            @endphp
                            <p>Price per Day: ₱{{ $currentRent->dorm->price }}</p>
                            <p>Total days: {{ $diff->format("%a days") }}</p>


                            <p>Total Price: <strong>₱{{$currentRent->total_price }}</strong></p>
                        </div>
                    </div>

                    @if ($currentRent->status == 'pending')
                        <div class="btn-div">
                            @if(isset($currentRent) && isset($currentRent->id))
                                <button id="cancelButton" class="btn cancel-button">Cancel Booking</button>
                                <form id="editRentForm" action="{{ route('rentForm.edit') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="rent_id" value="{{ $currentRent->id }}">
                                </form>

                                <a href="javascript:void(0);" class="btn edit-button"
                                    onclick="document.getElementById('editRentForm').submit();">Edit</a>

                            @else
                                <p>No current rent information available.</p>
                            @endif
                        </div>
                    @elseif($currentRent->status == 'approved')
                            @php

                                $today = Carbon\Carbon::now();
                                $rentCreatedDate = $currentRent->created_at;
                                $daysDifference = $rentCreatedDate->diffInDays($today);

                            @endphp
                            @if ($daysDifference < 1)
                                <div class="btn-div">
                                    @if ($currentRent->note == '')
                                        <button id="cancelButton" class="btn cancel-button">Cancel Booking</button>
                                    @else
                                        <p><strong>You requested a Cancellation</strong></p>
                                    @endif

                                </div>
                            @endif


                    @endif
                </div>
                <div id="cancelReasonModal" class="cancel-modal">
                    <div class="modal-contenter">
                        <span class="close-buttoner"
                            style="position: relative;left: 340px;top: -15px;font-size: 25px;color: red;font-weight: bold; cursor: pointer;">&times;</span>
                        <h3>Why are you canceling this booking?</h3>
                        <form action="{{ route('rentForm.cancel', $currentRent->id) }}" method="POST">
                            @csrf

                            <!-- Predefined reasons as radio buttons -->
                            <div class="cancel-reasons">
                                <label>
                                    <input type="radio" name="cancelReason" value="Change of plans" required> Change of plans
                                </label><br>
                                <label>
                                    <input type="radio" name="cancelReason" value="Found a better place" required> Found a
                                    better place
                                </label><br>
                                <label>
                                    <input type="radio" name="cancelReason" value="Personal reasons" required> Personal reasons
                                </label><br>
                                <label>
                                    <input type="radio" name="cancelReason" value="Financial reasons" required> Financial
                                    reasons
                                </label><br>
                                <label>
                                    <input type="radio" name="cancelReason" value="Issue with booking process" required> Issue
                                    with booking process
                                </label><br>

                                <!-- Other reason with text input -->
                                <label>
                                    <input type="radio" id="otherReasonRadio" name="cancelReason" value="Other" required> Other
                                </label>
                                <br>
                                <textarea name="otherReasonText" id="otherReasonText" rows="3" style="display:none;"
                                    placeholder="Please provide more details..."></textarea>
                            </div>

                            <br>
                            <button type="submit" class="btn submit-cancel-button">Submit Cancellation</button>
                        </form>
                    </div>
                </div>


        @else
            <div style="text-align: center; margin: 20px; ">
                <img src="{{ asset('images/living-room.svg') }}" alt="No properties"
                    style="max-width: 400px; height: auto; margin-bottom: 10px;">
                <p>No active rented property at the moment.</p>
            </div>
        @endif
    </div>


    <!-- Overlay -->
    <div id="modalOverlay" class="cancel-modal-overlay"></div>
    <!-- Rent History -->
    <div id="historySection" class="rent-section">
        <div style="margin-bottom: 20px;">
            <label for="searchFilter">Search:</label>
            <input type="text" id="searchFilter" class="filter-input"
                placeholder="Search by accommodation name, status, etc." oninput="filterAndPaginate()">
        </div>
        <div style="margin-bottom: 20px;">
            <label for="statusFilter">Filter by Status:</label>
            <select id="statusFilter" class="filter-input" onchange="filterAndPaginate()">
                <option value="">All</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>

        @if ($rentHistory->isEmpty())
            <div style="text-align: center; margin: 20px;">
                <img src="{{ asset('images/house-searching-animate.svg') }}" alt="No properties"
                    style="max-width: 400px; height: auto; margin-bottom: 10px;">
                <p>No rent history available.</p>
            </div>
        @else
            <table class="rent-history-table">
                <thead>
                    <tr>
                        <th>Accommodation
                            Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Reason</th>
                    </tr>
                </thead>
                <tbody id="tableBody"></tbody>
            </table>

            <!-- Pagination Links -->
            <div class="pagination-controls">
                <button id="prevPageBtn" onclick="prevPage()">Previous</button>
                <span id="currentPage">1</span>
                <button id="nextPageBtn" onclick="nextPage()">Next</button>
            </div>
        @endif
    </div>


    <div id="billingSection" class="rent-section">
        <h3 class="billing-title">Billing Information</h3>
        <!-- Tabs for Payments -->
        <div class="tabs">
            <button class="tab-button active" data-tab="pending-payments">Pending Payments</button>
            <button class="tab-button" data-tab="paid-payments">Paid Payments</button>
        </div>

        <div class="tab-content">
            <!-- Pending Payments Tab -->
            <div class="tab-pane active" id="pending-payments">
                <h4>Pending Payments</h4>
                <div id="pendingPaymentsContent" class="payment-container">
                    @if ($pendingPayments && $pendingPayments->isEmpty())
                        <p>No pending payments for the selected month.</p>
                    @elseif($pendingPayments)
                        <table class="rent-history-table" id="pendingPaymentsTable">
                            <thead>
                                <tr>
                                    <th>Accommodation Name</th>
                                    <th>Amount</th>
                                    <th>Billing Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendingPayments as $payment)
                                    <tr>
                                        <td>{{ ucfirst($payment->rentForm->dorm->name) }}</td>
                                        <td>₱{{ $payment->amount }}</td>
                                        <td>{{ \Carbon\Carbon::parse($payment->billing_date)->format('M j, Y') }}</td>
                                        <td><strong>{{ ucfirst($payment->status) }}</strong></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    @endif
                </div>
            </div>

            <!-- Paid Payments Tab -->
            <div class="tab-pane" id="paid-payments">
                <h4>Paid Payments</h4>
                <div id="paidPaymentsContent" class="payment-container">
                    @if ($paidPayments && $paidPayments->isEmpty())
                        <p>No payments made for the selected month.</p>
                    @elseif($paidPayments)
                        <div id="paidPaymentsFilters" class="filters" style="width: 100%;">
                            <label for="monthFilterPaid" class="filter-label">Filter by Paid Month:</label>
                            <input type="month" id="monthFilterPaid" name="paid_month" class="filter-input">

                            <label for="searchFilterPaid" class="filter-label">Search:</label>
                            <input type="text" id="searchFilterPaid" placeholder="Search..." class="filter-input">
                        </div>
                        <table class="rent-history-table" id="paidPaymentsTable">
                            <thead>
                                <tr>
                                    <th>Accommodation Name</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Reference ID</th>
                                    <th>Mode</th>
                                    <th>Paid Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($paidPayments as $payment)
                                    <tr>
                                        <td>{{ ucfirst($payment->rentForm->dorm->name) }}</td>
                                        <td>₱{{ $payment->amount }}</td>
                                        <td><strong>{{ ucfirst($payment->status) }}</strong></td>
                                        <td><a target={{$payment->reference ? '_blank' : ''}}
                                                href="{{$payment->reference ? 'https://storage.googleapis.com/homeseek-profile-image/' . $payment->reference : ''}}">{{$payment->reference ? 'Image' : ''}}</a>
                                        </td>
                                        <td>{{ ucwords(str_replace('_', ' ', $payment->mode)) }}</td>

                                        <td>
                                            {{ \Carbon\Carbon::parse($payment->paid_at)->format('M j, Y') }}<br>
                                            <small>{{ \Carbon\Carbon::parse($payment->paid_at)->format('h:i A') }}</small>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                        <div style="display: flex;width: 100%;flex-direction: column;align-items: center;">
                            <div id="noResultsMessage" style="display: none;">No results found</div><br>

                            <div id="paidPagination" class="pagination-controls">
                                <button id="prevPaid" class="pagination-btn">Previous</button>
                                <span id="paidPageNumber">Page 1</span>
                                <button id="nextPaid" class="pagination-btn">Next</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>




</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

</script>
<script>

    document.addEventListener('DOMContentLoaded', function () {
        try {
            const cancelButton = document.getElementById('cancelButton');
            const cancelReasonModal = document.getElementById('cancelReasonModal');
            const modalOverlay = document.getElementById('modalOverlay');
            const closeButton = document.querySelector('.close-buttoner');

            // SweetAlert Confirmation for Cancel Booking
            cancelButton.addEventListener('click', function (e) {
                e.preventDefault(); // Prevent default form submission
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you really want to cancel your booking?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, cancel it!',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show the cancellation modal
                        cancelReasonModal.style.display = 'block';
                        modalOverlay.style.display = 'block';
                    }
                });
            });

            // Close the modal
            closeButton.addEventListener('click', function () {
                cancelReasonModal.style.display = 'none';
                modalOverlay.style.display = 'none';
            });

            // Close modal when clicking outside of it
            modalOverlay.addEventListener('click', function () {
                cancelReasonModal.style.display = 'none';
                modalOverlay.style.display = 'none';
            });

            // Toggle the expandable details section
        } catch (err) {

        }
    });

</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const currentTab = document.getElementById('currentTab');
        const historyTab = document.getElementById('historyTab');
        const currentSection = document.getElementById('currentSection');
        const historySection = document.getElementById('historySection');

        billingTab.addEventListener('click', function () {
            billingTab.classList.add('tab-active');
            currentTab.classList.remove('tab-active');
            historyTab.classList.remove('tab-active');
            billingSection.classList.add('rent-section-active');
            currentSection.classList.remove('rent-section-active');
            historySection.classList.remove('rent-section-active');
        });

        currentTab.addEventListener('click', function () {
            currentTab.classList.add('tab-active');
            billingTab.classList.remove('tab-active');
            historyTab.classList.remove('tab-active');
            currentSection.classList.add('rent-section-active');
            billingSection.classList.remove('rent-section-active');
            historySection.classList.remove('rent-section-active');
        });

        historyTab.addEventListener('click', function () {
            historyTab.classList.add('tab-active');
            billingTab.classList.remove('tab-active');
            currentTab.classList.remove('tab-active');
            historySection.classList.add('rent-section-active');
            currentSection.classList.remove('rent-section-active');
            billingSection.classList.remove('rent-section-active');
        });
    });
    const expandButton = document.getElementById('expandButton');
    const extraDetails = document.getElementById('extraDetails');
    const arrow = document.querySelector('.expand-button .arrow');

    try {
        expandButton.addEventListener('click', function () {
            if (extraDetails.style.display === 'none') {
                extraDetails.style.display = 'block';
                arrow.classList.add('rotate');
            } else {
                extraDetails.style.display = 'none';
                arrow.classList.remove('rotate');
            }
        });
    } catch (err) {

    }
    function showExtendAlert() {
        Swal.fire({
            title: 'Extend Request Already Submitted',
            text: 'You have already submitted an extend request. Please wait for the owner\'s approval.',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'OK',
            cancelButtonText: 'Edit Request',
        }).then((result) => {
            if (result.isConfirmed) {
                // User clicked OK, close the alert
                Swal.close();
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // User clicked 'Edit Request', redirect to edit page or logic
                window.location.href = '{{$extend != null ? route("extendEdit", [$extend->id]) : ''}}'; // Edit route if needed
            }
        });
    }


</script>
<script>


    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons
            document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));

            // Hide all tab panes
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.style.display = 'none';
            });

            // Add active class to clicked button
            button.classList.add('active');

            // Show the corresponding tab pane
            const tabToShow = button.getAttribute('data-tab');
            document.getElementById(tabToShow).style.display = 'block';
        });
    });

    // Initialize by showing only the active tab pane on page load
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelector('.tab-pane.active').style.display = 'block';
    });

    document.querySelectorAll('input[name="cancelReason"]').forEach(radio => {
        radio.addEventListener('change', function () {
            const otherReasonText = document.getElementById('otherReasonText');
            if (this.value === 'Other') {
                otherReasonText.style.display = 'block'; // Show the text area for "Other"
            } else {
                otherReasonText.style.display = 'none';  // Hide the text area for other reasons
            }
        });
    });

</script>
<script>
    const rentHistory = @json($rentHistory);

    let filteredRentHistory = [...rentHistory];
    const propertiesPerPage = 5;
    let currentPage = 1;

    function calculateTotalPages() {
        return Math.ceil(filteredRentHistory.length / propertiesPerPage);
    }

    function renderTable(page) {
        const totalPages = calculateTotalPages();
        const start = (page - 1) * propertiesPerPage;
        const end = start + propertiesPerPage;
        const itemsToDisplay = filteredRentHistory.slice(start, end);

        const tableBody = document.getElementById("tableBody");
        tableBody.innerHTML = itemsToDisplay.map(rent => {
            const statusText = rent.status.charAt(0).toUpperCase() + rent.status.slice(1);
            const reason = (rent.status === 'rejected' || rent.status === 'cancelled') ? rent.note : '-';

            return `
            <tr>
                <td>${rent.dorm.name}</td>
                <td>${new Date(rent.start_date).toLocaleDateString()}</td>
                <td>${new Date(rent.end_date).toLocaleDateString()}</td>
                <td><strong>${statusText}</strong></td>
                <td>${reason === null ? '' : reason}</td>
            </tr>
        `;
        }).join("");

        document.getElementById("currentPage").textContent = 'page ' + currentPage;
        updatePaginationButtons(totalPages);
    }

    function nextPage() {
        const totalPages = calculateTotalPages();
        if (currentPage < totalPages) {
            currentPage++;
            renderTable(currentPage);
        }
    }

    function prevPage() {
        if (currentPage > 1) {
            currentPage--;
            renderTable(currentPage);
        }
    }

    function updatePaginationButtons(totalPages) {
        document.getElementById("prevPageBtn").disabled = currentPage === 1;
        document.getElementById("nextPageBtn").disabled = currentPage === totalPages || totalPages === 0;
    }

    function filterAndPaginate() {
        const statusFilter = document.getElementById("statusFilter").value.toLowerCase();
        const searchQuery = document.getElementById("searchFilter").value.toLowerCase();

        // Filter rentHistory by status and search query
        filteredRentHistory = rentHistory.filter(rent => {
            const statusMatch = statusFilter === "" || rent.status.toLowerCase() === statusFilter;
            const searchMatch =
                rent.dorm.name.toLowerCase().includes(searchQuery) ||
                new Date(rent.start_date).toLocaleDateString().includes(searchQuery) ||
                new Date(rent.end_date).toLocaleDateString().includes(searchQuery) ||
                rent.status.toLowerCase().includes(searchQuery) ||
                (rent.note && rent.note.toLowerCase().includes(searchQuery));

            return statusMatch && searchMatch;
        });

        currentPage = 1; // Reset to first page after filtering
        renderTable(currentPage);
    }

    // Initialize table on page load
    document.addEventListener("DOMContentLoaded", () => {
        renderTable(currentPage);
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const rowsPerPage = 5; // Number of rows per page
        let paidPage = 1;

        // Capture the filter elements for Paid Payments
        const monthFilterPaid = document.getElementById('monthFilterPaid');
        const searchFilterPaid = document.getElementById('searchFilterPaid');
        const prevPaidButton = document.getElementById("prevPaid");
        const nextPaidButton = document.getElementById("nextPaid");
        const noResultsMessage = document.getElementById("noResultsMessage");

        // Function to filter Paid Payments
        function filterPaidPayments() {
            const month = monthFilterPaid.value;
            const searchTerm = searchFilterPaid.value.toLowerCase();

            const table = document.getElementById('paidPaymentsTable');
            const rows = Array.from(table.getElementsByTagName('tr')).slice(1); // Skip the header row

            const filteredRows = rows.filter(row => {
                const columns = row.getElementsByTagName('td');
                const accommodationName = columns[0].textContent.trim().toLowerCase();
                const referenceId = columns[3].textContent.trim().toLowerCase();
                const paymentDate = columns[5].textContent.trim();

                // Extract month and year from the payment date (e.g., "Nov 5, 2024")
                const paymentDateObj = new Date(paymentDate);
                const paymentMonth = paymentDateObj.getMonth(); // Get the month index (0-11)
                const paymentYear = paymentDateObj.getFullYear(); // Get the year (e.g., 2024)

                // Check if the month filter matches (if any)
                let matchesMonth = true;
                if (month) {
                    const [selectedYear, selectedMonth] = month.split('-'); // Split YYYY-MM
                    const selectedMonthIndex = parseInt(selectedMonth, 10) - 1; // Convert to month index (0-11)
                    matchesMonth = (paymentMonth === selectedMonthIndex && paymentYear === parseInt(selectedYear, 10));
                }

                // Check if the row matches the search term (accommodation name, reference ID, or any other column)
                const matchesSearchTerm = searchTerm
                    ? Array.from(columns).some(column => column.textContent.trim().toLowerCase().includes(searchTerm))
                    : true;

                return matchesMonth && matchesSearchTerm;
            });

            // Hide all rows and only show the filtered ones
            rows.forEach(row => row.style.display = 'none');
            filteredRows.forEach(row => row.style.display = '');

            // Handle "No results found" message
            if (noResultsMessage) {
                if (filteredRows.length === 0) {
                    // Show the "No results found" message
                    noResultsMessage.style.display = 'block';
                } else {
                    // Hide the "No results found" message
                    noResultsMessage.style.display = 'none';
                }
            }

            // Update pagination after filtering
            updatePagination(paidPage, filteredRows.length);
        }

        // Function to update pagination based on filtered data
        function updatePagination(page, totalFilteredRows) {
            const totalPages = Math.ceil(totalFilteredRows / rowsPerPage);

            // Disable pagination buttons if no results or at the start/end of pages
            prevPaidButton.disabled = page === 1 || totalFilteredRows === 0;
            nextPaidButton.disabled = page === totalPages || totalFilteredRows === 0;

            // Show the current page number
            const pageNumberSpan = document.getElementById("paidPageNumber");
            if (pageNumberSpan) {
                pageNumberSpan.textContent = `Page ${page}`;
            }

            // Paginate through visible rows
            paginateTable(page, totalFilteredRows, totalPages);
        }

        // Function to paginate the table
        function paginateTable(page, totalFilteredRows, totalPages) {
            const table = document.getElementById('paidPaymentsTable');
            const rows = Array.from(table.getElementsByTagName('tr')).slice(1); // Skip header row

            // Filtered rows (those that are displayed)
            const visibleRows = rows.filter(row => row.style.display !== 'none');
            const startIndex = (page - 1) * rowsPerPage;
            const endIndex = Math.min(startIndex + rowsPerPage, visibleRows.length);

            // Hide all rows first
            visibleRows.forEach(row => row.style.display = 'none');

            // Show only the rows for the current page
            for (let i = startIndex; i < endIndex; i++) {
                visibleRows[i].style.display = '';
            }
        }

        // Pagination controls for Paid Payments
        if (prevPaidButton && nextPaidButton) {
            prevPaidButton.addEventListener("click", function () {
                if (paidPage > 1) {
                    paidPage--;
                    filterPaidPayments(); // Reapply filter after pagination
                }
            });

            nextPaidButton.addEventListener("click", function () {
                paidPage++;
                filterPaidPayments(); // Reapply filter after pagination
            });
        }

        // Add event listeners for the filters
        if (monthFilterPaid && searchFilterPaid) {
            monthFilterPaid.addEventListener("change", filterPaidPayments);  // On month change
            searchFilterPaid.addEventListener("input", filterPaidPayments);  // On search input
        }

        // Initialize the table with pagination and filters
        try {
            filterPaidPayments(); // Apply initial filter
        } catch (error) {
            console.error(error); // Log any errors during initialization
        }
    });



</script>
@endsection