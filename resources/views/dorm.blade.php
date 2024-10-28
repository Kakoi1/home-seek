<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test GCS Multiple Upload</title>
</head>

<body>
    <div style="margin: 50px;">
        <h2>Upload Multiple Images to Google Cloud Storage</h2>

        <!-- Success Message -->
        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        <!-- Upload Form -->
        <form action="{{ route('test.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="file">Choose Images:</label>
            <input type="file" name="files[]" multiple required>
            <br><br>
            <button type="submit">Upload</button>
        </form>

        <!-- Display Uploaded Images -->
        <h3>Uploaded Images</h3>
        <div style="display: flex; flex-wrap: wrap;">
            @foreach($fileUrls as $url)
                <div style="margin: 10px;">
                    <img src="{{ $url }}" alt="Uploaded Image" style="width: 150px; height: auto;">
                </div>
            @endforeach
        </div>
    </div>
</body>

</html>