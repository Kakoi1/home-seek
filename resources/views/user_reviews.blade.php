@extends('layouts.app')

@section('content')
<div class="container">
    <h2 style="text-align:center;">My Accommodation Reviews</h2>

    <!-- Custom Tabs for Pending and Past Reviews -->
    <div class="tabs">
        <button class="tab active" data-tab="pending-reviews">Pending Reviews</button>
        <button class="tab" data-tab="past-reviews">Past Reviews</button>
    </div>

    <div class="tab-content">
        <!-- Pending Reviews Tab Content -->
        <div id="pending-reviews" class="tab-pane active">
            <h3>Pending Reviews</h3>
            @if($pendingReviews->isEmpty())
                <p>No Accommodation awaiting review.</p>
            @else
                <div class="review-list">
                    @foreach($pendingReviews as $review)
                        <div class="review-item">
                            <h5>{{ $review->dorm->name }}</h5>
                            <p>Located at: {{ $review->dorm->address }}</p>
                            <a href="{{ route('reviews.store', Crypt::encrypt($review->id)) }}" class="btn">Leave a Review</a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Past Reviews Tab Content -->
        <div id="past-reviews" class="tab-pane">
            <h3>My Past Reviews</h3>
            @if($pastReviews->isEmpty())
                <p>You haven't reviewed any Accommodations yet.</p>
            @else
                <div class="review-list">
                    @foreach($pastReviews as $review)
                        <div class="review-item">
                            <h5>{{ $review->dorm->name }}</h5>
                            <p>Located at: {{ $review->dorm->address }}</p>
                            <div class="rating">
                                Rating:
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="star {{ $i <= $review->rating ? 'filled' : '' }}">★</span>
                                @endfor
                            </div>
                            <p><strong>Comments:</strong> {{ $review->comments }}</p>
                            <p><small>Reviewed on: {{ $review->updated_at->format('Y-m-d H:i') }}</small></p>
                            <a href="{{ route('reviews.store', $review->id) }}" class="btn">Edit Review</a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    /* Tab Buttons */
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

    .tab.active {
        background: linear-gradient(to left, rgba(11, 136, 147, 0.712), rgba(54, 0, 51, 0.74));
        color: white;
        transform: translateY(-5px);
    }

    /* Tab Content */
    .tab-content {
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 5px;
    }

    .tab-pane {
        display: none;
    }

    .tab-pane.active {
        display: block;
    }

    /* Review List and Items */
    .review-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .review-item {
        padding: 15px;
        background-color: #f9f9f9;
        border: 1px solid #eee;
        border-radius: 5px;
    }

    .review-item h5 {
        margin-bottom: 10px;
    }

    .btn {
        padding: 8px 12px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #45a049;
    }

    /* Star Rating */
    .rating .star {
        color: lightgray;
        font-size: 1.5rem;
    }

    .rating .star.filled {
        color: gold;
    }
</style>

<!-- Custom JavaScript for Tabs -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabButtons = document.querySelectorAll('.tab');
        const tabPanes = document.querySelectorAll('.tab-pane');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons
                tabButtons.forEach(btn => btn.classList.remove('active'));

                // Add active class to the clicked button
                button.classList.add('active');

                // Hide all tab panes
                tabPanes.forEach(pane => pane.classList.remove('active'));

                // Show the related tab pane
                const target = button.getAttribute('data-tab');
                document.getElementById(target).classList.add('active');
            });
        });
    });
</script>
@endsection