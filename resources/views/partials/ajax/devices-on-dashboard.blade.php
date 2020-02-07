@foreach ($devices as $device)
    <div class="col-xl-4 col-md-6 col-sm-6">
        <div class="card bg-blue-grey bg-darken-4">
            <div class="card-header">
                <b class="float-xs-left grey lighten-4">
                    <a href="{{ route('web.devices.show', $device->id) }}" class="info">{{ $device->name }}</a>
                </b>
                <div class="heading-elements">
                    @if ($device->state == 1)
                        @switch($device->alert)
                            @case("normal")
                                <span class="tag tag-pill tag-success glow-success">Normal</span>
                                @break
                            @case("warning")
                                <span class="tag tag-pill tag-warning glow-warning">Warning</span>
                                @break
                            @case("danger")
                                <span class="tag tag-pill tag-danger glow-danger">danger</span>
                                @break
                        @endswitch
                    @endif
                    
                    @if ($device->state)
                        <span class="tag tag-pill tag-success state-{{ $device->id }}">Connected</span>
                    @else
                        <span class="tag tag-pill tag-default state-{{ $device->id }}">Disconnected</span>
                    @endif
                </div>
            </div>
            <div class="card-body height-250">
                <a href="{{ route('web.devices.show', $device->id) }}">
                    <img class="img-fluid" style="height:100%; object-fit: cover;" src="{{ ($device->image_url ?: asset("app-assets/images/portfolio/portfolio-1.jpg")) }}" alt="{{ $device->name }}">
                </a>
                {{-- <div class="card-block white">
                    {{ $device->description }}
                </div> --}}
            </div>
        </div>
    </div>
@endforeach
