<?php
require 'config/auth.php';
require 'config/koneksi.php';
require 'config/fungsi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard.php');
    exit;
}
cek_csrf();

$id = (int)($_POST['id'] ?? 0);

$stmt = $conn->prepare('SELECT sampul FROM buku WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$buku = $stmt->get_result()->fetch_assoc();

if ($buku) {
    $stmt = $conn->prepare('DELETE FROM buku WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    hapus_sampul($buku['sampul']);   // unlink file gambar
    $_SESSION['flash'] = ['success', 'Buku dan file sampul berhasil dihapus.'];
} else {
    $_SESSION['flash'] = ['danger', 'Data buku tidak ditemukan.'];
}

header('Location: dashboard.php');
exit;
