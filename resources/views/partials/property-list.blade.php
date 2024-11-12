@foreach ($properties as $dorm)
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
                        style="background-image: url('{{ asset('https://storage.googleapis.com/homeseek-profile-image/' . $images[0]) }}');">
                        <div class="overlay-content">

                        </div>

                        <div class="icon-overlay">
                            <div class="dropdown">
                                <button class="dropdown-toggle" onclick="toggleDropdown({{ $dorm->id }})">
                                    <i class="fa-solid fa-ellipsis-vertical fa-lg" style="color: #ffffff;"></i>
                                </button>
                                <div id="dropdown-menu-{{ $dorm->id }}" class="dropdown-menu"
                                    style="display: none; position: absolute; left: 0; background-color: white; border: 1px solid #ccc; padding: 10px; border-radius: 4px; min-width: 100px;">

                                    @if($dorm->archive == 0)
                                        <a class="dropdown-item" href="{{ route('dorms.posted', $dorm->id) }}">Show</a>
                                        <a class="dropdown-item" href="{{ route('dorms.adddorm', $dorm->id) }}">Edit</a>
                                        <a class="dropdown-item text-danger" onclick="confirmArchive({{ $dorm->id }})">Delete</a>
                                    @else
                                        <a class="dropdown-item" href="#" style="pointer-events: none; color: gray;">Show (Disabled)</a>
                                        <a class="dropdown-item" href="#" style="pointer-events: none; color: gray;">Edit (Disabled)</a>
                                        <a class="dropdown-item text-success" onclick="restoreDorm({{ $dorm->id }})">Restore</a>
                                    @endif
                                    <form id="archive-form-{{ $dorm->id }}" action="{{ route('dorms.archive', $dorm->id) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                    </form>
                                </div>

                            </div>
                            <!-- Heart Icon for Favorites -->
                            <span class="favorite-icon" onclick="toggleFavorite({{ $dorm->id }})">
                                <i class="fa-solid fa-heart fa-lg" id="fav-icon-{{ $dorm->id }}" style="color: #fff00;"></i>
                                <span id="fav-count-{{ $dorm->id }}">{{ $dorm->favorited_by_count }}</span>
                            </span>

                            <!-- Eye Icon for Views -->
                            <span class="view-icon">
                                <i class="fa-solid fa-eye fa-lg" style="color: #ffffff; "></i>
                                <span id="view-count-{{ $dorm->id }}">{{ $dorm->views->count() }}</span>
                            </span>

                            <!-- Comment Icon for Reviews -->
                            <span class="favorite-icon" onclick="toggleComments({{ $dorm->id }})">
                                <i class="fa-solid fa-comment fa-lg" style="color: #ffffff;"></i>
                                <span id="fav-count-{{ $dorm->id }}">{{ $dorm->reviews->count() }}</span>
                            </span>

                            <!-- Custom Dropdown Menu -->
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

            </div>
        </div>
    </div>
@endforeach