<style>
    .proper {
        height: 400px;
        width: 500px;
        margin-bottom: 10px;
    }

    .proper-cont {
        max-width: 1800px;
        width: 100%;
        margin: 0 auto;
        display: flex;
        /* grid-template-rows: repeat(auto-fit, minmax(150px, 1fr)); */
        flex-wrap: wrap;
        justify-content: space-evenly;
        gap: 100px;
        height: 100%;
    }

    .image-carousel {
        position: relative;
        background-size: cover;
        background-position: center;
        width: 100%;
        height: 400px;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: white;
        border-radius: 10px;
        overflow: hidden;
        transition: background-image 0.5s ease-in-out;
    }

    .image-carousel.fade {
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
    }

    .image-carousel.active {
        opacity: 1;
    }

    .overlay-content {
        position: absolute;
        bottom: 20px;
        left: 0;
        right: 0;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        z-index: 2;
    }

    .card-body {
        background-color: rgba(0, 0, 0, 0.2);
        position: relative;
        top: 20px;
    }

    .prev,
    .next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
        font-size: 24px;
        z-index: 2;
        border-radius: 50%;
    }

    .prev {
        left: 10px;
    }

    .next {
        right: 10px;
    }

    .prev:hover,
    .next:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }

    .dots-container {
        text-align: center;
        position: absolute;
        bottom: 10px;
        width: 100%;
        display: flex;
        justify-content: center;
        z-index: 2;
    }

    .dot {
        height: 10px;
        width: 10px;
        margin: 0 5px;
        background-color: rgba(255, 255, 255, 0.7);
        border-radius: 50%;
        display: inline-block;
        transition: background-color 0.3s ease;
        cursor: pointer;
    }

    .dot.active {
        background-color: white;
    }

    .dot:hover {
        background-color: white;
    }
</style>

@if($dorms->isEmpty())
    <p>No dorms available.</p>
@else
    <div class="proper-cont">
        @foreach ($dorms as $dorm)
            <div class="proper">
                <div class="cards">
                    @if (!empty($dorm->image))
                        @php
                            // Decode the JSON string into an array
                            $images = json_decode($dorm->image, true);
                        @endphp

                        @if (is_array($images) && !empty($images))
                            <!-- Carousel container -->
                            <div class="image-carousel" id="carousel-{{ $dorm->id }}" data-images="{{ json_encode($images) }}"
                                data-current-image="0"
                                style="background-image: url('{{ asset('storage/dorm_pictures/' . $images[0]) }}');">
                                <div class="overlay-content">
                                    <div class="card-body">
                                        <h2><a href="{{ route('dorms.posted', $dorm->id) }}">{{ $dorm->name }}</a></h2>
                                        <h5 class="card-title">{{ $dorm->name }}</h5>
                                        <p class="card-text"><i class="fas fa-map-marker-alt"></i>
                                            {{ \Illuminate\Support\Str::limit($dorm->address, 50) }}</p>
                                        <p class="card-text"><span>₱</span>{{ $dorm->price }}</p>
                                    </div>
                                </div>

                                <!-- Arrow buttons for image navigation -->
                                <button class="prev" onclick="prevImage({{ $dorm->id }})">❮</button>
                                <button class="next" onclick="nextImage({{ $dorm->id }})">❯</button>

                                <!-- Dots for image indicators -->
                                <div class="dots-container" id="dots-{{ $dorm->id }}">
                                    @foreach ($images as $index => $image)
                                        <span class="dot {{ $index === 0 ? 'active' : '' }}"
                                            onclick="setImage({{ $dorm->id }}, {{ $index }})"></span>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <p>No images available.</p>
                        @endif
                    @else
                        <div class="image-carousel" style="background-image: url('{{ asset('default-placeholder.png') }}');">
                            <div class="overlay-content">
                                <h3>No Image Available</h3>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>



@endif

<script>


</script>