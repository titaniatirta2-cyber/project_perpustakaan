<?php
session_start();
require 'config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$stmt = $conn->prepare('SELECT id, username, password, nama_lengkap FROM users WHERE username = ?');
$stmt->bind_param('s', $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    session_regenerate_id(true);
    $_SESSION['user_id']  = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['nama']     = $user['nama_lengkap'];

    // Remember Me: simpan username saja di cookie (30 hari)
    if (isset($_POST['remember'])) {
        setcookie('remember_username', $user['username'], [
            'expires'  => time() + 60 * 60 * 24 * 30,
            'path'     => '/',
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    } else {
        setcookie('remember_username', '', time() - 3600, '/');
    }

    header('Location: dashboard.php');
    exit;
}

header('Location: index.php?pesan=gagal');
exit;
