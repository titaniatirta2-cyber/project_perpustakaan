<?php
// Dipanggil di awal halaman yang butuh login
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?pesan=belum_login');
    exit;
}

// Token CSRF sederhana untuk form POST
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(16));
}

function cek_csrf(): void
{
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'] ?? '')) {
        die('Token tidak valid.');
    }
}
