<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
require "../koneksi.php";

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

// Buat ambil username
$id_akun = $_COOKIE['id'];
$query = "SELECT * FROM akun WHERE id='$id_akun'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Cek apakah email sudah terpakai
$email = $_POST['email_sekolah'];
$queryCek = "SELECT * FROM akun WHERE email_sekolah='$email'";
$resultCek = mysqli_query($conn, $queryCek);
if (mysqli_num_rows($resultCek) > 0) {
?>

    <div class="card text-center">
        <div class="card-body">
            <div class="alert alert-danger text-center" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i> Akun sudah terpakai
            </div>
            <a href="../public/admin.php?id=<?= $_COOKIE['id'] ?>" class="btn btn-primary">« Kembali</a>
        </div>
    </div>

    <?php
    die();
}

// Pengecekan email sekolah

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $email_parts = explode('@', $email);
    $domain = end($email_parts);

    if ($domain == 'bcischool.sch.id') {
        // return true;
    } else {
    ?>

        <div class="card text-center">
            <div class="card-body">
                <div class="alert alert-danger text-center" role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i> Domain email tidak valid
                </div>
                <a href="../public/admin.php?id=<?= $_COOKIE['id'] ?>" class="btn btn-primary">« Kembali</a>
            </div>
        </div>

    <?php
        die();
    }
} else {
    ?>

    <div class="card text-center">
        <div class="card-body">
            <div class="alert alert-danger text-center" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i> Format email salah
            </div>
            <a href="../public/admin.php?id=<?= $_COOKIE['id'] ?>" class="btn btn-primary">« Kembali</a>
        </div>
    </div>

<?php
    // die();
}


try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'hellovliz17@gmail.com';                     //SMTP username
    $mail->Password   = 'gidw qydk uqur tceg';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('from@testwebsite.com', 'Market Day');
    $mail->addAddress($_POST['email_sekolah'], $row['username']);     //Add a recipient
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Verifikasi Akun';
    $mail->Body    = "Halo, " . $row['username'] . "<br><br>

    Terima kasih telah mendaftar di Market Day! Untuk menyelesaikan proses pendaftaran dan mengaktifkan akun Anda, silakan klik tautan di bawah ini untuk verifikasi: <br><br>

    <a href='http://localhost/Market%20Day/php/verif.php?email=" . $_POST['email_sekolah'] . "&id=" . $id_akun . "'>Klik disini untuk mulai verifikasi</a> <br><br>

    Jika Anda tidak mendaftar di Market Day, abaikan pesan ini. Jangan memberikan informasi akun Anda kepada siapapun. <br><br>

    Terima kasih, <br><br>

    Fauzan Zaki (Developer)";
    $mail->AltBody = "Halo, " . $row['username'] . "<br><br>

    Terima kasih telah mendaftar di Market Day! Untuk menyelesaikan proses pendaftaran dan mengaktifkan akun Anda, silakan klik tautan di bawah ini untuk verifikasi: <br><br>

    <a href='http://localhost/Market%20Day/php/verif.php?email=" . $_POST['email_sekolah'] . "&id=" . $id_akun . "'>Klik disini untuk mulai verifikasi</a> <br><br>

    Jika Anda tidak mendaftar di Market Day, abaikan pesan ini. Jangan memberikan informasi akun Anda kepada siapapun. <br><br>

    Terima kasih, <br><br>

    Fauzan Zaki (Developer)";

    $mail->send();
?>

    <div class="card text-center">
        <div class="card-body">
            <h5 class="card-title">Verifikasi email telah terkirim!</h5>
            <p class="card-text">Silahkan verifikasi melalui email yang sudah terkirim</p>
            <!-- <a href="../public/admin.php?id=<?= $_COOKIE['id'] ?>" class="btn btn-primary">« Kembali</a> -->
        </div>
    </div>

<?php
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>