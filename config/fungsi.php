<?php
const UPLOAD_DIR = __DIR__ . '/../uploads/';
const MAX_UKURAN = 2 * 1024 * 1024; // 2MB

function e($teks): string
{
    return htmlspecialchars((string)$teks, ENT_QUOTES, 'UTF-8');
}

// Percabangan untuk label status ketersediaan
function label_status(int $stok): array
{
    if ($stok > 0) {
        return ['Tersedia', 'success'];
    }
    return ['Dipinjam', 'danger'];
}

// Validasi + simpan file sampul. Return nama file, atau throw Exception jika gagal
function upload_sampul(array $file): string
{
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('Upload gagal (kode ' . $file['error'] . ').');
    }
    if ($file['size'] > MAX_UKURAN) {
        throw new Exception('Ukuran file maksimal 2MB.');
    }
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png'], true)) {
        throw new Exception('Ekstensi harus .jpg atau .png.');
    }
    $info = getimagesize($file['tmp_name']);
    if ($info === false || !in_array($info[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG], true)) {
        throw new Exception('File bukan gambar JPG/PNG yang valid.');
    }
    $nama = uniqid('sampul_', true) . '.' . $ext;
    if (!move_uploaded_file($file['tmp_name'], UPLOAD_DIR . $nama)) {
        throw new Exception('Gagal menyimpan file ke folder uploads.');
    }
    return $nama;
}

function hapus_sampul(?string $nama): void
{
    if ($nama && is_file(UPLOAD_DIR . $nama)) {
        unlink(UPLOAD_DIR . $nama);
    }
}

// Validasi input teks buku, return array error
function validasi_buku(array $d): array
{
    $err = [];
    if (trim($d['judul']) === '' || trim($d['penulis']) === '' || trim($d['kategori']) === '') {
        $err[] = 'Judul, kategori, dan penulis wajib diisi.';
    }
    if (!ctype_digit($d['tahun']) || (int)$d['tahun'] < 1900 || (int)$d['tahun'] > (int)date('Y')) {
        $err[] = 'Tahun terbit tidak valid.';
    }
    if (!ctype_digit($d['stok'])) {
        $err[] = 'Stok harus angka 0 atau lebih.';
    }
    return $err;
}
