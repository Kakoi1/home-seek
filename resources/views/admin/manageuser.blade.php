@extends('layouts.app')

@section('manage user')

@section('content')

<body>

    <!-- Main content -->
    <div class="home-content">
        <div class="container">
            <h2>Manage Users</h2>
            <!-- Filter Buttons -->
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="users" onclick="showSection('users')">Users</button>
                <button class="filter-btn" data-filter="verify" onclick="showSection('verify')">Verify
                    Request <span class="requestCount" style="display: {{$req ? '' : 'none'}};">{{$req}}</span>
                </button>
            </div>

            <!-- Users Table -->
            <div id="users-section">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Role</th>
                            <th>Verification Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
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
                                        <button class="btn-manage" onclick="manageUser({{ $user->id }})">Manage</button>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Verification Requests Table -->
            <div id="verify-section" style="display:none;">
                <table class="table table-striped">
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
                    <br>
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
                    <br>
                    <div>
                        <label for="permit">Business Permit:</label>
                        <img id="permit" src="" alt="Submitted Document" class="clickable-img"
                            style="width: 100%; height: 500px;">
                    </div>
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

                document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
                document.querySelector(`[data-filter="${section}"]`).classList.add('active');
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

            function deactivate(userId) {
                fetch(`/deactivate-user/${userId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            showAlert('success', 'Deactivated', data.message, () => location.reload());
                        }
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

</body>

@endsection