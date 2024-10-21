<?php
require "../koneksi.php";
$key = $_GET['key'];

if ($key == "") {
    header("location: index.php");
}

$query = "SELECT * FROM produk WHERE nama LIKE '%$key%'";
$result = mysqli_query($conn, $query);
?>


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
            <img src="db/img/<?= $row["gambar"] ?>" class="card-img-top img-fluid" loading="lazy">
            <div class="card-body">
                <h5 class="card-title"><?= ucfirst($row['nama']) ?></h5>
                <p class="card-text">Rp <?= number_format($row['harga'], 0, ',') ?></p>
                <p class="card-penjual"><i class="fa-solid fa-shop"></i> <?= $akun['username'] ?></p>
                <a href="overview.php?id=<?= $row['id'] ?>" class="btn btn-warning">Beli</a>
            </div>
        </div>
    </div>
<?php endwhile; ?>