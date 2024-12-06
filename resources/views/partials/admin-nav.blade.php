<style>
    .navbars {
        display: flex;
        /* This makes the div a flex container */
        padding: 20px;
        justify-content: center;
        /* Center the items horizontally */

    }

    .nav-list {
        display: flex;
        /* Make the list items align in a row */
        list-style: none;
        /* Remove bullet points from the list */
        padding: 0;
        /* Remove default padding */
        margin: 0;
        /* Remove default margin */
    }

    .nav-list li {
        margin-right: 20px;
        /* Add space between the links */
    }

    .nav-list li:last-child {
        margin-right: 0;
        /* Remove margin from the last item */
    }

    .link-item {
        text-decoration: none;
        /* Remove underline from links */
        color: white;
        /* Set link color */
        font-size: 16px;
        /* Adjust the font size */
    }

    .link-item i {
        margin-right: 5px;
        /* Space between icon and text */
    }

    .link-item:hover {
        color: #007bff;
        /* Change color on hover */
    }

    .links_name {
        color: white;
    }

    /* General Styling */
    .user-nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
    }

    .nav-menu {
        display: flex;
    }

    .authentic button {
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        padding: 5px 10px;
        background: none;
        font-size: 1rem;
        color: #fff;
        border: none;
        border: #ffffffbe solid 2px;
        transition: background-color 0.3s, color 0.3s;
    }

    .authentic {
        gap: 15px;

    }

    .authenticc,
    .navbars {
        display: flex;
    }

    #hamburger {
        display: none;
        font-size: 24px;
        cursor: pointer;
    }


    /* Responsive Styling */
    @media (max-width: 1030px) {
        .nav-menu {
            display: none;
            flex-direction: column;
            position: absolute;
            top: 60px;
            right: 0;
            width: 100%;
            background: linear-gradient(to right, rgb(11, 136, 147), rgb(54, 0, 51));
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .authentic {
            padding: 0px 20px 20px 20px;
        }

        .nav-list {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: justify;
            line-height: 2;
        }

        .nav-menu.show {
            display: flex;
        }

        .authenticc,
        .navbars {
            flex-direction: column;
            text-align: center;
        }

        #hamburger {
            display: inline-block;
        }


    }
</style>

<nav class="user-nav">
    @php
        $user = auth()->user();
    @endphp
    <div class="sidebar-button">
        @if ($user)
            <i class='bx bx-menu sidebarBtn'></i>
        @elseif(!request()->routeIs('login.view') && !request()->routeIs('register.view'))
            <i class='fa-solid fa-bars' id="hamburger"></i>
            <script>

                document.getElementById('hamburger').addEventListener('click', function () {
                    const navMenu = document.getElementById('navMenu');
                    navMenu.classList.toggle('show');
                });

            </script>
        @endif
        <img src="{{asset('images/5364136.png')}}" width="39px" height="39px" alt="">
        @if ($user)
            @if ($user->role == 'admin')
                <span class="dashboard" onclick="location.href = '{{route('admin.dashboard')}}'">Admin</span>
            @elseif($user->role == 'owner')
                <span class="dashboard" onclick="location.href = '{{route('owner.Dashboard')}}'">Home Seek</span>
            @else
                <span class="dashboard" onclick="location.href = '{{route('home')}}'">Home Seek</span>
            @endif
        @else
            <span class="dashboard" onclick="location.href = '{{route('index')}}'">Home Seek</span>
        @endif
    </div>

    <!-- Collapsible Nav Menu -->
    <div class="nav-menu" id="navMenu">
        @guest
            @if (request()->routeIs('index'))
                <div class="navbars">
                    <ul class="nav-list">
                        <li><a class="link-item" href="/"><i class='bx bx-home-alt'></i><span class="links_name">Home</span></a>
                        </li>
                        <li><a class="link-item" href="#services"><i class='bx bx-headphone'></i><span
                                    class="links_name">Services</span></a></li>
                        <li><a class="link-item" href="#portfolio"><i class='bx bx-briefcase-alt-2'></i><span
                                    class="links_name">Overview</span></a></li>
                        <li><a class="link-item" href="#about"><i class='bx bx-message-alt-check'></i><span
                                    class="links_name">About us</span></a></li>
                        <li><a class="link-item" href="#contact"><i class='bx bx-phone-call'></i><span
                                    class="links_name">Contact Us</span></a></li>
                    </ul>
                </div>


            @endif
            <div class="authentic form-inline my-2 my-lg-0">
                <button onclick="window.location.href='{{ route('login') }}'">Login</button>
                <button onclick="window.location.href='{{ route('register') }}'">Register</button>
            </div>
        @else
            </div>

            <div class="profile-details">
                <img src="{{ $user->profile_picture ? asset('https://storage.googleapis.com/homeseek-profile-image/' . $user->profile_picture) : 'https://via.placeholder.com/80x80' }}"
                    alt="Profile Picture" width="40px" height="40px">
                <span class="admin_name">{{ $user->name }}</span>
                <i class='bx bx-chevron-down'></i>
                <div class="dropdownMenu">
                    <ul>
                        <li><a style="color: #333333;" onclick="openUserPopup({{Auth::id()}})">Profile</a></li>
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
    </div>
</nav>


<script>
    // Define global JavaScript variables for routes
    window.routes = {

        notificationUrl: "{{ route('notifies') }}",

        markNotificationUrl: "{{ route('markAsRead', ':id') }}", // Route with placeholder for notification ID

        homeUrl: "{{ route('home') }}",
        mapUrl: "{{route('dorms.posted', ':dormId')}}"
    };

    document.addEventListener('DOMContentLoaded', function () {
        try {


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
        } catch (error) {

        }
    });
</script>