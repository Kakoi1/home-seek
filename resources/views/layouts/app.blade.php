@php
    use Diglactic\Breadcrumbs\Breadcrumbs;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'HomeSeek')</title>

    <link rel="stylesheet" href="{{ env('APP_URL') . 'css/pagination.css' }}">
    <link rel="stylesheet" href="{{ env('APP_URL') . 'css/styles.css' }}">
    <link rel="stylesheet" href="{{ env('APP_URL') . 'css/admin.css' }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->

    <style>

    </style>

    @if (Auth::user())
        <script src="{{asset('js/navbar.js')}}"></script>
    @endif


</head>
<style>
    /* Full-Screen Popup Overlay */
    .user-popup {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(0, 0, 0, 0.6);
        z-index: 1000;
    }

    /* Overlay Background */
    .user-popup-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        z-index: 1;
    }

    /* Modal Content */
    .user-popup-content {
        position: relative;
        z-index: 2;
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        max-width: 900px;
        width: 90%;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        overflow: auto;
        animation: fadeIn 0.3s ease;
        height: 900px;
    }

    /* Profile Header */
    .profile-header {
        display: flex;
        align-items: flex-start;
        gap: 5px;
        flex-direction: column;
    }

    #userData {
        padding: 20px;
    }

    /* Profile Image */
    .profile-img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ddd;
    }

    /* Close Button */
    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 24px;
        cursor: pointer;
        color: #333;
        font-weight: bold;
    }

    /* Divider Line */
    hr {
        border: none;
        border-top: 1px solid #ddd;
        margin: 10px 0;
    }

    .review-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .reviews-items {
        background-color: #f9f9f9;
        border: 1px solid #eee;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 15px;
    }

    .review-item h5 {
        margin-bottom: 10px;
    }

    /* Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .rating .star {
        color: lightgray;
        font-size: 1.5rem;
    }

    .rating .star.filled {
        color: gold;
    }

    .property-list {
        max-width: 800px;
        margin: 0 auto;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    /* Title styles */
    .property-list h4 {
        font-size: 24px;
        margin-bottom: 10px;
        color: #007bff;
    }

    /* Owner rating */
    .owner-rating {
        font-size: 16px;
        margin-bottom: 20px;
        font-weight: bold;
    }

    /* List of properties */
    .property-list ul {
        list-style-type: none;
        padding: 0;
    }

    /* Each property item */
    .property-list li {
        display: flex;
        align-items: center;
        border-bottom: 1px solid #ddd;
        padding: 15px 0;
    }

    .property-list li:last-child {
        border-bottom: none;
    }

    /* Property image */
    .property-list img {
        border-radius: 8px;
        margin-right: 15px;
    }

    /* Property details */
    .property-details {
        flex-grow: 1;
    }

    /* Property name and location */
    .property-details h5 {
        font-size: 18px;
        margin: 0 0 5px;
        color: #333;
    }

    .property-details p {
        margin: 5px 0;
        color: #555;
    }

    /* Rating style */
    .rating {
        font-weight: bold;
        color: #ffcc00;
        /* Gold color for ratings */
    }

    /* Pagination Controls Styling */
    #paginationControls {
        display: flex;
        justify-content: center;
        /* Center the pagination controls */
        align-items: center;
        margin-top: 20px;
        font-size: 16px;
        /* Slightly larger font for readability */
    }

    #paginationControls button {
        background-color: #007bff;
        /* Bootstrap primary color */
        color: white;
        border: none;
        border-radius: 4px;
        padding: 8px 12px;
        cursor: pointer;
        margin: 0 5px;
        /* Space between buttons */
        transition: background-color 0.3s;
        /* Smooth transition for hover effect */
    }

    #paginationControls button:disabled {
        background-color: #ccc;
        /* Light gray for disabled buttons */
        cursor: not-allowed;
    }

    #paginationControls button:hover:not(:disabled) {
        background-color: #0056b3;
        /* Darker blue on hover */
    }

    /* Pagination text styling */
    #paginationControls span {
        margin: 0 10px;
        /* Space around the text */
        font-weight: bold;
        /* Bold for emphasis */
        color: #333;
        /* Darker text color for contrast */
    }

    .overlaynot {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(0, 0, 0, 0.6);
        z-index: 1000;
    }

    .popupnot {
        background: #fff;
        padding: 20px;
        width: 500px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        z-index: 1001;
        text-align: center;
    }

    .popupnot button {
        padding: 10px 15px;
        border: none;
        border-color: #007bff;
        background: linear-gradient(to right, rgba(11, 136, 147, 0.911), rgba(54, 0, 51, 0.877));
        color: white;
        border-radius: 5px;
        margin: 0 auto;
        display: block;
    }

    .user-popup-content h2 {
        font-size: 1.5em;
        color: #333;
        margin-bottom: 15px;
    }

    /* Styling for the form labels */

    .report-popup {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }

    /* Styling for the 'Other' reason text input */
    #otherReasonInput input {
        width: 100%;
        padding: 8px;
        margin-top: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1em;
    }

    .userButton button {
        padding: 5px 10px;
        border: none;
        border-color: #007bff;
        background: linear-gradient(to right, rgba(11, 136, 147, 0.911), rgba(54, 0, 51, 0.877));
        color: white;
        border-radius: 5px;
        margin: 0 auto;
    }

    /* Styling for the rented property and upcoming bill sections */
    .rented-property,
    .upcoming-bill {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        background-color: #f9f9f9;
        /* box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); */
    }

    .rented-property h4,
    .upcoming-bill h5 {
        font-size: 1.2rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }

    .rented-property p,
    .upcoming-bill p {
        font-size: 1rem;
        color: #555;
        margin: 5px 0;
    }

    .rented-property p strong,
    .upcoming-bill p strong {
        font-weight: bold;
        color: #333;
    }

    /* For the upcoming bill amount */
    .upcoming-bill p strong+span {
        font-size: 1.1rem;
        /* color: #d9534f; */
        font-weight: bold;
    }

    .upcoming-bill p span {
        font-size: 1rem;
    }

    /* Overdue styling */
    .upcoming-bill p span[style="color: red;"] {
        color: red;
        font-weight: bold;
    }

    /* Add some hover effect for better user interaction */
    .rented-property:hover,
    .upcoming-bill:hover {
        background-color: #f1f1f1;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        cursor: pointer;
    }

    /* Responsive adjustments */
    @media (max-width: 600px) {

        .rented-property,
        .upcoming-bill {
            padding: 10px;
        }

        .rented-property h4,
        .upcoming-bill h5 {
            font-size: 1rem;
        }

        .rented-property p,
        .upcoming-bill p {
            font-size: 0.9rem;
        }
    }

    #reasonPop {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        width: 80%;
        margin: 0 auto;
    }

    /* Custom CSS for breadcrumbs */
    .breadcrumb {
        background-color: transparent;
        padding: 20;
        margin: 0;
    }

    .breadcrumb-item {
        display: inline-block;
        margin-right: 10px;
    }

    .breadcrumb-item a {
        color: #007bff;
        text-decoration: none;
    }

    .breadcrumb-item.active {
        color: #6c757d;
    }

    .breadcrumb-item+.breadcrumb-item::before {
        content: '>';
        margin: 0 10px;
        color: #6c757d;
    }

    /* This will style the custom checkboxes */
    .custom-check {
        margin-bottom: 10px;
        /* Space between each radio button */
        display: flex;
        /* Flexbox will align items horizontally */
        align-items: center;
        /* Aligns radio button and label vertically */
    }

    /* Style the label to provide space between radio button and label text */
    .custom-check label {
        margin-left: 10px;
        cursor: pointer;
        /* Cursor changes to pointer on hover */
    }

    /* Popup Overlay (background overlay) */
    .report-popup {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        /* Hidden by default */
        z-index: 9999;
    }

    /* User popup overlay (clicking this closes the popup) */
    .user-popup-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    /* Popup Content */
    .report-popup-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #fff;
        padding: 50px;
        border-radius: 8px;
        width: 80%;
        max-width: 450px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .report-popup h2 {
        text-align: center;
        font-size: 24px;
        margin-bottom: 20px;
    }

    .report-popup p {
        font-size: 16px;
        margin-bottom: 10px;
    }

    /* Input fields and buttons */
    .report-popup input[type="text"] {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .report-popup button {
        background-color: #007bff;
        color: white;
        padding: 10px 15px;
        margin-top: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    .report-popup button[type="button"]:hover {
        background-color: #0056b3;
    }

    .report-popup button[type="button"]:nth-child(2) {
        background-color: #dc3545;
    }

    .report-popup button[type="button"]:nth-child(2):hover {
        background-color: #c82333;
    }
</style>

<body>
    <div id="reportPopup" class="report-popup" style="display: none;">

        <div class="report-popup-content">
            <h2>Report</h2>
            <form id="reportForm">
                <input type="hidden" name="reported_id" id="reported_id">
                <input type="hidden" name="dorm_id" id="dorm_id">
                <input type="hidden" name="type" id="type">
                <h5>Select a reason:</h5>
                <div id="reasonPop"></div>
                <div id="otherReasonInput" style="display: none;">
                    <textarea type="text" name="otherReason" class="form-control"
                        placeholder="Please specify..."></textarea>
                </div>
                <br>
                <div style="display: flex;width: 100%;justify-content: center;gap: 15px;">
                    <button type="button" onclick="submitReport()">Submit Report</button>
                    <button type="button" onclick="closeReportPopup()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <div id="userPopup" class="user-popup" style="display: none;">
        <div class="user-popup-overlay" onclick="closeUserPopup()"></div>
        <div class="user-popup-content">
            <span class="close-btn" onclick="closeUserPopup()">&times;</span>
            <div class="profile-header">
                <img id="userProfilePicture" src="" alt="User Profile Picture" class="profile-img">

                <div style="width: 100%; padding: 10px;">
                    <h3 style="color: black;" id="userName"></h3>
                    <p id="userRole"></p>
                    <div style="display: flex;width: 100%;flex-direction: row;justify-content: flex-start;gap: 250px;">
                        <span>

                            <p id="status_acc"></p>
                            <p id="joined"></p>

                        </span>
                        <span id="contacter">

                        </span>
                    </div>
                </div>
                <div class="userButton" id="userButton" style="display: flex;width: 250px;"></div>
            </div>
            <hr>
            <div id="userData"></div>
            <div id="paginationControls" style=""></div>

        </div>
    </div>
    <div id="userNot" class="user-popup" style="display: none;">
        <div id="notificationOverlay" class="overlaynot"></div>
        <div id="notificationPopup" class="popupnot">
            <h3 style="color: black !important;">Notification</h3>
            <p id="popupMessage"></p>
            <button id="closeButton" onclick="closePopup()">Close</button>
        </div>
    </div>


    @if (Auth::user() && !request()->routeIs('index') && !request()->routeIs('dds') && !Auth::user()->email_verified_at == null && !request()->routeIs('privacy'))
        @include('partials.pusher')
        @include('partials.side-bar')

    @else
        <style>
            .home-section .user-nav {
                width: calc(100% - 0px);
                left: 0px;
            }

            .home-section {
                min-height: 100vh;
                width: calc(100% - 0px);
                left: 0px;
            }
        </style>
    @endif

    <div id="walletOverlay" class="overli" style="display:none;">
        <div class="overli-content">
            <h2>My Wallet</h2>
            <p><strong>Wallet Balance:</strong> ₱<span id="walletBalance">0.00</span></p>

            <h4>Transaction History</h4>
            <div id="walletTransactions" class="transaction-list">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody id="transactionTableBody">
                        <!-- Transactions will be dynamically populated here -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination Controls -->
            <div id="paginationControls" class="pagination-controls">
                <button id="prevPageBtn" style="width: 85px;" class="btn btn-secondary">Previous</button>
                <span id="pageNumber">Page 1</span>
                <button id="nextPageBtn" style="width: 60px;" class="btn btn-secondary">Next</button>
            </div>

            <!-- Action Buttons -->
            <div class="wallet-buttons">
                <button id="cashInButton" class="btner btn-primary">Cash In</button>
                <button id="cashOutButton" class="btner btn-secondary">Cash Out</button>
            </div>

            <!-- Close Button -->
            <button id="closeWalletOverlay" class="btner btn-danger mt-3">Close</button>
        </div>
    </div>


    <div class="" style="overflow: auto">

        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    let errorList = '<ul>';
                    @foreach ($errors->all() as $error)
                        errorList += '<li>{{ $error }}</li>';
                    @endforeach
                    errorList += '</ul>';

                    Swal.fire({
                        title: '',
                        html: errorList,
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                });
            </script>
        @endif

    </div>


    <section class="home-section">
        @include('partials.admin-nav')
        <br><br>
        @if (Auth::user())

            @if (!request()->routeIs('owner.Dashboard') && !request()->routeIs('dds') && !request()->routeIs('home') && !request()->routeIs('admin.Dashboard') && !request()->routeIs('index') && !Auth::user()->email_verified_at == null)

                {{ Breadcrumbs::render() }}

            @endif

            <br><br>
        @endif
        @yield('content')
    </section>

    @include('partials.footer')
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            @if ($errors->any())
                // alert('There were some errors with your submission. Please check the fields and try again.');
            @endif
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.js"></script>
    <style></style>

    <script src="{{ asset('js/search.js') }}"></script>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    title: '',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            });

        </script>

    @endif
    <script>
        let sidebar = document.querySelector(".sidebar");
        let logo = document.querySelector(".logo_name");
        let sidebarBtn = document.querySelector(".sidebarBtn");
        try {
            sidebarBtn.onclick = function () {
                sidebar.classList.toggle("active");
                if (sidebar.classList.contains("active")) {
                    sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
                } else
                    sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
            }
        } catch (error) {

        }

    </script>



    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let currentPage = 1;
            let currentUserId = null;
            const userid = {{Auth::id() ? Auth::id() : 0}};

            window.openUserPopup = async function (userId) {
                currentUserId = userId;

                try {
                    const response = await fetch(`/user-data/${userId}?page=${currentPage}`);
                    const data = await response.json();

                    document.getElementById('userName').innerText = data.name;
                    document.getElementById('userRole').innerText = data.role;
                    document.getElementById('contacter').innerHTML = data.contacts;
                    document.getElementById('joined').innerHTML = `<strong>Joined: ${data.joined}</strong>`;
                    document.getElementById('status_acc').innerHTML = data.status_acc ? `<strong class = 'text-danger'>Inactive</strong>` : `<strong class = 'text-success'>Active</strong>`;
                    document.getElementById('userProfilePicture').src =
                        data.profile_picture
                            ? `https://storage.googleapis.com/homeseek-profile-image/${data.profile_picture}`
                            : 'https://via.placeholder.com/80x80';

                    const userButton = document.getElementById('userButton');
                    userButton.innerHTML = ''; // Clear previous buttons
                    if (data.role !== 'Admin') {
                        console.log(data.role);

                        if (userid === currentUserId) {
                            // Create 'Edit Profile' button
                            const editButton = document.createElement('button');
                            editButton.innerText = 'Edit Profile';

                            editButton.addEventListener('click', () => {
                                const editProfileUrl = '{{ route('profile.edit') }}';  // Blade route rendering
                                location.href = editProfileUrl;
                            });

                            // Create 'My Wallet' button
                            const walletButton = document.createElement('button');
                            walletButton.innerText = 'My Wallet';

                            // Wallet overlay functionality
                            walletButton.addEventListener('click', async () => {
                                const overlay = document.getElementById('walletOverlay');
                                const transactionTableBody = document.getElementById('transactionTableBody');
                                const walletBalance = document.getElementById('walletBalance');
                                const pageNumber = document.getElementById('pageNumber');
                                const prevPageBtn = document.getElementById('prevPageBtn');
                                const nextPageBtn = document.getElementById('nextPageBtn');

                                // Initialize Pagination
                                let currentPage = 1;
                                const itemsPerPage = 5; // Number of items per page

                                overlay.style.display = 'flex'; // Show overlay
                                transactionTableBody.innerHTML = ''; // Clear previous data

                                try {
                                    // Fetch wallet details
                                    const response = await fetch("{{ route('wallet.details') }}");
                                    const data = await response.json();

                                    // Update wallet balance
                                    walletBalance.innerText = data.balance;

                                    // Pagination logic
                                    const totalTransactions = data.transactions;
                                    const totalPages = Math.ceil(totalTransactions.length / itemsPerPage);

                                    // Function to load page data
                                    function loadPage(page) {
                                        // Calculate the start and end index for the current page
                                        const start = (page - 1) * itemsPerPage;
                                        const end = start + itemsPerPage;

                                        // Clear the current table body
                                        transactionTableBody.innerHTML = '';

                                        // Add transactions for the current page
                                        const transactionsOnPage = totalTransactions.slice(start, end);

                                        if (transactionsOnPage.length > 0) {
                                            transactionsOnPage.forEach(transaction => {
                                                const row = document.createElement('tr');
                                                row.innerHTML = `
                                <td>${transaction.date}</td>
                                <td>${transaction.type}</td>
                                <td>₱${transaction.amount}</td>
                            `;
                                                transactionTableBody.appendChild(row);
                                            });
                                        } else {
                                            const noDataRow = document.createElement('tr');
                                            noDataRow.innerHTML = `
                            <td colspan="3" style="text-align: center;">No transactions available.</td>
                        `;
                                            transactionTableBody.appendChild(noDataRow);
                                        }

                                        // Update the page number
                                        pageNumber.innerText = `Page ${page}`;

                                        // Disable/Enable buttons based on the current page
                                        prevPageBtn.disabled = page === 1;
                                        nextPageBtn.disabled = page === totalPages;
                                    }

                                    // Load initial page
                                    loadPage(currentPage);

                                    // Event Listeners for page navigation
                                    prevPageBtn.addEventListener('click', () => {
                                        if (currentPage > 1) {
                                            currentPage--;
                                            loadPage(currentPage);
                                        }
                                    });

                                    nextPageBtn.addEventListener('click', () => {
                                        const totalPages = Math.ceil(totalTransactions.length / itemsPerPage);
                                        if (currentPage < totalPages) {
                                            currentPage++;
                                            loadPage(currentPage);
                                        }
                                    });

                                } catch (error) {
                                    console.error('Error fetching wallet details:', error);
                                }
                            });

                            // Add the buttons to the userButton container
                            userButton.appendChild(editButton);
                            userButton.appendChild(walletButton);
                        }

                        // Close overlay when the close button is clicked


                        else {
                            @if(Auth::check() && Auth::user()->role !== 'admin')
                                const reportButton = document.createElement('button');
                                reportButton.innerText = 'Report User';
                                reportButton.addEventListener('click', () => showReportPopup(currentUserId, null, 'user'));
                                userButton.appendChild(reportButton);
                            @endif

                        }
                        document.getElementById('closeWalletOverlay').addEventListener('click', () => {
                            const overlay = document.getElementById('walletOverlay');
                            overlay.style.display = 'none'; // Hide overlay
                        });
                    }
                    document.getElementById('cashInButton').addEventListener('click', () => {
                        location.href = "{{ route('wallet.cashIn') }}"; // Route for Cash In
                    });

                    document.getElementById('cashOutButton').addEventListener('click', () => {
                        location.href = "{{ route('cashout.page') }}"; // Route for Cash Out
                    });

                    document.getElementById('userData').innerHTML = data.content;

                    if (data.pagination) {
                        updatePaginationControls(data.pagination);
                        document.getElementById('paginationControls').style.display = 'block';
                    } else {
                        document.getElementById('paginationControls').style.display = 'none';
                    }

                    document.getElementById('userPopup').style.display = 'flex';
                } catch (error) {
                    console.error('Error fetching user data:', error);
                    alert('Failed to load user data. Please try again later.');
                }
            };

            function updatePaginationControls(pagination) {
                const paginationControls = document.getElementById('paginationControls');
                paginationControls.innerHTML = `
<button onclick="changePage(${pagination.current_page - 1})" ${pagination.current_page === 1 ? 'disabled' : ''
                    }>Previous</button>
<span>Page ${pagination.current_page} of ${pagination.last_page}</span>
<button onclick="changePage(${pagination.current_page + 1})" ${pagination.current_page === pagination.last_page
                        ? 'disabled' : ''}>Next</button>
`;
            }

            window.changePage = function (page) {
                currentPage = page;
                openUserPopup(currentUserId);
            };

            window.closeUserPopup = function () {
                document.getElementById('userPopup').style.display = 'none';
            };
        });

        window.updatePaginationControls = function (pagination) {
            const paginationControls = document.getElementById('paginationControls');
            paginationControls.innerHTML = `
<button onclick="changePage(${pagination.current_page - 1})" ${pagination.current_page === 1 ? 'disabled' : ''
                }>Previous</button>
<span>Page ${pagination.current_page} of ${pagination.last_page}</span>
<button onclick="changePage(${pagination.current_page + 1})" ${pagination.current_page === pagination.last_page
                    ? 'disabled' : ''}>Next</button>
`;
        };

        function showReportPopup(userId, dormId, typeRep) {
            // Set the hidden inputs with the passed values
            document.getElementById('reported_id').value = userId;
            document.getElementById('dorm_id').value = dormId;
            document.getElementById('type').value = typeRep;

            // Show the popup
            document.getElementById("reportPopup").style.display = "block";

            // Close any other popups if necessary
            closeUserPopup();

            // Change the report reason options based on the report type
            updateReportReasonOptions(typeRep);
        }

        // Close the popup
        function closeReportPopup() {
            document.getElementById("reportPopup").style.display = "none";
        }

        // Handle form submission
        function submitReport() {
            const formData = new FormData(document.getElementById('reportForm'));
            fetch('/report', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    closeReportPopup();
                })
                .catch(error => console.error('Error:', error));
        }

        // Function to toggle the visibility of the "Other" input field
        function toggleOtherInput(show) {
            const otherReasonInputDiv = document.getElementById('otherReasonInput');
            if (show) {
                otherReasonInputDiv.style.display = 'block'; // Show the input field
            } else {
                otherReasonInputDiv.style.display = 'none'; // Hide the input field
            }
        }

        // Function to update report reason options based on the report type (user or property)
        function updateReportReasonOptions(typeRep) {
            const reasonContainer = document.getElementById('reasonPop');

            // Clear existing radio buttons
            reasonContainer.querySelectorAll('div.custom-check').forEach(div => div.remove());

            // Define the reason options based on the report type
            let reasonOptions = [];

            if (typeRep === 'property') {
                reasonOptions = [
                    'Property Violation',
                    'Damage to Property',
                    'Unsafe Conditions',
                    'Illegal Activities'
                ];
            } else {
                reasonOptions = [
                    'Spam',
                    'Inappropriate Content',
                    'Harassment'
                ];
            }

            // Insert custom CSS styles into the document head
            const style = document.createElement('style');
            style.innerHTML = `
.custom-check {
margin-bottom: 10px; /* Space between each radio button */
display: flex; /* Align radio and label horizontally */

align-items: center; /* Aligns radio button and label vertically */
} .custom-check input{
width: 50px;
}

.custom-check label {
margin-left: 10px;
cursor: pointer; /* Cursor changes to pointer on hover */
}
`;
            document.head.appendChild(style);

            // Add the reason options dynamically
            reasonOptions.forEach(reason => {
                // Create radio button container
                const div = document.createElement('div');
                div.classList.add('custom-check'); // Custom class for radio button container

                // Create the radio button input
                const radio = document.createElement('input');
                radio.type = 'radio';
                radio.classList.add('custom-check-input'); // Custom class for radio button
                radio.name = 'Repreason'; // Same name to group them
                radio.value = reason;
                radio.id = `reason-${reason}`; // Give a unique ID for each radio button

                // Create the label for the radio button
                const label = document.createElement('label');
                label.setAttribute('for', radio.id); // Set the "for" attribute for accessibility
                label.innerHTML = reason;

                // Append radio inside the label (radio button comes before the text)
                label.insertBefore(radio, label.firstChild); // Insert radio input at the beginning

                // Append the label to the div container
                div.appendChild(label);

                // Append the div container to the reasonContainer
                reasonContainer.appendChild(div);
            });

            // Add "Other" option with a radio button
            const otherDiv = document.createElement('div');
            otherDiv.classList.add('custom-check');

            const otherRadio = document.createElement('input');
            otherRadio.type = 'radio';
            otherRadio.classList.add('custom-check-input');
            otherRadio.name = 'Repreason'; // Same name to group with other radio buttons
            otherRadio.value = 'Other';
            otherRadio.id = 'reason-Other';

            const otherLabel = document.createElement('label');
            otherLabel.setAttribute('for', otherRadio.id);
            otherLabel.innerHTML = 'Other';

            // Insert the radio input before the label text
            otherLabel.insertBefore(otherRadio, otherLabel.firstChild);

            otherDiv.appendChild(otherLabel);
            reasonContainer.appendChild(otherDiv);

            // Add the "Other" input field (hidden by default)
            const otherInputDiv = document.getElementById('otherReasonInput');
            otherInputDiv.style.display = 'none'; // Hide the input field by default

            // Add event listener to the "Other" radio button to toggle the input field visibility
            otherRadio.addEventListener('change', () => {
                if (otherRadio.checked) {
                    otherInputDiv.style.display = 'block'; // Show input field when "Other" is selected
                } else {
                    otherInputDiv.style.display = 'none'; // Hide input field when "Other" is not selected
                }
            });
        }


        // Event delegation: Listen for changes on the "Repreason" radio buttons
        document.getElementById('reasonPop').addEventListener('change', function (e) {
            if (e.target.name === 'Repreason') {
                if (e.target.value === "Other") {
                    toggleOtherInput(true); // Show the "Other" input when "Other" is selected
                } else {
                    toggleOtherInput(false); // Hide the "Other" input when any other option is selected
                }
            }
        });


        updateReportReasonOptions('user');



    </script>

</body>

</html>