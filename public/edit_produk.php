<?php
require '../koneksi.php';

//* Pengambilan id
$id = $_GET['id'];
if ($id == false) {
    header('location: login.php');
} else {
    $query_id = "SELECT * FROM produk WHERE id = '$id'";
    $result = mysqli_query($conn, $query_id);
    $row = mysqli_fetch_assoc($result);
}

//* Function untuk pengambilan gambar
function upload()
{
    global $row;
    $namaFile = $_FILES['gambar_produk']['name'];
    $ukuranFile = $_FILES['gambar_produk']['size'];
    $error = $_FILES['gambar_produk']['error'];
    $tmpName = $_FILES['gambar_produk']['tmp_name'];

    if ($error === 4) {
        return $row['gambar'];
    }

    $formatGambarValid = ["jpg", "jpeg", "png"];
    $formatGambar = explode('.', $namaFile);
    $formatGambar = strtolower(end($formatGambar));
    if (!in_array($formatGambar, $formatGambarValid)) {
        echo "<script>
                alert('Tolong masukan gambar dengan format jpg, jpeg, png');
            </script>";
        return $row['gambar'];
    }

    if ($ukuranFile > 1024 * 1024 * 2) {
        echo "<script>
        alert(' Maksimal ukuran gambar 2 MB');
        </script>";
        return $row['gambar'];
    }

    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $formatGambar;

    move_uploaded_file($tmpName, '../db/img/' . $namaFileBaru);
    return $namaFileBaru;
}

function editProduk()
{
    global $conn;
    global $row;
    $id = $row['id'];
    $namaProduk = htmlspecialchars($_POST['nama_produk']);
    $hargaProduk = $_POST['harga_produk'];
    $deskripsiProduk = htmlspecialchars($_POST['deskripsi_produk']);
    $gambarProduk = upload();
    $gambarLama = $row['gambar'];
    $jenisProduk = $_POST['kategori-produk'];
    $pathGambar = "../db/img/$gambarLama";

    if ($gambarProduk != $gambarLama) {
        if (file_exists($pathGambar)) {
            if (unlink($pathGambar)) {
                echo 'Gambar berhasil dihapus.';
            } else {
                echo 'Gagal menghapus gambar.';
            }
        } else {
            echo 'File gambar tidak ditemukan.';
        }
    }

    if ($namaProduk == NULL) {
        $namaProduk = $row['nama'];
    }
    if ($hargaProduk == NULL) {
        $hargaProduk = $row['harga'];
    }
    if ($deskripsiProduk == NULL) {
        $deskripsiProduk = $row['deskripsi'];
    }
    if ($jenisProduk == "Pilih kategori") {
        $jenisProduk = $row['tipe'];
    }

    $query = "UPDATE produk SET nama='$namaProduk', harga='$hargaProduk',gambar='$gambarProduk',tipe='$jenisProduk',deskripsi='$deskripsiProduk' WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        return mysqli_affected_rows($conn);
    }
}
if (isset($_POST['edit_produk'])) {
    if (editProduk() > 0) {
        $idAkun = $row['id_akun'];
        echo "<script>
        alert('Produk berhasil di update');
        location.replace('admin.php?id=$idAkun');
        </script>";
    }
}
if (isset($_POST["hapus_produk"])) {
    $gambarLama = $row['gambar'];
    $pathGambar = "../db/img/$gambarLama";
    if (file_exists($pathGambar)) {
        if (unlink($pathGambar)) {
            echo 'Gambar berhasil dihapus.';
        } else {
            echo 'Gagal menghapus gambar.';
        }
    } else {
        echo 'File gambar tidak ditemukan.';
    }
    $hapus = "DELETE FROM `produk` WHERE id='$id'";
    mysqli_query($conn, $hapus);
    $idAkun = $row["id_akun"];
    header("location: admin.php?id=$idAkun");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/edit_produk.css">
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
                        <a class="nav-link active" href="admin.php?id=<?= $row['id_akun'] ?>">Akun</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar Area -->

    <!-- Start Form Edit Produk -->
    <div class="container col-10 col-md-6 mt-4 mb-5">
        <h1 class="text-center mb-5">Edit Produk</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" class="form-control" id="id_akun" name="id_akun" value="<?= $row['id'] ?>">
            <div class="mb-3">
                <label for="nama_produk" class="form-label">Nama produk</label>
                <input type="text" class="form-control" id="nama_produk" name="nama_produk" autocomplete="off" placeholder="<?= $row['nama'] ?>">
            </div>
            <div class="mb-3">
                <label for="harga_produk" class="form-label">Harga produk</label>
                <input type="text" class="form-control" id="harga_produk" name="harga_produk" autocomplete="off" placeholder="<?= $row['harga'] ?>">
            </div>
            <div class="mb-3">
                <label for="deskripsi_produk">Deskripsi produk</label>
                <textarea class="form-control" id="deskripsi_produk" name="deskripsi_produk" style="height: 100px" autocomplete="off"><?= $row['deskripsi'] ?></textarea>
            </div>
            <div class="mb-3">
                <label for="gambar_produk" class="form-label">Gambar produk</label>
                <input type="file" class="form-control" id="gambar_produk" name="gambar_produk" autocomplete="off" accept=".jpg, .jpeg, .png">
            </div>
            <div class="mb-3">
                <select class="form-select" name="kategori-produk" aria-label="Default select example">
                    <option selected>Pilih kategori</option>
                    <option <?php if ($row['tipe'] == "Makanan & Minuman") : ?> selected <?php endif; ?> value="Makanan & Minuman">Makanan & Minuman</option>
                    <option <?php if ($row['tipe'] == "Kesehatan & Kecantikan") : ?> selected <?php endif; ?> value="Kesehatan & Kecantikan">Kesehatan & Kecantikan</option>
                    <option <?php if ($row['tipe'] == "Elektronik & Gadget") : ?> selected <?php endif; ?> value="Elektronik & Gadget">Elektronik & Gadget</option>
                    <option <?php if ($row['tipe'] == "Fashion & Aksesoris") : ?> selected <?php endif; ?> value="Fashion & Aksesoris">Fashion & Aksesoris</option>
                    <option <?php if ($row['tipe'] == "Buku & Barang Sekolah") : ?> selected <?php endif; ?> value="Buku & Barang Sekolah">Buku & Barang Sekolah</option>
                    <option <?php if ($row['tipe'] == "Perabotan Rumah Tangga") : ?> selected <?php endif; ?> value="Perabotan Rumah Tangga">Perabotan Rumah Tangga</option>
                    <option <?php if ($row['tipe'] == "olahraga") : ?> selected <?php endif; ?> value="olahraga">Olahraga</option>
                    <option <?php if ($row['tipe'] == "Hobi & Koleksi") : ?> selected <?php endif; ?> value="Hobi & Koleksi">Hobi & Koleksi</option>
                    <option <?php if ($row['tipe'] == "Kendaraan & Aksesoris") : ?> selected <?php endif; ?> value="Kendaraan & Aksesoris">Kendaraan & Aksesoris</option>
                </select>
            </div>
            <a class="btn btn-secondary" href="admin.php?id=<?= $row['id_akun'] ?>" role="button"> <i class="fa-solid fa-arrow-left"></i> Kembali</a>
            <button class="btn btn-primary" type="submit" name="edit_produk">Perbarui</button>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Hapus
            </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus produk</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah kamu yakin ingin menghapus produk ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <form action="" method="post">
                        <button type="submit" class="btn btn-danger" name="hapus_produk">Ya</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Start Form Edit Produk -->

    <!-- Script area -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/4775c75ff6.js" crossorigin="anonymous"></script>
</body>

</html>