{{-- resources/views/rentform/extend_rent.blade.php --}}

@extends('layouts.app')

@section('title', 'Extend Rent')

@section('content')

<!-- Embedded styles for the form -->
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
<br>
<div class="rent-form-container">
    <h2>
        {{ isset($extend) ? $rentForm->room->number . '-' . $rentForm->room->dorm->name : $rentForm->room->number . '-' . $rentForm->room->dorm->name }}
    </h2>

    <form id="extendForm">
        @csrf
        @if (isset($extend))
            @method('PATCH')
        @endif
        <!-- Rental Term Selection -->
        <div class="term-selection">
            <label for="term">Choose Extension Term:</label>
            <label>
                <input type="radio" name="term" value="short_term" id="short_term" required {{ (isset($extend) && $extend->term == 'short_term') ? 'checked' : '' }}> Short Term (Max 30 Days)
            </label>
            <label>
                <input type="radio" name="term" value="long_term" id="long_term" required {{ (isset($extend) && $extend->term == 'long_term') ? 'checked' : '' }}> Long Term (Months)
            </label>
        </div>

        <!-- Start Date (Read-only) -->
        <div class="form-group">
            <label for="start_date">Current End Date</label>
            <input type="date" id="start_date" onchange="valiDate()" name="start_date"
                value="{{ $rentForm->end_date->format('Y-m-d') }}" readonly>
        </div>
        <input type="hidden" name="form_id" value="{{ $rentForm->id }}">

        <!-- End Date (for short-term extension) -->
        <div class="form-group" id="end_date_group"
            style="display: {{ (isset($extend) && $extend->term == 'short_term') ? 'block' : 'none' }};">
            <label for="end_date">New End Date (for Short Term)</label>
            <input type="date" id="end_date" name="end_date"
                value="{{ isset($extend) && $extend->term == 'short_term' ? $extend->new_end_date : old('new_end_date')}}">
        </div>

        <!-- Duration (for long-term extension) -->
        <div class="form-group" id="duration_group"
            style="display: {{ (isset($extend) && $extend->term == 'long_term') ? 'block' : 'none' }};">
            <label for="duration">Duration (in months)</label>
            <input type="number" id="duration" name="duration" min="1"
                value="{{ isset($extend) && $extend->term == 'long_term' ? $extend->new_duration : '' }}">
        </div>

        <!-- Price and Date Information -->
        <div class="infoCont" id="price_info"></div>
        <br>
        <input type="hidden" name="total_price" id="tprice"
            value="{{isset($extend) ? $extend->t_price : old('t_price')}}">

        <button type="submit" class="btn btn-primary">Submit Extension Request</button>
    </form>
</div>

<!-- Include jQuery if not already included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Script for dynamic form behavior -->
<script>
    function valiDate() {
        const selectedStartDate = document.getElementById('start_date').value;

        if (selectedStartDate) {
            document.getElementById('end_date').setAttribute('min', selectedStartDate);
        }
    }

    $(document).ready(function () {
        const shortTermRadio = $('#short_term');
        const longTermRadio = $('#long_term');
        const startDateInput = $('#start_date');
        const endDateInput = $('#end_date');
        const durationInput = $('#duration');
        const endDateGroup = $('#end_date_group');
        const durationGroup = $('#duration_group');
        const priceInfoDiv = $('#price_info');
        const tpriceInput = $('#tprice');

        const priceDay = parseFloat({{ $rentForm->room->dorm->price_day }});
        const priceMonth = parseFloat({{ $rentForm->room->dorm->price }});

        window.calculateTotal = function () {
            let total = 0;
            let infoText = '';

            if (shortTermRadio.is(':checked')) {
                const currentEndDate = new Date(startDateInput.val());
                const newEndDate = new Date(endDateInput.val());
                const differenceInTime = newEndDate.getTime() - currentEndDate.getTime();
                const numberOfDays = Math.ceil(differenceInTime / (1000 * 3600 * 24));

                const minEndDate = new Date(currentEndDate);
                minEndDate.setDate(minEndDate.getDate() + 1);
                const formattedMinDate = minEndDate.toISOString().split('T')[0];
                endDateInput.attr('min', formattedMinDate);

                if (numberOfDays <= 0) {
                    tpriceInput.val('');
                    priceInfoDiv.text('New end date must be after the current end date.');
                    return;
                }

                total = priceDay * numberOfDays;
                infoText = `You are extending your stay by ${numberOfDays} day(s).<br> Price per day: ₱${priceDay}. <br> Total Price: ₱${total}`;
            } else if (longTermRadio.is(':checked') && durationInput.val()) {
                const durationMonths = parseInt(durationInput.val());

                if (durationMonths <= 0) {
                    tpriceInput.val('');
                    priceInfoDiv.text('Duration must be at least 1 month.');
                    return;
                }

                total = priceMonth * durationMonths;
                const newEndDate = new Date(startDateInput.val());
                newEndDate.setMonth(newEndDate.getMonth() + durationMonths);

                infoText = `Your new end date will be ${newEndDate.toISOString().split('T')[0]}.<br> Price per month: ₱${priceMonth}. <br> Total Price: ₱${total}`;
            }

            tpriceInput.val(total);
            priceInfoDiv.html(infoText);
        }

        window.handleTermChange = function () {
            if (shortTermRadio.is(':checked')) {
                endDateGroup.show();
                durationGroup.hide();
                durationInput.val('');
                durationInput.removeAttr('required');
                endDateInput.attr('required', true);
                calculateTotal();
            } else if (longTermRadio.is(':checked')) {
                durationInput.attr('required', true);
                endDateInput.removeAttr('required');
                endDateGroup.hide();
                durationGroup.show();
                endDateInput.val('');
                calculateTotal();
            } else {
                endDateGroup.hide();
                durationGroup.hide();
                endDateInput.val('');
                durationInput.val('');
            }
            priceInfoDiv.text('');
            tpriceInput.val('');
        }
        if ('{{isset($extend)}}') {
            window.calculateTotal();
            window.handleTermChange();
        }

        $(window).on("load", calculateTotal);

        shortTermRadio.on('change', handleTermChange);
        longTermRadio.on('change', handleTermChange);
        endDateInput.on('change', calculateTotal);
        durationInput.on('input', calculateTotal);

        // Initialize form state
        handleTermChange();
        $('#extendForm').on('submit', function (e) {
            e.preventDefault(); // Prevent the form from submitting normally

            const formData = $(this).serialize(); // Get form data

            $.ajax({
                url: "{{isset($extend) ? route('extendUpdate', $extend->id) : route('extend.submit') }}",
                method: "POST",
                data: formData,
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Success!",
                            html: response.message,
                            timer: 1500,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                                const timer = Swal.getPopup().querySelector("b");
                                timerInterval = setInterval(() => {
                                    timer.textContent = `${Swal.getTimerLeft()}`;
                                }, 100);
                            },
                            willClose: () => {
                                clearInterval(timerInterval);
                            }
                        }).then((result) => {
                            /* Read more about handling dismissals below */
                            if (result.dismiss === Swal.DismissReason.timer) {
                                location.href = '{{route('user.rentForms')}}'
                            }
                        });
                        // $('#price_info').html(`Extension successful! Your new end date is ${response.new_end_date}`);
                    }
                },
                error: function (xhr) {
                    // Handle validation errors or other issues
                    const errors = xhr.responseJSON.errors;
                    if (errors) {
                        let errorMessage = '';
                        for (const key in errors) {
                            errorMessage += errors[key] + '\n';
                        }
                        alert(errorMessage); // Show validation errors
                    }
                }
            });
        });
    });

</script>


@endsection