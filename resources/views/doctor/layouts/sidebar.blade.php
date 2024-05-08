<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('doctor.dashboard') }}">Orthoveer</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('doctor.dashboard') }}"><img style="width: 35px" src="{{ asset(config('settings.logo')) }}"
                    alt="OV"></a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">{{ trans('messages.dashboard') }}</li>
            <li class="{{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('doctor.dashboard') }}"><i class="fas fa-fire"></i>
                    <span>{{ trans('messages.dashboard') }}</span></a></li>

            <li class="menu-header">Starter</li>
            <li class="{{ request()->routeIs('doctor.scans.index') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('doctor.scans.index') }}"><i class="far fa-file"></i>
                    <span>{{ trans('messages.new_scan') }}</span></a></li>

            <li class="{{ request()->routeIs('doctor.patients.index') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('doctor.patients.index') }}"><i class="fas fa-user-injured"></i>
                    <span>{{ trans('messages.patients') }}</span></a></li>

            <li class="{{ request()->routeIs('doctor.orders.index') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('doctor.orders.index') }}"><i class="fas fa-briefcase"></i>
                    <span>{{ trans('messages.orders') }}</span></a></li>

            @php
                $unseenMessages = \App\Models\Chat::where(['receiver_id' => auth()->user()->id, 'seen' => 0])->count();
            @endphp

            <li class="{{ request()->routeIs('doctor.chat.index') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('doctor.chat.index') }}"><i class="fas fa-envelope"></i>
                    <span>{{ trans('messages.messages') }} ({{ $unseenMessages }})</span></a></li>
        </ul>

    </aside>
</div>
