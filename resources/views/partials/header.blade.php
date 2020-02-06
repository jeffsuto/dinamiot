<!-- navbar-fixed-top-->
<nav class="header-navbar navbar navbar-with-menu navbar-fixed-top navbar-dark navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-header">
        <ul class="nav navbar-nav">
            <li class="nav-item mobile-menu hidden-md-up float-xs-left"><a class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="icon-menu5 font-large-1"></i></a></li>
            <li class="nav-item"><a href="{{ route('web.dashboard.index') }}" class="navbar-brand nav-link"><img alt="branding logo" style="max-height: 30px" src="{{ asset('assets/images/dinamiot-full.svg') }}" data-expand="{{ asset('assets/images/dinamiot-full.svg') }}" data-collapse="{{ asset('assets/images/dinamiot-single.svg') }}" class="brand-logo"></a></li>
            <li class="nav-item hidden-md-up float-xs-right"><a data-toggle="collapse" data-target="#navbar-mobile" class="nav-link open-navbar-container"><i class="icon-ellipsis pe-2x icon-icon-rotate-right-right"></i></a></li>
        </ul>
        </div>
        <div class="navbar-container content container-fluid">
        <div id="navbar-mobile" class="collapse navbar-toggleable-sm">
            <ul class="nav navbar-nav">
                <li class="nav-item hidden-sm-down"><a class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="icon-menu5">         </i></a></li>
                <li class="nav-item hidden-sm-down"><a href="#" class="nav-link nav-link-expand"><i class="ficon icon-expand2"></i></a></li>
            </ul>
            <ul class="nav navbar-nav float-xs-right">
                <li class="dropdown dropdown-notification nav-item">
                    <a href="#" data-toggle="dropdown" class="nav-link nav-link-label">
                        <i class="ficon icon-bell4"></i>
                        <span class="tag tag-pill tag-default tag-danger tag-default tag-up notif-label">

                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                        <li class="dropdown-menu-header">
                            <h6 class="dropdown-header m-0">
                                <span class="grey darken-2">Notifications</span>
                                <span class="notification-tag tag tag-default tag-danger float-xs-right m-0 notif-count"></span>
                            </h6>
                        </li>
                        <li class="list-group scrollable-container notification-container">
                            {{-- ajax view here --}}
                        </li>
                        <li class="dropdown-menu-footer"><a href="javascript:void(0)" class="dropdown-item text-muted text-xs-center read-all-btn">Read all notifications</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        </div>
    </div>
</nav>

@push('script')
    <script>
        let notifCount = 0;
        notificationCount();
        function notificationCount() {
            $.ajax({
                url: "{{ route('api.v1.activities.count') }}"
            }).done(function(data){
                notifCount = data;
                if (data) {
                    $('.notif-label').text(data);
                    $('.notif-count').text(data+" New");
                }else{
                    $('.notif-label').text("");
                    $('.notif-count').text("");
                }
            });
        }

        // load notification
        loadNewNotification();
        function loadNewNotification() {
            $.ajax({
                url: "{{ route('api.v1.activities.new') }}"
            }).done(function(data){
                $('.notification-container').empty().html(data);
            });
        }

        // read all
        $('.read-all-btn').click(function(){
            $.ajax({
                url: "{{ route('api.v1.activities.read') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: "PUT",
                    action: "read all"
                }
            }).done(function(data){
                $('.notif-label').text("");
                $('.notif-count').text("");
                $('.notification-container').html("");
            });
        });

        // read specific notification
        function readNotification(id, redirect) {
            $.ajax({
                url: "{{ route('api.v1.activities.read') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: "PUT",
                    id: id
                }
            }).done(function(data){
                window.location.replace(redirect);
            });
        }

        socket.on('activity', function(data){
            loadNewNotification();
            notificationCount();
            
            var notification = new Notification(data.data.title, {
                icon:'<img src="https://img.icons8.com/pastel-glyph/64/000000/school-1-1.png">',
                body: data.data.message,
            });
            notification.onclick = function () {
                window.open(data.data.link);      
            };
        });
    
    </script>
@endpush