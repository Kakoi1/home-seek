<nav>
    @php
        $user = auth()->user();
    @endphp
    <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Admin</span>
    </div>
    <div class="search-box">
        <input type="text" placeholder="Search...">
        <i class='bx bx-search'></i>
    </div>
    <div class="profile-details">
        <img src="{{ asset('storage/profile_pictures/' . $user->profile_picture) }}" alt="Profile Picture" width="40px"
            height="40px">
        <span class="admin_name">{{$user->name}}</span>
        <i class='bx bx-chevron-down'></i>
        <!-- Dropdown Menu -->
        <div class="dropdown-menu">
            <ul>
                <li><a href="#">Profile</a></li>
                <li><a href="#">Settings</a></li>
                <li><a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>

</nav>