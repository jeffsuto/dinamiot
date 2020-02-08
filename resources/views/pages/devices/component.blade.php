@extends('layout.app')

@section('breadcrumbs', Breadcrumbs::render('devices.show.component', $component))

@section('content')
    <div id="alert-disconnected">
        @if (!$component->device->state)
            <div class="alert alert-danger alert-dismissible fade in mb-2" role="alert">
                <strong>This device is disconnected</strong>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card bg-blue-grey bg-darken-4 grey lighten-1">
                <div class="card-body">
                    @include('components.charts.live-chart', [
                        'component' => $component,
                        'height' => 300
                    ])
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        {{-- Data History --}}
        <div class="col-xl-8 col-lg-8 col-sm-12">
            <div class="card bg-grey bg-lighten-4">
                <div class="card-body">
                    <div class="row px-1 mt-1">
                        <div class="col-sm-7">
                            <h5 class="card-title mb-0">{{ $component->device->name }}'s {{ $component->name }} Data History</h5>
                            <div class="font-small-3 text-muted">{{ $time }}</div>
                        </div>

                        <div class="col-sm-5 d-md-block">
                            <div class="btn-group mr-1 mb-1 float-xs-right">
                                <button type="button" class="btn btn-info btn-min-width dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-search white"></i>
                                    Filter
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('web.devices.component', $component->id) }}">All time</a>
                                    <a class="dropdown-item" href="{{ route('web.devices.component', $component->id) }}?f=today">Today</a>
                                    <a class="dropdown-item" href="{{ route('web.devices.component', $component->id) }}?f=yesterday">Yesterday</a>
                                    <a class="dropdown-item" href="{{ route('web.devices.component', $component->id) }}?f=last week">This week</a>
                                    <a class="dropdown-item" href="{{ route('web.devices.component', $component->id) }}?f=last month">This month</a>
                                    <a class="dropdown-item" href="{{ route('web.devices.component', $component->id) }}?f=last year">This year</a>
                                    <div class="dropdown-divider"></div>
                                    <form class="px-1" action="{{ route('web.devices.component', $component->id) }}" method="GET">
                                        <div class="form-group">
                                            <label>Start date</label>
                                            <input class="form-control" type="date" name="start_date" 
                                            @if (isset($_REQUEST['start_date']))
                                                value="{{ $_REQUEST['start_date'] }}"
                                            @endif required>
                                        </div>
                                        <div class="form-group">
                                            <label>End date</label>
                                            <input class="form-control" type="date" name="end_date" 
                                            @if (isset($_REQUEST['end_date']))
                                                value="{{ $_REQUEST['end_date'] }}"
                                            @endif>
                                        </div>
                                        <button class="btn btn-primary btn-block" type="submit">Go!</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row px-1">
                        <div class="col-xl-3 col-lg-3 col-sm-12">
                            <div class="callout callout-danger bg-white">
                                <h4 class="max-value">
                                    {{ number_format($component_values->max('value'), 1) }} 
                                    <small class="text-muted">{{ $component->unit }}</small>
                                </h4>
                                Maximum Value
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-3 col-sm-12">
                            <div class="callout callout-info bg-white ">
                                <h4 class="min-value">
                                    {{ number_format($component_values->where('value', '<>', '')->min('value'), 1) }} 
                                    <small class="text-muted">{{ $component->unit }}</small>
                                </h4>
                                Minimum Value
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-3 col-sm-12">
                            <div class="callout callout-primary bg-white">
                                <h4 class="avg-value">
                                    {{ number_format($component_values->avg('value'), 1) }} 
                                    <small class="text-muted">{{ $component->unit }}</small>
                                </h4>
                                Average
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-3 col-sm-12">
                            <div class="callout callout-success bg-white">
                                <h4 class="data-received">
                                    {{ number_format($component_values->count()) }}
                                </h4>
                                Data Received
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <table class="my-datatables-ajax table" width="100%">
                        <thead>
                            <th class="text-xs-center">No.</th>
                            <th>Date</th>
                            <th class="text-xs-center">Time</th>
                            <th class="text-xs-center">Value</th>
                            <th class="text-xs-center">State</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        {{-- Gauge Chart --}}
        <div class="col-xl-4 col-lg-4 col-sm-12">
            @include('components.panels.gauge-panel', $component)
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            // if device is diconnected
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

            // init data
            var table = $('.my-datatables-ajax').DataTable({
                "ajax": {
                    url: "{{ route('web.devices.component', $component->id) }}",
                    data:{
                        f: "{{ @$_REQUEST['f'] }}",
                        start_date: "{{ @$_REQUEST['start_date'] }}",
                        end_date: "{{ @$_REQUEST['end_date'] }}"
                    }
                },
                "scrollX": true,
                "autoWidth": false,
                "columnDefs": [
                    { className: "text-xs-center", "targets": [ 0,2,3,4 ] }
                ]
            });

            // load component values summary
            function loadComponentValuesSummary() {
                $.ajax({
                    url: "{{ route('web.devices.component', $component->id) }}",
                    data:{
                        summary: true,
                        f: "{{ @$_REQUEST['f'] }}",
                        start_date: "{{ @$_REQUEST['start_date'] }}",
                        end_date: "{{ @$_REQUEST['end_date'] }}"
                    }
                }).done(function(data){
                    console.log(data.max);
                    
                    $('.max-value').html(data.max+' <small class="text-muted">{{ $component->unit }}</small>')
                    $('.min-value').html(data.min+' <small class="text-muted">{{ $component->unit }}</small>')
                    $('.avg-value').html(data.avg+' <small class="text-muted">{{ $component->unit }}</small>')
                    $('.data-received').html(data.data_received);
                })
            }

            // realtime update on component
            socket.on('component', function(data){
                if (data.data._id == "{{ $component->id }}") {
                    // reload datatables
                    table.ajax.reload(null, false);

                    // update summary data
                    loadComponentValuesSummary();

                    // update current value
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

                    if (!data.data.unit) {
                        console.log(true);
                        
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
                        label = '<span class="tag tag-pill tag-danger">Error</span>';
                    else if (data.data.value > data.data.max_value || data.data.value < data.data.min_value)
                        label = '<span class="tag tag-pill tag-warning">Warning</span>';
                    else
                        label = '<span class="tag tag-pill tag-success">Normal</span>';

                    $('.label-alert'+data.data._id).html(label);
                }
            });
        });
    </script>
@endpush
