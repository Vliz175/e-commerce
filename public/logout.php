<?php
session_start();
session_unset();
session_destroy();
setcookie('username', '', time() - 3600 * 24, '/');
setcookie('login', '', time() - 3600 * 24, '/');
setcookie('id', '', time() - 3600 * 24, '/');
setcookie('secretNumber', '', time() - 3600 * 24, '/');
header('location: login.php');
