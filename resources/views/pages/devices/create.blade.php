@extends('layout.app')

@section('breadcrumbs', Breadcrumbs::render('devices.create'))

@section('content')
<div class="row">
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade in mb-2" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <strong>Oh snap!</strong> {{ $error }}.
            </div>
        @endforeach
    @endif
    <div class="card bg-grey bg-lighten-4">
        <div class="card-body collapse in">
            <div class="card-block">
                <div class="card-text">
                    <p>Create your new device here before connecting to the web server. After you created the new device, you will receive <b>API endpoint</b> that ready to use to connect your device to the web server.</p>
                </div>
                <form class="form" action="{{ route('web.devices.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-body">
                        <h4 class="form-section"><i class="icon-drive"></i> Device Identity</h4>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label>Device Name</label>
                                    <input type="text" id="projectinput1" class="form-control" placeholder="Device name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label>Serial Number</label>
                                    <input type="text" class="form-control" placeholder="Serial Number" name="serial_number" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="projectinput3">Description</label>
                                    <textarea name="description" class="form-control" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="projectinput4">Device Image</label>
                                    <input type="file" class="form-control" name="image">
                                </div>
                            </div>
                        </div>

                        <h4 class="form-section"><i class="icon-content-left"></i> Device Components</h4>

                        <div class="component-wrapper">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-3 col-sm-12">
                                        <label>Component Name</label>
                                        <input type="text" class="form-control" placeholder="eg. Temperature" name="component_name[]">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-2 col-sm-12">
                                        <label>Component Type</label>
                                        <select name="component_type[]" class="form-control" required>
                                            <option value="">--- Select Component Type ---</option>
                                            <option value="analog">Analog Input</option>
                                            <option value="digital">Digital Input</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-2 col-sm-12">
                                        <label>Min. Value <span class="text-muted">(Optional)</span></label>
                                        <input type="number" class="form-control component-min-value" placeholder="min. value" name="component_min_value[]">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-2 col-sm-12">
                                        <label>Max. Value <span class="text-muted">(Optional)</span></label>
                                        <input type="number" class="form-control" placeholder="max. value" name="component_max_value[]">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-2 col-sm-12">
                                        <label>Unit Value <span class="text-muted">(Optional)</span></label>
                                        <input type="text" class="form-control" placeholder="eg. F" name="component_unit[]">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-12 col-sm-12">
                                    <button type="button" class="btn btn-success add-button">
                                        <i class="icon-plus"></i>
                                        Add new component
                                    </button>
                                </div>
                            </div>
                        </div><br>

                        <h4 class="form-section"><i class="icon-gear"></i> Device Configurations</h4>
                        
                        <div class="row">
                            <div class="col-md-5 col-sm-5">
                                <div class="form-group">
                                    <label>Request Interval <span class="text-muted">(your device's request interval time to the server in seconds)</span></label>
                                    <div class="input-group">
										<input type="number" class="form-control" placeholder="500" name="request_interval">
										<span class="input-group-addon">seconds</span>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ url()->previous() }}" class="btn btn-warning mr-1">
                            <i class="icon-cross2"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="icon-check2"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
    
        $(document).ready(function(){
            var addButton = $('.add-button'); //Add button selector
            var wrapper = $('.component-wrapper'); //Input field wrapper
            var fieldHTML = '<hr><div class="row">'+
                                '<div class="form-group">'+
                                    '<div class="col-md-3 col-sm-12">'+
                                        '<label>Component Name</label>'+
                                        '<input type="text" class="form-control" placeholder="Component name" name="component_name[]">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<div class="col-md-2 col-sm-12">'+
                                        '<label>Component Type</label>'+
                                        '<select name="component_type[]" class="form-control" required>'+
                                            '<option value="">--- Select Component Type ---</option>'+
                                            '<option value="analog">Analog Input</option>'+
                                            '<option value="digital">Digital Input</option>'+
                                        '</select>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<div class="col-md-2 col-sm-12">'+
                                        '<label>Min. Value <span class="text-muted">(Optional)</span></label>'+
                                        '<input type="number" class="form-control" placeholder="min. value" name="component_min_value[]">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<div class="col-md-2 col-sm-12">'+
                                        '<label>Max. Value <span class="text-muted">(Optional)</span></label>'+
                                        '<input type="number" class="form-control" placeholder="max. value" name="component_max_value[]">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<div class="col-md-2 col-sm-12">'+
                                        '<label>Unit Value <span class="text-muted">(Optional)</span></label>'+
                                        '<input type="text" class="form-control" placeholder="eg. F" name="component_unit[]">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<div class="col-md-1 col-sm-12">'+
                                        '<label class="white">Remove</label>'+
                                        '<button type="button" class="btn btn-danger form-control remove-button">'+
                                            '<i class="white icon-cross"></i>'+
                                        '</button>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'; //New input field html 
            
            //Once add button is clicked
            $(addButton).click(function(){
                // add field
                $(wrapper).append(fieldHTML);
            });
            
            //Once remove button is clicked
            $(wrapper).on('click', '.remove-button', function(e){
                e.preventDefault();
                $(this).parent('div').parent('div').parent('div').remove();//Remove field html
            });

            /**
             * Change field min. and max. value status to disable or enable
             * **/
            $('select[name^="component_type[]"]').each(function(i) {
                $(this).click(function(i){
                    // $(this).parent('div').parent('div')
                    console.log($('.component-min-value').val());
                    
                });
            });
        });
    
    </script>
@endpush