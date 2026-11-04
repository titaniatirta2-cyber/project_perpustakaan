<?php
// Koneksi database (mysqli)
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'db_perpustakaan';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    die('Koneksi database gagal. Periksa config/koneksi.php');
}
