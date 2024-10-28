@extends('layouts.app')

@section('title', 'Dorm Details')

@section('content')
<style>
    .upload-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 20px;
        font-family: Arial, sans-serif;
        background: #fefefe;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    h2 {
        color: #444;
        margin-bottom: 20px;
    }

    .drop-area {
        border: 2px dashed #4A90E2;
        border-radius: 8px;
        padding: 40px;
        position: relative;
        cursor: pointer;
        transition: background-color 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .drop-area:hover {
        background-color: #e6f2ff;
    }

    .drop-area input[type="file"] {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
    }

    .drop-text {
        color: #4A90E2;
        font-size: 18px;
        font-weight: bold;
    }

    .drop-area img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: none;
        border-radius: 8px;
    }

    .replace-btn,
    .remove-btn {
        background-color: #e74c3c;
        color: #fff;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
        position: absolute;
        bottom: 10px;
        transition: background-color 0.3s;
        display: none;
    }

    .replace-btn:hover,
    .remove-btn:hover {
        background-color: #c0392b;
    }

    .remove-btn {
        right: 10px;
    }

    .replace-btn {
        left: 10px;
    }
</style>



<div class="container">
    <h2>Upload Your Documents</h2>

    <!-- Valid ID Upload Area -->
    <div class="drop-area" onclick="document.getElementById('validIdInput').click()">
        <span class="drop-text">Drag & Drop or Click to Upload Valid ID</span>
        <input type="file" id="validIdInput" name="valid_id" accept="image/*"
            onchange="previewImage(event, 'validIdPreview')">
        <img id="validIdPreview" src="" alt="Valid ID Preview">
        <button class="replace-btn" onclick="document.getElementById('validIdInput').click()">Replace</button>
        <button class="remove-btn" onclick="removeImage('validIdPreview', 'validIdInput')">Remove</button>
    </div>

    <!-- Business Permit Upload Area -->
    <div class="drop-area" onclick="document.getElementById('businessPermitInput').click()" style="margin-top: 30px;">
        <span class="drop-text">Drag & Drop or Click to Upload Business Permit</span>
        <input type="file" id="businessPermitInput" name="business_permit" accept="image/*"
            onchange="previewImage(event, 'businessPermitPreview')">
        <img id="businessPermitPreview" src="" alt="Business Permit Preview">
        <button class="replace-btn" onclick="document.getElementById('businessPermitInput').click()">Replace</button>
        <button class="remove-btn" onclick="removeImage('businessPermitPreview', 'businessPermitInput')">Remove</button>
    </div>
</div>

<script>
    function previewImage(event, previewId) {
        const file = event.target.files[0];
        const previewImg = document.getElementById(previewId);
        const dropArea = previewImg.parentElement;
        const dropText = dropArea.querySelector('.drop-text');
        const replaceBtn = dropArea.querySelector('.replace-btn');
        const removeBtn = dropArea.querySelector('.remove-btn');

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImg.src = e.target.result;
                previewImg.style.display = 'block';
                dropText.style.display = 'none';
                replaceBtn.style.display = 'block';
                removeBtn.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }

    function removeImage(previewId, inputId) {
        const previewImg = document.getElementById(previewId);
        const dropArea = previewImg.parentElement;
        const dropText = dropArea.querySelector('.drop-text');
        const replaceBtn = dropArea.querySelector('.replace-btn');
        const removeBtn = dropArea.querySelector('.remove-btn');

        // Reset the preview and input
        previewImg.src = '';
        previewImg.style.display = 'none';
        dropText.style.display = 'block';
        replaceBtn.style.display = 'none';
        removeBtn.style.display = 'none';
        document.getElementById(inputId).value = '';
    }
</script>
@endsection