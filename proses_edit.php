<?php
require 'config/auth.php';
require 'config/koneksi.php';
require 'config/fungsi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard.php');
    exit;
}
cek_csrf();

$id       = (int)($_POST['id'] ?? 0);
$judul    = trim($_POST['judul'] ?? '');
$kategori = trim($_POST['kategori'] ?? '');
$penulis  = trim($_POST['penulis'] ?? '');
$tahun    = trim($_POST['tahun'] ?? '');
$stok     = trim($_POST['stok'] ?? '');

// Ambil data lama (untuk sampul lama)
$stmt = $conn->prepare('SELECT sampul FROM buku WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$lama = $stmt->get_result()->fetch_assoc();
if (!$lama) {
    $_SESSION['flash'] = ['danger', 'Data buku tidak ditemukan.'];
    header('Location: dashboard.php');
    exit;
}

$error = validasi_buku(compact('judul', 'kategori', 'penulis', 'tahun', 'stok'));
$sampul_baru = null;

// Sampul opsional saat edit
if (!$error && !empty($_FILES['sampul']['name'])) {
    try {
        $sampul_baru = upload_sampul($_FILES['sampul']);
    } catch (Exception $ex) {
        $error[] = $ex->getMessage();
    }
}

if ($error) {
    $_SESSION['flash'] = ['danger', implode('<br>', array_map('e', $error))];
    header("Location: edit_buku.php?id=$id");
    exit;
}

if ($sampul_baru) {
    $stmt = $conn->prepare('UPDATE buku SET judul=?, kategori=?, penulis=?, tahun_terbit=?, stok=?, sampul=? WHERE id=?');
    $stmt->bind_param('sssiisi', $judul, $kategori, $penulis, $tahun, $stok, $sampul_baru, $id);
    $stmt->execute();
    hapus_sampul($lama['sampul']);   // hapus file lama setelah update berhasil
} else {
    $stmt = $conn->prepare('UPDATE buku SET judul=?, kategori=?, penulis=?, tahun_terbit=?, stok=? WHERE id=?');
    $stmt->bind_param('sssiii', $judul, $kategori, $penulis, $tahun, $stok, $id);
    $stmt->execute();
}

$_SESSION['flash'] = ['success', 'Data buku berhasil diperbarui.'];
header('Location: dashboard.php');
exit;
