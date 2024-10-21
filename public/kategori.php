<?php
require "../koneksi.php";

function admin()
{
    if (isset($_COOKIE["id"])) {
        $id = $_COOKIE["id"];
        echo "?id=$id";
    } else {
        return false;
    }
}

//* logika pemilihan kategori

$kategori = $_GET['kategori'];
$query = "SELECT * FROM `produk` WHERE tipe='$kategori' ORDER BY RAND()";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/kategori.css">
    <link rel="stylesheet" href="../css/card_content.css">
    <title>Market Day</title>
</head>

<body>
    <!-- Start Navbar area -->
    <nav class="navbar navbar-expand-lg bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand text-dark" href="../index.php">Market <span>Day</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../index.php">Beranda</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Kategori
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="kategori.php?kategori=<?= urlencode("Makanan & Minuman") ?>">Makanan & Minuman</a></li>
                            <li><a class="dropdown-item" href="kategori.php?kategori=<?= urlencode("Kesehatan & Kecantikan") ?>">Kesehatan & Kecantikan</a></li>
                            <li><a class="dropdown-item" href="kategori.php?kategori=<?= urlencode("Fashion & Aksesoris") ?>">Fashion & Aksesoris</a></li>
                            <li><a class="dropdown-item" href="kategori.php?kategori=<?= urlencode("Buku & Barang Sekolah") ?>">Buku & Barang Sekolah</a></li>
                            <li><a class="dropdown-item" href="kategori.php?kategori=<?= urlencode("Perabotan Rumah Tangga") ?>">Perabotan Rumah Tangga</a></li>
                            <li><a class="dropdown-item" href="kategori.php?kategori=<?= urlencode("Olahraga") ?>">Olahraga</a></li>
                            <li><a class="dropdown-item" href="kategori.php?kategori=<?= urlencode("Hobi & Koleksi") ?>">Hobi & Koleksi</a></li>
                            <li><a class="dropdown-item" href="kategori.php?kategori=<?= urlencode("Kendaraan & Aksesoris") ?>">Kendaraan & Aksesoris</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php<?php admin() ?>">Akun</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar Area -->

    <!-- Start Card Content Area -->
    <div class="container">

        <h1 href="public/kategori.php" class="mb-3 mt-4 fs-3 judul">kategori: <?= ucfirst($kategori) ?></h1>
        <a class="kembali" href="../index.php"><i class="fa-solid fa-arrow-left mb-4"></i> Kembali</a>
        <div class="card-content d-flex flex-wrap">
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>

                <?php
                // query nama penjual untuk ditampilkan di card
                $idAkun = $row['id_akun'];
                $queryAkun = "SELECT * FROM akun WHERE id='$idAkun'";
                $x = mysqli_query($conn, $queryAkun);
                $akun = mysqli_fetch_assoc($x);
                ?>

                <div class="col-lg-2 col-sm-4 col-6 mb-2">
                    <div class="card" style=" margin-right: 20px">
                        <img src="../db/img/<?= $row["gambar"] ?>" class="card-img-top img-fluid" loading="lazy">
                        <div class="card-body">
                            <h5 class="card-title"><?= ucfirst($row['nama']) ?></h5>
                            <p class="card-text">Rp <?= number_format($row['harga'], 0, ',') ?></p>
                            <p class="card-penjual"><i class="fa-solid fa-shop"></i> <?= $akun['username'] ?></p>
                            <a href="overview.php?id=<?= $row['id'] ?>" class="btn btn-warning">Beli</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>

        </div>
    </div>
    <!-- End Card Content Area -->

    <!-- Script Area -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/4775c75ff6.js" crossorigin="anonymous"></script>
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