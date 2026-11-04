<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
require 'config/fungsi.php';

$pesan = [
    'belum_login' => ['warning', 'Silakan login terlebih dahulu.'],
    'gagal'       => ['danger',  'Username atau password salah.'],
    'logout'      => ['success', 'Anda berhasil logout.'],
][$_GET['pesan'] ?? ''] ?? null;

$username_cookie = $_COOKIE['remember_username'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | Mini Digital Library</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <style>
    body { min-height: 100vh; background: linear-gradient(135deg, #4f46e5, #7c3aed); }
    .card-login { max-width: 400px; border: 0; border-radius: 1rem; }
  </style>
</head>
<body class="d-flex align-items-center justify-content-center p-3">
  <div class="card card-login shadow-lg w-100">
    <div class="card-body p-4">
      <div class="text-center mb-4">
        <i class="bi bi-book-half fs-1 text-primary"></i>
        <h4 class="fw-bold mt-2">Mini Digital Library</h4>
        <p class="text-muted small mb-0">Masuk untuk mengelola data buku</p>
      </div>
      <?php if ($pesan): ?>
        <div class="alert alert-<?= $pesan[0] ?> py-2"><?= $pesan[1] ?></div>
      <?php endif; ?>
      <form action="proses_login.php" method="POST">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" value="<?= e($username_cookie) ?>" required autofocus>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" name="remember" id="remember" <?= $username_cookie ? 'checked' : '' ?>>
          <label class="form-check-label" for="remember">Remember Me</label>
        </div>
        <button class="btn btn-primary w-100">Login</button>
      </form>
    </div>
  </div>
</body>
</html>
