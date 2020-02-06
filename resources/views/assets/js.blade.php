<!-- BEGIN VENDOR JS-->
<script src="{{ asset("") }}app-assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>
<script src="{{ asset("") }}app-assets/vendors/js/ui/tether.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="{{ asset("") }}app-assets/js/core/libraries/bootstrap.min.js" type="text/javascript"></script>
<script src="{{ asset("") }}app-assets/vendors/js/ui/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<script src="{{ asset("") }}app-assets/vendors/js/ui/unison.min.js" type="text/javascript"></script>
<script src="{{ asset("") }}app-assets/vendors/js/ui/blockUI.min.js" type="text/javascript"></script>
<script src="{{ asset("") }}app-assets/vendors/js/ui/jquery.matchHeight-min.js" type="text/javascript"></script>
<script src="{{ asset("") }}app-assets/vendors/js/ui/screenfull.min.js" type="text/javascript"></script>
<script src="{{ asset("") }}app-assets/vendors/js/extensions/pace.min.js" type="text/javascript"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<script src="{{ asset('app-assets/vendors/js/charts/amcharts/core.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/charts/amcharts/charts.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/charts/amcharts/animated.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/charts/amcharts/theme.dark.js') }}"></script>
<script src="{{ asset("") }}app-assets/vendors/js/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="{{ asset("") }}app-assets/vendors/js/datatables/dataTables.bootstrap4.min.js" type="text/javascript"></script>
<script src="{{ asset("") }}app-assets/vendors/js/sweetalert/sweetalert.min.js"></script>
<script src="{{ asset("") }}app-assets/vendors/js/socket-io/socket.io.js"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="{{ asset("") }}app-assets/js/core/app-menu.js" type="text/javascript"></script>
<script src="{{ asset("") }}app-assets/js/core/app.js" type="text/javascript"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="{{ asset("") }}assets/js/scripts.js" type="text/javascript"></script>
<!-- END PAGE LEVEL JS-->

<script>
    let socket = io.connect("{{ explode(':', env('APP_URL'))[1] }}:{{ env('SOCKET_PORT') }}");

    socket.on('connected', function(data){
        console.log(data);
    });
    
    $('.my-datatables').DataTable();
</script>