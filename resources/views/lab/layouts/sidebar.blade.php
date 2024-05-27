<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('lab.dashboard') }}">Orthoveer</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('lab.dashboard') }}"><img style="width: 35px" src="{{ asset(config('settings.logo')) }}"
                    alt="OV"></a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">{{ trans('messages.dashboard') }}</li>
            <li class="{{ request()->routeIs('lab.dashboard') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('lab.dashboard') }}"><i class="fas fa-fire"></i>
                    <span>{{ trans('messages.dashboard') }}</span></a></li>

            <li class="menu-header">Starter</li>

            <li class="{{ request()->routeIs('lab.scans.new') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('lab.scans.new') }}"><i class="fas fa-folder-open"></i>
                    <span>{{ trans('messages.new_scans') }}</span></a></li>

            <li class="{{ request()->routeIs('lab.scans.pending') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('lab.scans.pending') }}"><i class="fas fa-truck-loading"></i>
                    <span>{{ trans('messages.pending_scans') }}</span></a></li>

            <li class="{{ request()->routeIs('lab.scans.index') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('lab.scans.index') }}"><i class="fas fa-briefcase"></i>
                    <span>{{ trans('messages.all_scans') }}</span></a></li>

            <li class="{{ request()->routeIs('lab.scans.create') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('lab.scans.create') }}"><i class="fas fa-plus"></i>
                    <span>{{ trans('messages.create_scan') }}</span></a></li>

                    <li class="{{ request()->routeIs('lab.printfiles.index') ? 'active' : '' }}"><a class="nav-link"
                        href="{{ route('lab.printfiles.index') }}"><i class="fas fa-file-upload"></i>
                        <span>{{ trans('messages.print_files') }}</span></a></li>

            @php
                $unseenMessages = \App\Models\Chat::where(['receiver_id' => auth()->user()->id, 'seen' => 0])->count();
            @endphp


            <li class="{{ request()->routeIs('lab.chat.index') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('lab.chat.index') }}"><i class="fas fa-envelope"></i>
                    <span>{{ trans('messages.messages') }} ({{ $unseenMessages }})</span></a></li>

        </ul>

    </aside>
</div>
