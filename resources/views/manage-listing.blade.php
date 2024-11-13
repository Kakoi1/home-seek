@extends('layouts.app')

@section('title', 'My Lisitngs')

@section('content')
<h2 style="text-align:center;">My Accommodations</h2>

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
<br>
<link rel="stylesheet" href="{{asset('css/perdorm.css')}}">
<div style="padding: 20px;">
    <a href="{{'adddorm'}}" class="custom-button">+ List a Accommodation </a>
    <a href="{{ route('owner.archived') }}" class="custom-button">View Archived Accommodation </a>
</div>


<br>
<div class="proper-cont" id="property-list">
    @include('partials.property-list', ['properties' => $properties])
</div>
<div id="pagination-links" class="d-flex justify-content-center">
    {{ $properties->links() }}
</div>

<script src="{{asset('js/dorm.js')}}"></script>

<script>

    function confirmArchive(dormId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('archive-form-' + dormId).submit();
            }
        })
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
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();

        let page = $(this).attr('href').split('page=')[1];

        fetchProperties(page);
    });

    function fetchProperties(page) {
        $.ajax({
            url: "/owner-properties?page=" + page, // Update with your actual route
            success: function (data) {
                $('#property-list').html(data.dorms); // Update the dorm list
                $('#pagination-links').html(data.pagination);
            }
        });
    }
</script>
@endsection