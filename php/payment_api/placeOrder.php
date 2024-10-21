<?php

session_start();
require '../koneksi.php';

//* Pengambilan server key
if (!empty($_POST['id-akun'])) {
    $_SESSION['id_akun'] = $_POST['id-akun'];
}
$idAkun = $_SESSION['id_akun'];
$query = "SELECT * FROM akun WHERE id='$idAkun'";
$result = mysqli_query($conn, $query);
$akun = mysqli_fetch_assoc($result);


//* Pemnagbilan data makanan
if (!empty($_POST['id-produk'])) {
    $_SESSION['id_produk'] = $_POST['id-produk'];
}
$idProduk = $_SESSION['id_produk'];
$query = "SELECT * FROM produk WHERE id='$idProduk'";
$result = mysqli_query($conn, $query);
$produk = mysqli_fetch_assoc($result);


//* Menentukan harga yang harus dibayar
if (!empty($_POST['jumlah-produk']) && !empty($_POST['harga-produk'])) {
    $_SESSION['jumlah_produk'] = $_POST['jumlah-produk'];
    $_SESSION['harga_produk'] = $_POST['harga-produk'];
}
$hargaTotal = $_SESSION['jumlah_produk'] * $_SESSION['harga_produk'];


//* Pengambilan Snaptoken midtrans
require_once dirname(__FILE__) . '/midtrans-php-master/Midtrans.php';
\Midtrans\Config::$serverKey = $akun['server_key'];
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

$params = array(
    'transaction_details' => array(
        'order_id' => rand(),
        'gross_amount' => $hargaTotal,
    ),
    'customer_details' => array(
        'first_name' => $_COOKIE['username'],
        // 'email' => 'budi.pra@example.com',
        'phone' => $_COOKIE['secretNumber'],
    ),
);

try {
    $snapToken = \Midtrans\Snap::getSnapToken($params);
} catch (Exception $e) {
    echo "<script>
    alert('Ada kesalahan dari penjual, pengaturan token yang invalid');
    window.history.back();
    </script>";
    die();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= $akun['client_key'] ?>"></script>
    <link rel="stylesheet" href="../css/place_order.css">
    <title>Market Day</title>
</head>

<body>


    <div class="container mt-5">
        <a href=""></a>
        <h1 class="text-center">Pembayaran</h1>
        <div class="bar-pesanan">
            <div class="img">
                <img src="../db/img/<?= $produk['gambar'] ?>" alt="">
            </div>
            <div class="total-pesanan">
                <h2>Nama produk</h2>
                <h4>Harga:</h4>
                <h4>Jumlah</h4>
            </div>
        </div>
    </div>
    <button type="button" id="pay-button">bayar</button>


    <!-- Script Area -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            window.snap.pay('<?= $snapToken ?>');
        });
    </script>
</body>

</html>