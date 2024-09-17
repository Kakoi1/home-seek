@extends('layouts.admin')

@section('manage user')

@section('content')

<body>

    <section class="home-section">
        @include('partials.admin-nav')

        <!-- main  content -->
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

                <div class="user-boxes" id="users-section">
                    @foreach($users as $user)
                        @if ($user->role != 'admin')
                            <div class="user-box">
                                <img src="{{ $user->profile_picture ? asset('storage/profile_pictures/' . $user->profile_picture) : 'https://via.placeholder.com/80x80' }}"
                                    alt="User Image">
                                <div class="user-info">
                                    <h4>{{ $user->name }}</h4>
                                    <p>Status: {{ $user->active_status ? 'Inactive' : 'Active' }}</p>
                                    <p>Role: {{ $user->role }}</p>
                                    <p>{{ $user->role == 'owner' ? 'Verified' : 'Not Verified' }}</p>
                                </div>
                                <div class="buttons">
                                    <button class="btn-act" {{ $user->active_status ? '' : 'hidden' }}
                                        onclick="activate({{ $user->id }})">Activate</button>
                                    <button class="btn-deact" {{ $user->active_status ? 'hidden' : '' }}
                                        onclick="deactivate({{ $user->id }})">Deactivate</button>
                                    <button class="btn-manage" onclick="manageUser({{ $user->id }})">Manage</button>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="user-boxes" id="verify-section" style="display:none;">
                    @foreach($verificationRequests as $verify)
                        <div class="user-box">
                            <img src="{{ $verify->user->profile_picture ? asset('storage/profile_pictures/' . $verify->user->profile_picture) : 'https://via.placeholder.com/80x80' }}"
                                alt="User Image">
                            <div class="user-info">
                                <h4>{{ $verify->user->name }}</h4>
                                <p style="text-decoration: underline; color: blue; cursor: pointer;"
                                    onclick="openModal({{ $verify }})">Requesting Verification
                                </p>
                            </div>
                            <div class="buttons">
                                <button class="btn-approve" onclick="approveVerification({{ $verify->id }})">Approve
                                </button>
                                <button class="btn-decline" onclick=" openRejectModal({{ $verify->id }})">Reject</button>
                            </div>
                        </div>
                    @endforeach
                </div>
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
        </div>
    </section>
    <div id="verifyModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>User Verification Details</h2>
            <div class="valid-id">
                <div>
                    <label for="idDoc">Valid Id:</label>
                    <!-- Image container to display submitted images -->
                    <img id="idDoc" src="" alt="Submitted Document" class="clickable-img"
                        style="width: 100%; height: 500px;">
                </div>
                <br>
                <div>
                    <label for="permit">Business Permit:</label>
                    <img id="permit" src="" alt="Submitted Document" class="clickable-img"
                        style=" width: 100%; height: 500px;">
                </div>
            </div>
        </div>
        <div id="imagePopup" class="popup">
            <span class="closepopup">&times;</span>
            <img class="popup-content" id="fullImage">
            <div id="caption"></div>
        </div>
    </div>


    <script>
        function showSection(section) {
            // Hide both sections initially
            document.getElementById('users-section').style.display = 'none';
            document.getElementById('verify-section').style.display = 'none';

            // Show the selected section
            if (section === 'users') {
                document.getElementById('users-section').style.display = 'flex';
            } else if (section === 'verify') {
                document.getElementById('verify-section').style.display = 'flex';
            }

            // Update button active class
            document.querySelectorAll('.filter-btn').forEach(function (btn) {
                btn.classList.remove('active');
            });
            document.querySelector(`[data-filter="${section}"]`).classList.add('active');
        }
        // Function to open the modal and display the user's submitted image
        function openModal(userId) {
            // You can fetch the image from the backend using an API call or pass the image path directly
            const modal = document.getElementById('verifyModal');
            const idDoc = document.getElementById('idDoc');
            const permit = document.getElementById('permit');

            // Use an AJAX call to fetch the user's submitted document based on userId if needed
            // Example: userImage.src = 'path_to_user_image';

            // For demonstration, let's assume the image URL is stored in a variable
            idDoc.src = '/storage/id_documents/' + userId.id_document;
            permit.src = '/storage/business_permits/' + userId.business_permit;


            // Display the modal
            modal.style.display = "block";
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById('verifyModal').style.display = "none";
        }

        // Close modal if clicked outside the content
        window.onclick = function (event) {
            const modal = document.getElementById('verifyModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Get the modal
        var popup = document.getElementById("imagePopup");

        // Get the full-size image and caption
        var fullImage = document.getElementById("fullImage");
        var captionText = document.getElementById("caption");

        // Get all images with the class 'clickable-img'
        var images = document.getElementsByClassName("clickable-img");

        for (let i = 0; i < images.length; i++) {
            images[i].onclick = function () {
                popup.style.display = "block";
                fullImage.src = this.src; // Use the same image source
                captionText.innerHTML = this.alt; // Use the alt text as caption
            }
        }

        // When the user clicks on <span> (x), close the modal
        var closeBtn = document.getElementsByClassName("closepopup")[0];
        closeBtn.onclick = function () {
            popup.style.display = "none";
        }

        // When the user clicks anywhere outside the modal, close it
        window.onclick = function (event) {
            if (event.target == popup) {
                popup.style.display = "none";
            }
        }

        function approveVerification(verificationId) {

            // Send an AJAX request to approve the verification
            fetch(`/approve-verification/${verificationId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Pass the CSRF token for security
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        showAlert('success', 'Success', data.message, function () {
                            location.reload(); // Reload or update UI after approval
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });

        }

        let selectedVerificationId = null;

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

            // Send an AJAX request to reject the verification
            fetch(`/reject-verification/${selectedVerificationId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Pass the CSRF token for security
                },
                body: JSON.stringify({
                    reason: reason
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        closeRejectModal();
                        showAlert('success', 'Rejected', data.message, function () {

                            location.reload();
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
        function activate(userId) {
            fetch(`/activate-user/${userId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        showAlert('success', 'Activated', data.message, function () {
                            location.reload();
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function deactivate(userId) {
            fetch(`/deactivate-user/${userId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        showAlert('success', 'Deactivated', data.message, function () {
                            location.reload();
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function showAlert(type, title, message, callback = null) {
            Swal.fire({
                title: title,
                text: message,
                icon: type,
                confirmButtonText: 'Close'
            }).then(() => {
                if (callback) {
                    callback();
                }
            });
        }


    </script>



    @endsection