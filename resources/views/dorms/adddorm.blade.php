@extends('layouts.app')

@section('title', $dorm ? 'Edit Dorm' : 'Add Dorm')

@section('content')
<style>
    .image-preview {
        display: inline-block;
        position: relative;
        margin: 10px;
    }

    .image-preview img {
        display: block;
    }

    .image-preview button {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: red;
        color: white;
        border: none;
        padding: 5px;
        cursor: pointer;
    }

    /* Form Container */
    .form-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        padding: 20px;
    }

    .form-group {
        flex: 0 0 48%;
        /* margin-bottom: 15px; */
    }

    /* -------------------------- */
    /* custombutton style */
    .custom-button {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        color: #fff;
        background-color: #3c8a4b;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .custom-button:hover {
        background-color: #094314;
    }

    .custom-button:active {
        background-color: #004080;
        transform: scale(0.98);
    }

    .custom-button:focus {
        outline: none;
    }

    /* ___________________________________ */
    h1,
    .custom-button {
        margin-left: 20px;
    }

    h1 {
        padding: 15px 18px;
        border-left: 10px solid cadetblue;
        border-radius: 6px;
        margin: 1.2rem;
    }

    .form-group label {
        font-weight: 500;
    }

    .form-group.image {
        margin: 10px;
    }
</style>

<h1>{{ $dorm ? 'Edit Dorm' : 'Add a Dorm' }}</h1>

<button type="button" class="custom-button" onclick="getUserLocation()"><i class="fas fa-map-marker-alt"></i> Get My
    Location</button>

<form id="locationForm" method="post" action="{{ $dorm ? route('dorms.update', $dorm->id) : route('savedorm') }}"
    enctype="multipart/form-data">
    @csrf
    @if($dorm)
        @method('PUT')
    @endif
    <div class="form-container">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $dorm->name ?? old('name') }}"
                required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description"
                name="description">{{ $dorm->description ?? old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address"
                placeholder="Click the address on the map" value="{{ $dorm->address ?? old('address') }}" required>
        </div>

        <div class="form-group">
            <label for="type">Type</label>
            <select class="form-control" id="type" name="type">
                <option value="" disabled {{ old('type') == '' ? 'selected' : '' }}>Select Type</option>
                <option value="dorm" {{ (old('type') == 'dorm' || (isset($dorm) && is_object($dorm) && $dorm->type == 'dorm')) ? 'selected' : '' }}>Dorm</option>
                <option value="apartment" {{ (old('type') == 'apartment' || (isset($dorm) && is_object($dorm) && $dorm->type == 'apartment')) ? 'selected' : '' }}>Apartment</option>
            </select>
        </div>


        <div class="form-group">

            <input type="hidden" class="form-control" id="latitude" name="latitude"
                value="{{ $dorm->latitude ?? old('latitude') }}" required>
        </div>

        <div class="form-group">

            <input type="hidden" class="form-control" id="longitude" name="longitude"
                value="{{ $dorm->longitude ?? old('longitude') }}" required>
        </div>

        <div class="form-group">
            <label for="rooms_available">Rooms Available</label>
            <input type="number" class="form-control" id="rooms_available" name="rooms_available"
                value="{{ $dorm->rooms_available ?? old('rooms_available') }}" required>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="text" class="form-control" id="price" name="price" value="{{ $dorm->price ?? old('price') }}"
                required>
        </div>
    </div>

    <div class="form-group image">
        <label for="image">Image</label>
        <input type="file" name="image[]" id="image" multiple {{ $dorm ? '' : 'required' }}>
        <div id="image-preview-container">
            @if($dorm && $dorm->image)
                @foreach(json_decode($dorm->image) as $index => $images)
                    <div class="image-preview" id="image-preview-{{ $index }}">
                        <img src="{{ asset('storage/dorm_pictures/' . $images) }}" style="width: 250px; height: 250px;">
                        <button type="button" id="remove-button-{{ $index }}"
                            onclick="removeExistingImage({{ $index }})">Remove</button>
                        <input type="text~" name="existing_images[]" value="{{ $images }}">
                    </div>
                @endforeach
            @endif
        </div>
    </div>


    <button type="button" onclick="showmap()">Show Map</button>
    <br>
    <input type="submit" value="{{ $dorm ? 'Update Dorm' : 'Add Dorm' }}">
</form>

@if(!$dorm)
    <form method="get" action="{{ route('showdorms') }}">
        <button type="submit">Show Dorms</button>
    </form>
@endif

<div id="map" style="width: 100%; height: 500px;">
    @if ($dorm)
        <script id="dorms-data" type="application/json">
                                                                                                                                                                                                                                                                                                                                {!! json_encode($dorm) !!}
                                                                                                                                                                                                                                                                                                                            </script>
    @endif

</div>

<script>
    let allFiles = Array.from(document.getElementById('image').files);

    document.getElementById('image').addEventListener('change', function (event) {
        const imagePreviewContainer = document.getElementById('image-preview-container');
        const files = event.target.files;

        if (files.length + allFiles.length > 6) {
            alert('You can upload a maximum of 6 images.');
            return;
        }

        Array.from(files).forEach(file => {
            allFiles.push(file);
            const reader = new FileReader();
            reader.onload = function (e) {
                const imagePreview = document.createElement('div');
                imagePreview.classList.add('image-preview');
                imagePreview.id = `new-image-preview-${allFiles.length - 1}`;

                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '250px';
                img.style.height = '250px';

                const removeButton = document.createElement('button');
                removeButton.textContent = 'Remove';
                removeButton.id = `remove-new-button-${allFiles.length - 1}`;
                removeButton.onclick = function () {
                    removeImage(allFiles.length - 1);
                };

                imagePreview.appendChild(img);
                imagePreview.appendChild(removeButton);
                imagePreviewContainer.appendChild(imagePreview);
            };
            reader.readAsDataURL(file);
        });

        updateFileInput();
    });

    function removeImage(index) {
        allFiles.splice(index, 1);
        document.getElementById(`new-image-preview-${index}`).remove();
        updateFileInput();
    }

    function updateFileInput() {
        const dataTransfer = new DataTransfer();
        allFiles.forEach(file => dataTransfer.items.add(file));
        document.getElementById('image').files = dataTransfer.files;
    }

    function removeExistingImage(index) {
        document.getElementById(`image-preview-${index}`).remove();
        // You can add code here to handle the removal of the image from the server if needed
    }
</script>

@endsection