@extends('layouts.app')

@section('title', 'Pending Cash-Out Requests')

@section('content')
<div class="container">
    <h2 class="text-center">Pending Cash-Out Requests</h2>

    @if($pendingRequests->count() > 0)
        <table class="table table-striped" id="pendingRequestsTable">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Details</th>
                    <th>Requested At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @foreach($pendingRequests as $request)
                    <tr class="request-row">
                        <td>{{ $request->user->name }}</td>
                        <td>₱{{ number_format($request->amount, 2) }}</td>
                        <td>{{ ucfirst($request->method) }}</td>
                        <td>{{ ucfirst($request->details) }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($request->created_at)->format('M j, Y') }}<br>
                            <small>{{ \Carbon\Carbon::parse($request->created_at)->format('h:i A') }}</small>
                        </td>
                        <td>
                            <button class="btn btn-success btn-sm"
                                onclick="confirmAction('approve', {{ $request->id }})">Approve</button>
                            <button class="btn btn-danger btn-sm"
                                onclick="confirmAction('reject', {{ $request->id }})">Reject</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Controls -->
        <div id="paginationControls" class="mt-3">
            <button class="btn btn-primary" id="previousBtn" onclick="changePages('prev')">Previous</button>
            <span id="currentPageNumber">Page 1</span>
            <button class="btn btn-primary" id="nextBtn" onclick="changePages('next')">Next</button>
        </div>
    @else
        <p>No pending cash-out requests at the moment.</p>
    @endif
</div>

<!-- JavaScript for SweetAlert -->
<script>
    // Set the number of rows per page
    const rowsPerPage = 8;
    const allRows = document.querySelectorAll('.request-row');
    const totalRows = allRows.length;
    const totalPages = Math.ceil(totalRows / rowsPerPage); // Total pages
    let currPage = 1;

    // Function to change pages
    function changePages(direction) {
        if (direction === 'next' && currPage < totalPages) {
            currPage++;
        } else if (direction === 'prev' && currPage > 1) {
            currPage--;
        }

        showPage(currPage);
    }

    // Function to display the correct page of rows
    function showPage(page) {
        const startIdx = (page - 1) * rowsPerPage;
        const endIdx = startIdx + rowsPerPage;

        // Hide all rows
        allRows.forEach(row => row.style.display = 'none');

        // Show the rows for the current page
        for (let i = startIdx; i < endIdx; i++) {
            if (allRows[i]) {
                allRows[i].style.display = 'table-row';
            }
        }

        // Update pagination controls
        updatePaginationControler();
    }

    // Function to update pagination controls (Previous/Next)
    function updatePaginationControler() {
        // Update current page display
        document.getElementById('currentPageNumber').textContent = `Page ${currPage}`;

        // Disable Previous button if on the first page or if totalRows <= rowsPerPage
        if (currPage === 1 || totalRows <= rowsPerPage) {
            document.getElementById('previousBtn').disabled = true;
        } else {
            document.getElementById('previousBtn').disabled = false;
        }

        // Disable Next button if on the last page or if totalRows <= rowsPerPage
        if (currPage === totalPages || totalRows <= rowsPerPage) {
            document.getElementById('nextBtn').disabled = true;
        } else {
            document.getElementById('nextBtn').disabled = false;
        }
    }

    // Initial Page Load
    window.onload = function () {
        showPage(1); // Show the first page when the page loads
    };

    // SweetAlert action handling (unchanged from your existing code)
    function confirmAction(action, id) {
        if (action === 'approve') {
            // Approve logic
            Swal.fire({
                title: `Are you sure?`,
                text: `Do you want to approve this request?`,
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Yes, approve',
            }).then((result) => {
                if (result.isConfirmed) {
                    submitForm('{{ route("admin.cashout.approve", ":id") }}'.replace(':id', id));
                }
            });
        } else if (action === 'reject') {
            // Reject logic with reasons
            Swal.fire({
                title: 'Reject Request',
                html: `
                <p>Please select a reason for rejection:</p>
                <div style="text-align: left;">
                    <label>
                        <input type="radio" name="reason" value="Insufficient information" required>
                        Insufficient information
                    </label><br>
                    <label>
                        <input type="radio" name="reason" value="Suspected fraud">
                        Suspected fraud
                    </label><br>
                    <label>
                        <input type="radio" name="reason" value="Other">
                        Other
                    </label>
                    <textarea id="otherReason" style="display:none; margin-top: 10px;" rows="3" placeholder="Enter your reason here..." class="form-control"></textarea>
                </div>
            `,
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Reject',
                preConfirm: () => {
                    // Get the selected reason
                    const selectedReason = document.querySelector('input[name="reason"]:checked');
                    const otherReason = document.getElementById('otherReason').value;

                    if (!selectedReason) {
                        Swal.showValidationMessage('Please select a reason');
                        return false;
                    }

                    return selectedReason.value === 'Other' ? otherReason : selectedReason.value;
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    const reason = result.value;
                    submitForm('{{ route("admin.cashout.reject", ":id") }}'.replace(':id', id), reason);
                }
            });

            // Show/hide the text area for "Other" reason
            document.addEventListener('change', (event) => {
                if (event.target.name === 'reason') {
                    const otherReason = document.getElementById('otherReason');
                    otherReason.style.display = event.target.value === 'Other' ? 'block' : 'none';
                }
            });
        }
    }

    function submitForm(url, reason = null) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = url;

        const csrfField = document.createElement('input');
        csrfField.type = 'hidden';
        csrfField.name = '_token';
        csrfField.value = '{{ csrf_token() }}';

        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PATCH';

        form.appendChild(csrfField);
        form.appendChild(methodField);

        if (reason) {
            const reasonField = document.createElement('input');
            reasonField.type = 'hidden';
            reasonField.name = 'reason';
            reasonField.value = reason;
            form.appendChild(reasonField);
        }

        document.body.appendChild(form);
        form.submit();
    }

</script>
@endsection