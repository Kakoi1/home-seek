<div class="sidebar">
    <div class="logo-details">
        <!-- <i class='bx bx-user'></i> -->
        <span class="logo_name">Home<span>Seek</span></span>
    </div>
    <ul class="nav-links">
        <li>
            <a href="{{ route('admin.dashboard') }}"
                class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class='bx bx-grid-alt'></i>
                <span class="links_name">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="#" class="link-item">
                <i class='bx bx-home-smile'></i>
                <span class="links_name">Manage Listings</span>

            </a>
        </li>
        <li>
            <a href="{{route('admin.manageuser')}}"
                class="{{ request()->routeIs('admin.manageuser') ? 'active' : '' }}">
                <i class='bx bx-group'></i>
                <span class="links_name">Manage Users</span>
            </a>
        </li>
        <li>
            <a href="#" class="link-item">
                <i class='bx bx-pie-chart-alt-2'></i>
                <span class="links_name">Analytics</span>
            </a>
        </li>


        <li class="log_out" class="link-item">
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class='bx bx-log-out'></i>
                <span class="links_name">Log out</span>
            </a>
        </li>
    </ul>
</div>