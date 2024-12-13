@extends('layouts.app')

@section('manage user')

@section('content')

<style>
    /* Search Bar */
    * {
        border: transparent !important;
    }

    .search-bar {
        margin-bottom: 15px;
    }

    .search-bar input[type="text"] {
        width: 100%;
        padding: 8px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 14px;
    }

    /* Custom Table */
    .custom-table {
        width: 100%;
        border-collapse: collapse;
        border-bottom: solid 1px;
    }

    .custom-table th,
    .custom-table td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }

    .custom-table th {
        background-color: #f2f2f2;
        color: #333;
    }



    /* Button Styling */
    .btn-act,
    .btn-deact,
    .btn-manage,
    .btn-approve,
    .btn-decline {
        padding: 8px 12px;
        border: none;
        color: #fff;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-act {
        background-color: #28a745;
    }

    .btn-act:hover {
        background-color: #218838;
    }

    .btn-deact {
        background-color: #dc3545;
    }

    .btn-deact:hover {
        background-color: #c82333;
    }

    .btn-manage,
    .btn-approve {
        background-color: #007bff;
    }

    .btn-manage:hover,
    .btn-approve:hover {
        background-color: #0056b3;
    }

    .btn-decline {
        background-color: #ffc107;
    }

    .btn-decline:hover {
        background-color: #e0a800;
    }

    /* Modal styling */
    .modal {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: rgba(0, 0, 0, 0.5);
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    /* Pagination container styling */
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

    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: white;
        padding: 20px;
        border-radius: 8px;
        width: 500px;
        height: auto;
        text-align: center;
    }

    .modal-content input[type="text"] {
        margin-top: 10px;
        width: 100%;
    }

    .reasoner {
        width: 70%;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    #userTableBody tr {
        border-bottom: solid #e0e0e0 1px !important;
    }

    #searchBar {
        border: solid #e0e0e0 1px !important;
    }
</style>

<!-- Main content -->
<div class="home-content">
    <div class="container">
        <h2 class="text-center">Manage Users</h2>

        <!-- Filter Buttons -->
        <div class="filter-buttons">
            <button class="filter-btn active" data-filter="users" onclick="showSection('users')">Users</button>
            <button class="filter-btn" data-filter="verify" onclick="showSection('verify')">Verify Request
                <span class="requestCount" style="display: {{ $req ? '' : 'none' }};">{{ $req }}</span>
            </button>
        </div>

        <!-- Search Bar for Users -->
        <div class="search-bar" id="search-bar">
            <input type="text" id="searchBar" onkeyup="filterAndPaginate()" placeholder="Search user by name">
        </div>

        <!-- Users Table -->
        <div id="users-section">
            <table class="custom-table" id="userTable">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Role</th>
                        <th>Strikes Remaining</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    @foreach($users as $user)
                        @if ($user->role != 'admin')
                            <tr>
                                <td><img src="{{ $user->profile_picture ? asset('https://storage.googleapis.com/homeseek-profile-image/' . $user->profile_picture) : 'https://via.placeholder.com/80x80' }}"
                                        alt="User Image" width="50"></td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->active_status ? 'Inactive' : 'Active' }}</td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->role == 'owner' ? 'Verified' : 'Not Verified' }}</td>
                                <td>
                                    <button class="btn-act" {{ $user->active_status ? '' : 'hidden' }}
                                        onclick="activate({{ $user->id }})">Activate</button>
                                    <button class="btn-deact" {{ $user->active_status ? 'hidden' : '' }}
                                        onclick="deactivate({{ $user->id }})">Deactivate</button>

                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <div class="pagination-container">
                <button class="pagination-button" id="prevPageBtns" onclick="prevPages()" disabled>Previous</button>
                <span class="pagination-info">Page <span id="currentPages">1</span></span>
                <button class="pagination-button" id="nextPageBtns" onclick="nextPages()">Next</button>
            </div>
        </div>

        <!-- Verification Requests Table -->
        <div id="verify-section" style="display:none;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Verification Request</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($verificationRequests as $verify)
                        <tr>
                            <td><img src="{{ $verify->user->profile_picture ? asset('https://storage.googleapis.com/homeseek-profile-image/' . $verify->user->profile_picture) : 'https://via.placeholder.com/80x80' }}"
                                    alt="User Image" width="50"></td>
                            <td>{{ $verify->user->name }}</td>
                            <td>
                                <p style="text-decoration: underline; color: blue; cursor: pointer;"
                                    onclick="openModal({{ $verify }})">Requesting Verification</p>
                            </td>
                            <td>
                                <button class="btn-approve"
                                    onclick="approveVerification({{ $verify->id }})">Approve</button>
                                <button class="btn-decline" onclick="openRejectModal({{ $verify->id }})">Reject</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Reject Modal -->
        <div id="rejectModal" class="modal" style="display:none;">
            <div class="modal-reject">
                <h4>Reject Verification</h4>
                <textarea id="rejectionReason" placeholder="Provide a reason for rejection"></textarea>
                <div class="rejBut">
                    <button onclick="submitRejection()">Submit</button>
                    <button onclick="closeRejectModal()">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Verification Details Modal -->
    <div id="verifyModal" class="modals">
        <div class="modal-contents">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>User Verification Details</h2>
            <div class="valid-id">
                <div>
                    <label for="idDoc">Valid Id:</label>
                    <img id="idDoc" src="" alt="Submitted Document" class="clickable-img"
                        style="width: 100%; height: 500px;">
                </div>
                <div>
                    <label for="permit">Business Permit:</label>
                    <img id="permit" src="" alt="Submitted Document" class="clickable-img"
                        style="width: 100%; height: 500px;">
                </div>
            </div>
        </div>
    </div>
</div>
<div id="deactivationModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <h2>Provide a Reason for Deactivation</h2>
        <form id="deactivateForm">
            <div class="reasoner">
                <div>
                    <label><input type="radio" name="reason" value="Violation of terms"> Violation of terms</label>
                </div>
                <div>
                    <label><input type="radio" name="reason" value="Inappropriate behavior"> Inappropriate
                        behavior</label>
                </div>
                <div>
                    <label><input type="radio" name="reason" value="Spam or scam"> Spam or scam</label>
                </div>
                <div>
                    <label><input type="radio" name="reason" value="Other"> Other</label>

                </div>
                <div style="width: 100%;">
                    <textarea id="customReason" class="form-control" placeholder="Specify reason"
                        style="display: none;"></textarea>
                </div>
                <br>
            </div>
            <div style="width: 100%;">
                <button type="button" class="btn btn-success" onclick="submitDeactivation()">Submit</button>
                <button type="button" class="btn btn-danger" onclick="closeDeactivateModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>
<div id="warningModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <h2>Provide a Reason for Warning</h2>
        <form id="warningForm">
            <div class="reasoner">
                <div>
                    <label><input type="radio" name="warnReason" value="Inappropriate language"> Inappropriate
                        language</label>
                </div>
                <div>
                    <label><input type="radio" name="warnReason" value="Spam activity"> Spam activity</label>
                </div>
                <div>
                    <label><input type="radio" name="warnReason" value="Misleading information"> Misleading
                        information</label>
                </div>
                <div>
                    <label><input type="radio" name="warnReason" value="Other"> Other</label>

                    <br>
                </div>
                <div style="width: 100%;">
                    <textarea name="customWarnReason" class="form-control" id="customWarnReason"
                        placeholder="Specify reason" style="display: none;"></textarea>

                </div>
                <br>
                <div style="width: 100%;">
                    <button type="button" class="btn btn-success" onclick="submitWarning()">Submit</button>
                    <button type="button" class="btn btn-danger" onclick="closeWarningModal()">Cancel</button>
                </div>
        </form>
    </div>
</div>
</div>
<script>
    // JavaScript functions for handling actions and modal functionality
    // Functionality remains the same, including activating, deactivating, approving, rejecting, and modal handling

    // Function to show specific sections
    function showSection(section) {
        document.getElementById('users-section').style.display = section === 'users' ? 'block' : 'none';
        document.getElementById('verify-section').style.display = section === 'verify' ? 'block' : 'none';
        document.getElementById('search-bar').style.display = section === 'users' ? 'block' : 'none';
        document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelector(`[data-filter="${section}"]`).classList.add('active');
    }

    function openWarningModal(userId) {
        selectedUserIdForWarning = userId;
        document.getElementById("warningModal").style.display = "flex";
    }
    function closeWarningModal() {
        document.getElementById("warningModal").style.display = "none";
        document.getElementById("warningForm").reset();
        document.getElementById("customWarnReason").style.display = "none";
    }
    document.querySelectorAll('input[name="warnReason"]').forEach(input => {
        input.addEventListener('change', function () {
            const customWarnReason = document.getElementById("customWarnReason");
            if (this.value === "Other") {
                customWarnReason.style.display = "block";
            } else {
                customWarnReason.style.display = "none";
            }
        });
    });

    function submitWarning() {
        const selectedWarnReason = document.querySelector('input[name="warnReason"]:checked');
        let warnReason = selectedWarnReason ? selectedWarnReason.value : '';

        if (warnReason === "Other") {
            warnReason = document.getElementById("customWarnReason").value.trim();
        }

        if (!warnReason) {
            alert("Please provide a reason for the warning.");
            return;
        }

        // Fetch request to submit warning with reason
        fetch(`/warn-user/${selectedUserIdForWarning}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ warnReason })
        })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    showAlert('info', 'Warning Issued', data.message, () => location.reload());
                }
                closeWarningModal();
            })
            .catch(error => console.error('Error:', error));
    }

    function openModal(userId) {
        const modal = document.getElementById('verifyModal');
        const idDoc = document.getElementById('idDoc');
        const permit = document.getElementById('permit');
        idDoc.src = 'https://storage.googleapis.com/homeseek-profile-image/' + userId.id_document;
        permit.src = 'https://storage.googleapis.com/homeseek-profile-image/' + userId.business_permit;
        modal.style.display = "block";
    }

    function closeModal() {
        document.getElementById('verifyModal').style.display = "none";
    }

    function approveVerification(verificationId) {
        fetch(`/approve-verification/${verificationId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    showAlert('success', 'Success', data.message, () => location.reload());
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function openRejectModal(verificationId) {
        selectedVerificationId = verificationId;
        document.getElementById('rejectModal').style.display = 'block';
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').style.display = 'none';
    }

    function submitRejection() {
        const reason = document.getElementById('rejectionReason').value;
        if (!reason) {
            alert('Please provide a reason for rejection.');
            return;
        }

        fetch(`/reject-verification/${selectedVerificationId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ reason })
        })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    closeRejectModal();
                    showAlert('success', 'Rejected', data.message, () => location.reload());
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function activate(userId) {
        fetch(`/activate-user/${userId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    showAlert('success', 'Activated', data.message, () => location.reload());
                }
            })
            .catch(error => console.error('Error:', error));
    }

    let selectedUserId;

    function openDeactivateModal(userId) {
        selectedUserId = userId;
        document.getElementById("deactivationModal").style.display = "flex";
    }

    function closeDeactivateModal() {
        document.getElementById("deactivationModal").style.display = "none";
        document.getElementById("deactivateForm").reset();
        document.getElementById("customReason").style.display = "none";
    }

    document.querySelectorAll('input[name="reason"]').forEach(input => {
        input.addEventListener('change', function () {
            const customReason = document.getElementById("customReason");
            if (this.value === "Other") {
                customReason.style.display = "block";
            } else {
                customReason.style.display = "none";
            }
        });
    });

    function submitDeactivation() {
        const selectedReason = document.querySelector('input[name="reason"]:checked');
        let reason = selectedReason ? selectedReason.value : '';

        if (reason === "Other") {
            reason = document.getElementById("customReason").value.trim();
        }

        if (!reason) {
            alert("Please provide a reason for deactivation.");
            return;
        }

        // Fetch request to deactivate with reason
        fetch(`/deactivate-user/${selectedUserId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ reason })
        })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    showAlert('success', 'Deactivated', data.message, () => location.reload());
                }
                closeDeactivateModal();
            })
            .catch(error => console.error('Error:', error));
    }

    function showAlert(type, title, message, callback = null) {
        Swal.fire({
            title: title,
            text: message,
            icon: type,
            confirmButtonText: 'Close'
        }).then(() => {
            if (callback) callback();
        });
    }
</script>

<script>

    // function filterUsers() {
    //     const input = document.getElementById('searchInput').value.toLowerCase();
    //     const rows = document.querySelectorAll('#usersTable tbody tr');
    //     rows.forEach(row => {
    //         const name = row.cells[1].textContent.toLowerCase();
    //         row.style.display = name.includes(input) ? '' : 'none';
    //     });
    // }
</script>

<script>
    const users = @json($users); // Replace this with actual user data as an array of objects

    let filteredUsers = [...users];
    const usersPerPage = 10;
    let currentPage = 1;

    function calculateTotalPages() {
        return Math.ceil(filteredUsers.length / usersPerPage);
    }

    // Function to render the table based on current page data
    // Capitalize first letter of each word in a string
    function capitalizeFirstLetter(str) {
        if (typeof str !== 'string') return str;
        return str.replace(/\b\w/g, function (char) {
            return char.toUpperCase();
        });
    }

    function renderTable(page) {
        const totalPages = calculateTotalPages();
        const start = (page - 1) * usersPerPage;
        const end = start + usersPerPage;
        const usersToDisplay = filteredUsers.slice(start, end);

        const tableBody = document.getElementById("userTableBody");
        tableBody.innerHTML = usersToDisplay.map(user => {
            // Capitalize user name, role, and status
            const userName = capitalizeFirstLetter(user.name);
            const userRole = capitalizeFirstLetter(user.role);
            const userStatus = user.active_status ? 'Inactive' : 'Active'; // 'Active' is already properly capitalized

            return `
            <tr>
                <td><img src="${user.profile_picture ? 'https://storage.googleapis.com/homeseek-profile-image/' + user.profile_picture : 'https://via.placeholder.com/80x80'}" alt="User Image" width="50"></td>
                <td><a href="javascript:void(0)" onclick="openUserPopup(${user.id})"><strong>${userName}</strong></a></td>
                <td>${capitalizeFirstLetter(userStatus)}</td>
                <td>${userRole}</td>
                <td>${user.strike}</td>
                <td>
                    <button class="btn btn-warning" onclick="openWarningModal(${user.id})">Warn</button>
                    <button class="btn-act" ${user.active_status ? '' : 'hidden'} onclick="activate(${user.id})">Activate</button>
                    <button class="btn-deact" ${user.active_status ? 'hidden' : ''} onclick="openDeactivateModal(${user.id})">Deactivate</button>
                </td>
            </tr>
        `;
        }).join("");

        document.getElementById("currentPage").textContent = page;

        updatePaginationButtons(totalPages);
    }


    // Functions for pagination controls
    function nextPages() {
        const totalPages = calculateTotalPages();
        if (currentPage < totalPages) {
            currentPage++;
            renderTable(currentPage);
        }
    }

    function prevPages() {
        if (currentPage > 1) {
            currentPage--;
            renderTable(currentPage);
        }
    }

    function updatePaginationButtons(totalPages) {
        const prevPageBtns = document.getElementById("prevPageBtns");
        const nextPageBtns = document.getElementById("nextPageBtns");

        prevPageBtns.disabled = currentPage === 1;
        nextPageBtns.disabled = currentPage === totalPages || totalPages === 0; // Disable if no results
    }

    // Filter and paginate function for search
    function filterAndPaginate() {
        const query = document.getElementById("searchBar").value.toLowerCase();
        filteredUsers = users.filter(user => user.name.toLowerCase().includes(query));
        currentPage = 1; // Reset to the first page after filtering
        renderTable(currentPage);
    }

    // Initial render
    renderTable(currentPage);
</script>


@endsection
