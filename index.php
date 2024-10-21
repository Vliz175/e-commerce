<?php
require "koneksi.php";
// require "api/api.php";
session_start();


function admin()
{
    if (isset($_COOKIE["id"])) {
        $id = $_COOKIE["id"];
        echo "?id=$id";
    } else {
        return false;
    }
}

// query semua produk
$query1 = "SELECT * FROM `produk` WHERE tipe='makanan & minuman' ORDER BY RAND() LIMIT 8";
$query2 = "SELECT * FROM `produk` WHERE tipe='kesehatan & kecantikan' ORDER BY RAND() LIMIT 8";
$query3 = "SELECT * FROM `produk` WHERE tipe='fashion & aksesoris' ORDER BY RAND() LIMIT 8";
$query4 = "SELECT * FROM `produk` WHERE tipe='buku & barang sekolah' ORDER BY RAND() LIMIT 8";
$query5 = "SELECT * FROM `produk` WHERE tipe='perabotan rumah tangga' ORDER BY RAND() LIMIT 8";
$query6 = "SELECT * FROM `produk` WHERE tipe='olahraga' ORDER BY RAND() LIMIT 8";
$query7 = "SELECT * FROM `produk` WHERE tipe='hobi & koleksi' ORDER BY RAND() LIMIT 8";
$query8 = "SELECT * FROM `produk` WHERE tipe='Kendaraan & Aksesoris' ORDER BY RAND() LIMIT 8";

$makananDanMinuman = mysqli_query($conn, $query1);
$kesehatanDanKecantikan = mysqli_query($conn, $query2);
$fashionDanAksesoris = mysqli_query($conn, $query3);
$bukuDanBarangSekolah = mysqli_query($conn, $query4);
$perabotanRumahTangga = mysqli_query($conn, $query5);
$olahraga = mysqli_query($conn, $query6);
$hobiDanKoleksi = mysqli_query($conn, $query7);
$kendaraanDanAksesoris = mysqli_query($conn, $query8);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/card_content.css">
    <link rel="stylesheet" href="css/index.css">
    <title>Market Day</title>
</head>

<body>
    <!-- Start Navbar area -->
    <nav class="navbar navbar-expand-lg bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand text-dark" href="#">Market <span>Day</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Beranda</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Kategori
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="public/kategori.php?kategori=<?= urlencode("Makanan & Minuman") ?>">Makanan & Minuman</a></li>
                            <li><a class="dropdown-item" href="public/kategori.php?kategori=<?= urlencode("Kesehatan & Kecantikan") ?>">Kesehatan & Kecantikan</a></li>
                            <li><a class="dropdown-item" href="public/kategori.php?kategori=<?= urlencode("Fashion & Aksesoris") ?>">Fashion & Aksesoris</a></li>
                            <li><a class="dropdown-item" href="public/kategori.php?kategori=<?= urlencode("Buku & Barang Sekolah") ?>">Buku & Barang Sekolah</a></li>
                            <li><a class="dropdown-item" href="public/kategori.php?kategori=<?= urlencode("Perabotan Rumah Tangga") ?>">Perabotan Rumah Tangga</a></li>
                            <li><a class="dropdown-item" href="public/kategori.php?kategori=<?= urlencode("Olahraga") ?>">Olahraga</a></li>
                            <li><a class="dropdown-item" href="public/kategori.php?kategori=<?= urlencode("Hobi & Koleksi") ?>">Hobi & Koleksi</a></li>
                            <li><a class="dropdown-item" href="public/kategori.php?kategori=<?= urlencode("Kendaraan & Aksesoris") ?>">Kendaraan & Aksesoris</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="public/admin.php<?php admin() ?>">Akun</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar Area -->

    <!-- Start Main Area -->
    <div class="container mt-5">
        <!-- Start search Area -->
        <!-- onsubmit="return submitform(); -->
        <form class="d-flex" role="search" action="php/redirect.php" method="post">
            <input class=" form-control me-2 keyword" name="keyword" id="search-box" type="search" placeholder="Cari produk" aria-label="Search" autocomplete="off">
            <button class="btn btn-outline-success" name="search" type="submit">Search</button>
        </form>
        <!-- End Search Area -->
        <hr>
        <!-- Start Content Area -->
        <div class="card-content layout" id="card-content">
            <div class="card-makanan mb-3">
                <a href="public/kategori.php?kategori=<?= urlencode("Makanan & Minuman") ?>" class="judul">Makanan & Minuman <i class="fa-solid fa-chevron-right"></i></a>
                <div class="slider mt-2 d-flex">
                    <?php if (mysqli_num_rows($makananDanMinuman) > 0) : ?>
                        <?php while ($row = mysqli_fetch_assoc($makananDanMinuman)) : ?>

                            <?php
                            // query nama penjual untuk ditampilkan di card
                            $idAkun = $row['id_akun'];
                            $queryAkun = "SELECT * FROM akun WHERE id='$idAkun'";
                            $x = mysqli_query($conn, $queryAkun);
                            $akun = mysqli_fetch_assoc($x);
                            ?>

                            <div class="col-lg-2 col-sm-4 col-6">
                                <div class="card " style=" margin-right: 20px">
                                    <img src="db/img/<?= $row["gambar"] ?>" class="card-img-top img-fluid" loading="lazy" alt="<?= $row['nama'] ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= ucfirst($row['nama']) ?></h5>
                                        <p class="card-text">Rp <?= number_format($row['harga'], 0, ',') ?></p>
                                        <p class="card-penjual"><i class="fa-solid fa-shop"></i> <?= $akun['username'] ?></p>
                                        <a href="public/overview.php?id=<?= $row['id'] ?>" class="btn btn-warning">Beli</a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <div class="alert alert-light" role="alert">
                            Barang tidak tersedia
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card-minuman mb-3">
                <a href="public/kategori.php?kategori=<?= urlencode("Kesehatan & Kecantikan") ?>" class="judul">Kesehatan & Kecantikan <i class="fa-solid fa-chevron-right"></i></a>
                <div class=" slider mt-2 d-flex">
                    <?php if (mysqli_num_rows($kesehatanDanKecantikan) > 0) : ?>
                        <?php while ($row = mysqli_fetch_assoc($kesehatanDanKecantikan)) : ?>

                            <?php
                            // query nama penjual untuk ditampilkan di card
                            $idAkun = $row['id_akun'];
                            $queryAkun = "SELECT * FROM akun WHERE id='$idAkun'";
                            $x = mysqli_query($conn, $queryAkun);
                            $akun = mysqli_fetch_assoc($x);
                            ?>

                            <div class="col-lg-2 col-sm-4 col-6">
                                <div class="card" style=" margin-right: 20px">
                                    <img src="db/img/<?= $row["gambar"] ?>" class="card-img-top img-fluid" loading="lazy" alt="<?= $row['nama'] ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= ucfirst($row['nama']) ?></h5>
                                        <p class="card-text">Rp <?= number_format($row['harga'], 0, ',') ?></p>
                                        <p class="card-penjual"><i class="fa-solid fa-shop"></i> <?= $akun['username'] ?></p>
                                        <a href="public/overview.php?id=<?= $row['id'] ?>" class="btn btn-warning">Beli</a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <div class="alert alert-light" role="alert">
                            Barang tidak tersedia
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card-lainnya mb-3">
                <a href="public/kategori.php?kategori=<?= urlencode("Fashion & Aksesoris") ?>" class="judul">Fashion & Aksesoris <i class="fa-solid fa-chevron-right"></i></a>
                <div class="slider mt-2 d-flex">
                    <?php if (mysqli_num_rows($fashionDanAksesoris) > 0) : ?>
                        <?php while ($row = mysqli_fetch_assoc($fashionDanAksesoris)) : ?>

                            <?php
                            // query nama penjual untuk ditampilkan di card
                            $idAkun = $row['id_akun'];
                            $queryAkun = "SELECT * FROM akun WHERE id='$idAkun'";
                            $x = mysqli_query($conn, $queryAkun);
                            $akun = mysqli_fetch_assoc($x);
                            ?>

                            <div class="col-lg-2 col-sm-4 col-6">
                                <div class="card" style=" margin-right: 20px">
                                    <img src="db/img/<?= $row["gambar"] ?>" class="card-img-top img-fluid" loading="lazy" alt="<?= $row['nama'] ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= ucfirst($row['nama']) ?></h5>
                                        <p class="card-text">Rp <?= number_format($row['harga'], 0, ',') ?></p>
                                        <p class="card-penjual"><i class="fa-solid fa-shop"></i> <?= $akun['username'] ?></p>
                                        <a href="public/overview.php?id=<?= $row['id'] ?>" class="btn btn-warning">Beli</a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <div class="alert alert-light" role="alert">
                            Barang tidak tersedia
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card-lainnya mb-3">
                <a href="public/kategori.php?kategori=<?= urlencode("Buku & Barang Sekolah") ?>" class="judul">Buku & Barang Sekolah <i class="fa-solid fa-chevron-right"></i></a>
                <div class="slider mt-2 d-flex">
                    <?php if (mysqli_num_rows($bukuDanBarangSekolah) > 0) : ?>
                        <?php while ($row = mysqli_fetch_assoc($bukuDanBarangSekolah)) : ?>

                            <?php
                            // query nama penjual untuk ditampilkan di card
                            $idAkun = $row['id_akun'];
                            $queryAkun = "SELECT * FROM akun WHERE id='$idAkun'";
                            $x = mysqli_query($conn, $queryAkun);
                            $akun = mysqli_fetch_assoc($x);
                            ?>

                            <div class="col-lg-2 col-sm-4 col-6">
                                <div class="card" style=" margin-right: 20px">
                                    <img src="db/img/<?= $row["gambar"] ?>" class="card-img-top img-fluid" loading="lazy" alt="<?= $row['nama'] ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= ucfirst($row['nama']) ?></h5>
                                        <p class="card-text">Rp <?= number_format($row['harga'], 0, ',') ?></p>
                                        <p class="card-penjual"><i class="fa-solid fa-shop"></i> <?= $akun['username'] ?></p>
                                        <a href="public/overview.php?id=<?= $row['id'] ?>" class="btn btn-warning">Beli</a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <div class="alert alert-light" role="alert">
                            Barang tidak tersedia
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card-lainnya mb-3">
                <a href="public/kategori.php?kategori=<?= urlencode("Perabotan Rumah Tangga") ?>" class="judul">Perabotan Rumah Tangga <i class="fa-solid fa-chevron-right"></i></a>
                <div class="slider mt-2 d-flex">
                    <?php if (mysqli_num_rows($perabotanRumahTangga) > 0) : ?>
                        <?php while ($row = mysqli_fetch_assoc($perabotanRumahTangga)) : ?>

                            <?php
                            // query nama penjual untuk ditampilkan di card
                            $idAkun = $row['id_akun'];
                            $queryAkun = "SELECT * FROM akun WHERE id='$idAkun'";
                            $x = mysqli_query($conn, $queryAkun);
                            $akun = mysqli_fetch_assoc($x);
                            ?>

                            <div class="col-lg-2 col-sm-4 col-6">
                                <div class="card" style=" margin-right: 20px">
                                    <img src="db/img/<?= $row["gambar"] ?>" class="card-img-top img-fluid" loading="lazy" alt="<?= $row['nama'] ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= ucfirst($row['nama']) ?></h5>
                                        <p class="card-text">Rp <?= number_format($row['harga'], 0, ',') ?></p>
                                        <p class="card-penjual"><i class="fa-solid fa-shop"></i> <?= $akun['username'] ?></p>
                                        <a href="public/overview.php?id=<?= $row['id'] ?>" class="btn btn-warning">Beli</a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <div class="alert alert-light" role="alert">
                            Barang tidak tersedia
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card-lainnya mb-3">
                <a href="public/kategori.php?kategori=<?= urlencode("Olahraga") ?>" class="judul">Olahraga <i class="fa-solid fa-chevron-right"></i></a>
                <div class="slider mt-2 d-flex">
                    <?php if (mysqli_num_rows($olahraga) > 0) : ?>
                        <?php while ($row = mysqli_fetch_assoc($olahraga)) : ?>

                            <?php
                            // query nama penjual untuk ditampilkan di card
                            $idAkun = $row['id_akun'];
                            $queryAkun = "SELECT * FROM akun WHERE id='$idAkun'";
                            $x = mysqli_query($conn, $queryAkun);
                            $akun = mysqli_fetch_assoc($x);
                            ?>

                            <div class="col-lg-2 col-sm-4 col-6">
                                <div class="card" style=" margin-right: 20px">
                                    <img src="db/img/<?= $row["gambar"] ?>" class="card-img-top img-fluid" loading="lazy" alt="<?= $row['nama'] ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= ucfirst($row['nama']) ?></h5>
                                        <p class="card-text">Rp <?= number_format($row['harga'], 0, ',') ?></p>
                                        <p class="card-penjual"><i class="fa-solid fa-shop"></i> <?= $akun['username'] ?></p>
                                        <a href="public/overview.php?id=<?= $row['id'] ?>" class="btn btn-warning">Beli</a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <div class="alert alert-light" role="alert">
                            Barang tidak tersedia
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card-lainnya mb-3">
                <a href="public/kategori.php?kategori=<?= urlencode("Hobi & Koleksi") ?>" class="judul">Hobi & Koleksi <i class="fa-solid fa-chevron-right"></i></a>
                <div class="slider mt-2 d-flex">
                    <?php if (mysqli_num_rows($hobiDanKoleksi) > 0) : ?>
                        <?php while ($row = mysqli_fetch_assoc($hobiDanKoleksi)) : ?>

                            <?php
                            // query nama penjual untuk ditampilkan di card
                            $idAkun = $row['id_akun'];
                            $queryAkun = "SELECT * FROM akun WHERE id='$idAkun'";
                            $x = mysqli_query($conn, $queryAkun);
                            $akun = mysqli_fetch_assoc($x);
                            ?>

                            <div class="col-lg-2 col-sm-4 col-6">
                                <div class="card" style=" margin-right: 20px">
                                    <img src="db/img/<?= $row["gambar"] ?>" class="card-img-top img-fluid" loading="lazy" alt="<?= $row['nama'] ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= ucfirst($row['nama']) ?></h5>
                                        <p class="card-text">Rp <?= number_format($row['harga'], 0, ',') ?></p>
                                        <p class="card-penjual"><i class="fa-solid fa-shop"></i> <?= $akun['username'] ?></p>
                                        <a href="public/overview.php?id=<?= $row['id'] ?>" class="btn btn-warning">Beli</a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <div class="alert alert-light" role="alert">
                            Barang tidak tersedia
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card-lainnya mb-5">
                <a href="public/kategori.php?kategori=<?= urlencode("Kendaraan & Aksesoris") ?>" class="judul">Kendaraan & Aksesoris <i class="fa-solid fa-chevron-right"></i></a>
                <div class="slider mt-2 d-flex">
                    <?php if (mysqli_num_rows($kendaraanDanAksesoris) > 0) : ?>
                        <?php while ($row = mysqli_fetch_assoc($kendaraanDanAksesoris)) : ?>

                            <?php
                            // query nama penjual untuk ditampilkan di card
                            $idAkun = $row['id_akun'];
                            $queryAkun = "SELECT * FROM akun WHERE id='$idAkun'";
                            $x = mysqli_query($conn, $queryAkun);
                            $akun = mysqli_fetch_assoc($x);
                            ?>

                            <div class="col-lg-2 col-sm-4 col-6">
                                <div class="card" style=" margin-right: 20px">
                                    <img src="db/img/<?= $row["gambar"] ?>" class="card-img-top img-fluid" loading="lazy" alt="<?= $row['nama'] ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= ucfirst($row['nama']) ?></h5>
                                        <p class="card-text">Rp <?= number_format($row['harga'], 0, ',') ?></p>
                                        <p class="card-penjual"><i class="fa-solid fa-shop"></i> <?= $akun['username'] ?></p>
                                        <a href="public/overview.php?id=<?= $row['id'] ?>" class="btn btn-warning">Beli</a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <div class="alert alert-light" role="alert">
                            Barang tidak tersedia
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- End Content Area -->
    <!-- End Main Area -->


    <!-- Script area -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/4775c75ff6.js" crossorigin="anonymous"></script>
    <!-- <script src="js/jquery-3.7.1.min.js"></script> -->
    <!-- <script src="js/script.js"></script> -->
    <script>
        function submitform() {
            let key = document.getElementById('search-box').value;

            if (key.trim() === "") {
                alert("silahkan masukan data pencarian");
                return false;
            } else {
                window.location.href = "public/hasil_pencarian.php?q=" + encodeURIComponent(key);
                return true;
            }
        }
    </script>
</body>

</html>