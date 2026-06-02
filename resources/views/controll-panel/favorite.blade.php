<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>My Favorites &mdash; Stisla</title>

    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
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
                                                            <td class="align-middle text-nowrap">
                                                                <button class="btn btn-sm btn-info movie-detail"
                                                                    data-id="{{ $favorite->imdb_id }}" title="Detail">
                                                                    <i class="fas fa-info-circle"></i>
                                                                </button>
                                                                <button class="btn btn-sm btn-danger remove-favorite"
                                                                    data-id="{{ $favorite->imdb_id }}"
                                                                    title="{{ __('messages.remove') }}">
                                                                    <i class="fas fa-trash"></i>
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

    <div class="modal fade" tabindex="-1" role="dialog" id="movieDetailModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('messages.movie_detail') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="movie-detail-content" class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">{{ __('messages.loading') }}</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ __('messages.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    @include('layout.footer')

    <script>
        const appLocales = {
            confirmDeleteFavorite: "{{ __('messages.confirm_delete_favorite') ?? 'Are you sure?' }}",
            errorDeleteFavorite: "{{ __('messages.error_delete_favorite') ?? 'Error deleting' }}",
            genre: "{{ __('messages.genre') ?? 'Genre' }}",
            director: "{{ __('messages.director') ?? 'Director' }}",
            actors: "{{ __('messages.actors') ?? 'Actors' }}",
            rating: "{{ __('messages.rating') ?? 'Rating' }}",
            plot: "{{ __('messages.plot') ?? 'Plot' }}",
            detailNotFound: "{{ __('messages.detail_not_found') ?? 'Movie detail not found.' }}",
            detailError: "{{ __('messages.detail_error') ?? 'Error fetching details.' }}"
        };

        $(document).ready(function() {
            // Hapus Favorit
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
                    success: function(response) {
                        row.fadeOut(300, function() {
                            $(this).remove();
                            if ($('table tbody tr').length === 0) {
                                setTimeout(function() {
                                    location.reload();
                                }, 500);
                            }
                        });
                    },
                    error: function(xhr) {
                        alert(appLocales.errorDeleteFavorite);
                        btn.prop('disabled', false);
                        btn.html('<i class="fas fa-trash"></i>');
                    }
                });
            });

            // Tampilkan Detail
            $(document).on('click', '.movie-detail', function(e) {
                e.preventDefault();
                let imdbId = $(this).data('id');

                $('#movieDetailModal').modal('show');
                $('#movie-detail-content').html(`
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">{{ __('messages.loading') }}</span>
                        </div>
                    </div>
                `);

                $.ajax({
                    url: `/controll-panel/movies/detail/${imdbId}`,
                    type: "GET",
                    success: function(response) {
                        if (response.Response === "True" || response.Title) {
                            let poster = (response.Poster && response.Poster !== 'N/A') ?
                                response.Poster :
                                'https://via.placeholder.com/300x450?text=No+Image';
                            let html = `
                                <div class="row text-left">
                                    <div class="col-md-4 text-center mb-3">
                                        <img src="${poster}" alt="${response.Title}" class="img-fluid rounded shadow">
                                    </div>
                                    <div class="col-md-8">
                                        <h4>${response.Title} (${response.Year})</h4>
                                        <p class="mb-1"><strong><i class="fas fa-tags"></i> ${appLocales.genre}:</strong> ${response.Genre}</p>
                                        <p class="mb-1"><strong><i class="fas fa-video"></i> ${appLocales.director}:</strong> ${response.Director}</p>
                                        <p class="mb-1"><strong><i class="fas fa-users"></i> ${appLocales.actors}:</strong> ${response.Actors}</p>
                                        <p class="mb-1"><strong><i class="fas fa-star text-warning"></i> ${appLocales.rating}:</strong> ${response.imdbRating}</p>
                                        <hr>
                                        <p><strong>${appLocales.plot}:</strong><br>${response.Plot}</p>
                                    </div>
                                </div>
                            `;
                            $('#movie-detail-content').html(html);
                        } else {
                            $('#movie-detail-content').html(
                                `<div class="alert alert-danger">${appLocales.detailNotFound}</div>`
                                );
                        }
                    },
                    error: function(xhr) {
                        $('#movie-detail-content').html(
                            `<div class="alert alert-danger">${appLocales.detailError}</div>`
                            );
                    }
                });
            });
        });
    </script>
</body>

</html>
