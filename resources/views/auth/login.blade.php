<!DOCTYPE html>
<!-- Mengubah atribut lang secara dinamis -->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <!-- Menggunakan title dari kamus -->
    <title>{{ __('messages.login_title') }} &mdash; OMDB</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-social/bootstrap-social.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div
                        class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="login-brand">
                            <img src="{{ asset('assets/img/stisla-fill.svg') }}" alt="logo" width="100"
                                class="shadow-light rounded-circle">
                        </div>

                        <!-- Tombol Switcher Bahasa sesuai Referensi Gambar -->
                        <div class="d-flex justify-content-center mb-4">
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle text-uppercase" type="button"
                                    id="languageSelector" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fas fa-globe mr-1"></i> {{ app()->getLocale() }}
                                </button>
                                <div class="dropdown-menu shadow-sm" aria-labelledby="languageSelector">
                                    <a class="dropdown-item d-flex align-items-center {{ app()->getLocale() == 'id' ? 'active' : '' }}"
                                        href="{{ route('lang.switch', 'id') }}">
                                        ID - Indonesia
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center {{ app()->getLocale() == 'en' ? 'active' : '' }}"
                                        href="{{ route('lang.switch', 'en') }}">
                                        EN - English
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>{{ __('messages.login_title') }}</h4>
                            </div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('signin') }}" class="needs-validation"
                                    novalidate="">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email" tabindex="1">
                                        @error('email')
                                            <span class="text-sm text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Password</label>
                                        </div>
                                        <input type="password" class="form-control" name="password" tabindex="2">
                                        @error('password')
                                            <span class="text-sm text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            {{ __('messages.login_title') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="mt-5 text-muted text-center">
                            {{-- Gunakan key register_title jika ingin diterjemahkan --}}
                            Don't have an account? <a href="{{ url('/register') }}">Create One</a>
                        </div>
                        <div class="simple-footer">
                            Copyright &copy; <span id="year"></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Script JS tetap sama seperti kode awal kamu -->
    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    {{-- SweetAlert Section tetap dipertahankan --}}
    @if (session()->has('success'))
        <script>
            Swal.fire({
                text: "{{ session()->get('success') }}",
                icon: 'success',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            })
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            Swal.fire({
                text: "{{ session()->get('error') }}",
                icon: 'error',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            })
        </script>
    @endif

    <script>
        document.getElementById('year').innerHTML = new Date().getFullYear();
    </script>
</body>

</html>
