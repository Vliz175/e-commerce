<?php
session_start();
require '../koneksi.php';

//* OTP Logika
$verifikasiOTP = null;
if (isset($_POST['registrasi'])) {

    $hideElement = true;
    // pengecekan apakah sudah ada username yang sama sebelumnya
    $username = htmlspecialchars($_POST['username']);
    $cekUsername = mysqli_query($conn, "SELECT username FROM akun WHERE username = '$username'");
    if (mysqli_num_rows($cekUsername) > 0) {
        echo "<script>
        alert('Username sudah terpakai');
        location.href = 'registrasi.php';
        </script>";
        exit();
    }

    // merubah format nomor handphone
    $noHp = $_POST['nomor_hp'];
    $nomorHp = "62" . substr($noHp, 1);
    $_SESSION['nomorHp'] = $nomorHp;

    // pengiriman otp ke nomor hp
    $nomor = mysqli_escape_string($conn, $_SESSION['nomorHp']);
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
    echo $_SESSION['nomorHp'];
    $nomor = mysqli_escape_string($conn, $_SESSION['nomorHp']);
    $q = mysqli_query($conn, "SELECT * FROM otp WHERE nomor = $nomor AND otp = $otp");
    $row = mysqli_num_rows($q);
    $r = mysqli_fetch_array($q);
    if ($row) {
        if (time() - $r['waktu'] <= 300) {
            $verifikasiOTP = true;
            // echo "otp benar";
        } else {
            echo "<script>
            alert('OTP expired')
            </script>";
        }
    } else {
        echo "<script>
        alert('OTP salah')
        </script>";
    }
}
//* End OTP Logika

if ($verifikasiOTP == true) {
    $username = trim(htmlspecialchars($_POST["username"]));
    $nomor_hp = trim($_SESSION['nomorHp']);
    $password = trim(htmlspecialchars($_POST['password']));
    $cekPassword = trim($_POST["cekPassword"]);
    $emailSekolah = trim($_POST['email_sekolah']);

    //* Cek apaka ada nama yang sama
    $cekUsername = mysqli_query($conn, "SELECT username FROM akun WHERE username = '$username'");
    if (mysqli_num_rows($cekUsername) > 0) {
        $errMsg = "Username sudah terpakai";
    }

    //* Cek apakah password sesuai
    if ($cekPassword != $password) {
        $errMsg = "Password tidak sesuai";
    }

    if (!empty($errMsg)) {
        echo "<script>
        alert('$errMsg');
        </script>";
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($conn, "INSERT INTO akun (username, password, nomor_hp, email_sekolah) VALUES ('$username','$password','$nomor_hp','$emailSekolah')");
        $query = "SELECT * FROM akun WHERE username ='$username'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        // echo "<script>
        //         alert('Akun anda berhasil terdaftar');
        //         window.location.href = 'login.php';
        //      </script>";
        $_SESSION['id'] = $row['id'];
        setcookie('username', $row['username'], time() + 3600 * 24, '/');
        setcookie('login', true, time() + 3600 * 24, '/');
        setcookie('id', $row['id'], time() + 3600 * 24, '/');
        setcookie('secretNumber', $row['nomor_hp'], time() + 3600 * 24, '/');
        header("location: admin.php?id=" . $_SESSION['id']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/registrasi.css">
    <style>
        <?php if ($hideElement == true) : ?>

        /* */
        .hide-element {
            display: none;
        }

        <?php endif; ?>
    </style>
    <title>Registrasi</title>
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
                        <a class="nav-link" href="admin.php">Akun</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar Area -->

    <!-- Start Registrasi Area-->
    <div class="container hide-element container-registrasi pt-4">
        <form action="" method="post" id="form">
            <h1 class="text-center text-registrasi">Registrasi</h1>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="username" required autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="nomor_hp" class="form-label">No. HP</label>
                <input type="text" class="form-control" name="nomor_hp" id="nomor_hp" required autocomplete="off" placeholder="08xxxxxxxxxx" pattern="08[0-9]{9,12}">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" autocomplete="off" required></input>
            </div>
            <div class="mb-3">
                <label for="cekPassword" class="form-label">Verifikasi Password</label>
                <input type="password" class="form-control" name="cekPassword" id="cekPassword" autocomplete="off" required></input>
                <a href="login.php">Sudah punya akun?</a>
            </div>

            <input class="btn btn-warning w-100" type="submit" name="registrasi" value="Submit">
        </form>
    </div>
    <!-- End Registrasi Area  -->

    <!-- OTP Area -->
    <?php
    if (isset($_POST['registrasi'])) : ?>
        <div class="container container-registrasi">
            <form action="" method="post" id="form">
                <div class="mb-3">
                    <label for="otp" class="form-label">Kode OTP</label>
                    <input type="text" name="otp" class="form-control" id="otp" aria-describedby="emailHelp" required autocomplete="off" pattern="\d{6}">
                    <input type="hidden" name="nomor_hp" value="<?= $_SESSION['nomorHp'] ?>">
                    <input type="hidden" name="username" value="<?= $_POST['username'] ?>">
                    <input type="hidden" name="password" value="<?= $_POST['password'] ?>">
                    <input type="hidden" name="cekPassword" value="<?= $_POST['cekPassword'] ?>">
                    <!-- <input type="hidden" name="email_sekolah" id="cekPassword" value=""></input> -->
                    <div id="emailHelp" class="form-text">Masukan kode otp yang telah dikirim melalui whatsappp</div>
                </div>

                <button type="submit" name="submit-login" class="btn btn-primary">Submit</button>
            </form>
        </div>
    <?php endif; ?>
    <!-- End OTP Area -->

    <!-- Script Area -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <!-- <script src="../js/script.js"></script> -->
</body>

</html>