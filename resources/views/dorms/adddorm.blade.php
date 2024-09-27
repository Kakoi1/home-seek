@extends('layouts.app')

@section('title', $dorm ? 'Edit Property' : 'List Property')

@section('content')
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        color: #333;
        margin: 0;
        padding: 0;
    }

    h1 {
        text-align: center;
        font-size: 2rem;
        margin-bottom: 20px;
    }

    form {
        max-width: 800px;
        margin: 0 auto;
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        height: 100%;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        font-size: 1rem;
    }

    textarea {
        resize: vertical;
        min-height: 100px;
    }

    button[type="button"],
    button[type="submit"] {
        display: inline-block;
        border-color: #007bff;
        background: linear-gradient(to right, rgba(11, 136, 147, 0.911), rgba(54, 0, 51, 0.877));
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1rem;
        margin-top: 10px;
        transition: background-color 0.3s ease;
    }

    button[type="button"]:hover,
    button[type="submit"]:hover {
        background-color: #0056b3;
    }

    /* Image Preview Section */
    #image-preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
        margin-top: 15px;
    }

    .image-preview {
        position: relative;
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
        width: 200px;
        height: 200px;
    }

    .image-preview img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-preview button {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: red;
        color: white;
        border: none;
        padding: 5px 8px;
        border-radius: 50%;
        font-size: 0.8rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .image-preview button:hover {
        background-color: darkred;
    }

    /* Map Overlay Styles */
    #map-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    #map-container {
        width: 90%;
        max-width: 900px;
        height: 700px;
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    #map {
        width: 100%;
        height: 100%;
        background-color: #eaeaea;
    }

    /* Close Button on Map Overlay */
    .close-map-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: red;
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        text-align: center;
        line-height: 30px;
        cursor: pointer;
        font-size: 1.2rem;
        z-index: 10;
    }

    .close-map-btn:hover {
        background-color: darkred;
    }
</style>
<div>
    <h1>{{ $dorm ? 'Edit Property' : 'List Property' }}</h1>

    <form id="locationForm" method="post" action="{{ $dorm ? route('dorms.update', $dorm->id) : route('savedorm') }}"
        enctype="multipart/form-data">
        @csrf
        @if($dorm)
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ $dorm->name ?? old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description">{{ $dorm->description ?? old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <button type="button" onclick="getUserLocation()">Get My Address</button> <button type="button"
                onclick="showMap()">Show Map</button><br><br>
            <input type="text" id="address" readonly name="address" value="{{ $dorm->address ?? old('address') }}"
                required>
        </div>

        <div class="form-group">
            <label for="type">Type</label>
            <select id="type" name="type">
                <option value="" disabled {{ old('type') == '' ? 'selected' : '' }}>Select Type</option>
                <option value="dorm" {{ (old('type') == 'dorm' || (isset($dorm) && is_object($dorm) && $dorm->type == 'dorm')) ? 'selected' : '' }}>Dorm</option>
                <option value="apartment" {{ (old('type') == 'apartment' || (isset($dorm) && is_object($dorm) && $dorm->type == 'apartment')) ? 'selected' : '' }}>Apartment</option>
            </select>
        </div>

        <div class="form-group">
            <input type="hidden" id="latitude" name="latitude" value="{{ $dorm->latitude ?? old('latitude') }}"
                required>
        </div>

        <div class="form-group">
            <input type="hidden" id="longitude" name="longitude" value="{{ $dorm->longitude ?? old('longitude') }}"
                required>
        </div>

        <div class="form-group">
            <label for="rooms_available">Rooms Available</label>
            <input type="number" id="rooms_available" name="rooms_available"
                value="{{ $dorm->rooms_available ?? old('rooms_available') }}" required>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="text" id="price" name="price" value="{{ $dorm->price ?? old('price') }}" required>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image[]" accept="image/png, image/gif, image/jpeg" id="image" multiple {{ $dorm ? '' : 'required' }}>
            <div id="image-preview-container">
                @if($dorm && $dorm->image)
                    @foreach(json_decode($dorm->image) as $index => $images)
                        <div class="image-preview" id="image-preview-{{ $index }}">
                            <img src="{{ asset('storage/dorm_pictures/' . $images) }}">
                            <button type="button" onclick="removeExistingImage({{ $index }})">X</button>
                            <input type="hidden" name="existing_images[]" value="{{ $images }}">
                        </div>
                    @endforeach
                @endif
            </div>
        </div>


        <button type="submit">{{ $dorm ? 'Update Post' : 'Post' }}</button>
    </form>

    @if(!$dorm)



    @endif

    <!-- Map Overlay Container -->
    <div id="map-overlay" class="overlays">
        <button class="close-map-btn" onclick="closeMap()">×</button>
        <div id="map-container">
            <div id="map" style="width: 100%; height: 100%;">
                @if ($dorm)
                    <script id="dorms-data" type="application/json">
                                                                                                                                                                        {!! json_encode($dorm) !!}
                                                                                                                                                                    </script>
                @endif

            </div>
        </div>
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
                    img.style.width = '200px';
                    img.style.height = '200px';

                    const removeButton = document.createElement('button');
                    removeButton.textContent = 'X';
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
</div>
<br><br>
@endsection