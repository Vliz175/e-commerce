<?php
$conn = mysqli_connect("localhost", "root", "", "market_day");

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
