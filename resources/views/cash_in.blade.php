@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Cash In</h2>

    <!-- Amount Input -->
    <form id="cashInForm">
        @csrf
        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" class="form-control" name="amount" id="amount" placeholder="Enter amount" required
                min="1">
        </div>
        <button type="button" class="btn btn-primary" id="createPaymentIntent">Proceed to Payment</button>
    </form>

    <!-- Loading Screen -->
    <div id="loading" class="text-center" style="display:none; margin-top:20px;">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <p>Please wait...</p>
    </div>

    <!-- Card Details Overlay -->
    <div id="cardDetailsOverlay" class="overlr" style="display:none;">
        <div class="overlr-content">
            <h4>Enter Payment Details</h4>
            <div id="card-element"></div>
            <button id="submitPayment" class="btn btn-success mt-3">Submit Payment</button>
            <button id="closeOverlay" class="btn btn-secondary mt-3">Cancel</button>
        </div>
    </div>
</div>

<!-- CSS for Overlay -->
<style>
    .overlr {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .overlr-content {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        width: 90%;
        max-width: 500px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .overlr-content h4 {
        margin-bottom: 20px;
    }
</style>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const stripe = Stripe("{{ config('services.stripe.key') }}");
        let clientSecret;
        let cardElement;
        let elements;

        const loadingDiv = document.getElementById('loading');
        const cardDetailsOverlay = document.getElementById('cardDetailsOverlay');

        document.getElementById('createPaymentIntent').addEventListener('click', async () => {
            const amount = document.getElementById('amount').value;

            if (amount <= 0) {
                Swal.fire('Error', 'Enter a valid amount!', 'error');
                return;
            }

            // Show loading screen
            loadingDiv.style.display = 'block';

            // Create Payment Intent
            const response = await fetch("{{ route('wallet.cashInProcess') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ amount }),
            });

            const data = await response.json();
            clientSecret = data.client_secret;

            // Hide loading and show card details overlay
            loadingDiv.style.display = 'none';
            cardDetailsOverlay.style.display = 'flex';

            // Initialize Stripe Elements only once
            if (!elements) {
                elements = stripe.elements();
                cardElement = elements.create('card');
                cardElement.mount('#card-element');
            }
        });

        document.getElementById('submitPayment').addEventListener('click', async () => {
            if (!cardElement) {
                Swal.fire('Error', 'Payment method not initialized. Please try again.', 'error');
                return;
            }

            // Show loading screen
            loadingDiv.style.display = 'block';
            cardDetailsOverlay.style.display = 'none';

            // Confirm Payment
            const { paymentIntent, error } = await stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: cardElement,
                },
            });

            if (error) {
                loadingDiv.style.display = 'none'; // Hide loading on error
                Swal.fire('Payment Failed', error.message, 'error');
            } else {
                // Confirm Cash-In
                const confirmResponse = await fetch("{{ route('wallet.cashInConfirm') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        amount: paymentIntent.amount / 100,
                        payment_id: paymentIntent.id,  // Send payment_id to backend
                    }),
                });

                if (confirmResponse.ok) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Payment successful! Wallet balance has been updated.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    loadingDiv.style.display = 'none';
                    Swal.fire('Error', 'Failed to update wallet balance. Please contact support.', 'error');
                }
            }
        });

        document.getElementById('closeOverlay').addEventListener('click', () => {
            cardDetailsOverlay.style.display = 'none'; // Hide overlay
        });
    });
</script>
@endsection