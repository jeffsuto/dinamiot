<div class="row match-height">
    <div class="col-xl-8 col-lg-8 col-sm-12">
        <div class="card bg-blue-grey bg-darken-4 white">
            <div class="card-header">
                {{ $component->name }}
                <div class="heading-elements">
                    <a href="{{ route('web.devices.component', $component->id) }}" class="btn btn-info">View detail</a>
                </div>
            </div>
            <div class="card-body collapse in">
                <div class="card-block">
                    {{-- Chart --}}
                    @include('components.charts.live-chart', [
                        'component' => $component,
                        'height' => 250
                    ])  
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4 col-lg-4 col-sm-12">
        @include('components.panels.gauge-panel', $component)
    </div>
</div>