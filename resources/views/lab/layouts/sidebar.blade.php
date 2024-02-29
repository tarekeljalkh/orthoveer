<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Orthoveer</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">OV</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ request()->routeIs('lab.dashboard') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('lab.dashboard') }}"><i class="fas fa-fire"></i>
                    <span>Dashboard</span></a></li>

            <li class="menu-header">Starter</li>

            <li class="{{ request()->routeIs('lab.orders.index') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('lab.orders.index') }}"><i class="fas fa-briefcase"></i>
                    <span>Orders</span></a></li>

            <li class="#"><a class="nav-link"
                    href="#"><i class="fas fa-envelope"></i>
                    <span>Messages</span></a></li>


        </ul>

    </aside>
</div>
