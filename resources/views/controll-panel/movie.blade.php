<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Movies Dashboard &mdash; Stisla</title>

    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sidebar-fix.css') }}">

</head>

<body>
    @include('layout.header')
    @include('layout.sidebar')

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('messages.search_movies_title') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a
                            href="{{ url('dashboard') }}">{{ __('messages.dashboard') }}</a></div>
                    <div class="breadcrumb-item">{{ __('messages.all_movies') }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ __('messages.movie_list') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET" action="" id="search-form">
                                        <div class="input-group">
                                            <input type="text" name="q" id="search-input" class="form-control"
                                                placeholder="{{ __('messages.search_placeholder') }}"
                                                value="{{ request('q') }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table table-striped" id="movie-table">
                                        <thead>
                                            <tr>
                                                <th>{{ __('messages.poster') }}</th>
                                                <th>{{ __('messages.title') }}</th>
                                                <th>{{ __('messages.year') }}</th>
                                                <th>{{ __('messages.type') }}</th>
                                                <th>{{ __('messages.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="movie-container">
                                            <tr id="empty-row">
                                                <td colspan="5" class="text-center py-5">
                                                    <i class="fas fa-search fa-3x text-muted mb-3 d-block"></i>
                                                    <span
                                                        class="text-muted">{{ __('messages.search_instruction') }}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div id="loader" class="text-center py-3" style="display: none;">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">{{ __('messages.loading') }}</span>
                                    </div>
                                    <p class="text-muted mt-2">{{ __('messages.loading') }}</p>
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
            movieNotFound: "{{ Lang::has('messages.movie_not_found') ? __('messages.movie_not_found') : 'Movie not found' }}",
            apiError: "{{ Lang::has('messages.api_error') ? __('messages.api_error') : 'API Error' }}",
            errorSearchFilm: "{{ Lang::has('messages.error_search_film') ? __('messages.error_search_film') : 'Error searching' }}",
            genre: "{{ Lang::has('messages.genre') ? __('messages.genre') : 'Genre' }}",
            director: "{{ Lang::has('messages.director') ? __('messages.director') : 'Director' }}",
            actors: "{{ Lang::has('messages.actors') ? __('messages.actors') : 'Actors' }}",
            rating: "{{ Lang::has('messages.rating') ? __('messages.rating') : 'Rating' }}",
            plot: "{{ Lang::has('messages.plot') ? __('messages.plot') : 'Plot' }}",
            detailNotFound: "{{ Lang::has('messages.detail_not_found') ? __('messages.detail_not_found') : 'Movie detail not found.' }}",
            detailError: "{{ Lang::has('messages.detail_error') ? __('messages.detail_error') : 'Error fetching details.' }}"
        };

        $(document).ready(function() {
            // Fungsi untuk memeriksa database dan menyesuaikan warna tombol love
            function syncFavorites() {
                $.ajax({
                    url: "{{ route('favorite.list') }}",
                    type: "GET",
                    success: function(response) {
                        if (response.favorites) {
                            let favIds = response.favorites.map(f => f.imdb_id);

                            $('.add-favorite').each(function() {
                                let id = $(this).data('id');
                                if (favIds.includes(id)) {
                                    $(this).removeClass('btn-danger').addClass('btn-success');
                                } else {
                                    $(this).removeClass('btn-success').addClass('btn-danger');
                                }
                            });

                            if ($('#search-input').val().trim() !== '') {
                                sessionStorage.setItem('movieSearchResults', $('#movie-container')
                                    .html());
                            }
                        }
                    }
                });
            }

            // Memeriksa histori pencarian sebelumnya saat halaman dimuat
            let savedQuery = sessionStorage.getItem('movieSearchQuery');
            let savedResults = sessionStorage.getItem('movieSearchResults');

            if (savedQuery && savedResults) {
                $('#search-input').val(savedQuery);
                $('#movie-container').html(savedResults);
                syncFavorites();
            }

            // Pencarian Film
            $('#search-form').on('submit', function(e) {
                e.preventDefault();
                let query = $('#search-input').val().trim();

                if (query === '') {
                    let emptyRowHtml = `
                        <tr id="empty-row">
                            <td colspan="5" class="text-center py-5">
                                <i class="fas fa-search fa-3x text-muted mb-3 d-block"></i>
                                <span class="text-muted">{{ __('messages.search_instruction') }}</span>
                            </td>
                        </tr>
                    `;
                    $('#movie-container').html(emptyRowHtml);

                    sessionStorage.removeItem('movieSearchQuery');
                    sessionStorage.removeItem('movieSearchResults');
                    return;
                }

                $('#loader').show();
                $('#movie-container').empty();

                $.ajax({
                    url: "{{ route('panel.movies') }}",
                    type: "GET",
                    data: {
                        q: query
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#loader').hide();

                        // Teks error ketika tidak ada film yang di temukan
                        if (response.error) {
                            let errorHtml =
                                `<tr><td colspan="5" class="text-center text-danger py-4">${appLocales.movieNotFound}</td></tr>`;
                            $('#movie-container').html(errorHtml);

                            sessionStorage.setItem('movieSearchQuery', query);
                            sessionStorage.setItem('movieSearchResults', errorHtml);
                            return;
                        }

                        if (response.movies && response.movies.length > 0) {
                            let rows = '';
                            response.movies.forEach(function(movie) {
                                let poster = movie.Poster !== 'N/A' ? movie.Poster :
                                    'https://via.placeholder.com/50x75?text=No+Image';

                                rows += `
                                <tr>
                                    <td><img src="${poster}" alt="${movie.Title}" width="50" class="img-thumbnail shadow-sm"></td>
                                    <td class="align-middle font-weight-bold">${movie.Title}</td>
                                    <td class="align-middle">${movie.Year}</td>
                                    <td class="align-middle"><span class="badge badge-primary text-capitalize">${movie.Type}</span></td>
                                    <td class="align-middle text-nowrap">
                                        <button class="btn btn-sm btn-info movie-detail" data-id="${movie.imdbID}" title="Detail">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger add-favorite" data-id="${movie.imdbID}" title="Favorite">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                            });
                            $('#movie-container').html(rows);

                            sessionStorage.setItem('movieSearchQuery', query);
                            sessionStorage.setItem('movieSearchResults', rows);

                            syncFavorites();
                        } else {
                            // Mengubah text-muted menjadi text-danger agar berwarna merah
                            let notFoundHtml =
                                `<tr><td colspan="5" class="text-center text-danger py-4">${appLocales.movieNotFound}</td></tr>`;
                            $('#movie-container').html(notFoundHtml);

                            sessionStorage.setItem('movieSearchQuery', query);
                            sessionStorage.setItem('movieSearchResults', notFoundHtml);
                        }
                    },
                    error: function(xhr) {
                        $('#loader').hide();
                        let apiErrorHtml =
                            `<tr><td colspan="5" class="text-center text-danger py-4">${appLocales.apiError}</td></tr>`;
                        $('#movie-container').html(apiErrorHtml);
                    }
                });
            });

            // Toggle Favorite
            $(document).on('click', '.add-favorite', function(e) {
                e.preventDefault();
                let btn = $(this);
                let imdbId = btn.data('id');
                let row = btn.closest('tr');

                $.ajax({
                    url: "{{ route('favorite.toggle') }}",
                    type: "POST",
                    data: {
                        imdb_id: imdbId,
                        title: row.find('td:nth-child(2)').text().trim(),
                        year: row.find('td:nth-child(3)').text().trim(),
                        poster: row.find('img').attr('src'),
                        type: row.find('.badge').text().trim(),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.isFavorite) {
                            btn.removeClass('btn-danger').addClass('btn-success');
                            alert(response.message);
                        } else {
                            btn.removeClass('btn-success').addClass('btn-danger');
                            alert(response.message);
                        }

                        if ($('#search-input').val().trim() !== '') {
                            sessionStorage.setItem('movieSearchResults', $('#movie-container')
                                .html());
                        }
                    },
                    error: function(xhr) {
                        alert(appLocales.errorSearchFilm);
                    }
                });
            });

            // Tampilkan Detail Modal
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
