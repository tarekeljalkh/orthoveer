<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">Orthoveer</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}"><img style="width: 35px" src="{{ asset(config('settings.logo')) }}"
                    alt="OV"></a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('admin.dashboard') }}"><i class="fas fa-fire"></i>
                    <span>Dashboard</span></a></li>


            <li class="menu-header">Starter</li>

            {{-- <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fas fa-columns"></i> <span>Layout</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="layout-default.html">Default Layout</a></li>
                    <li><a class="nav-link" href="layout-transparent.html">Transparent Sidebar</a></li>
                    <li><a class="nav-link" href="layout-top-navigation.html">Top Navigation</a></li>
                </ul>
            </li> --}}

            <li class="{{ request()->routeIs('admin.doctors.index') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('admin.doctors.index') }}"><i class="fas fa-user-md"></i>
                    <span>Doctors</span></a></li>

            <li class="{{ request()->routeIs('admin.labs.index') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('admin.labs.index') }}"><i class="fas fa-flask"></i>
                    <span>Labs</span></a></li>

            <li class="{{ request()->routeIs('admin.external_labs.index') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('admin.external_labs.index') }}"><i class="fas fa-vials"></i>
                    <span>External Labs</span></a></li>

            <li class="{{ request()->routeIs('admin.categories.index') ? 'active' : '' }}" class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                    <span>Type of Works</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('admin.categories.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.categories.index') }}">Categories</a></li>
                    <li class="{{ request()->routeIs('admin.type-of-works.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.type-of-works.index') }}">Type of Works</a></li>
                </ul>
            </li>

            <li class="{{ request()->routeIs('admin.setting.index') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('admin.setting.index') }}"><i class="fas fa-cog"></i>
                    <span>Settings</span></a></li>


        </ul>

    </aside>
</div>
