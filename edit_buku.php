<?php
require 'config/auth.php';
require 'config/koneksi.php';
require 'config/fungsi.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $conn->prepare('SELECT * FROM buku WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$b = $stmt->get_result()->fetch_assoc();

if (!$b) {
    $_SESSION['flash'] = ['danger', 'Data buku tidak ditemukan.'];
    header('Location: dashboard.php');
    exit;
}

$judul_halaman = 'Edit Buku';
$judul_form = 'Edit Data Buku';
$aksi = 'proses_edit.php';

include 'config/header.php';
include 'config/form_buku.php';
include 'config/footer.php';
