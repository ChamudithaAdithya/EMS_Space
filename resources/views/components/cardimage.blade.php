<div class="container ">

    <div class="card card-block" class="container p-5 mb-3">
        <img style=" height: 22vh; width: auto;" src="{{ $imageUrl }}" class="card-img-top" alt="{{ $imageAlt }}">

        <div class="card-body">
            <h5 class="card-title">{{ $title }}</h5>
            <p class="card-text">{{ $content }}</p>
            <p class="card-text">Start:{{ $sdate}} End:{{ $edate}}</p>
            <a href="{{ route('space_event.runnigEvents', ['newEventId' => $eid]) }}">
                <button style="padding: 5px 10px; background-color: #0AD1C8; color: white; border: none; border-radius: 4px; cursor: pointer;">
                    See More Details...
                </button>
            </a>

        </div>

        @push('css')

        @endpush

    </div>
</div>