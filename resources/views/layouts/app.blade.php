@php
    use Diglactic\Breadcrumbs\Breadcrumbs;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'HomeSeek')</title>

    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>

    </style>
    <script src="{{ asset('js/map.js') }}"></script>
    <script src="{{asset('js/navbar.js')}}"></script>

</head>

<body>
    @if (Auth::user())
        @include('partials.pusher')
        @include('partials.side-bar')

    @else
        <style>
            .home-section .user-nav {
                width: calc(100% - 0px);
                left: 0px;
            }

            .home-section {
                min-height: 100vh;
                width: calc(100% - 0px);
                left: 0px;
            }
        </style>
    @endif



    <div class="" style="overflow: auto">

        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    let errorList = '<ul>';
                    @foreach ($errors->all() as $error)
                        errorList += '<li>{{ $error }}</li>';
                    @endforeach
                    errorList += '</ul>';

                    Swal.fire({
                        title: 'Validation Errors',
                        html: errorList,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
            </script>
        @endif

    </div>

    <section class="home-section">
        @include('partials.admin-nav')
        @if (Auth::user())
            <br><br>
            @if (!request()->routeIs('owner.Dashboard') && !request()->routeIs('home') && !request()->routeIs('admin.Dashboard'))
                {{ Breadcrumbs::render() }}
            @endif

            <br><br>
        @endif
        @yield('content')
    </section>

    @include('partials.footer')
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            @if ($errors->any())
                alert('There were some errors with your submission. Please check the fields and try again.');
            @endif
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.js"></script>
    <style></style>

    <script src="{{ asset('js/search.js') }}"></script>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            });

        </script>

    @endif
    <script>
        let sidebar = document.querySelector(".sidebar");
        let logo = document.querySelector(".logo_name");
        let sidebarBtn = document.querySelector(".sidebarBtn");
        sidebarBtn.onclick = function () {
            sidebar.classList.toggle("active");
            if (sidebar.classList.contains("active")) {
                sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
            } else
                sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
        }
    </script>
</body>

</html>