<link rel="stylesheet" href="{{asset('css/perdorm.css')}}">

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

                                </div>
                                <div class="icon-overlay">
                                    <!-- Heart Icon for Favorites -->
                                    <span class="favorite-icon" onclick="toggleFavorite({{ $dorm->id }})">
                                        <i class="fa-regular fa-heart" style="color: #007bff;"></i>
                                        <span id="fav-count-{{ $dorm->id }}">{{ $dorm->favorite_count }}12</span>
                                    </span>

                                    <!-- Eye Icon for Views -->
                                    <span class="view-icon">
                                        <i class="fas fa-eye" style="color: #007bff;"></i>
                                        <span id="view-count-{{ $dorm->id }}">{{ $dorm->view_count }}12</span>
                                    </span>
                                    <!-- Heart Icon for Favorites -->
                                    <span class="favorite-icon" onclick="toggleComments({{ $dorm->id }})">
                                        <i class="fa-regular fa-comment" style="color: #007bff;"></i>
                                        <span id="fav-count-{{ $dorm->id }}">{{ $dorm->favorite_count }}12</span>
                                    </span>
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
                    <div class="card-body" onclick="location.href='{{ route('dorms.posted', $dorm->id) }}'">
                        <h5 class="card-title">{{ $dorm->name }}</h5>
                        <p class="card-text"><i class="fas fa-map-marker-alt"></i>
                            {{ \Illuminate\Support\Str::limit($dorm->address, 50) }}</p>
                        <p class="card-text"><span>₱</span>{{ $dorm->price }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>



@endif

<script>


</script>