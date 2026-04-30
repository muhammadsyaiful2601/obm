<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">Muhammad Syaiful</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">MS</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Pages</li>

            <li class="dropdown {{ Request::is('controll-panel/*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-film"></i><span>Movies</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('controll-panel/dashboard') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ route('dashboard') }}">{{ app()->getLocale() == 'id' ? 'Cari Film' : 'Search Movies' }}</a>
                    </li>
                    <li class="{{ Request::is('controll-panel/favorite') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ route('favorite') }}">{{ app()->getLocale() == 'id' ? 'Favorit Saya' : 'My Favorites' }}</a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
