<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SD Negeri Jomblang 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://via.placeholder.com/1500x500');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        .section-padding {
            padding: 60px 0;
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .testimonial-card {
            border-left: 4px solid #0d6efd;
            padding-left: 20px;
        }
        .navbar-brand img {
            height: 50px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SD Negeri Jomblang 2">
                SD Negeri Jomblang 2
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/profile">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/gallery">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/kontak">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section mt-5">
        <div class="container">
            <h1 class="display-4 fw-bold">Selamat Datang di SD Negeri Jomblang 2</h1>
            <p class="lead">Mewujudkan Generasi Cerdas, Berkarakter, dan Berakhlak Mulia</p>
        </div>
    </section>

    <!-- Berita Section -->
    <section class="section-padding">
        <div class="container">
            <h2 class="text-center mb-5">Berita Terbaru</h2>
            <div class="row">
                @foreach($beritas as $berita)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset('uploads/berita/' . $berita->gambar) }}" class="card-img-top" alt="{{ $berita->judul }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $berita->judul }}</h5>
                            <p class="card-text">{{ Str::limit(strip_tags($berita->isi), 100) }}</p>
                            <a href="#" class="btn btn-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Pengumuman Section -->
    <section class="section-padding bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Pengumuman</h2>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="list-group">
                        @foreach($pengumumans as $pengumuman)
                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{ $pengumuman->judul }}</h5>
                                <small>{{ $pengumuman->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">{{ Str::limit(strip_tags($pengumuman->isi), 150) }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistik Section -->
    <section class="section-padding">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h3>{{ $jumlahSiswa }}</h3>
                            <p>Jumlah Siswa</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h3>{{ $jumlahGuru }}</h3>
                            <p>Jumlah Guru</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h3>15</h3>
                            <p>Fasilitas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Guru Section -->
    <section class="section-padding bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Guru & Staff</h2>
            <div class="row">
                @foreach($gurus as $guru)
                <div class="col-md-3 mb-4">
                    <div class="card text-center">
                        <img src="{{ asset('uploads/guru/' . $guru->foto) }}" class="card-img-top rounded-circle mx-auto mt-3" style="width: 100px; height: 100px; object-fit: cover;" alt="{{ $guru->nama }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $guru->nama }}</h5>
                            <p class="card-text">{{ $guru->jabatan }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Fasilitas Section -->
    <section class="section-padding">
        <div class="container">
            <h2 class="text-center mb-5">Fasilitas Sekolah</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-book fa-3x mb-3 text-primary"></i>
                            <h5>Perpustakaan</h5>
                            <p>Perpustakaan dengan koleksi buku yang lengkap</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-laptop fa-3x mb-3 text-primary"></i>
                            <h5>Lab Komputer</h5>
                            <p>Laboratorium komputer dengan perangkat terbaru</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-futbol fa-3x mb-3 text-primary"></i>
                            <h5>Lapangan Olahraga</h5>
                            <p>Lapangan olahraga yang luas dan nyaman</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimoni Section -->
    <section class="section-padding bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Testimoni</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="testimonial-card">
                        <p>"Sekolah yang sangat nyaman untuk belajar. Guru-gurunya ramah dan profesional."</p>
                        <strong>- Orang Tua Siswa</strong>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="testimonial-card">
                        <p>"Fasilitas lengkap dan proses belajar mengajar yang menyenangkan."</p>
                        <strong>- Alumni</strong>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="testimonial-card">
                        <p>"Anak saya sangat senang bersekolah di sini. Prestasinya meningkat signifikan."</p>
                        <strong>- Wali Murid</strong>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Preview -->
    <section class="section-padding">
        <div class="container">
            <h2 class="text-center mb-5">Galeri Foto</h2>
            <div class="row">
                @foreach($galleries as $gallery)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('uploads/gallery/' . $gallery->gambar) }}" class="card-img-top" alt="{{ $gallery->judul }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $gallery->judul }}</h5>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="/gallery" class="btn btn-primary">Lihat Semua Foto</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>SD Negeri Jomblang 2</h5>
                    <p>Mewujudkan Generasi Cerdas, Berkarakter, dan Berakhlak Mulia</p>
                </div>
                <div class="col-md-4">
                    <h5>Kontak</h5>
                    <p><i class="fas fa-map-marker-alt"></i> Jl. Jomblang No. 123, Yogyakarta</p>
                    <p><i class="fas fa-phone"></i> (0274) 123456</p>
                    <p><i class="fas fa-envelope"></i> info@sdjomblang2.sch.id</p>
                </div>
                <div class="col-md-4">
                    <h5>Link Terkait</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Dinas Pendidikan</a></li>
                        <li><a href="#" class="text-white">Kemdikbud</a></li>
                        <li><a href="#" class="text-white">Portal Guru</a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p>&copy; 2023 SD Negeri Jomblang 2. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
