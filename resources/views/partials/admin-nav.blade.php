<nav class="user-nav">
    @php
        $user = auth()->user();
    @endphp
    <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        @if ($user)
            @if ($user->role == 'admin')
                <span class="dashboard" onclick="location.href = '{{route('admin.dashboard')}}'">Admin</span>
            @else
                <span class="dashboard" onclick="location.href = '{{route('home')}}'">Home Seek</span>
            @endif

        @else
            <span class="dashboard" onclick="location.href = '{{route('index')}}'">Home Seek</span>
        @endif

    </div>


    @guest
        @if (request()->routeIs('index'))
            <div class="authenticc ml-auto">
                <button onclick="window.location.href='{{ route('login') }}'">Login</button>
                <button onclick="window.location.href='{{ route('register') }}'">Register</button>
            </div>
        @endif
    @else

        <div class="profile-details">
            <img src="{{ $user->profile_picture ? asset('storage/profile_pictures/' . $user->profile_picture) : 'https://via.placeholder.com/80x80' }}"
                alt="Profile Picture" width="40px" height="40px">
            <span class="admin_name">{{ $user->name }}</span>
            <i class='bx bx-chevron-down'></i>
            <div class="dropdownMenu">
                <ul>
                    <li><a href="{{route('profile')}}">Profile</a></li>
                    <li><a href="#">Settings</a></li>
                    <li><a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
            &nbsp;
            &nbsp;
            <div class="notification-wrapper">
                <i class='bx bxs-bell-ring' id="notificationIcon"></i>
                <span id="notificationCount" class="notification-count">0</span>
                <!-- Notification Dropdown Menu -->
                <div id="notificationsMenu" class="dropdownMenu notifications">
                    <!-- Notifications will be dynamically populated -->
                </div>
            </div>
            <!-- Dropdown Menu -->

        </div>


    @endguest


</nav>

<script>
    // Define global JavaScript variables for routes
    window.routes = {
        chatroomsUrl: "{{ route('fetchChatrooms') }}",
        roomchatUrl: "{{ route('chatroom.Chatroom') }}",
        notificationUrl: "{{ route('notifies') }}",
        dormUrl: "{{ route('dorm.chat', ['dorm' => ':id', 'chatroom' => ':room_id']) }}",
        roomUrl: "{{ route('room.chat', ['room' => ':id', 'roomchat' => ':room_id']) }}",
        markNotificationUrl: "{{ route('markAsRead', ':id') }}", // Route with placeholder for notification ID
        roomEditUrl: "{{ route('room.edit', ['id' => ':room_id', 'action' => 'view']) }}",  // Route with placeholder for room_id
        homeUrl: "{{ route('home') }}",
        mapUrl: "{{route('dorms.posted', ':dormId')}}"
    };

    document.addEventListener('DOMContentLoaded', function () {
        // Select the chevron icon and the dropdown menu
        const chevronIcon = document.querySelector('.bx-chevron-down');
        const dropdownMenu = document.querySelector('.dropdownMenu');

        // Add click event listener to the chevron icon
        chevronIcon.addEventListener('click', function () {
            // Toggle the 'show' class on the dropdown menu to show/hide it
            dropdownMenu.classList.toggle('show');
        });

        // Close the dropdown if clicking outside of it
        document.addEventListener('click', function (event) {
            // Check if the clicked element is not inside the profile details container
            if (!event.target.closest('.profile-details')) {
                dropdownMenu.classList.remove('show');
            }
        });
    });
</script>