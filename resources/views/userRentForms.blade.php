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
        background-color: #00b4d8;
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

    .btn.leave-button {
        background-color: red;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    .btn.submit-leave-button {
        background-color: green;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    .btn.extend-button {
        background-color: blue;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }
</style>
<br>
<div class="container">
    <h2>Booked Property</h2>

    <!-- Tabs -->
    <div class="tabs">
        <div class="tab tab-active" id="currentTab">Current Rented Property</div>
        <div class="tab" id="historyTab">Rent History</div>
    </div>

    <!-- Current Rented Property -->
    <div id="currentSection" class="rent-section rent-section-active">
        @if ($currentRent)


            <div class="rent-form-card">
                <h3>Room #{{ $currentRent->room->number }} - {{ $currentRent->room->dorm->name }}</h3>
                <p>Start Date: {{ $currentRent->start_date->format('F j, Y') }}</p>
                <p>End Date: {{ $currentRent->end_date->format('F j, Y') }}</p>
                <p>Rent term: {{ $currentRent->term == 'short_term' ? 'Short Term' : 'Long Term' }}</p>
                <p>Status: <strong>{{ ucfirst($currentRent->status) }}</strong></p>

                <!-- Expandable Section -->
                <div class="expandable-section">
                    <button id="expandButton" class="expand-button">
                        <span>Details</span>
                        <span class="arrow">▼</span>
                    </button>
                    <div id="extraDetails" class="extra-details" style="display: none;">
                        @if ($currentRent->term == 'short_term')
                                        @php
                                            $date1 = date_create($currentRent->start_date);
                                            $date2 = date_create($currentRent->end_date);
                                            $diff = date_diff($date1, $date2);
                                        @endphp
                                        <p>Price per Day: ₱{{ $currentRent->room->dorm->price_day }}</p>
                                        <p>Total days: {{ $diff->format("%a days") }}</p>
                        @else
                            <p>Price per Month: ₱{{ $currentRent->room->dorm->price }}</p>
                            <p>Duration in Months: {{ $currentRent->duration }}</p>
                        @endif

                        <p>Total Price: <strong>₱{{ $currentRent->total_price }}</strong></p>
                    </div>
                </div>

                @if ($currentRent->status == 'pending')
                    <div class="btn-div">
                        <!-- Cancel Button with SweetAlert Confirmation -->
                        <button id="cancelButton" class="btn cancel-button">Cancel Booking</button>


                        <a href="{{ route('rentForm.create', [$currentRent->room_id, $currentRent->id]) }}"
                            class="btn edit-button">Edit</a>
                    </div>
                @elseif ($currentRent->status == 'approved')
                        <div class="btn-div">
                            <button id="leaveButton" class="btn cancel-button">Leave Rent</button>
                            @php
                                $today = \Carbon\Carbon::now();


                                $remainingTime = $today->diffInDays($currentRent->end_date);
                            @endphp

                            @if (($currentRent->term == 'short_term' && $remainingTime <= 3) || ($currentRent->term == 'long_term' && $remainingTime <= 30))
                                @if ($extend)
                                    <a href="javascript:void(0);" onclick="showExtendAlert()">You already submitted an Extend Request</a>
                                @else

                                    <a href="{{ route('rentForm.extend', [$currentRent->id]) }}" class="btn edit-button">Extend Stay</a>
                                @endif


                            @endif
                        </div>
                @endif
            </div>
            <!-- Leave Reason Modal -->
            <div id="leaveReasonModal" class="cancel-modal">
                <div class="modal-content">
                    <span class="close-button">&times;</span>
                    <h3>Why do you want to leave?</h3>
                    <form action="{{ route('rentForm.leave', $currentRent->id) }}" method="POST">
                        @csrf
                        <textarea name="leaveReason" id="leaveReason" rows="4" required
                            placeholder="Please provide your reason..."></textarea>
                        <button type="submit" class="btn submit-leave-button">Submit</button>
                    </form>
                </div>
            </div>

            <div id="cancelReasonModal" class="cancel-modal">
                <div class="modal-content">
                    <span class="close-button">&times;</span>
                    <h3>Why are you canceling this booking?</h3>
                    <form action="{{ route('rentForm.cancel', $currentRent->id) }}" method="POST">
                        @csrf
                        <textarea name="cancelReason" id="cancelReason" rows="4" required
                            placeholder="Please provide your reason..."></textarea>
                        <br>
                        <button type="submit" class="btn submit-cancel-button">Submit Cancellation</button>
                    </form>
                </div>
            </div>
        @else
            <p>No active rented property at the moment.</p>
        @endif
    </div>


    <!-- Overlay -->
    <div id="modalOverlay" class="cancel-modal-overlay"></div>
    <!-- Rent History -->
    <div id="historySection" class="rent-section">
        @if ($rentHistory->isEmpty())
            <p>No rent history available.</p>
        @else
            <div class="rent-history">
                @foreach ($rentHistory as $rent)
                    <div class="rent-form-card">
                        <h3>Room #{{ $rent->room->number }} - {{ $rent->room->dorm->name }}</h3>
                        <p>Start Date: {{ $rent->start_date->format('F j, Y') }}</p>
                        <p>End Date: {{ $rent->end_date->format('F j, Y') }}</p>
                        <p>Status: <strong>{{ ucfirst($rent->status) }}</strong></p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const leaveButton = document.getElementById('leaveButton');
        const leaveReasonModal = document.getElementById('leaveReasonModal');
        const modalOverlay = document.getElementById('modalOverlay');
        const closeButton = document.querySelector('.close-button');

        // SweetAlert Confirmation for Leaving Rent
        leaveButton.addEventListener('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to leave the rent?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, leave!',
                cancelButtonText: 'No, stay'
            }).then((result) => {
                if (result.isConfirmed) {
                    leaveReasonModal.style.display = 'block';
                    modalOverlay.style.display = 'block';
                }
            });
        });

        closeButton.addEventListener('click', function () {
            leaveReasonModal.style.display = 'none';
            modalOverlay.style.display = 'none';
        });

        modalOverlay.addEventListener('click', function () {
            leaveReasonModal.style.display = 'none';
            modalOverlay.style.display = 'none';
        });

    });
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

        currentTab.addEventListener('click', function () {
            currentTab.classList.add('tab-active');
            historyTab.classList.remove('tab-active');
            currentSection.classList.add('rent-section-active');
            historySection.classList.remove('rent-section-active');
        });

        historyTab.addEventListener('click', function () {
            historyTab.classList.add('tab-active');
            currentTab.classList.remove('tab-active');
            historySection.classList.add('rent-section-active');
            currentSection.classList.remove('rent-section-active');
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
                window.location.href = '{{isset($extend) ? route("extendEdit", [$extend->id]) : ''}}'; // Edit route if needed
            }
        });
    }
</script>

@endsection