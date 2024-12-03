@extends('layouts.app') <!-- Assuming a base layout exists -->
<style>
    .card {
        border: transparent !important;
    }
</style>
@section('content')
<div class="container">
    <h1 class="mb-4">Cash Out</h1>

    <!-- Wallet Summary -->
    <div class="card mb-4">
        <div class="card-body">
            <h4>Wallet Balance: ₱<span id="walletBalance">{{ number_format($walletBalance, 2) }}</span></h4>
        </div>
    </div>

    <!-- Cash Out Form -->
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="mb-3">Request Cash Out</h4>
            <form action="{{ route('cashout.submit') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="amount">Amount to Cash Out</label>
                    <input type="number" step="0.01" min="100" name="amount" id="amount"
                        class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}" required>
                    <small class="form-text text-muted">Minimum cash out amount: ₱100</small>
                    @error('amount')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Payment Method -->
                <div class="form-group mb-3">
                    <label for="paymentMethod">Select Method</label>
                    <select name="payment_method" id="paymentMethod"
                        class="form-control @error('payment_method') is-invalid @enderror" required>
                        <option value="">-- Select Method --</option>
                        <option value="gcash" {{ old('payment_method') == 'gcash' ? 'selected' : '' }}>GCash</option>
                        <option value="paymaya" {{ old('payment_method') == 'paymaya' ? 'selected' : '' }}>PayMaya
                        </option>
                        <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>
                            Bank Transfer</option>
                    </select>
                    @error('payment_method')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Account Details -->
                <div class="form-group mb-3">
                    <label for="accountDetails">Account Details</label>
                    <input type="text" name="account_details" id="accountDetails"
                        class="form-control @error('account_details') is-invalid @enderror"
                        value="{{ old('account_details') }}" placeholder="Enter GCash/PayMaya/Bank Account Number"
                        required>
                    @error('account_details')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Submit Cash Out Request</button>
            </form>
        </div>
    </div>
    <!-- Recent Cash Out Transactions -->
    <div class="card">
        <div class="card-body">
            <hr>
            <h4 class="mb-3">Recent Cash Out Transactions</h4>
            @if($transactions->isNotEmpty())
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Method</th>
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
                                <td>{{ ucfirst($transaction->method) }}</td>
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
<script>
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