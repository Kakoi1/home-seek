@extends('layouts.app')

@section('content')
<style>
    /* Styling for the tab navigation */
    .nav-tabs {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }

    .nav-tabs .nav-link {
        color: #495057;
        padding: 10px 20px;
        border-radius: 0;
    }

    .nav-tabs .nav-link.active {
        background: linear-gradient(to left, rgba(11, 136, 147, 0.712), rgba(54, 0, 51, 0.74));
        color: white;
        border: none;
        font-weight: bold;
        border-radius: 10px;
    }

    /* Card styles */
    .card {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
        border: none;
    }

    .card-header {
        background: linear-gradient(to left, rgba(11, 136, 147, 0.712), rgba(54, 0, 51, 0.74));
        color: white;
        padding: 10px 15px;
        font-weight: bold;
        border-bottom: none;
        border-radius: 8px 8px 0 0;
    }

    .btns {
        background: linear-gradient(to left, rgba(11, 136, 147, 0.712), rgba(54, 0, 51, 0.74));
        color: white;
        padding: 10px 15px;
        font-weight: bold;
        border: none;
        border-radius: 8px;
    }

    .card-body {
        padding: 20px;
    }

    .room-section {
        /* background-color: #f9f9f9; */
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 15px;
        /* border: 1px solid #e0e0e0; */
    }

    .tenant-card {
        /* background-color: #f5f5f5; */
        padding: 10px;
        border-radius: 4px;
        /* box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); */
    }

    .tenant-card h5 {
        margin: 0;
        font-size: 1.2rem;
    }

    .tenant-card p {
        margin: 5px 0;
    }

    /* Action buttons */
    .action-buttons {
        margin-top: 10px;
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
    }

    .action-buttons button {
        width: 150px;
        height: 35px;
        border-radius: 8px;
        margin: 4px;
    }


    .btn {
        border-radius: 4px;
        padding: 5px 10px;
        font-size: 0.875rem;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
    }

    /* Hover effects */
    .card:hover {
        transform: translateY(-3px);
        transition: 0.3s ease-in-out;
    }

    .btn-success:hover,
    .btn-danger:hover {
        opacity: 0.9;
    }

    /* Tab content area */
    .tab-content {
        padding-top: 20px;
    }

    p,
    h2,
    h3,
    h4,
    h5 {
        margin-bottom: 15px;
    }


    h4 {
        font-weight: bold;
        color: #007bff;
    }

    h3 {
        font-weight: bold;
        color: #ffffff;
    }

    /* Responsive Design */
    @media (max-width: 768px) {

        .card-header,
        .card-body {
            text-align: center;
        }

        .nav-tabs {
            display: block;
        }

        .nav-tabs .nav-link {
            margin-bottom: 10px;
            width: 100%;
            text-align: center;
        }
    }

    .expand-btn {
        cursor: pointer;
        color: blue;
        text-decoration: none;
    }

    .expand-btn:after {
        content: " ▼";
        /* Arrow down */
    }

    .expand-btn.collapsed:after {
        content: " ►";
        /* Arrow right */
    }

    .hidden {
        display: none;
    }

    .tab-header {
        display: flex;
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .tab-header div {
        padding: 10px;
        cursor: pointer;
        background: #f1f1f1;
        margin-right: 5px;
        border-radius: 8px;
    }

    .tab-header div.active {
        background: linear-gradient(to left, rgba(11, 136, 147, 0.712), rgba(54, 0, 51, 0.74));
        color: white;
    }

    .tab-content {
        padding: 10px;
        border-radius: 5px;
    }
</style>
<div class="container">
    <!-- Tabs Navigation -->
    <div class="btn">
        <i class="fa-solid fa-clock-rotate-left"></i><a href="{{route('owner.history')}}">History</a>
    </div>
    <br>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="tenants-tab" data-toggle="tab" href="#tenants" role="tab"
                aria-controls="tenants" aria-selected="true">Tenants</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="rent-requests-tab" data-toggle="tab" href="#rentRequests" role="tab"
                aria-controls="rentRequests" aria-selected="false">Booking Requests
                @if ($count > 0)
                    <span class="badge badge-danger">{{ $count }}</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="cancel-requests-tab" data-toggle="tab" href="#cancellations" role="tab"
                aria-controls="cancellations" aria-selected="false">Cancellations
                @if ($counts > 0)
                    <span class="badge badge-danger">{{ $counts }}</span>
                @endif
            </a>
        </li>
    </ul>


    <div class="tab-content" id="myTabContent">
        <!-- Tenants Tab -->
        <div class="tab-pane fade show active" id="tenants" role="tabpanel" aria-labelledby="tenants-tab">
            @forelse($properties as $property)
                <div class="card mt-3">
                    <div class="card-header">
                        <h3>{{ $property['dorm_name'] }} - {{ $property['dorm_location'] }}</h3>
                    </div>
                    <div class="card-body">
                        @foreach($property['dorms'] as $room)
                            <div class="room-section mb-3">
                                <h4>Room {{ $room['name'] }}</h4>
                                @if(empty($room['tenants']))
                                    <p>No tenants in this room.</p>
                                @else
                                        @foreach($room['tenants'] as $tenant)
                                                <div class="tenant-card">
                                                    <h5 onclick="openUserPopup({{ $tenant['user_id'] }})">
                                                        <strong><a href="javascript: void(0)">{{ ucfirst($tenant['name']) }}</a></strong>
                                                        @if (!$tenant['pending_bills']->isEmpty())
                                                            <span class="badge badge-danger">Not Paid</span>
                                                        @endif

                                                    </h5>
                                                    <span class="expand-btn" onclick="toggleDetails({{ $tenant['user_id'] }})">Details</span>
                                                    <p>Email: <a href="mailto:{{ $tenant['email'] }}">{{ $tenant['email'] }}</a></p>
                                                    <p>Rent Status: <strong>{{ ucfirst($tenant['status']) }}</strong></p>

                                                    <div id="tenantDetails{{ $tenant['user_id'] }}" class="hidden">
                                                        @if ($tenant['status'] == 'approved')
                                                                        @php
                                                                            $today = Carbon\Carbon::now();
                                                                            $startDate = Carbon\Carbon::parse($tenant['start_date']);
                                                                            $remainingTimeInHours = $today->diffInHours($startDate, false);
                                                                            if ($remainingTimeInHours < 24) {
                                                                                $remainingTime = intval($remainingTimeInHours) . ' hour' . (intval($remainingTimeInHours) > 1 ? 's' : '');
                                                                                if ($remainingTime <= 0) {
                                                                                    $remainingTime = 'today';
                                                                                }
                                                                            } else {
                                                                                $remainingTimeInDays = $today->diffInDays($startDate, false);
                                                                                $remainingTime = intval($remainingTimeInDays) . ' day' . (intval($remainingTimeInDays) > 1 ? 's' : '');
                                                                            }

                                                                        @endphp
                                                                        <p>Rent Start Date: <strong>{{ $tenant['start_date'] }}</strong></p>
                                                                        <p>Rent will start in: {{ $remainingTime }}</p>
                                                                        <br>
                                                                        <button class="btns" onclick="sendNotification({{ $tenant['user_id'] }})">Send Upcoming
                                                                            Stay
                                                                            Notification</button>
                                                        @elseif($tenant['status'] == 'active')
                                                                        @php
                                                                            $today = \Carbon\Carbon::now();
                                                                            $endDate = \Carbon\Carbon::parse($tenant['end_date']);
                                                                            $remainingTime = (int) $endDate->diffInDays($today, false);
                                                                        @endphp
                                                                        <p>Rent End Date: <strong>{{ $tenant['end_date'] }}</strong></p>
                                                                        <p>Rent will end in: {{ abs($remainingTime) }} days</p>
                                                        @endif

                                                        <!-- Tabs for Pending and Paid Bills -->
                                                        @if ($tenant['status'] == 'active')
                                                                <hr>
                                                                @if (!$tenant['pending_bills']->isEmpty())
                                                                        <div id="tab-content-pending-{{ $tenant['user_id'] }}" class="tab-content">
                                                                            @foreach($tenant['pending_bills'] as $bill)
                                                                                        @php
                                                                                            // Convert the billing date to a Carbon instance
                                                                                            $dueDate = \Carbon\Carbon::parse($bill['billing_date']);
                                                                                            $currentDate = \Carbon\Carbon::now();
                                                                                            // Calculate the difference in days
                                                                                            $daysRemaining = $dueDate->diffInDays($currentDate, false); // false for absolute value
                                                                                            // Round the number of days remaining to the nearest integer
                                                                                            $roundedDaysRemaining = round($daysRemaining);
                                                                                        @endphp

                                                                                        <div style="padding: 5px;">
                                                                                            <p class="d-flex justify-content-between align-items-center mb-3">
                                                                                                <span><strong>Amount:</strong> ₱{{ $bill['amount'] }}</span>
                                                                                                <!-- Display the number of days remaining -->
                                                                                                <span><strong>Due Date:</strong>
                                                                                                    @if ($roundedDaysRemaining > 0)
                                                                                                        {{ $roundedDaysRemaining }} days
                                                                                                    @elseif ($roundedDaysRemaining == 0)
                                                                                                        Today
                                                                                                    @else
                                                                                                        Overdue by {{ abs($roundedDaysRemaining) }} days
                                                                                                    @endif
                                                                                                </span>
                                                                                            </p>
                                                                                        </div>
                                                                                        <br>
                                                                                        <div style="display: flex; justify-content: flex-start; gap: 10px;">
                                                                                            <form method="POST" action="{{ route('notifyTenant', $bill['rent_form_id']) }}">
                                                                                                @csrf
                                                                                                <button type="submit" class="btns">Notify Payment</button>
                                                                                            </form>

                                                                                            <!-- Over the Counter Pay Button -->
                                                                                            <button type="button" class="btn btn-info btn-sm"
                                                                                                onclick="togglePaymentForm('paymentForm{{ $bill['id'] }}')">Pay Over the
                                                                                                Counter</button>
                                                                                        </div>

                                                                                        <!-- Hidden Form for Over the Counter Payment -->
                                                                                        <div id="paymentForm{{ $bill['id'] }}"
                                                                                            style="display:none; margin-top: 10px; padding: 15px; border: 1px solid #ccc; background-color: #f9f9f9;">
                                                                                            <form method="POST" action="{{ route('processPayment', $bill['id']) }} "
                                                                                                enctype="multipart/form-data">
                                                                                                @csrf
                                                                                                @method('PATCH')
                                                                                                <div class="form-group">
                                                                                                    <label for="mode_of_payment">Mode of Payment:</label>
                                                                                                    <select id="mode_of_payment" name="mode_of_payment"
                                                                                                        class="form-control">
                                                                                                        <option value="cash">Cash</option>
                                                                                                        <option value="e_wallet">E - Wallet</option>
                                                                                                        <option value="credit_card">Credit Card</option>
                                                                                                        <option value="bank_transfer">Bank Transfer</option>

                                                                                                    </select>
                                                                                                </div>

                                                                                                <div class="form-group">
                                                                                                    <label for="payment_reference">Payment Reference:</label>
                                                                                                    <input type="file" id="payment_reference" name="payment_reference"
                                                                                                        accept="image/png, image/gif, image/jpeg" style="height: 45px;"
                                                                                                        class="form-control" placeholder="Proof of payment">
                                                                                                </div>

                                                                                                <div class="form-group">
                                                                                                    <label for="payment_date">Payment Date:</label>
                                                                                                    <input type="date" id="payment_date" name="payment_date"
                                                                                                        class="form-control" required>
                                                                                                </div>

                                                                                                <button type="submit" class="btn btn-success btn-sm">Submit Payment</button>
                                                                                            </form>
                                                                                        </div>
                                                                            @endforeach
                                                                        </div>
                                                                @elseif (!$tenant['paid_bills']->isEmpty())
                                                                    <div id="tab-content-paid-{{ $tenant['user_id'] }}" class="tab-content">
                                                                        @foreach($tenant['paid_bills'] as $bill)
                                                                            <div style="padding: 5px;">
                                                                                <p class="d-flex justify-content-between align-items-center mb-3">
                                                                                    <span><strong>Amount:</strong> ₱{{ $bill['amount'] }}</span>
                                                                                    <span><strong>Paid At:</strong>
                                                                                        {{ \Carbon\Carbon::parse($bill['paid_at'])->format('M d, Y') }}</span>
                                                                                </p>
                                                                                <p class="d-flex justify-content-between align-items-center mb-3">
                                                                                    <span><strong>Status:</strong> Paid</span>
                                                                                    <span><strong>Mode of Payment:</strong>
                                                                                        @if($bill['mode'] == 'credit_card')
                                                                                            Credit Card
                                                                                        @elseif($bill['mode'] == 'e_wallet')
                                                                                            E-Wallet
                                                                                        @elseif($bill['mode'] == 'bank_transfer')
                                                                                            Bank Transfer
                                                                                        @else
                                                                                            {{ ucfirst($bill['mode']) }}
                                                                                        @endif
                                                                                    </span>
                                                                                </p>

                                                                            </div>
                                                                            <br>
                                                                        @endforeach
                                                                    </div>
                                                                @else
                                                                    <p>No pending or paid bills available.</p>
                                                                @endif
                                                        @endif

                                                    </div>
                                                </div>
                                        @endforeach
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <p>No properties available.</p>
            @endforelse
        </div>

        <!-- Rent Requests Tab -->
        <div class="tab-pane fade" id="rentRequests" role="tabpanel" aria-labelledby="rent-requests-tab">
            <h2 class="mt-4">Pending Rent Requests</h2>
            @if (empty($pendingRentForms))
                <p>No pending rent form submissions.</p>
            @else
                @foreach ($pendingRentForms as $rentForm)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ ucfirst($rentForm->dorm_name) }}</h5>
                            <p onclick="openUserPopup({{ $rentForm->user_id }})">Tenant: <strong><a
                                        href="javascript: void(0)">{{ ucfirst($rentForm->tenant_name) }}</a></strong></p>
                            <p>Submitted on: {{ \Carbon\Carbon::parse($rentForm->created_at)->format('Y-m-d H:i') }}</p>
                            <div class="action-buttons">
                                <form id="approveBook" action="{{ route('rentForm.updateStatus', $rentForm->rent_form_id) }}"
                                    method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="approved">
                                </form>

                                <button type="button" class="approve-btn btn-success"
                                    onclick="confirmApproval()">Approve</button>
                                <!-- Reject Button triggers modal -->
                                <button class="reject-btn btn-danger" data-toggle="modal" data-target="#rejectModal"
                                    data-rent-id="{{ $rentForm->rent_form_id }}">Reject</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="rejectModalLabel">Provide Rejection Reason</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="rejectForm" action="{{ route('rentForm.updateStatus', $rentForm->rent_form_id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <label for="rejectionReason">Reason for Rejection</label>
                                            <textarea class="form-control" id="rejectionReason" name="rejection_reason"
                                                required></textarea>
                                        </div>
                                        <button type="submit" name="status" value="rejected" class="btn btn-danger">Submit
                                            Rejection</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Cancellations Tab -->
        <div class="tab-pane fade" id="cancellations" role="tabpanel" aria-labelledby="cancel-requests-tab">
            <h2 class="mt-4">Cancellation Requests</h2>
            @if(empty($cancellations))
                <p>No cancellation requests available.</p>
            @else
                @foreach($cancellations as $cancellation)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ ucfirst($cancellation->dorm_name) }}</h5>
                            <p onclick="openUserPopup({{ $cancellation->user_id }})">Tenant: <strong><a
                                        href="javascript: void(0)">{{ ucfirst($cancellation->tenant_name) }}</a></strong></p>
                            <p>Cancellation Reason: {{ $cancellation->cancel_reason }}</p>
                            <p>Requested on: {{ \Carbon\Carbon::parse($cancellation->updated_at)->format('Y-m-d H:i') }}</p>
                            <div class="action-buttons">
                                <form id="cancellationForm"
                                    action="{{ route('cancellation.updateStatus', $cancellation->rent_form_id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('PATCH')

                                    <!-- Approve button -->
                                    <button type="button" class="approve-btn btn-success"
                                        onclick="confirmAction('approved')">Approve</button>

                                    <!-- Reject button -->
                                    <button type="button" class="reject-btn btn-danger"
                                        onclick="confirmAction('rejected')">Reject</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

</div>
<script>
    // Toggle visibility of tenant details
    function toggleDetails(tenantId) {
        const details = document.getElementById(`tenantDetails${tenantId}`);
        const btn = document.querySelector(`.expand-btn[onclick="toggleDetails(${tenantId})"]`);
        details.classList.toggle('hidden');
        btn.classList.toggle('collapsed');
    }

    // Switch between pending and paid bills tabs
    function switchTab(tenantId, tab) {
        const pendingTab = document.getElementById(`pending-tab-${tenantId}`);
        const paidTab = document.getElementById(`paid-tab-${tenantId}`);
        const pendingContent = document.getElementById(`tab-content-pending-${tenantId}`);
        const paidContent = document.getElementById(`tab-content-paid-${tenantId}`);

        if (tab === 'pending') {
            pendingTab.classList.add('active');
            paidTab.classList.remove('active');
            pendingContent.classList.remove('hidden');
            paidContent.classList.add('hidden');
        } else {
            pendingTab.classList.remove('active');
            paidTab.classList.add('active');
            pendingContent.classList.add('hidden');
            paidContent.classList.remove('hidden');
        }
    }
    function sendNotification(tenantId) {
        fetch(`/notify-tenant/${tenantId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Notification sent successfully!');
                } else {
                    alert('Failed to send notification.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error sending notification.');
            });
    }

</script>
<script>
    function togglePaymentForm(formId) {
        var form = document.getElementById(formId);
        // Toggle the display of the form
        if (form.style.display === "none" || form.style.display === "") {
            form.style.display = "block";
        } else {
            form.style.display = "none";
        }
    }
    function confirmApproval() {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you really want to approve this booking?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, approve it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form if confirmed
                document.getElementById('approveBook').submit();
            }
        });
    }
    function confirmAction(status) {
        let actionText = status === 'approved' ? 'approve' : 'reject';
        let actionTitle = status === 'approved' ? 'Are you sure you want to approve this cancellation?' : 'Are you sure you want to reject this cancellation?';
        let actionButtonText = status === 'approved' ? 'Yes, approve it!' : 'Yes, reject it!';

        Swal.fire({
            title: actionTitle,
            text: 'You won\'t be able to revert this action.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: actionButtonText,
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Set the status value and submit the form
                let form = document.getElementById('cancellationForm');
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'status';
                input.value = status;
                form.appendChild(input);

                // Submit the form after adding the status value
                form.submit();
            }
        });
    }
</script>


@endsection