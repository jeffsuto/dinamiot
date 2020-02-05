@extends('layout.app')

@section('breadcrumbs', Breadcrumbs::render('devices'))

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade in mb-2" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <strong>Well done!</strong> {{ session('success') }}.
        </div>
    @endif
    <div class="card bg-grey bg-lighten-4">
        <div class="card-header">
            <h4 class="card-title">
                <a href="{{ route('web.devices.create') }}" class="btn btn-success">Create new device</a>
            </h4>
            <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-body collapse in">
            <div class="card-block">
                <table class="my-datatables table">
                    <thead>
                        <th class="text-xs-center">No.</th>
                        <th>Device Name</th>
                        <th class="text-xs-center">Serial Number</th>
                        <th class="text-xs-center">State</th>
                        <th class="text-xs-center">Actions</th>
                    </thead>
                    <tbody>
                        @foreach ($devices as $device)
                            <tr>
                                <td class="text-xs-center">{{ $loop->iteration }}</td>
                                <td><a href="{{ route('web.devices.show', $device->id) }}" class="blue">{{ $device->name }}</a></td>
                                <td class="text-xs-center">{{ $device->serial_number }}</td>
                                <td class="text-xs-center">
                                    @if ($device->state)
                                        <div class="tag tag-pill tag-success">Connected</div>
                                    @else
                                        <div class="tag tag-pill tag-default">Disconnected</div>
                                    @endif
                                </td>
                                <td class="text-xs-center">
                                    <div class="row">
                                        <a href="{{ route('web.devices.edit', $device->id) }}" class="btn btn-warning">
                                            <i class="icon-pencil"></i>
                                        </a>
                                        <button type="submit" class="btn btn-danger" onclick="deleteDevice('{{ $device->id }}')">
                                            <i class="icon-trash-o"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function deleteDevice(id) {
            let url = "{{ route('web.devices.destroy', ':id') }}";
            url = url.replace(':id', id);
            swal({
                title: "Are you sure?",
                text: "Once deleted, your device and component data will be deleted!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: url,
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: "delete"
                        }
                    }).done(function(data){
                        swal("Poof! Your device has been deleted!", {
                            icon: "success",
                        })
                        .then((oke) => {
                            if (oke) {
                                location.reload();
                            }
                        });
                    }); 
                } 
            });
        }
    
    </script>
@endpush