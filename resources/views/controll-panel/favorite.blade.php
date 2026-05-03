<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>My Favorites &mdash; Stisla</title>

    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
</head>

<body>
    @include('layout.header')
    @include('layout.sidebar')

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <!-- Menggunakan __() untuk multi-bahasa -->
                <h1>{{ __('messages.my_favorites') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a
                            href="{{ url('dashboard') }}">{{ __('messages.dashboard') }}</a></div>
                    <div class="breadcrumb-item">{{ __('messages.favorites') }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ __('messages.favorite_movies') }}</h4>
                            </div>
                            <div class="card-body">
                                <div id="favorites-content">
                                    <div class="text-center py-5">
                                        <i class="fas fa-heart-broken fa-3x text-muted mb-3 d-block"></i>
                                        <h5 class="text-muted">
                                            {{ __('messages.no_favorites_yet') }}
                                        </h5>
                                        <p class="text-muted">
                                            {{ __('messages.start_adding_favorites') }}
                                        </p>
                                        <a href="{{ url('dashboard') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-search"></i>
                                            {{ __('messages.search_movies') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('layout.footer')
</body>


</html>
