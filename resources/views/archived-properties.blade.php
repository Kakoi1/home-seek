@extends('layouts.app')

@section('title', 'Archived Properties')

@section('content')
<style>
    .custom-button {
        display: inline-block;
        padding: 10px 20px;
        background-color: #0b8893;
        color: white;
        text-decoration: none;/ font-size: 1rem;
        border-radius: 8px;
        transition: background-color 0.3s ease, transform 0.3s ease;
        margin: 15px 0;

    }

    .custom-button:hover {
        background-color: #04656d;
        transform: translateY(-3px);
        color: white;
    }

    .proper {
        height: 100% !important;
    }

    .cards {
        margin-top: 10px !important;
    }

    .dropdown-toggle {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 16px;
        padding: 0;
        margin-left: auto;
        margin-left: 100px;
        position: relative;
        left: -120px;
    }

    /* Style for dropdown items */
    .dropdown-menu a {
        text-decoration: none;
        color: black;
        display: block;
        padding: 5px;
    }

    .dropdown-menu a:hover {
        background-color: #f0f0f0;
    }

    /* Style for the delete button */
    .dropdown-item.text-danger {
        color: red;
    }

    .dropdown-item.text-danger:hover {
        background-color: #ffe6e6;
    }
</style>
<h2>Archived Properties</h2>
<link rel="stylesheet" href="{{asset('css/perdorm.css')}}">
<div style="padding: 20px;">
    <a href="{{ route('owner.Property') }}" class="custom-button">Back to Active Properties</a>
</div>

<div class="proper-cont" id="archived-property-list">
    @if ($properties->isEmpty())
        <h4>No Archived Accomodation found</h4>
    @else
        @include('partials.property-list', ['properties' => $properties])
    @endif
</div>

<div id="archived-pagination-links" class="d-flex justify-content-center">
    {{ $properties->links() }}
</div>

<script src="{{asset('js/dorm.js')}}"></script>
<script>

    function restoreDorm(dormId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will restore the Accomodation!",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, restore it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // You can create a route that handles restoring the dorm
                $.ajax({
                    url: '/dorms/restore/' + dormId, // Use the appropriate route for restoring the dorm
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        Swal.fire('Restored!', 'The Accomodation has been restored.', 'success');
                        location.reload();
                    }
                });
            }
        });
    }

    function toggleDropdown(dormId) {
        var dropdownMenu = document.getElementById('dropdown-menu-' + dormId);
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    }

    // Close dropdown if clicked outside
    window.onclick = function (event) {
        if (!event.target.matches('.dropdown-toggle')) {
            var dropdowns = document.getElementsByClassName('dropdown-menu');
            for (var i = 0; i < dropdowns.length; i++) {
                dropdowns[i].style.display = 'none';
            }
        }
    }


</script>
<script>
    $(document).on('click', '#archived-pagination-links a', function (e) {
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        fetchArchivedProperties(page);
    });

    function fetchArchivedProperties(page) {
        $.ajax({
            url: "/owner-properties/archived?page=" + page,
            success: function (data) {
                $('#archived-property-list').html(data.archived_dorms); // Update archived dorms
                $('#archived-pagination-links').html(data.archived_pagination); // Update pagination
            },
            error: function () {
                alert("An error occurred while fetching data.");
            }
        });
    }

</script>
@endsection