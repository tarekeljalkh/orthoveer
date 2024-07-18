<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                        class="fas fa-search"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">

        @php
            $notifications = \App\Models\Notification::latest()->take(10)->get();

        @endphp


        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">{{ trans('messages.notifications') }}
                    <div class="float-right">
                        <a href="#">{{ trans('messages.mark_all_as_read') }}</a>
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-icons">

                    @foreach ($notifications as $notification)
                        <a href="#" class="dropdown-item dropdown-item-unread">
                            <div class="dropdown-item-icon bg-primary text-white">
                                <i class="fas fa-code"></i>
                            </div>
                            <div class="dropdown-item-desc">
                                Sender: {{ $notification->sender->first_name }}<br>
                                Receiver: {{ $notification->receiver->first_name }}<br>
                                ID: {{ $notification->scan_id }}
                                <div class="time text-primary">
                                    {{ date('h:i A | d-F-Y', strtotime($notification->created_at)) }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="dropdown-footer text-center">
                    <a href="{{ route('admin.notifications.index') }}">{{ trans('messages.view_all') }} <i
                            class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li>

        {{-- Localization --}}
        <li class="dropdown dropdown-list-toggle">
            <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg">
                <i class="fas fa-globe"></i>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">{{ trans('messages.select_language') }}
                    <div class="float-right">
                        <a href="#">{{ trans('messages.close') }}</a>
                    </div>
                </div>
                <div class="dropdown-list-content">
                    {{-- <a href="{{ route('setLang', ['locale' => 'en']) }}" class="dropdown-item">English</a>
                    <a href="{{ route('setLang', ['locale' => 'fr']) }}" class="dropdown-item">Français</a> --}}
                    <a href="{{ route('setLang', ['locale' => 'en']) }}"
                        class="dropdown-item {{ App::getLocale() == 'en' ? 'active-lang' : '' }}">{{ trans('messages.english') }}</a>
                    <a href="{{ route('setLang', ['locale' => 'fr']) }}"
                        class="dropdown-item {{ App::getLocale() == 'fr' ? 'active-lang' : '' }}">{{ trans('messages.french') }}</a>
                    <!-- Add more languages as needed -->
                </div>
            </div>
        </li>

        {{-- End Localization --}}
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset(auth()->user()->image) }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->first_name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> {{ trans('messages.profile') }}
                </a>
                <div class="dropdown-divider"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a href="#" class="dropdown-item has-icon text-danger"
                        onclick="event.preventDefault();
                this.closest('form').submit();">
                        <i class="fas fa-sign-out-alt"></i> {{ trans('messages.logout') }}
                    </a>
                </form>

            </div>
        </li>
    </ul>
</nav>
