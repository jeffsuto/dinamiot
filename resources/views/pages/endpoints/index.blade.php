@extends('layout.app')

@section('breadcrumbs', Breadcrumbs::render('endpoints'))

@section('content')
    <div class="card bg-grey bg-lighten-4">
        <div class="card-header">
            <b>Device's Endpoint List</b>
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
                        <th class="text-xs-center">Data Received</th>
                        <th class="text-xs-center">Request Interval</th>
                        <th class="text-xs-center">Actions</th>
                    </thead>
                    <tbody>
                        @foreach ($endpoints as $endpoint)
                            <tr>
                                <td class="text-xs-center">{{ $loop->iteration }}</td>
                                <td>{{ $endpoint->device->name }}</td>
                                <td class="text-xs-center">{{ $endpoint->device->serial_number }}</td>
                                <td class="text-xs-center">{{ $endpoint->data_received }}</td>
                                <td class="text-xs-center"><b>{{ $endpoint->request_interval }}</b> seconds</td>
                                <td class="text-xs-center">
                                    <a href="{{ route('web.endpoints.show', $endpoint->id) }}" class="btn btn-info">
                                        <i class="icon-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection