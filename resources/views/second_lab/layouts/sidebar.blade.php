<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('second_lab.dashboard') }}">Orthoveer</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('second_lab.dashboard') }}"><img style="width: 35px" src="{{ asset(config('settings.logo')) }}"
                    alt="OV"></a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">{{ trans('messages.dashboard') }}</li>
            <li class="{{ request()->routeIs('second_lab.dashboard') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('second_lab.dashboard') }}"><i class="fas fa-fire"></i>
                    <span>{{ trans('messages.dashboard') }}</span></a></li>

            <li class="menu-header">Starter</li>

            <li class="{{ request()->routeIs('second_lab.scans.new') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('second_lab.scans.new') }}"><i class="fas fa-folder-open"></i>
                    <span>{{ trans('messages.new_scans') }}</span></a></li>

            <li class="{{ request()->routeIs('second_lab.scans.index') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('second_lab.scans.index') }}"><i class="fas fa-briefcase"></i>
                    <span>{{ trans('messages.all_scans') }}</span></a></li>

                    <li class="{{ request()->routeIs('second_lab.printfiles.index') ? 'active' : '' }}"><a class="nav-link"
                        href="{{ route('second_lab.printfiles.index') }}"><i class="fas fa-file-upload"></i>
                        <span>{{ trans('messages.print_files') }}</span></a></li>

            <li class="{{ request()->routeIs('second_lab.orders.index') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('second_lab.orders.index') }}"><i class="fas fa-briefcase"></i>
                    <span>{{ trans('messages.dhl_orders') }}</span></a></li>

        </ul>

    </aside>
</div>
