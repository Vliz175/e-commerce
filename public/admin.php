<?php
session_start();
require '../koneksi.php';


if ($_COOKIE["login"] == false) {
    header('location: login.php');
}


//* Pengambilan id
$id = $_GET['id'];
if ($id == false) {
    header('location: login.php');
} else {
    $query_id = "SELECT * FROM akun WHERE id = '$id'";
    $result = mysqli_query($conn, $query_id);
    $row = mysqli_fetch_assoc($result);
}


//* query Produk
if (isset($_POST["edit_produk"])) {
    $idEditProduk = $_POST["id_edit_produk"];
    $queryIdEditProduk = "SELECT * FROM `produk` WHERE id='$idEditProduk'";
    $result = mysqli_query($conn, $queryIdEditProduk);
    $rowIdEditProduk = mysqli_fetch_assoc($result);
}


//* logika untuk file gambar produk
function upload()
{
    $namaFile = $_FILES['gambar_produk']['name'];
    $ukuranFile = $_FILES['gambar_produk']['size'];
    $error = $_FILES['gambar_produk']['error'];
    $tmpName = $_FILES['gambar_produk']['tmp_name'];

    if ($error === 4) {
        echo "<script>
            alert('tolong masukan gambar');
        </script>";
        return false;
    }

    $formatGambarValid = ["jpg", "jpeg", "png"];
    $formatGambar = explode('.', $namaFile);
    $formatGambar = strtolower(end($formatGambar));
    if (!in_array($formatGambar, $formatGambarValid)) {
        echo "<script>
                alert('Tolong masukan gambar dengan format jpg, jpeg, png');
            </script>";
        return false;
    }

    if ($ukuranFile > 1024 * 1024) {
        echo "<script>
        alert(' Maksimal ukuran gambar 1 MB');
        </script>";
        return false;
    }

    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $formatGambar;

    move_uploaded_file($tmpName, '../db/img/' . $namaFileBaru);
    return $namaFileBaru;
}


//* Tambahkan Produk
function tambahProduk()
{
    global $conn;

    $idAkun = $_POST['id_akun'];
    $namaProduk = htmlspecialchars($_POST['nama_produk']);
    $hargaProduk = $_POST['harga_produk'];
    $deskripsiProduk = htmlspecialchars($_POST['deskripsi_produk']);
    $tipeProduk = $_POST['kategori-produk'];
    $gambarProduk = upload();

    if (!$gambarProduk) {
        return false;
    }

    $query = "INSERT INTO produk (nama, harga, gambar, tipe, deskripsi, id_akun) VALUES ('$namaProduk','$hargaProduk','$gambarProduk','$tipeProduk','$deskripsiProduk','$idAkun')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

if (isset($_POST['tambahkan'])) {
    if (tambahProduk() > 0) {
        echo "<script>
       alert('Produk berhasil ditambahkan');
       location.href ='admin.php?id=$id';
        </script>";
    }
}


//* Logika untuk file foto profil
function uploadFoto()
{
    global $row;
    $namaFile = $_FILES['foto_profil']['name'];
    $ukuranFile = $_FILES['foto_profil']['size'];
    $error = $_FILES['foto_profil']['error'];
    $tmpName = $_FILES['foto_profil']['tmp_name'];

    if ($error === 4) {
        return $row['profil'];
    }

    $array = ['png', 'jpg', 'jpeg'];
    $formatFile = explode('.', $namaFile);
    $formatFile = strtolower(end($formatFile));
    if (!in_array($formatFile, $array)) {
        echo "<script>
        alert('Tolong masukan gambar dengan format jpg, jpeg, png');
        </script";
        return $row['profil'];
    }

    if ($ukuranFile > 1024 * 1024) {
        echo "<script>
        alert('Maksimal ukuran gambar 1 MB');
        </Script>";
        return $row['profil'];
    }

    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $formatFile;

    move_uploaded_file($tmpName, "../db/img_profile/" . $namaFileBaru);
    return $namaFileBaru;
}



//* Update untuk edit akun
function editAkun($foto1, $rowProfil1)
{
    global $id;
    global $conn;
    global $row;
    $rowProfil = $rowProfil1;;
    $username = $_POST['username'];
    $nomorHp = $_POST['nomor_hp'];
    $foto = $foto1;
    $fotoLama = "../db/img_profile/" . $rowProfil;

    if ($foto != $rowProfil) {
        if (file_exists($fotoLama)) {
            if (unlink($fotoLama)) {
                // echo 'Gambar berhasil dihapus.';
            } else {
                // echo 'Gagal menghapus gambar.';
            }
        } else {
            // echo 'File gambar tidak ditemukan.';
        }
    }

    if ($nomorHp == null) {
        $nomorHp = $row['nomor_hp'];
    }
    if (empty($username)) {
        $username = $row['username'];
    }

    $query = "UPDATE akun SET username='$username', nomor_hp='$nomorHp', profil='$foto' WHERE id ='$id'";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

//* Logika otp


$verifikasiOTP = false;

if (isset($_POST['perbarui']) && !empty($_POST['nomor_hp'])) {
    if (preg_match('/^628\d{7,10}$/', (string)$_POST['nomor_hp'])) {
    } else {
        echo "<script>
        alert('Salah format untuk nomor hp');
        location.href ='admin.php?id=$id';
        </script>";
        die();
    }

    $_SESSION['foto'] = uploadFoto();
    $_SESSION['rowProfil'] = $row['profil'];
    $verifikasiOTP = true;
    $nomor = mysqli_escape_string($conn, $_POST['nomor_hp']);

    if ($nomor) {
        if (!mysqli_query($conn, "DELETE FROM otp WHERE nomor = $nomor")) {
            echo ("Error description: " . mysqli_error($con));
        }
        $curl = curl_init();
        $otp = rand(100000, 999999);
        $waktu = time();
        mysqli_query($conn, "INSERT INTO otp (nomor,otp,waktu) VALUES ( $nomor ,$otp , $waktu )");
        $data = [
            'target' => $nomor,
            'message' => "Your OTP : " . $otp
        ];

        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                "Authorization: y2L1AuvqmJ+zFoDmotfs",
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, "https://api.fonnte.com/send");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);
    }
} elseif (isset($_POST['submit-login'])) {
    $otp = mysqli_escape_string($conn, $_POST['otp']);
    $nomor = mysqli_escape_string($conn, $_POST['nomor_hp']);
    $q = mysqli_query($conn, "SELECT * FROM otp WHERE nomor = $nomor AND otp = $otp");
    $rows = mysqli_num_rows($q);
    $r = mysqli_fetch_array($q);
    if ($rows) {
        if (time() - $r['waktu'] <= 300) {
            // echo "otp benar";
            editAkun($_SESSION['foto'], $_SESSION['rowProfil']);
            unset($_SESSION['rowProfil']);
            unset($_SESSION['foto']);
            echo "<script>
       alert('Akun berhasil diperbarui');
       location.href ='admin.php?id=$id';
        </script>";
        } else {
            echo "<script>
            alert('otp expired');
            </script>";
        }
    } else {
        echo "<script>
        alert('otp salah');
        </script>";
    }
} elseif (isset($_POST['perbarui']) && empty($_POST['nomor_hp'])) {
    editAkun(uploadFoto(), $row['profil']);
    echo "<script>
       alert('Akun berhasil diperbarui');
       location.href ='admin.php?id=$id';
        </script>";
}


//* Produk View
$queryProduk = "SELECT * FROM `produk` WHERE id_akun='$id'";
$resultProduk = mysqli_query($conn, $queryProduk);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/admin.css">
    <style>
        <?php if ($verifikasiOTP == true) : ?>.hide-element {
            display: none;
        }

        <?php endif; ?>
    </style>
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
                        <a class="nav-link active" href="#">Akun</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar Area -->

    <!-- Start Main Content Area  -->
    <div class="container-fluid mt-4">
        <!-- Start Menu Control Area -->
        <div class=" container menu-control hide-element">
            <div class="identitas">
                <div class="img">
                    <img src="../db/img_profile/<?= $row['profil'] ?>" alt="">
                </div>
                <div class="username-penjual">
                    <h3 class="text-center"><?= $row['username'] ?></h3>
                    <?php if ($row['email_sekolah'] == "YourEmail@bcischool.sch.id" || $row['email_sekolah'] == null) : ?>
                        <h6>Pembeli</h6>
                    <?php else : ?>
                        <h6>Penjual / Pembeli</h6>
                    <?php endif; ?>
                </div>
            </div>

            <div class="feature">
                <ul>
                    <li>
                        <?php if ($row['email_sekolah'] == "YourEmail@bcischool.sch.id" || $row['email_sekolah'] == null) : ?>
                            <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#tambahProduk" disabled>
                                <i class="fa-regular fa-square-plus"></i> Tambah Produk
                            </button>
                        <?php else : ?>
                            <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#tambahProduk">
                                <i class="fa-regular fa-square-plus"></i> Tambah Produk
                            </button>
                        <?php endif; ?>
                    </li>
                    <li>
                        <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#editAkun">
                            <i class="fa-solid fa-pen-to-square"></i> Edit Akun
                        </button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#logout">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        <!-- End Menu Control -->

        <!-- Start View Produk Area -->
        <div class="container mt-4 pt-3 view-site hide-element">
            <div class=" wrapper row">
                <?php if (mysqli_num_rows($resultProduk) != 0) : ?>
                    <?php while ($rowProduk = mysqli_fetch_assoc($resultProduk)) : ?>

                        <?php
                        // query nama penjual untuk ditampilkan di card
                        $idAkun = $rowProduk['id_akun'];
                        $queryAkun = "SELECT * FROM akun WHERE id='$idAkun'";
                        $x = mysqli_query($conn, $queryAkun);
                        $akun = mysqli_fetch_assoc($x);
                        ?>

                        <div class="col-lg-2 col-sm-4 col-6 mb-3">
                            <div class="card">
                                <img src="../db/img/<?= $rowProduk['gambar'] ?>" class="card-img-top" loading="lazy" alt="<?= $rowProduk['nama'] ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?= ucfirst($rowProduk['nama']) ?></h5>
                                    <p class="card-text">Rp <?= number_format($rowProduk['harga'], 0, '.') ?></p>
                                    <p class="card-penjual"><i class="fa-solid fa-shop"></i> <?= $akun['username'] ?></p>
                                    <a href="overview.php?id=<?= $rowProduk['id'] ?>" class="btn btn-success">Lihat</a>
                                    <a href="edit_produk.php?id=<?= $rowProduk['id'] ?>" class="btn btn-primary">edit</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
            </div>
        <?php elseif ($row['email_sekolah'] == "YourEmail@bcischool.sch.id" || $row['email_sekolah'] == null) : ?>
            <div class=" alert alert-warning text-center w-100" role="alert">
                <a type="button" class="link-akun-penjual" data-bs-toggle="modal" data-bs-target="#ubahAkunPenjual">
                    Aktifkan akun sebagai penjual
                </a>
            </div>
        <?php else : ?>
            <div class=" alert alert-warning text-center w-100" role="alert">
                Kamu belum menambahkan produk
            </div>
        <?php endif; ?>

        </div>
        <!-- End View Produk Area -->
    </div>
    <!-- End Main Content Area -->

    <!-- Start Modal Area -->
    <!-- Modal Tambah Produk -->
    <div class="modal fade" id="tambahProduk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Produk</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" class="form-control" id="id_akun" name="id_akun" value="<?= $row['id'] ?>">
                        <div class="mb-3">
                            <label for="nama_produk" class="form-label">Nama produk</label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="harga_produk" class="form-label">Harga produk</label>
                            <input type="text" class="form-control" id="harga_produk" name="harga_produk" required autocomplete="off" placeholder="000000">
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi_produk">Deskripsi produk</label>
                            <textarea class="form-control" placeholder="" id="deskripsi_produk" name="deskripsi_produk" style="height: 100px" autocomplete="off">
                        Tempat 
                        </textarea>
                        </div>
                        <div class="mb-3">
                            <label for="gambar_produk" class="form-label">Gambar produk</label>
                            <input type="file" class="form-control" id="gambar_produk" name="gambar_produk" required autocomplete="off" accept=".jpg, .jpeg, .png">
                            <div id="emailHelp" class="form-text">* Wajib diisi</div>
                        </div>
                        <div class="mb-3">
                            <select class="form-select" name="kategori-produk" aria-label="Default select example">
                                <option selected>Pilih kategori</option>
                                <option value="Makanan & Minuman">Makanan & Minuman</option>
                                <option value="Kesehatan & Kecantikan">Kesehatan & Kecantikan</option>
                                <option value="Elektronik & Gadget">Elektronik & Gadget</option>
                                <option value="Fashion & Aksesoris">Fashion & Aksesoris</option>
                                <option value="Buku & Barang Sekolah">Buku & Barang Sekolah</option>
                                <option value="Perabotan Rumah Tangga">Perabotan Rumah Tangga</option>
                                <option value="olahraga">Olahraga</option>
                                <option value="Hobi & Koleksi">Hobi & Koleksi</option>
                                <option value="Kendaraan & Aksesoris">Kendaraan & Aksesoris</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary" name="tambahkan">Tambahkan</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Akun -->
    <div class="modal fade" id="editAkun" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Akun</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" autocomplete="off" placeholder="<?= $row['username'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="nomor_hp" class="form-label">Nomor HP</label>
                            <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" autocomplete="off" placeholder="<?= $row['nomor_hp'] ?>">
                        </div>
                        <div class=" mb-3">
                            <label for="foto_profil" class="form-label">Foto profil</label>
                            <input type="file" class="form-control" id="foto_profil" name="foto_profil" autocomplete="off" placeholder="<?= $row['profil'] ?>">
                        </div>
                    </div>
                    <div class=" modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-primary" name="perbarui">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Logout -->
    <div class="modal fade" id="logout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Logout</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Yakin ingin logout?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <a class="btn btn-primary" href="logout.php" role="button">Ya</a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Area -->

    <!-- OTP Area -->
    <?php if ($verifikasiOTP == true) : ?>
        <div class="container container-registrasi">
            <form action="" method="post" id="form">
                <div class="mb-3">
                    <label for="otp" class="form-label">Kode OTP</label>
                    <input type="text" name="otp" class="form-control" id="otp" aria-describedby="emailHelp" required autocomplete="off" pattern="\d{6}">
                    <input type="hidden" name="nomor_hp" value="<?= $_POST['nomor_hp'] ?>">
                    <input type="hidden" name="username" value="<?= $_POST['username'] ?>">
                    <div id="emailHelp" class="form-text">Masukan kode otp yang telah dikirim melalui whatsappp</div>
                </div>

                <button type="submit" name="submit-login" class="btn btn-primary">Submit</button>
            </form>
        </div>
    <?php endif; ?>
    <!-- End OTP Area -->

    <!-- Pengaktifan Akun penjual area -->
    <div class="modal fade" id="ubahAkunPenjual" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Akun penjual</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="../php/mailerUI.php" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="email_sekolah" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email_sekolah" name="email_sekolah" aria-describedby="emailHelp" required pattern="[a-zA-Z0-9._%+-]+@bcischool\.sch\.id" autocomplete="off" placeholder="Email@bcischool.sch.id">
                            <div id="emailHelp" class="form-text text-danger"><i class="fa-solid fa-circle-exclamation"></i> Gunakan akun email sekolah</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" name="set_email_sekolah">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End  Pengaktifan Akun penjual area -->

    <!-- Script area -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/4775c75ff6.js" crossorigin="anonymous"></script>
</body>

</html>