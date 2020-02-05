<!-- main menu-->
<div data-scroll-to-active="true" class="main-menu menu-fixed menu-dark menu-accordion menu-shadow">
    <!-- / main menu header-->
    <!-- main menu content-->
    <div class="main-menu-content">
        <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
            {{-- Dashboard --}}
            <li class="nav-item">
                <a href="{{ route('web.dashboard.index') }}">
                    <i class="icon-home3"></i>
                    <span data-i18n="nav.dash.main" class="menu-title">Dashboard</span>
                </a>
            </li>
            {{-- Devices --}}
            <li class="nav-item">
                <a href="{{ route('web.devices.index') }}">
                    <i class="icon-drive"></i>
                    <span data-i18n="nav.dash.main" class="menu-title">Devices</span>
                </a>
            </li>
            {{-- Endpoints --}}
            <li class="nav-item">
                <a href="{{ route('web.endpoints.index') }}">
                    <i class="icon-sphere"></i>
                    <span data-i18n="nav.dash.main" class="menu-title">Endpoints</span>
                </a>
            </li>
            {{-- Activities --}}
            <li class="nav-item">
                <a href="{{ route('web.activities.index') }}" class="acitivities">
                    <i class="icon-stack"></i>
                    <span data-i18n="nav.dash.main" class="menu-title">Activities</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- / main menu-->