<div class="col-xl 3 col-lg-3 col-sm-6">
    <div class="card card bg-blue-grey bg-darken-4 white">
        <div class="card-body">
            <div id="digital-div{{ $component->id }}" class="media {{ (isset($component->value) ? "":"glow-danger") }} {{ ($component->value ? "glow-success":"") }}">
                <div class="p-2 media-body text-xs-left digital-value{{ $component->id }}">
                    @if (isset($component->value))
                        <h3>{{ ($component->value ? "ON":"OFF") }}</h3>
                    @else
                        <h3>-</h3>
                    @endif
                    
                    <span>{{ $component->name }}</span>
                </div>
                @if (isset($component->value))
                    <div class="digital-color{{ $component->id }} p-2 text-xs-center
                        {{ ($component->value ? "bg-teal bg-accent-4":"bg-grey") }} 
                        media-right media-middle">
                    </div>
                @else
                    <div class="digital-color{{ $component->id }} p-2 text-xs-center bg-danger media-right media-middle">
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>