<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Movies Dashboard &mdash; Stisla</title>

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

    @include('layout.footer')

    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>

    <script>
        // Localization untuk JavaScript
        const appLocales = {
            movieNotFound: "{{ __('messages.movie_not_found') }}",
            apiError: "{{ __('messages.api_error') }}",
            confirmDeleteFavorite: "{{ __('messages.confirm_delete_favorite') }}",
            errorDeleteFavorite: "{{ __('messages.error_delete_favorite') }}",
            errorSearchFilm: "{{ __('messages.error_search_film') }}"
        };

        $(document).ready(function() {
            // Fungsi untuk toggle favorit
            $(document).on('click', '.add-favorite', function(e) {
                e.preventDefault();

                let btn = $(this);
                let imdbId = btn.data('id');
                let title = btn.closest('tr').find('td:nth-child(2)').text().trim();
                let year = btn.closest('tr').find('td:nth-child(3)').text().trim();
                let poster = btn.closest('tr').find('img').attr('src');
                let type = btn.closest('tr').find('.badge').text().trim();

                $.ajax({
                    url: "{{ route('favorite.toggle') }}",
                    type: "POST",
                    data: {
                        imdb_id: imdbId,
                        title: title,
                        year: year,
                        poster: poster,
                        type: type,
                        _token: "{{ csrf_token() }}"
                    },
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        if (response.isFavorite) {
                            btn.removeClass('btn-danger').addClass('btn-success');
                            btn.html('<i class="fas fa-heart"></i>');
                            showNotification('success', response.message);
                        } else {
                            btn.removeClass('btn-success').addClass('btn-danger');
                            btn.html('<i class="fas fa-heart"></i>');
                            showNotification('warning', response.message);
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        showNotification('error', appLocales.errorSearchFilm);
                    }
                });
            });

            // Fungsi untuk menghapus favorit dari halaman favorit
            $(document).on('click', '.remove-favorite', function(e) {
                e.preventDefault();

                let btn = $(this);
                let imdbId = btn.data('id');
                let row = btn.closest('tr');

                $.ajax({
                    url: "{{ route('favorite.toggle') }}",
                    type: "POST",
                    data: {
                        imdb_id: imdbId,
                        _token: "{{ csrf_token() }}"
                    },
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        row.fadeOut(300, function() {
                            $(this).remove();

                            // Jika tidak ada favorit, tampilkan pesan kosong
                            let table = $('table tbody');
                            if (table.find('tr').length === 0) {
                                location.reload();
                            }
                        });
                        showNotification('info', response.message);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        showNotification('error', 'Terjadi kesalahan saat menghapus favorit');
                    }
                });
            });

            // Fungsi helper untuk notification
            function showNotification(type, message) {
                // Anda bisa menggunakan Toast library atau alert sederhana
                alert(message);
            }

            $('#search-form').on('submit', function(e) {
                e.preventDefault(); // Mencegah halaman reload/refresh agar AJAX berjalan

                let query = $('#search-input').val().trim();

                // Jika input pencarian kosong, jangan lakukan request
                if (query === '') {
                    $('#movie-container').html(`
                    <tr id=\"empty-row\">
                        <td colspan=\"5\" class=\"text-center py-5\">
                            <i class=\"fas fa-search fa-3x text-muted mb-3 d-block\"></i>
                            <span class=\"text-muted\">{{ __('messages.search_instruction') }}</span>
                        </td>
                    </tr>
                `);
                    return;
                }

                // Tampilkan animasi loader dan kosongkan kontainer tabel
                $('#loader').show();
                $('#movie-container').empty();

                $.ajax({
                    url: "{{ route('panel.movies') }}", // Mengarah ke rute /controll-panel/movies Anda
                    type: "GET",
                    data: {
                        q: query
                    },
                    dataType: "json",
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest' // Wajib agar Controller mengenali ini sebagai request AJAX
                    },
                    success: function(response) {
                        $('#loader').hide();

                        // Jika ada error response dari OMDB API (misal key salah atau film tidak ditemukan)
                        if (response.error) {
                            $('#movie-container').html(`
                            <tr>
                                <td colspan="5" class="text-center text-danger py-4">
                                    <i class="fas fa-exclamation-triangle mr-2"></i> ${response.error}
                                </td>
                            </tr>
                        `);
                            return;
                        }

                        // Jika film berhasil ditemukan dan datanya ada
                        if (response.movies && response.movies.length > 0) {
                            let rows = '';
                            response.movies.forEach(function(movie) {
                                // Cek jika film tidak memiliki poster resmi dari OMDB
                                let poster = movie.Poster !== 'N/A' ? movie.Poster :
                                    'https://via.placeholder.com/50x75?text=No+Image';

                                rows += `
                                <tr>
                                    <td><img src="${poster}" alt="${movie.Title}" width="50" class="img-thumbnail shadow-sm"></td>
                                    <td class="align-middle font-weight-bold">${movie.Title}</td>
                                    <td class="align-middle">${movie.Year}</td>
                                    <td class="align-middle"><span class="badge badge-primary text-capitalize">${movie.Type}</span></td>
                                    <td class="align-middle">
                                        <button class="btn btn-sm btn-danger add-favorite" data-id="${movie.imdbID}">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                            });
                            $('#movie-container').html(
                                rows);
                        } else {
                            $('#movie-container').html(`
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">${appLocales.movieNotFound}</td>
                            </tr>
                        `);
                        }
                    },
                    error: function(xhr) {
                        $('#loader').hide();
                        $('#movie-container').html(`
                        <tr>
                            <td colspan="5" class="text-center text-danger py-4">
                                <i class="fas fa-times-circle mr-2"></i> ${appLocales.apiError}
                            </td>
                        </tr>
                    `);
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>

</html>
