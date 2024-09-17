<!DOCTYPE html>
<!-- Coding by CodingNepal | www.codingnepalweb.com -->
<html lang="en" dir="ltr">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Homeseek Admin Dashboard | CodingLab </title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
</head>

<body>
    <header>

    </header>

    <div class="admin-container">
        @include('partials.side-bar')
        @yield('content')
    </div>

    @include('partials.footer')
</body>

<script>

    Pusher.logToConsole = true;
    var userId = {{auth()->id()}}
    // Initialize Pusher
    var pusher = new Pusher('dcc0e13b5e4470612577', {
        cluster: 'ap1'
    });

    // Subscribe to the channel
    var channel = pusher.subscribe('user.' + userId);

    // Bind to the event
    channel.bind('test.notification', function (data) {
        console.log('Received data:', data); // Debugging line

        // Display Toastr notification with icons and inline content
        if (data.sender && data.message) {
            const markAsReadUrl = `{{ url('markAsRead') }}/${data.rooms}`;
            toastr.info(
                `<div class="notification-content" onclick = 'location.href = "${markAsReadUrl}"'>
                        <i class="fas fa-book" style="margin-left: 20px;"></i> <span>  ${data.message}</span><br>
                        <i class="fas fa-user"></i> <span>  <strong>From: </strong> ${data.sender.name}</span>
                    </div>`,
                'New Post Notification',
                {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 0, // Set timeOut to 0 to make it persist until closed
                    extendedTimeOut: 0, // Ensure the notification stays open
                    positionClass: 'toast-top-right',
                    enableHtml: true
                }
            );
        } else {
            console.error('Invalid data received:', data);
        }
    });

    // Debugging line
    pusher.connection.bind('connected', function () {
        console.log('Pusher connected');
    });

    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".sidebarBtn");
    sidebarBtn.onclick = function () {
        sidebar.classList.toggle("active");
        if (sidebar.classList.contains("active")) {
            sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        } else
            sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
    }
</script>

</html>