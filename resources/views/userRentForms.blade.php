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
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        border-radius: 10px;
        z-index: 1001;
        max-width: 500px;
        width: 100%;
    }

    /* Modal Textarea */
    .cancel-modal textarea {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .

    /* Modal Close Button */
    .close-button {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 20px;
        cursor: pointer;
        color: #555;
    }

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
</style>
<br>
<div class="container">
    <h2>Booked Property</h2>

    <!-- Tabs -->
    <div class="tabs">
        <div class="tab tab-active" id="currentTab">Current Booked Property</div>
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
                @php
                    $today = \Carbon\Carbon::now();
                    $date1 = date_create($currentRent->created_at->format("F j, Y"));
                    $date2 = date_create($today->format("F j, Y"));
                    $remainingTime = date_diff($date1, $date2);
                @endphp
                <div class="rent-form-card">
                    <h3>{{ $currentRent->dorm->name }}</h3>
                    <p>Check in Date: {{ $currentRent->start_date->format('F j, Y') }}</p>
                    <p>Check out Date: {{ $currentRent->end_date->format('F j, Y') }}</p>
                    <p>Status: <strong>{{ ucfirst($currentRent->status) }}</strong></p>
                    @if ($currentRent->status == 'active')
                        <p>Days before check out: <strong>{{ $remainingTime->format("%a days")}}</strong></p>
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
                            <button id="cancelButton" class="btn cancel-button">Cancel Booking</button>
                            <a href="{{ route('rentForm.create', [$currentRent->dorm_id, $currentRent->id]) }}"
                                class="btn edit-button">Edit</a>
                        </div>
                    @elseif($currentRent->status == 'approved')
                        @if ($remainingTime->format("%a") <= 2)
                            <div class="btn-div">
                                @if ($currentRent->note == '')
                                    <button id="cancelButton" class="btn cancel-button">Cancel Booking</button>
                                @else
                                    <p><strong>You requested a Canellation</strong></p>
                                @endif

                            </div>
                        @endif


                    @endif
                </div>
                <div id="cancelReasonModal" class="cancel-modal">
                    <div class="modal-content">
                        <span class="close-button">&times;</span>
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
        @if ($rentHistory->isEmpty())
            <div style="text-align: center; margin: 20px; ">
                <img src="{{ asset('images/house-searching-animate.svg') }}" alt="No properties"
                    style="max-width: 400px; height: auto; margin-bottom: 10px;">
                <p>No rent history available.</p>
            </div>
        @else
            <div class="rent-history">
                @foreach ($rentHistory as $rent)
                    <div class="rent-form-card">
                        <h3>{{ $rent->dorm->name }}</h3>
                        <p>Start Date: {{ $rent->start_date->format('F j, Y') }}</p>
                        <p>End Date: {{ $rent->end_date->format('F j, Y') }}</p>
                        <p>Status: <strong>{{ ucfirst($rent->status) }}</strong></p>
                        @if ($rent->status == 'rejected' || $rent->status == 'cancelled')
                            <p>Reason: <strong>{{$rent->note}}</strong></p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <div id="billingSection" class="rent-section">
        <h3 class="billing-title">Billing Information</h3>

        <!-- Date Filter -->
        <label for="month" class="filter-label">Filter by Month:</label>
        <input type="month" id="monthFilter" name="month" value="{{ request('month') }}" class="filter-input">

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
                    @if ($pendingPayments == [])
                        <p>No pending payments for the selected month.</p>
                    @else
                        @foreach ($pendingPayments as $payment)
                            <div class="payment-card">
                                <strong>Room #{{ $payment->rentForm->dorm->name }}</strong>
                                <p>{{ $payment->rentForm->dorm->name }}</p>
                                <p>₱{{ $payment->amount }}</p>
                                <p class="due-date">Due Date: {{ $payment->billing_date }}</p>
                                <!-- Payment form -->
                                <form class="payment-form" data-payment-id="{{ $payment->id }}" method="POST"
                                    action="{{ route('makePayment', $payment->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Pay Now</button>
                                </form>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Paid Payments Tab -->
            <div class="tab-pane" id="paid-payments">
                <h4>Paid Payments</h4>
                <div id="paidPaymentsContent" class="payment-container">
                    @if ($paidPayments->isEmpty())
                        <p>No payments made for the selected month.</p>
                    @else
                        @foreach ($paidPayments as $payment)
                            <div class="payment-card">
                                <strong>{{ $payment->rentForm->dorm->name }}</strong>
                                <p>₱{{ $payment->amount }}</p>
                                <p class="paid-date">Paid on: {{ $payment->paid_at }}</p>
                            </div>
                        @endforeach
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
        const cancelButton = document.getElementById('cancelButton');
        const cancelReasonModal = document.getElementById('cancelReasonModal');
        const modalOverlay = document.getElementById('modalOverlay');
        const closeButton = document.querySelector('.close-button');

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

    expandButton.addEventListener('click', function () {
        if (extraDetails.style.display === 'none') {
            extraDetails.style.display = 'block';
            arrow.classList.add('rotate');
        } else {
            extraDetails.style.display = 'none';
            arrow.classList.remove('rotate');
        }
    });
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
    $(document).ready(function () {
        // Handle filtering by month
        $('#monthFilter').change(function () {
            var selectedMonth = $('#monthFilter').val();
            var activeTab = $('.tab-button.active').data('tab');

            if (selectedMonth) {
                fetchPayments(selectedMonth, activeTab);
            }
        });

        // Handle tab switching
        $('.tab-button').on('click', function () {
            var selectedMonth = $('#monthFilter').val();
            var activeTab = $(this).data('tab'); // Get the active tab

            if (selectedMonth) {
                fetchPayments(selectedMonth, activeTab);
            }
        });

        // AJAX function to fetch payments
        // Function to fetch payments
        function fetchPayments(month, tab) {
            var url = "{{ route('billing.filter') }}";
            var type = (tab === 'pending-payments') ? 'pending' : 'paid';

            $.ajax({
                url: url,
                method: 'GET',
                data: { month: month, type: type },
                success: function (response) {
                    var payments = response.payments;
                    if (type === 'pending') {
                        updatePendingPayments(payments);
                    } else {
                        updatePaidPayments(payments);
                    }
                },
                error: function () {
                    alert('Error fetching payments. Please try again.');
                }
            });
        }

        // Function to update pending payments HTML
        function updatePendingPayments(payments) {
            var content = '';

            if (payments.length === 0) {
                content = '<p>No pending payments for the selected month.</p>';
            } else {
                payments.forEach(function (payment) {
                    content += '<div class="payment-card">' +
                        '<strong>Room #' + payment.rent_form.room.number + '</strong>' +
                        '<p>' + payment.rent_form.room.dorm.name + '</p>' +
                        '<p>₱' + payment.amount + '</p>' +
                        '<p class="due-date">Due Date: ' + payment.billing_date + '</p>' +
                        '<form class="payment-form" data-payment-id="' + payment.id + '" method="POST" action="/make-payment/' + payment.id + '">' +
                        '<input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').attr('content') + '">' +
                        '<button type="submit" class="btn btn-success">Pay Now</button>' +
                        '</form>' +
                        '</div>';
                });
            }

            $('#pendingPaymentsContent').html(content);

            // Intercept form submission for each payment form
            $('.payment-form').on('submit', function (e) {
                e.preventDefault(); // Prevent the default form submission

                var form = $(this);
                var formData = form.serialize(); // Serialize form data, including the CSRF token

                $.ajax({
                    url: form.attr('action'),  // Get the form action URL
                    type: 'POST',
                    data: formData,  // Send serialized form data
                    success: function (response) {
                        alert('Payment successful!');
                        // Optionally, update the UI with the new data, like refreshing payment info
                        updatePendingPayments(response.pendingPayments);
                    },
                    error: function (xhr, status, error) {
                        alert('Payment failed. Please try again.');
                        console.log(xhr.responseText);
                    }
                });
            });
        }




        // Function to update paid payments HTML
        function updatePaidPayments(payments) {
            var content = '';

            if (payments.length === 0) {
                content = '<p>No payments made for the selected month.</p>';
            } else {
                payments.forEach(function (payment) {
                    content += '<div class="payment-card">' +
                        '<strong>Room #' + payment.rent_form.room.number + '</strong>' +
                        '<p>' + payment.rent_form.room.dorm.name + '</p>' +
                        '<p>₱' + payment.amount + '</p>' +
                        '<p class="paid-date">Paid on: ' + payment.paid_at + '</p>' +
                        '</div>';
                });
            }

            $('#paidPaymentsContent').html(content);
        }
    });

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
@endsection