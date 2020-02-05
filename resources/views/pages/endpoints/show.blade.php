@extends('layout.app')

@section('breadcrumbs', Breadcrumbs::render('endpoints.show', $endpoint))

@section('content')
    <div class="row">
        <div class="col-xl-8 col-lg-8 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <b class="orange darken-1">{{ $endpoint->method }}</b>
                        {{ $endpoint->device->name }}'s Components Value
                    </h4>
                </div>
                <div class="card-body">
                    <div class="card-block">
                        <form>
                            <div class="form-group">
                                <input type="text" class="form-control" value="{{ $endpoint->url }}" readonly>
                            </div>
                            
                            <h5 class="form-section">Headers</h5>
    
                            @foreach ($endpoint->headers as $header)
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label class="text-bold-600">{{ $header['key'] }}</label>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>{{ $header['value'] }}</label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <h5 class="form-section">Body</h5>

                            <div class="form-group">
                                <textarea style="font-family:Courier" class="form-control font-small-3" id="example-data" readonly cols="30" rows="10"></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="media">
                        <div class="p-2 media-body text-xs-left">
                            <h3 class="{{ ($endpoint->device->state ? "teal":"grey") }}">{{ ($endpoint->device->state ? "Online":"Offline") }}</h3>
                            <span>Device State</span>
                        </div>
                        <div class="p-2 text-xs-center bg-{{ ($endpoint->device->state ? "teal":"grey") }} media-right media-middle">
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-block">
                        <div class="media">
                            <div class="media-body text-xs-left">
                                <h3 class="orange">{{ $endpoint->data_received }}</h3>
                                <span>Data Received</span>
                            </div>
                            <div class="media-right media-middle">
                                <i class="icon-database orange font-large-2 float-xs-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-block">
                        <div class="media">
                            <div class="media-body text-xs-left">
                                <h3 class="cyan">{{ $endpoint->request_interval }} seconds</h3>
                                <span>Request Interval</span>
                            </div>
                            <div class="media-right media-middle">
                                <i class="icon-stopwatch cyan font-large-2 float-xs-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        var obj = {!! $endpoint->data_example !!};
        var pretty = JSON.stringify(obj, undefined, 4);
        document.getElementById('example-data').value = pretty;
    </script>
@endpush