@extends('layouts.app')

@section('content')

<style>
    /* Center the form on the page */
    .container {
        max-width: 600px;
        margin: 2rem auto;
    }

    /* Form styling */
    form {
        /* background-color: #ffffff; */
        /* border: 1px solid #ddd;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
        border-radius: 8px;
        padding: 2rem;
    }

    /* Form title styling */
    h2 {
        font-weight: 600;
        color: #333;
        font-size: 1.5rem;
    }

    /* Form group styling */
    .form-group {
        margin-bottom: 1.5rem;
    }

    /* Label styling */
    .form-label {
        font-weight: 500;
        color: #555;
    }

    /* Input and select styling */
    .form-control {
        border-radius: 4px;
        border: 1px solid #ccc;
        /* padding: 0.75rem; */
        font-size: 1rem;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 4px rgba(0, 123, 255, 0.2);
    }

    /* Button styling */
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        padding: 0.5rem 1.5rem;
        font-size: 1rem;
        font-weight: 500;
        transition: background-color 0.3s ease;
        border-radius: 4px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    /* Text center for the button container */
    .text-center {
        text-align: center;
    }

    /* Add subtle hover effect for form fields */
    .form-control:hover {
        background-color: #f9f9f9;
    }
</style>
<div class="container">
    <h2 class="text-center mb-4">Edit Rent Form</h2>

    <form action="{{ route('rentForm.update', $rent->id) }}" method="POST" class="">
        @csrf
        @method('PUT')

        <!-- Hidden Fields -->
        <input type="hidden" name="user_id" value="{{ $rent->user_id }}">
        <input type="hidden" name="dorm_id" value="{{ $rent->dorm_id }}">

        <!-- Property Price Per Day (Hidden) -->
        <input type="hidden" id="property_price" value="{{ $property->price}}">

        <!-- Start Date -->
        <div class="form-group mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control"
                value="{{ old('start_date', $rent->start_date) }}" required>
        </div>

        <!-- End Date -->
        <div class="form-group mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control"
                value="{{ old('end_date', $rent->end_date) }}" required>
        </div>

        <!-- Guest -->
        <div class="form-group mb-3">
            <label for="guest" class="form-label">Number of Guests</label>
            <select name="guest" id="guest" class="form-control" required>
                @for ($i = 1; $i <= $property->capacity; $i++)
                    <option value="{{ $i }}" {{ old('guest', $rent->guest) == $i ? 'selected' : '' }}>
                        {{ $i }} {{ Str::plural('guest', $i) }}
                    </option>
                @endfor
            </select>
        </div>


        <!-- Total Price -->
        <div class="form-group mb-3">
            <label for="total_price" class="form-label">Total Price</label>
            <input type="number" name="total_price" id="total_price" class="form-control"
                value="{{ old('total_price', $rent->total_price) }}" readonly>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Update Rent Details</button>
        </div>
    </form>
</div>

<!-- JavaScript for Total Price Calculation -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const totalPriceInput = document.getElementById('total_price');
        const propertyPrice = parseFloat(document.getElementById('property_price').value);

        // Set today's date as the minimum date
        const today = new Date().toISOString().split('T')[0];
        startDateInput.setAttribute('min', today);
        endDateInput.setAttribute('min', today);

        function calculateTotalPrice() {
            const startDate = startDateInput.value ? new Date(startDateInput.value) : null;
            const endDate = endDateInput.value ? new Date(endDateInput.value) : null;

            if (startDate && endDate && startDate <= endDate) {
                const days = Math.floor((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
                const totalPrice = days * propertyPrice;
                totalPriceInput.value = totalPrice.toFixed(2);
            } else {
                totalPriceInput.value = ''; // Clear total price if invalid dates
            }
        }

        // Event listener to adjust min date for end date based on start date
        startDateInput.addEventListener('change', function () {
            const startDate = startDateInput.value;
            if (startDate) {
                endDateInput.setAttribute('min', startDate); // Set end date min to start date
            }
            calculateTotalPrice(); // Update price calculation
        });

        // Recalculate total price when end date changes
        endDateInput.addEventListener('change', calculateTotalPrice);
    });
</script>


@endsection