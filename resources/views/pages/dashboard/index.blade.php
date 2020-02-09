@extends('layout.app')

@section('content')
    <div class="row match-height devices-container">
        @include('partials.ajax.devices-on-dashboard', $devices)
    </div>
@endsection

@push('script')
    <script>
        function loadDevices() {
            $.ajax({
                url: "{{ route('web.dashboard.index') }}"
            }).done(function(data){
                $('.devices-container').html(data);
            });
        }

        // if any updated on table devices, it will execute loadDevices()
        socket.on('device', function(data){
            loadDevices();
        });

    </script>
@endpush
