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
    <link rel="stylesheet" href="{{ asset('assets/css/dropdown-fix.css') }}">
</head>

<body>
    @include('layout.header')
    @include('layout.sidebar')

    <div class="main-content">
        <section class="section">
            <div class="section-header">
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
                                    @if ($favorites && count($favorites) > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('messages.poster') }}</th>
                                                        <th>{{ __('messages.title') }}</th>
                                                        <th>{{ __('messages.year') }}</th>
                                                        <th>{{ __('messages.type') }}</th>
                                                        <th>{{ __('messages.action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($favorites as $favorite)
                                                        <tr id="favorite-{{ $favorite->imdb_id }}">
                                                            <td>
                                                                <img src="{{ $favorite->poster !== 'N/A' && $favorite->poster ? $favorite->poster : 'https://via.placeholder.com/50x75?text=No+Image' }}"
                                                                    alt="{{ $favorite->title }}" width="50"
                                                                    class="img-thumbnail shadow-sm">
                                                            </td>
                                                            <td class="align-middle font-weight-bold">
                                                                {{ $favorite->title }}</td>
                                                            <td class="align-middle">{{ $favorite->year ?? '-' }}</td>
                                                            <td class="align-middle">
                                                                <span
                                                                    class="badge badge-primary text-capitalize">{{ $favorite->type ?? '-' }}</span>
                                                            </td>
                                                            <td class="align-middle">
                                                                <button class="btn btn-sm btn-danger remove-favorite"
                                                                    data-id="{{ $favorite->imdb_id }}">
                                                                    <i class="fas fa-trash"></i>
                                                                    {{ __('messages.remove') }}
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="fas fa-heart-broken fa-3x text-muted mb-3 d-block"></i>
                                            <h5 class="text-muted">{{ __('messages.no_favorites_yet') }}</h5>
                                            <p class="text-muted">{{ __('messages.start_adding_favorites') }}</p>
                                            <a href="{{ route('panel.movies') }}" class="btn btn-primary mt-2">
                                                <i class="fas fa-search"></i> {{ __('messages.search_movies') }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('layout.footer')

    <script>
        // Localization untuk JavaScript
        const appLocales = {
            confirmDeleteFavorite: "{{ __('messages.confirm_delete_favorite') }}",
            errorDeleteFavorite: "{{ __('messages.error_delete_favorite') }}"
        };

        $(document).ready(function() {
            // Fungsi untuk menghapus favorit
            $(document).on('click', '.remove-favorite', function(e) {
                e.preventDefault();

                let btn = $(this);
                let imdbId = btn.data('id');
                let row = btn.closest('tr');

                if (!confirm(appLocales.confirmDeleteFavorite)) {
                    return;
                }

                btn.prop('disabled', true);
                btn.html('<i class="fas fa-spinner fa-spin"></i>');

                $.ajax({
                    url: "{{ route('favorite.toggle') }}",
                    type: "POST",
                    data: {
                        imdb_id: imdbId,
                        title: '',
                        _token: "{{ csrf_token() }}"
                    },
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        row.fadeOut(300, function() {
                            $(this).remove();

                            let tbody = $('table tbody');
                            if (tbody.find('tr').length === 0) {
                                setTimeout(function() {
                                    location.reload();
                                }, 500);
                            }
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert(appLocales.errorDeleteFavorite);
                        btn.prop('disabled', false);
                        btn.html('<i class="fas fa-trash"></i> {{ __('messages.remove') }}');
                    }
                });
            });
        });
    </script>
</body>

</html>
