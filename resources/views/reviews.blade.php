@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Review Property: {{ $review->dorm->name }}</h2>

    <!-- Review Form -->
    <form id="reviewForm" action="{{ route('reviews.submit', $review->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <!-- Rating Section (5-Star) -->
        <div class="form-group">
            <label for="rating">Rate this property:</label>
            <div class="star-rating">
                <input type="radio" id="star5" name="rating" value="5" {{ $review->rating == 5 ? 'checked' : '' }} />
                <label for="star5" title="5 stars">☆</label>
                <input type="radio" id="star4" name="rating" value="4" {{ $review->rating == 4 ? 'checked' : '' }} />
                <label for="star4" title="4 stars">☆</label>
                <input type="radio" id="star3" name="rating" value="3" {{ $review->rating == 3 ? 'checked' : '' }} />
                <label for="star3" title="3 stars">☆</label>
                <input type="radio" id="star2" name="rating" value="2" {{ $review->rating == 2 ? 'checked' : '' }} />
                <label for="star2" title="2 stars">☆</label>
                <input type="radio" id="star1" name="rating" value="1" {{ $review->rating == 1 ? 'checked' : '' }} />
                <label for="star1" title="1 star">☆</label>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="form-group">
            <label for="comments">Leave your comments:</label>
            <textarea name="comments" id="comments" class="form-control" rows="5">{{ $review->comments }}</textarea>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Submit Review</button>
    </form>
</div>

<!-- Include some custom CSS for the star rating -->
<style>
    .star-rating {
        direction: rtl;
        font-size: 2rem;
        display: inline-block;
    }

    .star-rating input {
        display: none;
    }

    .star-rating label {
        color: lightgray;
        cursor: pointer;
    }

    .star-rating input:checked~label {
        color: gold;
    }

    .star-rating label:hover,
    .star-rating label:hover~label {
        color: gold;
    }
</style>
<script>
    document.getElementById('reviewForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission

        // Get form data
        const formData = new FormData(this);

        // Send AJAX request
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // SweetAlert for success
                    Swal.fire({
                        title: 'Success!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'OK',
                    }).then(() => {
                        // Redirect to home page after confirmation
                        window.location.href = '/home';
                    });
                } else {
                    // SweetAlert for error
                    Swal.fire({
                        title: 'Error!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'OK',
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // SweetAlert for server error
                Swal.fire({
                    title: 'Oops!',
                    text: 'An error occurred. Please try again later.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                });
            });
    });

</script>
@endsection