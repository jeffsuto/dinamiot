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

        setInterval(() => {
            
            let data = [
                {
                    "key": "c1_suhu",
                    "value": Math.floor(Math.random() * 70) + 10
                },
                {
                    "key": "c2_bahan_bakar",
                    "value": Math.floor(Math.random() * 10) + 1
                },
                {
                    "key": "c3_kipas_pendingin",
                    "value": 1
                },
                {
                    "key": "c4_lampu_genset",
                    "value": 1
                },
                {
                    "key": "c5_saklar_genset",
                    "value": 1
                }
            ];
            
            $.ajax({
                url: "http://35.239.225.192:100/api/v1/components/value/store",
                method: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                headers: {
                    'device-token':'5e3c0b4dbcbd074a153d243d'
                },
                data: JSON.stringify(data)
            }).done(function(data){
                console.log("Genset Utara Sukses");
            });
        }, 3000);
    
    </script>
@endpush