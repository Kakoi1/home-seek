<style>
    .proper {
        height: 400px;
        width: 500px;
        margin-bottom: 10px;
    }

    .proper-cont {
        max-width: 1800px;
        display: flex;
        /* grid-template-rows: repeat(auto-fit, minmax(150px, 1fr)); */
        flex-wrap: wrap;
        justify-content: space-evenly;
        gap: 100px;
        height: 100%;
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
                            $images = json_decode($dorm->image, true);
                        @endphp
                        @if (is_array($images) && count($images) > 0)
                            <img src="{{ asset('storage/dorm_pictures/' . $images[0]) }}" class="card-img-top" alt="{{ $dorm->name }} "
                                height='270px'>
                        @else
                            <img src="{{ asset('default-placeholder.png') }}" class="card-img-top" alt="No Image Available">
                        @endif
                    @else
                        <img src="{{ asset('default-placeholder.png') }}" class="card-img-top" height='270px'
                            alt="No Image Available">
                    @endif
                    <div class="card-body">
                        <h2><a href="{{ route('dorms.posted', $dorm->id) }}">{{ $dorm->name }}</a></h2>
                        <h5 class="card-title">{{ $dorm->name }}</h5>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($dorm->address, 50) }}</p>

                        <p class="card-text">{{ $dorm->price }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif