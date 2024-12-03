@extends('layouts.app')

@section('content')
<style>
    .card {
        border: transparent;
    }
</style>
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
    <br>
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
    <div class="card">
        <div class="card-body">
            <hr>
            <h4 class="mb-3">Recent Cash In Transactions</h4>
            @if($transactions->isNotEmpty())
                <table class="table table-striped" id="transactionsTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="transactionsBody">
                        @foreach($transactions as $transaction)
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($transaction->created_at)->format('M j, Y') }}<br>
                                    <small>{{ \Carbon\Carbon::parse($transaction->created_at)->format('h:i A') }}</small>
                                </td>
                                <td>₱{{ number_format($transaction->amount, 2) }}</td>
                                <td>
                                    @if($transaction->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($transaction->status === 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div id="paginationCont" class="mt-3 d-flex justify-content-center"></div>
            @else
                <p>No cash out transactions found.</p>
            @endif
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

    document.addEventListener("DOMContentLoaded", function () {
        const rowsPerPage = 5; // Number of rows per page
        const tbody = document.getElementById("transactionsBody");
        const paginationControls = document.getElementById("paginationCont");
        const rows = Array.from(tbody.querySelectorAll("tr"));
        const totalRows = rows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage);
        let currentPage = 1;

        // Function to display rows for the current page
        function displayPage(page) {
            // Hide all rows
            rows.forEach(row => (row.style.display = "none"));

            // Calculate start and end indexes
            const startIndex = (page - 1) * rowsPerPage;
            const endIndex = Math.min(startIndex + rowsPerPage, totalRows);

            // Show rows for the current page
            for (let i = startIndex; i < endIndex; i++) {
                rows[i].style.display = "table-row";
            }

            // Update pagination controls
            updatePaginationControls(page);
        }

        // Function to update pagination controls
        function updatePaginationControls(page) {
            paginationControls.innerHTML = "";

            // Create "Previous" button
            const prevButton = document.createElement("button");
            prevButton.textContent = "Previous";
            prevButton.classList.add("btn", "btn-sm", "mx-1", "btn-primary");
            prevButton.disabled = page === 1; // Disable if on the first page
            prevButton.addEventListener("click", () => {
                if (currentPage > 1) {
                    currentPage--;
                    displayPage(currentPage);
                }
            });
            paginationControls.appendChild(prevButton);

            // Display the current page number
            const pageIndicator = document.createElement("span");
            pageIndicator.textContent = `Page ${page} of ${totalPages}`;
            pageIndicator.classList.add("mx-2");
            paginationControls.appendChild(pageIndicator);

            // Create "Next" button
            const nextButton = document.createElement("button");
            nextButton.textContent = "Next";
            nextButton.classList.add("btn", "btn-sm", "mx-1", "btn-primary");
            nextButton.disabled = page === totalPages; // Disable if on the last page
            nextButton.addEventListener("click", () => {
                if (currentPage < totalPages) {
                    currentPage++;
                    displayPage(currentPage);
                }
            });
            paginationControls.appendChild(nextButton);
        }

        // Initial display of page 1
        if (totalRows > 0) {
            displayPage(1);
        }
    });

</script>
@endsection