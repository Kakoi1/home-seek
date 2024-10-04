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
                            <p>Price per Day: ₱{{ $currentRent->room->dorm->price_day }}</p>
                        @else
                            <p>Price per Month: ₱{{ $currentRent->room->dorm->price }}</p>
                        @endif


                        <p>Total Price: <strong>₱{{ $currentRent->total_price }}</strong></p>
                        <p>Total Calculation:
                            {{ $currentRent->term == 'short_term' ? 'Days x Price per Day' : 'Months x Price per Month' }}
                        </p>
                    </div>
                </div>

                @if ($currentRent->status == 'pending')
                    <div class="btn-div">
                        <form action="{{ route('rentForm.cancel', $currentRent->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn cancel-button">Cancel Booking</button>
                        </form>
                        <a href="{{ route('rentForm.create', [$currentRent->room_id, $currentRent->id]) }}"
                            class="btn edit-button">Edit</a>
                    </div>
                @else
                    <button class="btn disabled-button" disabled>Form can't be edited or canceled</button>
                @endif
            </div>
        @else
            <p>No active rented property at the moment.</p>
        @endif
    </div>

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
</script>
<!-- Script to toggle the expandable section -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
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
    });
</script>

@endsection