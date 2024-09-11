<header>
    <nav class="navbar ">
        <h2 class="logo"><a href="/home">Home <span>Seek</span></a></h2>
        <input type="checkbox" id="menu-toggler">
        <label for="menu-toggler" id="hamburger-btn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="24px" height="24px">
                <path d="M0 0h24v24H0z" fill="none" />
                <path d="M3 18h18v-2H3v2zm0-5h18V11H3v2zm0-7v2h18V6H3z" />
            </svg>
        </label>

        <ul class="all-links ml-auto ">
            @guest
                <li><a href="/">Home</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#portfolio">Overview</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact Us</a></li>
                <div class="authenticc ml-auto">
                    <button onclick="window.location.href='{{ route('login') }}'">Login</button>
                    <button onclick="window.location.href='{{ route('register') }}'">Register</button>
                </div>
            @else 
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="chatroomDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Messages <span id="messageCount" class="badge badge-danger"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="chatroomDropdown">
                        <!-- Chatrooms will be appended here by JavaScript -->
                        <div id="chatroomDropdownMenu"></div>

                    </div>


                </li>

                <li class="nav-item dropdown">
                    <a id="notificationsDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Notifications <span id="notificationCount" class="badge badge-danger"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationsDropdown">
                        <div id="notificationsMenu"></div>
                    </div>
                </li>


                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false" v-pre>
                        <img src="{{ asset('storage/profile_pictures/' . Auth::user()->profile_picture) }}"
                            alt="Profile Picture" style="width: 30px; height: 30px;">
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <a class="dropdown-item" href="{{ route('profile') }}">
                            Profile
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                <!-- <script src="{{asset('js/navbar.js')}}"></script> -->
            @endguest
        </ul>
    </nav>
</header>