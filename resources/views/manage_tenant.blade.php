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
        background-color: #007bff;
        color: white;
        border: none;
        font-weight: bold;
    }

    /* Card styles */
    .card {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
        border: none;
    }

    .card-header {
        background-color: #007bff;
        color: white;
        padding: 10px 15px;
        font-weight: bold;
        border-bottom: none;
        border-radius: 8px 8px 0 0;
    }

    .card-body {
        padding: 20px;
    }

    .room-section {
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 15px;
        border: 1px solid #e0e0e0;
    }

    .tenant-card {
        background-color: #f5f5f5;
        padding: 10px;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
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
</style>
<div class="container">
    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="tenants-tab" data-toggle="tab" href="#tenants" role="tab"
                aria-controls="tenants" aria-selected="true">Tenants</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="rent-requests-tab" data-toggle="tab" href="#rentRequests" role="tab"
                aria-controls="rentRequests" aria-selected="false">Booking Requests</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="extend-requests-tab" data-toggle="tab" href="#extendRequests" role="tab"
                aria-controls="extendRequests" aria-selected="false">Extension Requests</a>
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
                        @if(empty($property['rooms']))
                            <p>No rooms in this property.</p>
                        @else
                            @foreach($property['rooms'] as $room)
                                <div class="room-section mb-3">
                                    <h4>Room {{ $room['number'] }}</h4>
                                    @if(empty($room['tenants']))
                                        <p>No tenants in this room.</p>
                                    @else
                                        @foreach($room['tenants'] as $tenant)
                                            <div class="tenant-card p-3 mb-2 border rounded">
                                                <h5>{{ $tenant['name'] }}</h5>
                                                <p>Email: <a href="mailto:{{ $tenant['email'] }}">{{ $tenant['email'] }}</a></p>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @empty
                <p>No properties available.</p>
            @endforelse
        </div>

        <div class="tab-pane fade" id="rentRequests" role="tabpanel" aria-labelledby="rent-requests-tab">
            <h2 class="mt-4">Pending Rent Requests</h2>
            @if (empty($pendingRentForms))
                <p>No pending rent form submissions.</p>
            @else
                @foreach ($pendingRentForms as $rentForm)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Room {{ $rentForm->room_number }} - {{ $rentForm->dorm_name }}</h5>
                            <p>Tenant: {{ $rentForm->tenant_name }}</p>
                            <p>Submitted on: {{ \Carbon\Carbon::parse($rentForm->created_at)->format('Y-m-d H:i') }}</p>
                            <div class="action-buttons">
                                <form action="{{ route('rentForm.updateStatus', $rentForm->rent_form_id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="approve-btn" name="status" value="approved">Approve</button>
                                    <button type="submit" class="reject-btn" name="status" value="rejected">Reject</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        {{-- Extension Requests Tab --}}

    </div>



    @endsection