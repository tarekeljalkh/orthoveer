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
            <li class="menu-header">{{ trans('messages.dashboard') }}</li>
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('admin.dashboard') }}"><i class="fas fa-fire"></i>
                    <span>{{ trans('messages.dashboard') }}</span></a></li>


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
                    <span>{{ trans('messages.doctors') }}</span></a></li>

            <li class="{{ request()->routeIs('admin.labs.index') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('admin.labs.index') }}"><i class="fas fa-flask"></i>
                    <span>{{ trans('messages.labs') }}</span></a></li>

            <li class="{{ request()->routeIs('admin.external_labs.index') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('admin.external_labs.index') }}"><i class="fas fa-vials"></i>
                    <span>{{ trans('messages.external_labs') }}</span></a></li>

            <li class="dropdown {{ request()->routeIs('admin.categories.index') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                    <span>{{ trans('messages.type_of_works') }}</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('admin.categories.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.categories.index') }}">{{ trans('messages.categories') }}</a></li>
                    <li class="{{ request()->routeIs('admin.type-of-works.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.type-of-works.index') }}">{{ trans('messages.type_of_works') }}</a></li>
                </ul>
            </li>


            <li class="{{ request()->routeIs('admin.chat.index') ? 'active' : '' }}"><a class="nav-link"
                href="{{ route('admin.chat.index') }}"><i class="fas fa-envelope"></i>
                <span>{{ trans('messages.messages') }}</span></a></li>


            <li class="{{ request()->routeIs('admin.setting.index') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('admin.setting.index') }}"><i class="fas fa-cog"></i>
                    <span>{{ trans('messages.settings') }}</span></a></li>


        </ul>

    </aside>
</div>
