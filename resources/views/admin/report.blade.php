@extends('layouts.app')

@section('content')


<style>
    /* Styling for pagination buttons */
    .pagination-btn {
        padding: 5px 10px;
        margin: 2px;
        cursor: pointer;
    }

    .pagination-btn.active {
        background-color: #4CAF50;
        color: white;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    table tr:hover {
        background-color: transparent;
        /* or any other value */
        color: black;
    }

    th {
        background: #091327;
        color: whitesmoke;

    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .actions button {
        padding: 6px 12px;
        margin: 0 5px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        color: white;
    }

    .btn-valid {
        background-color: #28a745;
    }

    .btn-invalid {
        background-color: #dc3545;
    }

    .btn-valid:hover {
        background-color: #218838;
    }

    .btn-invalid:hover {
        background-color: #c82333;
    }

    .pagination-btn {
        padding: 5px 10px;
        margin: 0 5px;
        border: 1px solid #ccc;
        background-color: #f9f9f9;
        cursor: pointer;
    }

    .pagination-btn.active {
        background-color: #1e3a8a;
        color: #fff;
        font-weight: bold;
    }
</style>

<div class="container">
    <h2>Reports Management</h2>

    <div class="filters">
        <label for="statusFilter">Status:</label>
        <select id="statusFilter">
            <option value="pending" selected>Pending</option>
            <option value="valid">Valid</option>
            <option value="invalid">Invalid</option>
        </select>

        <label for="typeFilter">Report Type:</label>
        <select id="typeFilter">
            <option value="">All</option>
            <option value="user">User</option>
            <option value="property">Accomodation</option>
        </select>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Reporter</th>
                <th>Reported User</th>
                <th>Accomodation</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="reportTableBody">

        </tbody>
    </table>

    <!-- Pagination controls -->
    <div id="paginationControls">
        <button id="prevPageBtn" onclick="prevPage()">Previous</button>
        <span id="pager"></span>
        <button id="nextPageBtn" onclick="nextPage()">Next</button>
    </div>
</div>

<script>
    let currentPage = 1;
    let lastPage = 1;  // Global variable to hold the last page number

    // Function to move to the next page
    function nextPage() {
        if (currentPage < lastPage) {
            currentPage++;
            fetchReports(currentPage);
        }
    }

    // Function to move to the previous page
    function prevPage() {
        if (currentPage > 1) {
            currentPage--;
            fetchReports(currentPage);
        }
    }

    // Function to update pagination button states and page display
    function updatePaginationButtons() {
        const prevPageBtn = document.getElementById("prevPageBtn");
        const nextPageBtn = document.getElementById("nextPageBtn");
        const pager = document.getElementById("pager");

        prevPageBtn.disabled = currentPage === 1;
        nextPageBtn.disabled = currentPage === lastPage || lastPage === 0;

        // Update the pager text with the current and last page numbers
        pager.textContent = `Page ${currentPage} of ${lastPage}`;
    }

    // Function to fetch and display reports
    function fetchReports(page = 1) {
        const status = document.querySelector("#statusFilter").value;  // Get selected status filter
        const reportType = document.querySelector("#typeFilter").value; // Get selected report type filter

        fetch(`/reports/fetch?page=${page}&status=${status}&report_type=${reportType}`)
            .then(response => response.json())
            .then(data => {
                lastPage = data.last_page;  // Set lastPage from API response
                displayReports(data.data);  // Display fetched reports
                updatePaginationButtons();  // Update the pagination button states
            })
            .catch(error => console.error("Error fetching reports:", error));
    }

    // Function to display reports in the table
    function displayReports(reports) {
        const reportTableBody = document.querySelector("#reportTableBody");
        reportTableBody.innerHTML = "";  // Clear existing rows

        // Check if the reports array is empty
        if (reports.length === 0) {
            const noReportsMessage = `
            <tr>
                <td colspan="7" class="text-center">No Complaints available</td>
            </tr>
        `;
            reportTableBody.insertAdjacentHTML("beforeend", noReportsMessage); // Insert the "No reports" message
            return;  // Exit the function early since there are no reports to display
        }

        // If there are reports, display them
        reports.forEach(report => {
            const reportType = report.dorm_id ? "Accomodation" : "User";
            const actionButtons = report.status === 'pending'
                ? `
            <button class="btn-valid" onclick="handleAction(${report.id}, 'valid')">Valid</button>
            <button class="btn-invalid" onclick="handleAction(${report.id}, 'invalid')">Invalid</button>
        `
                : ''; // Empty string means no buttons will be added

            const row = `
            <tr>
                <td>${report.user.name}</td>
                <td>${report.reported.name}</td>
                <td>${report.dorm ? report.dorm.name : 'N/A'}</td>
                <td>${report.reason}</td>
                <td>${report.status}</td>
                <td>${reportType}</td>
                <td class="actions">
                    ${actionButtons}  <!-- Display action buttons only if status is 'pending' -->
                </td>
            </tr>
        `;
            reportTableBody.insertAdjacentHTML("beforeend", row);  // Insert rows into the table body
        });
    }

    // Function to handle filter changes
    function handleFilterChange() {
        currentPage = 1;  // Reset to the first page when filters change
        fetchReports(currentPage);  // Fetch reports with the new filters
    }

    // Attach event listeners to filter inputs (dropdowns)
    document.querySelector("#statusFilter").addEventListener("change", handleFilterChange);
    document.querySelector("#typeFilter").addEventListener("change", handleFilterChange);

    document.addEventListener("DOMContentLoaded", function () {
        // Initial fetch of reports when the page loads
        fetchReports(currentPage);
    });


</script>
<script>
    function handleAction(reportId, action) {
        const csrfToken = '{{ csrf_token() }}';

        fetch(`/reports/${reportId}/action`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ action: action })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`Report marked as ${action}.`);
                    location.reload();
                } else {
                    alert('Failed to update report status.');
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>
@endsection