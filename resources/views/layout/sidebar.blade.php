<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        @auth
            @php
                $fullName = Auth::user()->name;
                $words = explode(' ', trim($fullName));
                $initials = '';
                foreach ($words as $word) {
                    if (!empty($word)) {
                        $initials .= strtoupper($word[0]);
                    }
                }
            @endphp
        @endauth

        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">{{ Auth::check() ? $fullName : 'Guest' }}</a>
        </div>

        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">{{ Auth::check() ? $initials : 'G' }}</a>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-header">{{ __('messages.pages') }}</li>

            <li class="dropdown {{ Request::is('controll-panel/*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
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
