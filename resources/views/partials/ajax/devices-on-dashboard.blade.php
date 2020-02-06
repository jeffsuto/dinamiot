@foreach ($devices as $device)
    <div class="col-xl-4 col-md-6 col-sm-6">
        <div class="card bg-blue-grey bg-darken-4">
            <div class="card-header">
                <b class="float-xs-left grey lighten-4">
                    <a href="{{ route('web.devices.show', $device->id) }}" class="info">{{ $device->name }}</a>
                </b>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        @switch($device->alert)
                            @case("normal")
                                <li class="glow-success"><span class="tag tag-pill tag-success">Normal</span></i></li>
                                @break
                            @case("warning")
                                <li class="glow-warning"><span class="tag tag-pill tag-warning">Warning</span></i></li>
                                @break
                            @case("danger")
                                <li class="glow-danger"><span class="tag tag-pill tag-danger">danger</span></i></li>
                                @break
                        @endswitch
                        
                        @if ($device->state)
                            <li><span class="tag tag-pill tag-success state-{{ $device->id }}">Connected</span></li>
                        @else
                            <li><span class="tag tag-pill tag-default state-{{ $device->id }}">Disconnected</span></li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="card-body height-250">
                <a href="{{ route('web.devices.show', $device->id) }}">
                    <img class="img-fluid" style="height:100%; object-fit: cover;" src="{{ ($device->image_path ?: asset("app-assets/images/portfolio/portfolio-1.jpg")) }}" alt="{{ $device->name }}">
                </a>
                {{-- <div class="card-block white">
                    {{ $device->description }}
                </div> --}}
            </div>
        </div>
    </div>
@endforeach
