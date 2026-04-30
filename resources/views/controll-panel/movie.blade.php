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
                <h1>{{ app()->getLocale() == 'id' ? 'Cari Film' : 'Search Movies' }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ url('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">{{ app()->getLocale() == 'id' ? 'Semua Film' : 'All Movies' }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ app()->getLocale() == 'id' ? 'Daftar Film' : 'Movie List' }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET" action="" id="search-form">
                                        <div class="input-group">
                                            <input type="text" name="q" id="search-input" class="form-control"
                                                placeholder="{{ app()->getLocale() == 'id' ? 'Cari judul film...' : 'Search movies...' }}"
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
                                                <th>Poster</th>
                                                <th>{{ app()->getLocale() == 'id' ? 'Judul' : 'Title' }}</th>
                                                <th>{{ app()->getLocale() == 'id' ? 'Tahun' : 'Year' }}</th>
                                                <th>{{ app()->getLocale() == 'id' ? 'Tipe' : 'Type' }}</th>
                                                <th>{{ app()->getLocale() == 'id' ? 'Aksi' : 'Action' }}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="movie-container">
                                            {{-- Tampilan saat tabel kosong[cite: 2] --}}
                                            <tr id="empty-row">
                                                <td colspan="5" class="text-center py-5">
                                                    <i class="fas fa-search fa-3x text-muted mb-3 d-block"></i>
                                                    <span
                                                        class="text-muted">{{ app()->getLocale() == 'id' ? 'Masukkan kata kunci untuk mencari film.' : 'Enter a keyword to search movies.' }}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Loader saat proses API[cite: 2] --}}
                                <div id="loader" class="text-center py-3" style="display: none;">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <p class="text-muted mt-2">Loading...</p>
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
