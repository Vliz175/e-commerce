<?php
// Periksa apakah 'keyword' diset sebelum mengaksesnya
if (isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];

    // Gunakan operator titik (.) untuk menggabungkan string
    header("location: ../public/hasil_pencarian.php?keyword=" . $keyword);
    exit(); // Penting untuk menghentikan eksekusi skrip setelah melakukan redirect
} else {
    // Handle jika 'keyword' tidak diatur
    echo "Keyword tidak ditemukan.";
}
?>
