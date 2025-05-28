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

            <li class="nav-item dropdown {{ request()->routeIs('doctor.treatment-plans.*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-notes-medical"></i><span>Treatment
                        Plans</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('doctor.treatment-plans.index') }}">All Treatment Plans</a>
                    </li>
                    <li><a class="nav-link" href="{{ route('doctor.treatment-plans.create') }}">New Treatment Plan</a>
                    </li>
                </ul>
            </li>


            <li class="{{ request()->routeIs('doctor.patients.index') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('doctor.patients.index') }}"><i class="fas fa-user-injured"></i>
                    <span>{{ trans('messages.patients') }}</span></a></li>


            @php
                $doctorId = auth()->user()->id;

                $allOrdersCount = App\Models\Scan::where('doctor_id', $doctorId)->count();

                $pendingCount = App\Models\Scan::where('doctor_id', $doctorId)
                    ->whereHas('latestStatus', function ($query) {
                        $query->where('status', 'pending');
                    })
                    ->count();

                $rejectedCount = App\Models\Scan::where('doctor_id', $doctorId)
                    ->whereHas('latestStatus', function ($query) {
                        $query->where('status', 'rejected');
                    })
                    ->count();

                $completedCount = App\Models\Scan::where('doctor_id', $doctorId)
                    ->whereHas('latestStatus', function ($query) {
                        $query->where('status', 'completed');
                    })
                    ->count();

                $deliveredCount = App\Models\Scan::where('doctor_id', $doctorId)
                    ->whereHas('latestStatus', function ($query) {
                        $query->where('status', 'delivered');
                    })
                    ->count();
            @endphp

            <li
                class="dropdown {{ request()->routeIs('doctor.orders.index') || request()->routeIs('doctor.orders.pending') || request()->routeIs('doctor.orders.rejected') || request()->routeIs('doctor.orders.completed') || request()->routeIs('doctor.orders.delivered') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                    <span>Orders</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('doctor.orders.index') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('doctor.orders.index') }}">All Orders ({{ $allOrdersCount }})</a></li>
                    <li class="{{ request()->routeIs('doctor.orders.pending') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('doctor.orders.pending') }}">Pending Orders ({{ $pendingCount }})</a></li>
                    <li class="{{ request()->routeIs('doctor.orders.rejected') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('doctor.orders.rejected') }}">Rejected Orders ({{ $rejectedCount }})</a>
                    </li>
                    <li class="{{ request()->routeIs('doctor.orders.completed') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('doctor.orders.completed') }}">Completed Orders ({{ $completedCount }})</a>
                    </li>
                    <li class="{{ request()->routeIs('doctor.orders.delivered') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('doctor.orders.delivered') }}">Delivered Orders ({{ $deliveredCount }})</a>
                    </li>
                </ul>
            </li>

        </ul>

    </aside>
</div>
