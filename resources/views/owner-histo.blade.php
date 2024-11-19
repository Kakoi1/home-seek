@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Owner's History</h1>

    <!-- Custom Tabs for Navigation -->
    <div class="tab-navigation">
        <button class="tab-button active" onclick="openTab(event, 'tenants')">Past Tenants</button>
        <button class="tab-button" onclick="openTab(event, 'bookings')">Bookings</button>
        <button class="tab-button" onclick="openTab(event, 'payments')">Payments</button>
    </div>
    <div class="tab-content">
        <!-- Past Tenants Tab -->
        <section id="Past-Tenant">
            <div id="tenants" class="tab-pane active">
                <h3>Past Tenants</h3>
                <input type="text" class="form-control" id="tenantsSearch" placeholder="Search tenants...">

                <table class="custom-table" id="tenantsTable">
                    <thead>
                        <tr>
                            <th>Tenant Name</th>
                            <th>Accomodation Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                        </tr>
                    </thead>

                    <tbody id="tenantsTableBody">
                        @forelse ($pastTenants as $tenant)
                                                @php
                                                    $hashedData = Crypt::encrypt($tenant->dorm->id);
                                                @endphp
                                                <tr>
                                                    <td> <strong><a onclick="openUserPopup({{ $tenant->user->id }})"
                                                                href="javascript: void(0)">{{ ucfirst($tenant->user->name) }}</a></strong></td>
                                                    <td><strong><a
                                                                href="{{route('dorms.posted', $hashedData)}}">{{  ucfirst($tenant->dorm->name) }}</a></strong>
                                                    </td>
                                                    <td>{{ $tenant->start_date }}</td>
                                                    <td>{{ $tenant->end_date }}</td>
                                                </tr>
                        @empty
                            <tr>
                                <td colspan="4">No past tenants found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div id="tenantsTablePagination">
                    <button class="pagination-button" id="tenantsPrevButton">Previous</button>
                    <span id="tenantsPageText">Page 1</span>
                    <button class="pagination-button" id="tenantsNextButton">Next</button>
                </div>
            </div>
        </section>
        <!-- Bookings Tab with Status Filter -->
        <section id="booking">
            <div id="bookings" class="tab-pane">
                <h3>Bookings</h3>
                <!-- Booking Status Filter -->
                <div>
                    <label for="bookingFilter">Filter by Status:</label>
                    <select class="form-control" id="bookingFilter">
                        <option value="all">All</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Canceled</option>
                    </select>
                    <br>
                    <input type="text" class="form-control" id="bookingsSearch" placeholder="Search bookings...">
                </div>
                <table class="custom-table" id="bookingsTable">
                    <thead>
                        <tr>
                            <th>Tenant Name</th>
                            <th>Accomodation Name</th>
                            <th>Booking Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="bookingsTableBody">
                        @forelse ($bookings as $booking)
                            <tr class="booking-row" data-status="{{ $booking->status }}">
                                <td><strong><a onclick="openUserPopup({{ $booking->user->id }})"
                                            href="javascript: void(0)">{{ ucfirst($booking->user->name) }}</a></strong></td>
                                <td>{{  ucfirst($booking->dorm->name) }}</td>
                                <td>{{ $booking->created_at->format('F d, Y') }}</td>
                                <td class="{{ 'status-' . $booking->status }}">
                                    {{ ucfirst($booking->status) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">No bookings found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div id="bookingsTablePagination">
                    <button class="pagination-button" id="bookingsPrevButton">Previous</button>
                    <span id="bookingsPageText">Page 1</span>
                    <button class="pagination-button" id="bookingsNextButton">Next</button>
                </div>

            </div>
        </section>
        <!-- Payments Tab -->
        <div id="payments" class="tab-pane">
            <h3>Paid Payments</h3>
            <label for="monthFilter">Select Month:</label>
            <div>
                <input type="month" class="form-control" id="monthFilter">
                <br>
                <input type="text" class="form-control" id="paymentsSearch" placeholder="Search payments...">
            </div>
            <table class="custom-table" id="paymentsTable">
                <thead>
                    <tr>
                        <th>Tenant Name</th>
                        <th>Accommodation Name</th>
                        <th>Proof of Payment</th>
                        <th>Amount</th>
                        <th>Billing Date</th>
                        <th>Paid Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="paymentsTableBody">
                    @forelse ($payments as $payment)
                                        @php
                                            $hashedDatas = Crypt::encrypt($payment->rentForm->dorm->id);
                                        @endphp
                                        <tr class="payment-row" data-date="{{ \Carbon\Carbon::parse($payment->paid_at)->format('Y-m') }}"
                                            data-status="{{ $payment->status }}">
                                            <td><strong><a onclick="openUserPopup({{ $payment->rentForm->user->id }})"
                                                        href="javascript: void(0)">{{ ucfirst($payment->rentForm->dorm->name) }}</a></strong>
                                            </td>
                                            <td><strong><a
                                                        href="{{route('dorms.posted', $hashedDatas)}}">{{  ucfirst($payment->rentForm->dorm->name) }}</a></strong>
                                            </td>
                                            <td><a target='_blank'
                                                    href="{{'https://storage.googleapis.com/homeseek-profile-image/' . $payment->reference}}">Image</a>
                                            </td>
                                            <td>${{ number_format($payment->amount, 2) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($payment->billing_date)->format('F d, Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($payment->paid_at)->format('M j, Y') }}</td>
                                            <td class="{{ $payment->status == 'paid' ? 'status-paid' : 'status-unpaid' }}">
                                                {{ ucfirst($payment->status) }}
                                            </td>
                                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No payment history found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div id="paymentsTablePagination">
                <button class="pagination-button" id="paymentsPrevButton">Previous</button>
                <span id="paymentsPageText">Page 1</span>
                <button class="pagination-button" id="paymentsNextButton">Next</button>
            </div>
        </div>
    </div>
</div>


<!-- Custom CSS -->
<style>
    .tab-navigation {
        display: flex;
        margin-bottom: 20px;
    }

    .tab-button {
        background-color: #f1f1f1;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        font-size: 16px;
        margin-right: 5px;
        transition: background-color 0.3s ease;
    }

    .tab-button.active,
    .tab-button:hover {
        background: linear-gradient(to left, rgba(11, 136, 147, 0.712), rgba(54, 0, 51, 0.74));
        color: white;
        font-weight: bold;
    }

    .tab-pane {
        display: none;
    }

    .tab-pane.active {
        display: block;
        animation: fadeEffect 0.3s ease;
    }

    @keyframes fadeEffect {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th,
    th:last-child {
        background: none;
        color: black;
        border: none;
    }

    .custom-table td {
        padding: 10px;
        border: none;
        text-align: left;

    }

    .status-confirmed {
        color: green;
    }

    .status-pending {
        color: orange;
    }

    .status-paid {
        color: green;
    }

    .status-unpaid {
        color: red;
    }

    #tableContainer {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        /* Add space below the table */
    }

    #paginationDiv {
        display: flex;
        justify-content: center;
        /* Center the pagination controls */
        align-items: center;
        gap: 20px;
        /* Space between buttons */
        padding: 10px 0;
    }

    .pagination-button {
        padding: 5px 8px;
        cursor: pointer;
        border-radius: 8px;
        background-color: #0d6efd;
        color: white;
    }

    .pagination-button:disabled {
        cursor: not-allowed;
        opacity: 0.5;
        background-color: grey;
        color: red;
    }

    .pagination-button.active {
        font-weight: bold;
    }
</style>

<!-- Custom JavaScript -->
<script>
    function openTab(event, tabName) {
        const tabPanes = document.querySelectorAll(".tab-pane");
        const tabButtons = document.querySelectorAll(".tab-button");

        tabPanes.forEach(pane => pane.classList.remove("active"));
        tabButtons.forEach(button => button.classList.remove("active"));

        document.getElementById(tabName).classList.add("active");
        event.currentTarget.classList.add("active");
    }

    // Booking Filter Function
    // Tenants Table: Pagination and Filter
    // Pagination class

    class Pagination {
        constructor(tableBody, paginationDiv, pageSize, prevButton, nextButton, pageText) {
            this.tableBody = tableBody;
            this.paginationDiv = paginationDiv;
            this.pageSize = pageSize;
            this.prevButton = prevButton;
            this.nextButton = nextButton;
            this.pageText = pageText;
            this.currentPage = 1;
            this.filteredRows = Array.from(tableBody.rows); // Store rows after filtering
            this.totalPages = Math.ceil(this.filteredRows.length / this.pageSize); // Total pages based on filtered rows
            this.renderPagination();
            this.update(); // Ensure we start by displaying rows for page 1
        }

        renderPagination() {
            // Update the page text (e.g., "Page 1 of 5")
            this.pageText.textContent = `Page ${this.currentPage} of ${this.totalPages}`;

            // Enable/Disable the "Previous" and "Next" buttons
            this.prevButton.disabled = this.currentPage === 1;
            this.nextButton.disabled = this.currentPage === this.totalPages;
        }

        update() {
            const start = (this.currentPage - 1) * this.pageSize;
            const end = start + this.pageSize;

            // Hide all rows initially
            this.tableBody.querySelectorAll('tr').forEach(row => row.style.display = 'none');

            // Show only the rows for the current page
            this.filteredRows.slice(start, end).forEach(row => row.style.display = '');

            // Update pagination text dynamically
            this.renderPagination();
        }

        // Update the pagination based on filtered rows
        updatePaginationForFilteredRows(filteredRows) {
            this.filteredRows = filteredRows; // Store filtered rows
            this.totalPages = Math.ceil(filteredRows.length / this.pageSize); // Recalculate total pages
            this.currentPage = 1; // Always start at the first page after filtering
            this.update(); // Update the displayed rows to match the filtered data
        }
    }

    const paginationOptions = {
        tenants: {
            tableBody: '#tenantsTableBody',
            paginationDiv: '#tenantsTablePagination',
            filterInput: '#tenantsSearch',
            prevButton: '#tenantsPrevButton',
            nextButton: '#tenantsNextButton',
            pageText: '#tenantsPageText',
            pageSize: 5
        },
        bookings: {
            tableBody: '#bookingsTableBody',
            paginationDiv: '#bookingsTablePagination',
            filterInput: '#bookingsSearch',
            statusFilter: '#bookingFilter',
            prevButton: '#bookingsPrevButton',
            nextButton: '#bookingsNextButton',
            pageText: '#bookingsPageText',
            pageSize: 5
        },
        payments: {
            tableBody: '#paymentsTableBody',
            paginationDiv: '#paymentsTablePagination',
            filterInput: '#paymentsSearch',
            monthFilter: '#monthFilter',
            prevButton: '#paymentsPrevButton',
            nextButton: '#paymentsNextButton',
            pageText: '#paymentsPageText',
            pageSize: 5
        }
    };

    // Initialize pagination and filtering for each tab
    Object.keys(paginationOptions).forEach(tab => {
        const options = paginationOptions[tab];
        const tableBody = document.querySelector(options.tableBody);
        const paginationDiv = document.querySelector(options.paginationDiv);
        const filterInput = document.querySelector(options.filterInput);
        const prevButton = document.querySelector(options.prevButton);
        const nextButton = document.querySelector(options.nextButton);
        const pageText = document.querySelector(options.pageText);

        // Initialize pagination
        const pagination = new Pagination(tableBody, paginationDiv, options.pageSize, prevButton, nextButton, pageText);

        // Filter function for each tab
        function filterTable() {
            const filterValue = filterInput.value.toLowerCase();
            const rows = Array.from(tableBody.rows);
            let filteredRows = [];

            if (tab === 'bookings') {
                const statusFilterValue = document.querySelector(options.statusFilter).value;

                filteredRows = rows.filter(row => {
                    const status = row.getAttribute('data-status');
                    const matchesStatus = status === statusFilterValue || statusFilterValue === 'all';
                    const matchesSearch = row.textContent.toLowerCase().includes(filterValue);
                    return matchesStatus && matchesSearch;
                });
            } else if (tab === 'payments') {
                const monthFilterValue = document.querySelector(options.monthFilter).value;

                filteredRows = rows.filter(row => {
                    const date = row.getAttribute('data-date');
                    const matchesMonth = date === monthFilterValue || monthFilterValue === '';
                    const matchesSearch = row.textContent.toLowerCase().includes(filterValue);
                    return matchesMonth && matchesSearch;
                });
            } else {
                filteredRows = rows.filter(row => row.textContent.toLowerCase().includes(filterValue));
            }

            pagination.updatePaginationForFilteredRows(filteredRows);
        }

        filterInput.addEventListener('input', filterTable);
        if (options.statusFilter) document.querySelector(options.statusFilter).addEventListener('change', filterTable);
        if (options.monthFilter) document.querySelector(options.monthFilter).addEventListener('change', filterTable);

        prevButton.addEventListener('click', () => {
            pagination.currentPage = Math.max(1, pagination.currentPage - 1);
            pagination.update();
        });

        nextButton.addEventListener('click', () => {
            pagination.currentPage = Math.min(pagination.totalPages, pagination.currentPage + 1);
            pagination.update();
        });
    });
</script>
@endsection