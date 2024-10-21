<?php
require "../koneksi.php";

$getEmail = $_GET['email'];
$getId = $_GET['id'];

$query = "UPDATE `akun` SET `email_sekolah`='$getEmail' WHERE id='$getId'";
mysqli_query($conn, $query);
// if (mysqli_query($conn, $query)) {
//     echo "berhasil";
// } else {
//     echo "gagal";
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/mailerUI.css">
    <title>Market Day</title>
</head>

<body>
    <div class="container">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Verifikasi email telah berhasil!</h5>
                <p class="card-text">Silahkan kembali ke halaman awal</p>
                <!-- <a href="../public/admin.php?id=<?= $getId ?>" class="btn btn-primary">« Kembali</a> -->
            </div>
        </div>
    </div>

    <!-- Script area -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/4775c75ff6.js" crossorigin="anonymous"></script>
</body>

</html>