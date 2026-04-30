<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ __('messages.register_title') }} &mdash; OMDB</title>

    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/jquery-selectric/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div
                        class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                        <div class="login-brand">
                            <img src="{{ asset('assets/img/stisla-fill.svg') }}" alt="logo" width="100"
                                class="shadow-light rounded-circle">
                        </div>

                        <!-- Language Switcher (Identik dengan halaman Login) -->
                        <div class="text-center mb-3">
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-outline-primary btn-sm dropdown-toggle text-uppercase"
                                    type="button" data-toggle="dropdown">
                                    <i class="fas fa-globe"></i> {{ app()->getLocale() }}
                                </button>
                                <div class="dropdown-menu">
                                    <a href="{{ route('lang.switch', 'en') }}"
                                        class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}">
                                        English
                                    </a>
                                    <a href="{{ route('lang.switch', 'id') }}"
                                        class="dropdown-item {{ app()->getLocale() == 'id' ? 'active' : '' }}">
                                        Bahasa Indonesia
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>{{ __('messages.register_title') }}</h4>
                            </div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('register.process') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="full_name">{{ __('messages.full_name') }}</label>
                                        <input id="full_name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" autofocus>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="password" class="d-block">Password</label>
                                            <input id="password" type="password"
                                                class="form-control pwstrength @error('password') is-invalid @enderror"
                                                data-indicator="pwindicator" name="password">
                                            <div id="pwindicator" class="pwindicator">
                                                <div class="bar"></div>
                                                <div class="label"></div>
                                            </div>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="password_confirmation"
                                                class="d-block">{{ __('messages.password_confirmation') }}</label>
                                            <input id="password_confirmation" type="password" class="form-control"
                                                name="password_confirmation">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                                            {{ __('messages.register_title') }}
                                        </button>
                                    </div>
                                </form>

                                <div class="mt-5 text-muted text-center">
                                    {{ __('messages.already_have_account') }} <a href="{{ route('login') }}">Login</a>
                                </div>
                            </div>
                        </div>
                        <div class="simple-footer">
                            Copyright &copy; Stisla <span id="years"></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Scripts Tetap Sama -->
    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>
    <script src="{{ asset('assets/modules/jquery-pwstrength/jquery.pwstrength.min.js') }}"></script>
    <script src="{{ asset('assets/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('assets/js/page/auth-register.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script>
        document.getElementById('years').innerHTML = new Date().getFullYear();
    </script>
</body>

</html>
