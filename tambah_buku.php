<?php
require 'config/auth.php';
require 'config/fungsi.php';

$judul_halaman = 'Tambah Buku';
$judul_form = 'Tambah Buku Baru';
$aksi = 'proses_tambah.php';
$b = $_SESSION['old'] ?? [];   // isi ulang form jika validasi gagal
unset($_SESSION['old']);

include 'config/header.php';
include 'config/form_buku.php';
include 'config/footer.php';
