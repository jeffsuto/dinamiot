<div class="card bg-blue-grey bg-darken-4 white">
    <div class="card-header">
        {{ $component->name }} Status
        <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0 label-alert{{ $component->id }}">
                @if(empty($component->value))
                    <li><span class="tag tag-pill tag-danger">Error</span></i></li>
                @elseif ($component->value > $component->max_value || $component->value < $component->min_value)
                    <li><span class="tag tag-pill tag-warning">Warning</span></i></li>
                @else
                    <li><span class="tag tag-pill tag-success">Normal</span></i></li>
                @endif
            </ul>
        </div>
    </div>
    <div class="card-body collapse in">
        <div class="card-block">
            @include('components.charts.gauge-chart', [
                'component' => $component
            ])
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div id="current-div{{ $component->id }}" class="col-xs-6 text-xs-center 
                @if (empty($component->value))
                    glow-danger
                @else
                    {{ ($component->value > $component->max_value || $component->value < $component->min_value ? "glow-warning":"glow-success") }}    
                @endif
                ">
                <span class="text-muted">Current</span>
                @if (empty($component->value))
                    <h2 class="block font-weight-normal current-{{ $component->id }}">- <small class="text-muted">{{ $component->unit }}</small></h2>
                @else
                    <h2 class="block font-weight-normal current-{{ $component->id }}">{{ $component->value }} <small class="text-muted">{{ $component->unit }}</small></h2>
                @endif
            </div>
            <div class="col-xs-6 text-xs-center">
                <span class="text-muted">Average</span>
                <h2 class="block font-weight-normal average-{{ $component->id }}">
                    {{ ($component->values->avg('value') ?  number_format($component->values->avg('value'),1):0) }} 
                    <small class="text-muted">{{ ($component->unit?:"") }}</small>
                </h2>
            </div>
        </div>
    </div>
</div>