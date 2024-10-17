<div class="sidebar">
    @if (!request()->routeIs('login.view') && !request()->routeIs('register.view'))
        <div class="logo-details">
            <img src="{{asset('images/5364136.png')}}" width="39px" height="39px" alt="">
            <span class="logo_name">HomeSeek</span>
        </div>

    @endif
    <ul class="nav-links">
        @guest
            @if (request()->routeIs('index'))
                <li><a class="link-item" href="/"><i class='bx bx-home-alt'></i><span class="links_name">Home</span></a></li>
                <li><a class="link-item" href="#services"><i class='bx bx-headphone'></i><span
                            class="links_name">Services</span></a></li>
                <li><a class="link-item" href="#portfolio"><i class='bx bx-briefcase-alt-2'></i><span
                            class="links_name">Overview</span></a></li>
                <li><a class="link-item" href="#about"><i class='bx bx-message-alt-check'></i><span class="links_name">About
                            us</span></a></li>
                <li><a class="link-item" href="#contact"><i class='bx bx-phone-call'></i><span class="links_name">Contact
                            Us</span></a></li>
                <br>

            @endif
        @else
            @if (auth()->user()->role == 'owner')
                <!-- Owner------------------------ -->
                <li>
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class='bx bx-grid-alt'></i>
                        <span class="links_name">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('user.rentForms') }}" class="{{ request()->routeIs('user.rentForms') ? 'active' : '' }}">
                        <i class='bx bxs-book'></i>
                        <span class="links_name">Booked Property</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('') ? 'active' : '' }}">
                        <i class='bx bxs-heart-square'></i>
                        <span class="links_name">Favourites</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('') ? 'active' : '' }}">
                        <i class='bx bx-list-check'></i>
                        <span class="links_name">Manage Listings</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('managetenant') }}" class="{{ request()->routeIs('managetenant') ? 'active' : '' }}">
                        <i class='bx bx-user-check'></i>
                        <span class="links_name">Manage Tenants</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('myReviews') }}" class="{{ request()->routeIs('myReviews') ? 'active' : '' }}">
                        <i class="fa-solid fa-comments"></i>
                        <span class="links_name">My Reviews</span>
                    </a>
                </li>

            @elseif(auth()->user()->role == 'admin')
                <!-- admin------------------------ -->
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


            @else
                <!---------- tenant-------- -->
                <li>
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class='bx bx-grid-alt'></i>
                        <span class="links_name">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('user.rentForms') }}" class="{{ request()->routeIs('user.rentForms') ? 'active' : '' }}">
                        <i class='bx bxs-book'></i>
                        <span class="links_name">Booked Property</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('') ? 'active' : '' }}">
                        <i class='bx bxs-heart-square'></i>
                        <span class="links_name">Favourites</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('myReviews') }}" class="{{ request()->routeIs('myReviews') ? 'active' : '' }}">
                        <i class="fa-solid fa-comments"></i>
                        <span class="links_name">My Reviews</span>
                    </a>
                </li>
            @endif


            <li class="log_out" class="link-item">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class='bx bx-log-out'></i>
                    <span class="links_name">Log out</span>
                </a>
            </li>
        @endguest


    </ul>

</div>

<script>


</script>