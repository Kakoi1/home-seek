@if($dorms->isEmpty())
    <p>No dorms available.</p>
@else
    <div class="row">
        @foreach ($dorms as $dorm)
            <div class="col-md-4">
                <div class="card mb-4">
                    @if (!empty($dorm->image))
                        @php
                            $images = json_decode($dorm->image, true);
                        @endphp
                        @if (is_array($images) && count($images) > 0)
                            <img src="{{ asset('storage/dorm_pictures/' . $images[0]) }}" class="card-img-top" alt="{{ $dorm->name }}">
                        @else
                            <img src="{{ asset('default-placeholder.png') }}" class="card-img-top" alt="No Image Available">
                        @endif
                    @else
                        <img src="{{ asset('default-placeholder.png') }}" class="card-img-top" alt="No Image Available">
                    @endif
                    <div class="card-body">
                        <h2><a href="{{ route('dorms.posted', $dorm->id) }}">{{ $dorm->name }}</a></h2>
                        <h5 class="card-title">{{ $dorm->name }}</h5>
                        <p class="card-text">{{ $dorm->address }}</p>
                        <p class="card-text">{{ $dorm->price }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
