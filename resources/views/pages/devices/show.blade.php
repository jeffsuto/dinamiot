@extends('layout.app')

@section('breadcrumbs', Breadcrumbs::render('devices.show', $device))

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade in mb-2" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <strong>Well done!</strong> {!! session('success') !!}.
        </div>
    @endif
    
    <div id="alert-disconnected">
        @if (!$device->state)
            <div class="alert alert-danger alert-dismissible fade in mb-2" role="alert">
                <strong>This device is disconnected</strong>
            </div>
        @endif
    </div>

    <div class="row">
        @foreach ($device->components()->where('type', 'digital')->get() as $component)
            @include('components.panels.digital-panel', ['component' => $component])
        @endforeach
    </div>
    <div>
        @foreach ($device->components()->where('type', 'analog')->get() as $component)
            @include('components.panels.analog-panel', ['component' => $component])
        @endforeach
    </div>
@endsection

@push('script')
    <script>
        
        socket.on('device', function(data){
            let html =  '<div class="alert alert-danger alert-dismissible fade in mb-2" role="alert">'+
                            '<strong>This device is disconnected</strong>'+
                        '</div>';
            if (data.data.state) {
                $('#alert-disconnected').html("");
            } else {
                $('#alert-disconnected').html(html);
            }
        });

        // realtime update on component
        socket.on('component', function(data){
            
            if (data.data.type == "analog") {
                // update current analog value
                $('#current-div'+data.data._id).removeClass('glow-danger glow-warning glow-success');
                if (data.data.value == null) {
                    data.data.value = "-";
                    $('#current-div'+data.data._id).addClass('glow-danger');
                }else{
                    if (data.data.value > data.data.max_value || data.data.value < data.data.min_value) {
                        $('#current-div'+data.data._id).addClass('glow-warning');
                    } else {
                        $('#current-div'+data.data._id).addClass('glow-success');
                    }
                }

                if (data.data.unit == null) {
                    data.data.unit = "";
                }
                let current = data.data.value+' <small class="text-muted">'+data.data.unit+'</small>';
                $('.current-'+data.data._id).html(current);

                // update average value
                let average = data.data.avg+' <small class="text-muted">'+data.data.unit+'</small>';
                $('.average-'+data.data._id).html(average);

                // update label state
                let label = "";
                if(data.data.value == "-")
                    label = '<li><span class="tag tag-pill tag-danger">Error</span></i></li>';
                else if (data.data.value > data.data.max_value || data.data.value < data.data.min_value)
                    label = '<li><span class="tag tag-pill tag-warning">Warning</span></i></li>';
                else
                    label = '<li><span class="tag tag-pill tag-success">Normal</span></i></li>';
                
                $('.label-alert'+data.data._id).html(label);
            } else {
                // change glow effect
                $('#digital-div'+data.data._id).removeClass('glow-danger glow-warning glow-success');
                if (data.data.value == null) {
                    $('#digital-div'+data.data._id).addClass('glow-danger');
                }else{
                    if (data.data.value) {
                        $('#digital-div'+data.data._id).addClass('glow-success');
                    }
                }

                // update value
                if (data.data.value != null)
                    $('.digital-value'+data.data._id).html('<h3>'+(data.data.value ? "ON":"OFF")+'</h3><span>'+data.data.name+'</span>');
                else
                    $('.digital-value'+data.data._id).html('<h3>-</h3><span>'+data.data.name+'</span>');

                // change color
                $('.digital-color'+data.data._id).removeClass('bg-danger bg-teal bg-accent-4 bg-grey');
                if (data.data.value == null) {
                    $('.digital-color'+data.data._id).addClass('bg-danger');
                }else{
                    if (data.data.value) {
                        $('.digital-color'+data.data._id).addClass('bg-teal bg-accent-4');
                    }else{
                        $('.digital-color'+data.data._id).addClass('bg-grey');
                    }
                }
            }
        });
    
    </script>
@endpush