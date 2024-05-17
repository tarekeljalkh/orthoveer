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

            <li class="{{ request()->routeIs('second_lab.scans.pending') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('second_lab.scans.pending') }}"><i class="fas fa-truck-loading"></i>
                    <span>{{ trans('messages.pending_scans') }}</span></a></li>

            <li class="{{ request()->routeIs('second_lab.scans.index') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('second_lab.scans.index') }}"><i class="fas fa-briefcase"></i>
                    <span>{{ trans('messages.all_scans') }}</span></a></li>

            <li class="{{ request()->routeIs('second_lab.orders.index') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('second_lab.orders.index') }}"><i class="fas fa-briefcase"></i>
                    <span>{{ trans('messages.orders') }}</span></a></li>

                    @php
                    $unseenMessages = \App\Models\Chat::where(['receiver_id' => auth()->user()->id, 'seen' => 0])->count();
                @endphp


            <li class="{{ request()->routeIs('second_lab.chat.index') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('second_lab.chat.index') }}"><i class="fas fa-envelope"></i>
                    <span>{{ trans('messages.messages') }} ({{ $unseenMessages }})</span></a></li>

        </ul>

    </aside>
</div>
