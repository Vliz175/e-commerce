<?php
//* OTP Logika
// if (isset($_POST['perbarui'])) {
//     $hideElement = true;
//     $username = htmlspecialchars($_POST['username']);
//     $cekUsername = mysqli_query($conn, "SELECT username FROM akun WHERE username = '$username'");
//     if (mysqli_num_rows($cekUsername) > 0) {
//         echo "<script>
//         alert('Username sudah terpakai');
//         </script>";
//     }

//     $nomor = mysqli_escape_string($conn, $_POST['nomor_hp']);
//     if ($nomor) {
//         if (!mysqli_query($conn, "DELETE FROM otp WHERE nomor = $nomor")) {
//             echo ("Error description: " . mysqli_error($con));
//         }
//         $curl = curl_init();
//         $otp = rand(100000, 999999);
//         $waktu = time();
//         mysqli_query($conn, "INSERT INTO otp (nomor,otp,waktu) VALUES ( $nomor ,$otp , $waktu )");
//         $data = [
//             'target' => $nomor,
//             'message' => "Your OTP : " . $otp
//         ];

//         curl_setopt(
//             $curl,
//             CURLOPT_HTTPHEADER,
//             array(
//                 "Authorization: y2L1AuvqmJ+zFoDmotfs", //! tokennya ambil di fonnte.com
//             )
//         );
//         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
//         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//         curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
//         curl_setopt($curl, CURLOPT_URL, "https://api.fonnte.com/send");
//         curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
//         curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
//         $result = curl_exec($curl);
//         curl_close($curl);
//     }
// } elseif (isset($_POST['submit-login'])) {
//     $otp = mysqli_escape_string($conn, $_POST['otp']);
//     $nomor = mysqli_escape_string($conn, $_POST['nomor_hp']);
//     $q = mysqli_query($conn, "SELECT * FROM otp WHERE nomor = $nomor AND otp = $otp");
//     $row = mysqli_num_rows($q);
//     $r = mysqli_fetch_array($q);
//     if ($row) {
//         if (time() - $r['waktu'] <= 300) {
//             // $verifikasiOTP = true;

//         } else {
//             echo "<script>
//             alert('OTP expired')
//             </script>";
//         }
//     } else {
//         echo "<script>
//         alert('OTP salah')
//         </script>";
//     }
// }
//* End OTP Logika
// echo "<script>
//     alert('Akun berhasil di update');
//     location.replace('admin.php?id=$id');
//     </script>";

session_start();
function coba()
{
    $namaFile = $_FILES['foto_profil']['name'];
    $ukuranFile = $_FILES['foto_profil']['size'];
    $error = $_FILES['foto_profil']['error'];
    $tmpName = $_FILES['foto_profil']['tmp_name'];
    // echo $namaFile;
    // echo "<br>";
    // echo $ukuranFile;
    // echo "<br>";
    // echo $error;
    // echo "<br>";
    // echo $tmpName;
    // echo "<br>";
    return $tmpName;
}
$test = "testing";
if (isset($_POST['test'])) {
    $_SESSION['tmpName'] = coba();
    echo $_SESSION['tmpName'];
}

if (isset($_POST['validasi'])) {
    echo $_SESSION['tmpName'] . "oke";
}
if (isset($_POST['hapus'])) {
    unset($_SESSION['hapus']);
    echo $test;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coba coba</title>
</head>

<body>
    <form action="" enctype="multipart/form-data" method="post">
        <input type="file" name="foto_profil">
        <button type="submit" name="test">submit</button>
        <?php if (isset($_POST['test'])) : ?>
            <button type="submit" name="validasi">Validasi</button>
        <?php elseif (isset($_POST['validasi'])) : ?>
            <button type="submit" name="hapus">Hapus</button>
        <?php endif; ?>
    </form>
</body>

</html>