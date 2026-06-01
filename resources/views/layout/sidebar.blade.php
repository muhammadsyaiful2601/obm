<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">Muhammad Syaiful</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">MS</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">{{ __('messages.pages') }}</li>

            <li class="dropdown {{ Request::is('controll-panel/*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown-menu">
                    <i class="fas fa-film"></i>
                    <span>{{ __('messages.movies') }}</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('controll-panel/dashboard') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('dashboard') }}">{{ __('messages.search_films') }}</a>
                    </li>
                    <li class="{{ Request::is('controll-panel/favorite') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('favorite') }}">{{ __('messages.my_favorites_menu') }}</a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
