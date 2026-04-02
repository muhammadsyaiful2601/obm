 <div id="app">
     <div class="main-wrapper main-wrapper-1">
         <div class="navbar-bg"></div>

         <nav class="navbar navbar-expand-lg main-navbar">
             <form class="form-inline mr-auto">
                 <ul class="navbar-nav mr-3">
                     <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i
                                 class="fas fa-bars"></i></a></li>
                 </ul>
             </form>
             <ul class="navbar-nav navbar-right">
                 <li class="dropdown">
                     <a href="#" data-toggle="dropdown"
                         class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                         <div class="d-sm-none d-lg-inline-block"><i class="fas fa-globe"></i>
                             EN</div>
                     </a>
                     <div class="dropdown-menu dropdown-menu-right">
                         <a href="#" class="dropdown-item has-icon text-primary"><i
                                 class="fas fa-check-circle"></i> English</a>
                         <a href="#" class="dropdown-item has-icon"><i class="fas fa-check-circle"></i> Bahasa
                             Indonesia</a>
                     </div>
                 </li>
                 <li class="dropdown">
                     <a href="#" data-toggle="dropdown"
                         class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                         <img alt="image"
                             src="https://omdb-app-master-mx2c8l.laravel.cloud/assets/img/avatar/avatar-1.png"
                             class="rounded-circle mr-1">
                         <div class="d-sm-none d-lg-inline-block">Hi, Muhammad Syaiful</div>
                     </a>
                     <div class="dropdown-menu dropdown-menu-right">
                         <div class="dropdown-divider"></div>
                         <a href="{{ url('/keluar') }}" class="dropdown-item has-icon text-danger">
                             <i class="fas fa-sign-out-alt"></i> Logout
                         </a>
                     </div>
                 </li>
             </ul>
         </nav>

         <div class="main-sidebar sidebar-style-2">
             <aside id="sidebar-wrapper">
                 <div class="sidebar-brand">
                     <a href="{{ url('/') }}">Muhammad Syaiful</a>
                 </div>
                 <div class="sidebar-brand sidebar-brand-sm">
                     <a href="{{ url('/') }}">MS</a>
                 </div>
                 <ul class="sidebar-menu">
                     <li class="menu-header">Pages</li>
                     <li class="dropdown active">
                         <a href="#" class="nav-link has-dropdown"><i
                                 class="fas fa-film"></i><span>Movies</span></a>
                         <ul class="dropdown-menu">
                             <li class="active"><a class="nav-link" href="{{ url('dashboard') }}">Search Movies</a>
                             </li>
                             <li><a class="nav-link" href="{{ url('favorite') }}">My Favorites</a></li>
                         </ul>
                     </li>
                 </ul>
             </aside>
         </div>
