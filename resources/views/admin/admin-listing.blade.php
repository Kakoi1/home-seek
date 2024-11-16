@extends('layouts.app')

@section('content')
<style>
    .container {
        max-width: 900px;
        margin: auto;
        padding: 20px;
    }

    .page-title {
        text-align: center;
        font-size: 28px;
        color: #333;
        margin-bottom: 20px;
    }

    /* Table styling */
    .properties-table {
        width: 100%;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
    }

    .properties-table th,
    .properties-table td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #e0e0e0;
    }

    .properties-table th {
        background-color: #f5f5f5;
        font-weight: bold;
        color: #333;
    }

    .properties-table tbody tr:hover {
        background-color: #fafafa;
    }

    /* Property name clickable styling */
    .property-name {
        color: #007BFF;
        cursor: pointer;
        text-decoration: underline;
    }

    .property-name:hover {
        color: #0056b3;
    }

    /* Status styling */
    .status-active {
        color: green;
        font-weight: bold;
    }

    .status-deactivated {
        color: red;
        font-weight: bold;
    }

    /* Button styling */
    .btn {
        padding: 8px 12px;
        font-size: 14px;
        border-radius: 5px;
        cursor: pointer;
        color: #fff;
        border: none;
        transition: background-color 0.3s;
    }

    .btn-warning {
        background-color: #f0ad4e;
    }

    .btn-warning:hover {
        background-color: #ec971f;
    }

    .btn-secondary {
        background-color: #c3c3c3;
    }

    .btn-secondary:disabled {
        cursor: not-allowed;
        background-color: #c0c0c0;
    }

    /* Form styling */
    .deactivate-form {
        display: inline-block;
        margin: 0;
    }

    .pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
    }

    .pagination-button {
        background-color: #007bff;
        /* Button color */
        color: #fff;
        padding: 8px 12px;
        border: none;
        border-radius: 5px;
        margin: 0 5px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s;
    }

    .pagination-button:hover {
        background-color: #0056b3;
        /* Hover color */
    }

    .pagination-button:disabled {
        background-color: #e0e0e0;
        /* Lighter grey for disabled state */
        color: #888;
        /* Grey text color */
        cursor: not-allowed;
        box-shadow: none;
        /* Remove shadow if any */
        pointer-events: none;
        opacity: 0.6;
    }

    .pagination-info {
        font-size: 16px;
        margin: 0 10px;
    }

    /* Overlay background */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }

    /* Modal content */
    .modal-content {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        width: 400px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    /* Modal title */
    .modal-content h3 {
        margin-bottom: 15px;
        font-size: 1.25rem;
        color: #333;
    }

    /* Reason options */
    .reason-options label {
        display: block;
        margin: 10px 0;
        font-size: 0.95rem;
        color: #555;
    }

    .reason-options input[type="radio"] {
        margin-right: 8px;
    }

    /* Other textarea */
    #otherReason {
        width: calc(100% - 20px);
        margin-top: 10px;
        padding: 10px;
        font-size: 0.95rem;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    /* Buttons */
    button {
        margin: 10px;
        padding: 8px 16px;
        font-size: 0.9rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button[type="button"]:first-child {
        background: #ff6b6b;
        color: #fff;
    }

    button[type="button"]:last-child {
        background: #dc3545;
    }

    /* Overlay styling */
    #overlayprop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        /* Semi-transparent background */
        z-index: 1000;
    }

    /* Modal container styling */
    #propertyDetails {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80%;
        max-width: 600px;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        z-index: 1001;
        display: none;
    }

    /* Modal content styling */
    .prop-content {
        text-align: center;
    }

    .modal-content h2 {
        font-size: 24px;
        margin-bottom: 10px;
        color: #333;
    }

    .modal-content p,
    .modal-content ul {
        font-size: 16px;
        color: #555;
    }

    /* Close button styling */
    .close-btn {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 24px;
        color: #aaa;
        cursor: pointer;
    }

    .close-btn:hover {
        color: #000;
    }

    .review-item {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
    }

    .profile-picture {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 15px;
    }

    .review-content {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .user-name {
        font-weight: bold;
        color: #333;
    }

    .review-comments {
        margin-top: 5px;
        font-size: 14px;
        color: #555;
    }

    .rating {
        margin-top: 5px;
        font-size: 12px;
        color: #888;
    }
</style>
<div class="container">
    <h1>Manage Posted Accomodation</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Accomodation Name</th>
                <th>Owner</th>
                <th>Location</th>
                <th>Availability</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($properties as $property)
                        @php
                            $fullAddress = $property->address;

                            // Split the string by commas
                            $addressParts = explode(',', $fullAddress);
                            $shortAddress = implode(', ', array_slice($addressParts, 0, 3));
                        @endphp
                        <tr>

                            <td style="cursor: pointer;" onclick="location.href = '{{route('dorms.posted', $property->id)}}'">
                                {{ $property->name }}
                            </td>
                            <td>{{ $property->user->name }}</td>
                            <td>{{ $shortAddress}}</td>
                            <td>
                                <span class="{{ $property->flag ? 'text-danger' : 'text-success' }}">
                                    {{ $property->flag ? 'Deactivated' : 'Active' }}
                                </span>
                            </td>
                            <td>
                                @if(!$property->flag)
                                    <form action="{{ route('admin.deactivateProperty', $property->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="stat" value="">
                                        <button type="submit" class="btn btn-warning btn-sm"
                                            onclick="return confirm('Are you sure you want to deactivate this Accomodation?');">
                                            Deactivate
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.deactivateProperty', $property->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="stat" value="">
                                        <button type="submit" class="btn btn-warning btn-sm"
                                            onclick="return confirm('Are you sure you want to deactivate this Accomodation?');">
                                            activate
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination-container">
        <button class="pagination-button" id="prevPageBtn" onclick="prevPage()" disabled>Previous</button>
        <span class="pagination-info">Page <span id="currentPage">1</span></span>
        <button class="pagination-button" id="nextPageBtn" onclick="nextPage()">Next</button>
    </div>
</div>
<div id="deactivateModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <h3>Provide Reason for Deactivation</h3>
        <form id="deactivateForm" method="POST" action="">
            @csrf
            @method('PUT')
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" id="propertyId" name="propertyId" value="">

            <div class="reason-options">
                <label><input type="radio" name="reason" value="Violation of terms" required> Violation of terms</label>
                <label><input type="radio" name="reason" value="Misleading information"> Misleading information</label>
                <label><input type="radio" name="reason" value="Spam activity"> Spam activity</label>
                <label><input type="radio" name="reason" value="Other"> Other</label>
                <textarea id="otherReason" name="otherReason" placeholder="Please specify if 'Other'"
                    style="display:none;"></textarea>
            </div>

            <button type="button" onclick="submitDeactivateForm()">Submit</button>
            <button type="button" onclick="closeModal()">Cancel</button>
        </form>
    </div>
</div>

<!-- Overlay and Modal for Property Details -->
<div id="overlayprop" style="display:none;"></div>
<div id="propertyDetails" style="display:none;">
    <div class="prop-content">
        <span class="close-btn" onclick="closePropertyDetails()">&times;</span>
        <div id="propertyTitle"></div>


        <!-- Canvas for the chart -->
        <canvas id="ratesChart" width="400" height="200"></canvas>

        <h3>Tenant Reviews</h3>
        <ul id="reviewsList" style="list-style-type: none;"></ul>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const properties = @json($properties);

    let filteredProperties = [...properties];
    const propertiesPerPage = 10;
    let currentPage = 1;

    function calculateTotalPages() {
        return Math.ceil(filteredProperties.length / propertiesPerPage);
    }

    // Capitalize first letter of each word in a string
    function capitalizeFirstLetter(str) {
        if (typeof str !== 'string') return str;
        return str.replace(/\b\w/g, function (char) {
            return char.toUpperCase();
        });
    }

    function renderTable(page) {
        const totalPages = calculateTotalPages();
        const start = (page - 1) * propertiesPerPage;
        const end = start + propertiesPerPage;
        const propertiesToDisplay = filteredProperties.slice(start, end);

        const tableBody = document.querySelector("tbody");
        tableBody.innerHTML = propertiesToDisplay.map(property => {
            // Shorten the address to a preview
            const shortAddress = property.address.split(',').slice(0, 3).join(', ');

            // Determine dorm and owner status
            const isDormDeactivated = property.flag || property.user.active_status === 1;
            const statusText = isDormDeactivated ? 'Deactivated' : 'Active';
            const statusClass = isDormDeactivated ? 'text-danger' : 'text-success';
            const avail = property.availability ? 'Occupied' : 'Available';

            // Return the HTML content with capitalized values
            return `
        <tr>
            <td style="cursor: pointer;" onclick="showPropertyDetails(${property.id})">
                <a href="javascript:void(0)">
                    <strong>${capitalizeFirstLetter(property.name)}</strong>
                </a>
            </td>
            <td>
                <a href="javascript:void(0)" onclick="openUserPopup(${property.user.id})">
                    <strong>${capitalizeFirstLetter(property.user.name)}</strong>
                </a>
            </td>
            <td>${capitalizeFirstLetter(shortAddress)}</td>
            <td>${capitalizeFirstLetter(avail)}</td>
            <td><span class="${statusClass}">${capitalizeFirstLetter(statusText)}</span></td>
            <td>
                <button type="button" class="btn" ${property.flag || property.user.active_status ? 'disabled' : ''}
                    onclick="handleAction(${property.id}, ${isDormDeactivated})">
                     Deactivate
                </button>
            </td>
        </tr>
    `;
        }).join("");

        // Update the current page text
        document.getElementById("currentPage").textContent = page;

        // Update pagination buttons (this function needs to be implemented somewhere)
        updatePaginationButtons(totalPages);
    }



    function nextPage() {
        const totalPages = calculateTotalPages();
        if (currentPage < totalPages) {
            currentPage++;
            renderTable(currentPage);
        }
    }

    function prevPage() {
        if (currentPage > 1) {
            currentPage--;
            renderTable(currentPage);
        }
    }

    function updatePaginationButtons(totalPages) {
        document.getElementById("prevPageBtn").disabled = currentPage === 1;
        document.getElementById("nextPageBtn").disabled = currentPage === totalPages || totalPages === 0;
    }

    function filterAndPaginate() {
        const query = document.getElementById("searchBar").value.toLowerCase();
        filteredProperties = properties.filter(property => property.name.toLowerCase().includes(query));
        currentPage = 1;
        renderTable(currentPage);
    }

    renderTable(currentPage);
    function handleAction(propertyId, isDeactivated) {
        if (isDeactivated) {
            // If property is deactivated, simply activate without modal
            if (confirm('Are you sure you want to activate this Accomodation?')) {
                document.getElementById("deactivateForm").action = `/managepage/property${propertyId}/deactivate`;
                document.getElementById("deactivateForm").submit();
            }
        } else {
            // If property is active, show modal to provide reason for deactivation
            if (confirm('Are you sure you want to deactivate this Accomodation?')) {
                openDeactivateModal(propertyId);
            }
        }
    }

    function openDeactivateModal(propertyId) {
        document.getElementById("deactivateModal").style.display = "flex";
        document.getElementById("propertyId").value = propertyId;
        document.getElementById("deactivateForm").action = `/managepage/property${propertyId}/deactivate`;
    }
    function closeModal() {
        document.getElementById("deactivateModal").style.display = "none";
    }

    function submitDeactivateForm() {
        document.getElementById("deactivateForm").submit();
    }

    // Show 'Other' textarea if 'Other' option is selected
    document.querySelectorAll('input[name="reason"]').forEach(input => {
        input.addEventListener('change', () => {
            const otherReason = document.getElementById("otherReason");
            if (input.value === 'Other' && input.checked) {
                otherReason.style.display = "block";
                otherReason.required = true;
            } else {
                otherReason.style.display = "none";
                otherReason.required = false;
            }
        });
    });



</script>

<script>
    function showPropertyDetails(id) {
        fetch(`/properties/${id}/details`)
            .then(response => response.json())
            .then(data => {
                document.getElementById("propertyTitle").innerHTML = `<a href="javascript:void(0)"><strong><h2 onclick = 'location.href = "/dorms/${data.dorm.id}"'>${data.dorm.name}</h2></strong></a>`;
                document.getElementById("overlayprop").style.display = "block";
                document.getElementById("propertyDetails").style.display = "block";

                // Prepare data for the chart with rates
                const labels = ["View Count", "Booking Rate", "Cancellation Rate"];
                const rates = [
                    data.viewCount,
                    data.bookingRate.toFixed(2),
                    data.cancellationRate.toFixed(2)
                ];
                const counts = [
                    data.viewCount,
                    data.bookingCount,
                    data.cancellationCount
                ];

                // Destroy previous chart if it exists
                if (window.ratesChart instanceof Chart) {
                    window.ratesChart.destroy();
                }

                // Render chart with custom tooltip
                setTimeout(() => {
                    const ctx = document.getElementById("ratesChart").getContext("2d");
                    window.ratesChart = new Chart(ctx, {
                        type: "bar",
                        data: {
                            labels: labels,
                            datasets: [{
                                label: "Accomodation Metrics (%)",
                                data: rates,
                                backgroundColor: ["#4CAF50", "#FFC107", "#FF5722"],
                                borderColor: ["#388E3C", "#FFA000", "#D32F2F"],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: "Rate (%)"
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function (context) {
                                            // Get the percentage rate and count
                                            const rate = context.raw; // Current rate from `rates` array
                                            const count = counts[context.dataIndex]; // Corresponding count
                                            return `Rate: ${rate}% | Count: ${count}`;
                                        }
                                    }
                                }
                            }
                        }
                    });
                }, 100);

                // Populate reviews
                const reviewsList = document.getElementById("reviewsList");
                reviewsList.innerHTML = "";
                data.reviews.forEach(review => {
                    const li = document.createElement("li");
                    li.classList.add("review-item");

                    li.innerHTML = `
                    <img src="https://storage.googleapis.com/homeseek-profile-image/${review.user.profile_picture}" 
                        alt="${review.user.name}'s profile picture" class="profile-picture">
                    <div class="review-content">
                        <span class="user-name">${review.user.name}</span>
                        <span class="review-comments">${review.comments} (Rating: ${review.rating})</span> 
                        
                    </div>
                `;
                    reviewsList.appendChild(li);
                });
            })
            .catch(error => console.error("Error fetching Accomodation details:", error));
    }

    function closePropertyDetails() {
        document.getElementById("overlayprop").style.display = "none";
        document.getElementById("propertyDetails").style.display = "none";
    }


</script>

@endsection