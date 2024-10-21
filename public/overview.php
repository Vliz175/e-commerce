<?php
require "../koneksi.php";
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

//* Cek jika belum login akun maka ga bisa bauar
$cookieLogin = false;
if (isset($_COOKIE['login'])) {
    $cookieLogin = $_COOKIE['login'];
}
if (!$cookieLogin == true) {
    echo "<script>
        alert('Silahkan login terlebih dahulu');
        document.location.href = 'login.php';
    </script>";
    exit();
}


//* mengambil id dari get
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
} else {
    echo "ID produk tidak valid.";
}

//* query data produk
$query_produk = "SELECT * FROM `produk` WHERE id = '$id'";
$result_produk = mysqli_query($conn, $query_produk);
$produk = mysqli_fetch_assoc($result_produk);

//* query data akun
$id_akun = $produk["id_akun"];
$query_akun = "SELECT * FROM `akun` WHERE id = '$id_akun'";
$result_akun = mysqli_query($conn, $query_akun);
$akun = mysqli_fetch_assoc($result_akun);

//* Pengiriman teks ke whatsapp
if (isset($_POST['pesan'])) {
    $jumlahProduk = $_POST['jumlah-produk'];
    $totalHarga = $produk['harga'] * $jumlahProduk;
    $penulisanHarga = 'Rp ' . number_format($totalHarga, 0, ',', '.');
    header("Location: https://wa.me/{$akun['nomor_hp']}?text=Halo%20saya%20ingin%20memesan%20produk%20anda%0AProduk%20:%20{$produk['nama']}%0AJumlah%20:%20{$jumlahProduk}%0AHarga%20:%20{$penulisanHarga}");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/overview.css">
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
                        <a class="nav-link" aria-current="page" href="../index.php">Beranda</a>
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

    <!-- Start Main Area -->
    <div class="container container-content mt-4">
        <a href="javascript:history.back()" class="mb-4"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
        <div class="img">
            <img src="../db/img/<?= $produk["gambar"] ?>" class="rounded img-fluid" alt="">
        </div>
        <div class="deskripsi">
            <div class="produk mt-4">
                <h1><?= ucfirst($produk["nama"]) ?></h1>
                <h4>Rp <?= number_format($produk['harga'], 0, ',') ?></h4>
                <form action="" method="post">
                    <div class="mb-3 wrapper-jumlah-produk">
                        <label for="jumlah-produk" class="form-label">Jumlah Produk</label>
                        <input type="number" value="1" class="form-control" name="jumlah-produk" id="jumlah-produk">
                        <input type="hidden" value="<?= $produk['harga'] ?>" name="harga-produk" id="harga-produk">
                        <input type="hidden" value="<?= $akun['id'] ?>" name="id-akun" id="id-akun">
                        <input type="hidden" value="<?= $produk['id'] ?>" name="id-produk" id="id-produk">
                        <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                    </div>

            </div>
            <hr>
            <div class="penjual">
                <div class="img">
                    <img src="../db/img_profile/<?= $akun['profil'] ?>" alt="">
                </div>
                <div class="identitas">
                    <h1><?= $akun["username"] ?></h1>
                    <h6 style="margin-top: -5px;">Penjual</h6>
                </div>
            </div>
            <hr>
            <div class="barang">
                <h2>Keterangan</h2>
                <p><?= $produk['deskripsi'] ?></p>
            </div>
        </div>
        <div class="customer-button">
            <!-- <a class="btn wa btn-lg text-white" style="background-color: #25D366;" href="https://wa.me/<?= $akun['nomor_hp'] ?>?text=<?= require 'text.php' ?>" role="button">Pesan</a> -->
            <input class="btn beli btn-success text-white btn-lg" type="submit" name="pesan" value="Pesan">
            <!-- <button type="button" class="btn btn-success text-white btn-lg beli" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Pesan
            </button> -->
        </div>
        </form>
    </div>
    <!-- End Main Area -->

    <!-- Start Modal Arae -->
    <!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Metode pembayaran</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                        <label class="form-check-label" for="flexRadioDefault1">
                            Cash on Delivery (COD)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                        <label class="form-check-label" for="flexRadioDefault2">
                            Pembayaran Online
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary">Oke</button>
                </div>
            </div>
        </div>
    </div> -->
    <!-- End Modal Area -->

    <!-- Script area -->
    <script src="../js/jquery-3.7.1.min.js"></script>
    <script src="../js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/4775c75ff6.js" crossorigin="anonymous"></script>
</body>

</html>