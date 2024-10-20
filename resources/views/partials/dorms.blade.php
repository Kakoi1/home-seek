<link rel="stylesheet" href="{{asset('css/perdorm.css')}}">

@if($dorms->isEmpty())
    <div style="text-align: center; margin: 20px;">
        <img src="{{ asset('images/search-house.svg') }}" alt="No results found"
            style="max-width: 400px; height: auto; margin-bottom: 10px;" />
        <p>No dorms available.</p>
    </div>
@else
    <div class="proper-cont">
        @foreach ($dorms as $dorm)
            <div class="proper">
                <div class="carder">
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
                                @php
                                    // Check if the currently authenticated user has favorited the dorm
                                    $favouriteClass = $dorm->favoritedBy->contains('id', auth()->id()) ? 'fa-solid' : 'fa-regular';
                                    $viewClass = $dorm->views->contains('user_id', auth()->id()) ? 'fa-solid' : 'fa-regular';
                                    $reviewClass = $dorm->reviews->contains('user_id', auth()->id()) ? 'fa-solid' : 'fa-regular';
                                @endphp

                                <div class="icon-overlay">
                                    <!-- Heart Icon for Favorites -->
                                    <span class="favorite-icon" onclick="toggleFavorite({{ $dorm->id }})">
                                        <i class="{{ $favouriteClass }} fa-heart" id="fav-icon-{{ $dorm->id }}"
                                            style="color: #007bff;"></i>
                                        <span id="fav-count-{{ $dorm->id }}">{{ $dorm->favorited_by_count }}</span>
                                    </span>

                                    <!-- Eye Icon for Views -->
                                    <span class="view-icon">
                                        <i class="{{$viewClass}} fa-eye" style="color: #007bff;"></i>
                                        <span id="view-count-{{ $dorm->id }}">{{ $dorm->views->count() }}</span>
                                    </span>

                                    <!-- Heart Icon for Favorites -->
                                    <span class="favorite-icon" onclick="toggleComments({{ $dorm->id }})">
                                        <i class="{{$reviewClass}} fa-comment" style="color: #007bff;"></i>
                                        <span id="fav-count-{{ $dorm->id }}">{{ $dorm->reviews->count() }}</span>
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
                    <div class="cardbody" onclick="location.href='{{ route('dorms.posted', $dorm->id) }}'">
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
    function toggleFavorite(dormId) {
        const url = `{{ route('dorm.favorite', ':dormId') }}`.replace(':dormId', dormId);  // Adjust the route based on your Laravel routes
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            }
        })
            .then(response => response.json())
            .then(data => {
                // Update favorite count
                const favCountElement = document.getElementById(`fav-count-${dormId}`);
                favCountElement.innerText = data.count;

                const favIcon = document.getElementById(`fav-icon-${dormId}`);
                if (data.is_favorited) {
                    favIcon.classList.remove('fa-regular');
                    favIcon.classList.add('fa-solid'); // Change to solid heart
                } else {
                    favIcon.classList.remove('fa-solid');
                    favIcon.classList.add('fa-regular'); // Change back to outline heart
                }

            })
            .catch(error => console.error('Error:', error));
    }


</script>