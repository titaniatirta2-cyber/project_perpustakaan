<?php
require 'config/auth.php';
require 'config/koneksi.php';
require 'config/fungsi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard.php');
    exit;
}
cek_csrf();

$judul    = trim($_POST['judul'] ?? '');
$kategori = trim($_POST['kategori'] ?? '');
$penulis  = trim($_POST['penulis'] ?? '');
$tahun    = trim($_POST['tahun'] ?? '');
$stok     = trim($_POST['stok'] ?? '');

$error = validasi_buku(compact('judul', 'kategori', 'penulis', 'tahun', 'stok'));
$sampul = null;

// Sampul wajib diisi saat tambah data
if (!$error) {
    try {
        if (empty($_FILES['sampul']['name'])) {
            throw new Exception('Sampul buku wajib diupload.');
        }
        $sampul = upload_sampul($_FILES['sampul']);
    } catch (Exception $ex) {
        $error[] = $ex->getMessage();
    }
}

if ($error) {
    $_SESSION['flash'] = ['danger', implode('<br>', array_map('e', $error))];
    $_SESSION['old'] = ['judul' => $judul, 'kategori' => $kategori, 'penulis' => $penulis, 'tahun_terbit' => $tahun, 'stok' => $stok];
    header('Location: tambah_buku.php');
    exit;
}

$stmt = $conn->prepare('INSERT INTO buku (judul, kategori, penulis, tahun_terbit, stok, sampul) VALUES (?, ?, ?, ?, ?, ?)');
$stmt->bind_param('sssiis', $judul, $kategori, $penulis, $tahun, $stok, $sampul);
$stmt->execute();

$_SESSION['flash'] = ['success', 'Buku berhasil ditambahkan.'];
header('Location: dashboard.php');
exit;
