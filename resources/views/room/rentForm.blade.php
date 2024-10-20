@extends('layouts.app')

@section('title', 'Rent Form')

@section('content')

<style>
    /* Styles */
    .rent-form-container {
        width: 50%;
        margin: 0 auto;
        padding: 20px;
        background-color: #f7f7f7;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .rent-form-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .rent-form-container label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }

    .rent-form-container input[type="text"],
    .rent-form-container input[type="number"],
    .rent-form-container input[type="date"],
    .rent-form-container select {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .rent-form-container button {
        background: linear-gradient(to left, rgba(11, 136, 147, 0.712), rgba(54, 0, 51, 0.74));
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 100%;
    }

    .rent-form-container button:hover {
        background-color: #218838;
    }

    .rent-form-container .back-link {
        display: block;
        text-align: center;
        margin-top: 20px;
    }

    .term-selection {
        margin-bottom: 20px;
    }

    .term-selection label {
        margin-right: 15px;
    }

    .price-info {
        /* margin-bottom: 20px; */
        /* text-align: center; */
        font-weight: bold;
        display: flex;
        justify-content: flex-start;
    }

    .infoCont {
        font-weight: bold;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 0px 0px 0px 20px;
        border: solid .5px;
        border-radius: 8px;
        line-height: 2;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
</style>
<br><br>
<div class="rent-form-container">
    <h2>{{ isset($rent) ? 'Edit Booking' : 'Book a Room' }}</h2>

    <form action="{{ isset($rent) ? route('rentForm.update', $rent->id) : route('rentForm.store') }}" method="POST">
        @csrf
        @if (isset($rent))
            @method('PATCH')
        @endif

        <!-- Room Selection -->
        <label for="room_id">Room</label>
        <select name="room_id" id="room_id" required>
            <option value="">Select Room</option>
            @foreach($rooms as $room)
                <option value="{{ $room->id }}" data-price-day="{{ $room->dorm->price_day }}"
                    data-price-month="{{ $room->dorm->price }}" {{ isset($rent) && $rent->room_id == $room->id ? 'selected' : '' }}>
                    Room #{{ $room->number }} - {{ $room->dorm->name }}
                </option>
            @endforeach
        </select>

        <p>Price / month: <strong>{{ isset($rent) ? $rent->room->dorm->price : $room->dorm->price }}</strong></p>
        <p>Price / day: <strong> {{ isset($rent) ? $rent->room->dorm->price_day : $room->dorm->price_day }}</strong>
        </p>
        <input type="hidden" id="price_day"
            value="{{ isset($rent) ? $rent->room->dorm->price_day : $room->dorm->price_day }}">
        <input type="hidden" id="price_month"
            value="{{ isset($rent) ? $rent->room->dorm->price : $room->dorm->price }}">

        <!-- Start Date -->
        <label for="start_date">Start Date</label>
        <input type="date" id="start_date" name="start_date"
            value="{{ isset($rent) ? $rent->start_date->format('Y-m-d') : old('start_date') }}" required
            onchange="valiDate()">

        <!-- End Date (for short-term rent) -->
        <label for="end_date" id="end_date_label" style="display: none;">End Date (for short-term)</label>
        <input type="date" id="end_date" name="end_date"
            value="{{ isset($rent) ? $rent->end_date->format('Y-m-d') : old('end_date') }}" style="display: none;">
        @if (isset($rent))
            <p>Your Current end date: {{ $rent->end_date->format('Y-m-d') }}</p>
        @endif

        <!-- Duration (for long-term rent) -->
        <label for="duration" id="duration_label" style="display: none;">Duration (in months)</label>
        <input type="number" id="duration" name="duration" min="2"
            value="{{ isset($rent) ? $rent->duration : old('duration') }}" style="display: none;">
        <input type="hidden" name="dorm_id" value="{{ isset($rent) ? $rent->room->dorm_id : $room->dorm_id}}">
        <input type="hidden" id="durdate" name="durdate"
            value="{{ isset($rent) ? $rent->end_date->format('Y-m-d') : old('end_date') }}">

        <!-- Rental Term Selection -->
        <div class="term-selection">
            <label>
                <input type="radio" name="term" value="short_term" id="short_term" {{ isset($rent) && $rent->duration <= 1 ? 'checked' : '' }}> Short Term (Max 30 Days)
            </label>
            <label>
                <input type="radio" name="term" value="long_term" id="long_term" {{ isset($rent) && $rent->duration > 1 ? 'checked' : '' }}> Long Term (Months)
            </label>
        </div>

        <div class="infoCont" id="infoCont">
            <div class="price-info" id="price_info">
            </div>
            <!-- Total Price Display -->
            <p>Total Rent: <strong id="total_price">{{isset($rent) ? $rent->total_price : old('duration')}}</strong></p>

        </div>
        <br>
        <input type="hidden" name="total_price" id="tprice"
            value="{{isset($rent) ? $rent->total_price : old('duration')}}">

        <button type="submit">{{ isset($rent) ? 'Update Rent Form' : 'Submit Rent Form' }}</button>
    </form>

    <a href="{{ route('dorms.posted', ['id' => $room->dorm_id]) }}" class="back-link">Go Back</a>
</div>

<!-- Script for form logic and calculation -->
<script>
    function valiDate() {
        const selectedStartDate = document.getElementById('start_date').value;
        const maxDate = new Date(selectedStartDate);
        const minDate = new Date(selectedStartDate);
        maxDate.setDate(maxDate.getDate() + 30);
        minDate.setDate(minDate.getDate() + 1);

        if (selectedStartDate) {
            // Set min attribute for end date
            document.getElementById('end_date').setAttribute('min', minDate.toISOString().split('T')[0]);

            // Set max attribute for end date
            const maxDateISO = maxDate.toISOString().split('T')[0]; // Format to YYYY-MM-DD
            document.getElementById('end_date').setAttribute('max', maxDateISO);

            // Optionally reset end date value
            document.getElementById('end_date').value = '';
        }
    }


    document.addEventListener('DOMContentLoaded', function () {
        const shortTermRadio = document.getElementById('short_term');
        const longTermRadio = document.getElementById('long_term');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const durationInput = document.getElementById('duration');
        const roomSelect = document.getElementById('room_id');
        const totalPriceDisplay = document.getElementById('total_price');
        const priceDayInput = document.getElementById('price_day');
        const priceMonthInput = document.getElementById('price_month');
        const durationLabel = document.getElementById('duration_label');
        const enddateLabel = document.getElementById('end_date_label');
        const tpriceInput = document.getElementById('tprice');
        const priceInfoDiv = document.getElementById('price_info');

        const today = new Date().toISOString().split('T')[0];
        startDateInput.setAttribute('min', today);

        function setPriceValues() {
            const selectedRoom = roomSelect.options[roomSelect.selectedIndex];
            const priceDay = selectedRoom.getAttribute('data-price-day');
            const priceMonth = selectedRoom.getAttribute('data-price-month');
            // priceDayInput.value = priceDay;
            // priceMonthInput.value = priceMonth;
            calculateTotal();
            handleTermChange();
        }

        function calculateTotal() {
            let total = 0;
            const priceDay = parseFloat(priceDayInput.value);
            const priceMonth = parseFloat(priceMonthInput.value);

            if (shortTermRadio.checked && startDateInput.value && endDateInput.value) {
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);
                const numberOfDays = Math.ceil((endDate - startDate) / (1000 * 3600 * 24)) + 1;
                total = priceDay * numberOfDays;
                priceInfoDiv.innerHTML = `You selected ${numberOfDays} day(s). <br> Price per day: $${priceDay}.`;
            } else if (longTermRadio.checked && durationInput.value) {
                const durationInMonths = parseInt(durationInput.value, 10);
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(startDate.setMonth(startDate.getMonth() + durationInMonths));
                total = priceMonth * durationInMonths;
                priceInfoDiv.innerHTML = `Your rental ends on: ${endDate.toISOString().split('T')[0]}.`;
                document.getElementById('durdate').value = endDate.toISOString().split('T')[0];
            }

            totalPriceDisplay.textContent = total.toFixed(2);
            tpriceInput.value = total;
            checkPrice()
        }
        function checkPrice() {
            if (tpriceInput.value == 0) {
                document.getElementById('infoCont').style.display = 'none'
            } else {
                document.getElementById('infoCont').style.display = 'flex'
            }
        }
        function handleTermChange() {
            if (shortTermRadio.checked) {
                durationLabel.style.display = 'none';
                durationInput.style.display = 'none';
                durationInput.value = ''; // Clear duration
                endDateInput.style.display = 'block';
                enddateLabel.style.display = 'block';
                endDateInput.setAttribute('required', true);
                valiDate();
            } else if (longTermRadio.checked) {
                endDateInput.style.display = 'none';
                enddateLabel.style.display = 'none';
                endDateInput.removeAttribute('required');
                durationInput.style.display = 'block';
                durationLabel.style.display = 'block';
                endDateInput.value = '';
            }
            calculateTotal(); // Recalculate when the term changes
        }
        startDateInput.addEventListener('change', calculateTotal);
        endDateInput.addEventListener('change', calculateTotal);
        durationInput.addEventListener('input', calculateTotal);
        roomSelect.addEventListener('change', setPriceValues);
        shortTermRadio.addEventListener('change', handleTermChange);
        longTermRadio.addEventListener('change', handleTermChange);
        setPriceValues();
    });
</script>
@endsection