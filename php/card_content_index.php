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