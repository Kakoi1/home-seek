@extends('layouts.app')

@section('title', 'Rent Form')

@section('content')

<form id="checkForm" action="/check-form" method="post">
    @csrf
    <input type="hidden" name="roomId" value="{{ $room->id }}">
    <input type="hidden" name="dormId" value="{{ $dorm->id }}">
</form>

<div class="rent-form">

    <h2>Rent Form for {{ $room->number }} - {{ $dorm->name }}</h2>
    <form id="rent-form" action="{{ route('rent-form.store') }}" method="POST">
        @csrf
        <input type="hidden" name="room_id" value="{{ $room->id }}">
        <input type="hidden" name="dorm_id" value="{{ $dorm->id }}">
        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="duration">Duration (Months)</label>
            <input type="number" name="duration" class="form-control" required min="1">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
    document.getElementById('rent-form').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent default form submission

        const form = document.getElementById('rent-form');
        const formData = new FormData(form);


        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Success',
                        text: 'Your rent form has been submitted successfully.',
                        icon: 'success',
                        confirmButtonText: 'Close'
                    }).then(() => {
                        window.close(); // Close the tab/window
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message || 'An error occurred while submitting the form.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'An unexpected error occurred.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });



    });
    document.addEventListener('DOMContentLoaded', function () {

        const checkForm = document.getElementById('checkForm');
        const checkData = new FormData(checkForm);

        fetch(checkForm.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: checkData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Error',
                        text: 'You already submited a response',
                        icon: 'error',
                        confirmButtonText: 'Close'
                    }).then(() => {
                        window.close(); // Close the tab/window
                    });
                }
            })

    });

</script>
@endsection