<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('lab.dashboard') }}">Orthoveer</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('lab.dashboard') }}"><img style="width: 35px" src="{{ asset(config('settings.logo')) }}" alt="OV"></a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ request()->routeIs('lab.dashboard') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('lab.dashboard') }}"><i class="fas fa-fire"></i>
                    <span>Dashboard</span></a></li>

            <li class="menu-header">Starter</li>

            <li class="{{ request()->routeIs('lab.orders.new') ? 'active' : '' }}"><a class="nav-link"
                href="{{ route('lab.orders.new') }}"><i class="fas fa-folder-open"></i>
                <span>New Orders</span></a></li>

            <li class="{{ request()->routeIs('lab.orders.pending') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('lab.orders.pending') }}"><i class="fas fa-truck-loading"></i>
                    <span>Pending Orders</span></a></li>

            <li class="{{ request()->routeIs('lab.orders.index') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('lab.orders.index') }}"><i class="fas fa-briefcase"></i>
                    <span>All Orders</span></a></li>

            <li class="{{ request()->routeIs('lab.chat.index') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('lab.chat.index') }}"><i class="fas fa-envelope"></i>
                    <span>Messages</span></a></li>



        </ul>

    </aside>
</div>
