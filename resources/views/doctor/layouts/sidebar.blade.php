<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('doctor.dashboard') }}">Orthoveer</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('doctor.dashboard') }}">OV</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('doctor.dashboard') }}"><i class="fas fa-fire"></i>
                    <span>Dashboard</span></a></li>

            <li class="menu-header">Starter</li>
            <li class="{{ request()->routeIs('doctor.scans.index') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('doctor.scans.index') }}"><i class="far fa-file"></i>
                    <span>New Scan</span></a></li>

            <li class="{{ request()->routeIs('doctor.patients.index') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('doctor.patients.index') }}"><i class="fas fa-user-injured"></i>
                    <span>Patients</span></a></li>

            <li class="{{ request()->routeIs('doctor.orders.index') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('doctor.orders.index') }}"><i class="fas fa-briefcase"></i>
                    <span>Orders</span></a></li>

            <li class="#"><a class="nav-link"
                    href="#"><i class="fas fa-envelope"></i>
                    <span>Messages</span></a></li>


        </ul>

    </aside>
</div>
