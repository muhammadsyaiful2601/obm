<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>

        <nav class="navbar navbar-expand-lg main-navbar">
            <form class="form-inline mr-auto">
                <ul class="navbar-nav mr-3">
                    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>
            </form>
            <ul class="navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <div class="d-sm-none d-lg-inline-block">
                            <i class="fas fa-globe"></i> <span class="text-uppercase">{{ app()->getLocale() }}</span>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-title">{{ __('messages.select_language') }}</div>
                        <a href="{{ route('lang.switch', 'en') }}"
                            class="dropdown-item has-icon {{ app()->getLocale() == 'en' ? 'text-primary' : '' }}">
                            <i class="fas fa-check-circle"></i> English
                        </a>
                        <a href="{{ route('lang.switch', 'id') }}"
                            class="dropdown-item has-icon {{ app()->getLocale() == 'id' ? 'text-primary' : '' }}">
                            <i class="fas fa-check-circle"></i> Bahasa Indonesia
                        </a>
                    </div>
                </li>

                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}"
                            class="rounded-circle mr-1">
                        <div class="d-sm-none d-lg-inline-block">
                            {{ __('messages.greeting') }}, {{ Auth::check() ? Auth::user()->name : 'Muhammad Syaiful' }}
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('signout') }}" class="dropdown-item has-icon text-danger">
                            <i class="fas fa-sign-out-alt"></i> {{ __('messages.logout') }}
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
