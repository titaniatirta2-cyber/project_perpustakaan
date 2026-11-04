<?php /* Layout atas: wajib set $judul_halaman sebelum include */ ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($judul_halaman) ?> | Mini Digital Library</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <style>
    body { background: #f3f4f8; }
    .navbar { background: linear-gradient(135deg, #4f46e5, #7c3aed); }
    .card { border: 0; border-radius: .9rem; }
    .thumb { width: 48px; height: 64px; object-fit: cover; border-radius: .4rem; }
    .thumb-kosong { width: 48px; height: 64px; border-radius: .4rem; background: #e5e7eb;
                    display: flex; align-items: center; justify-content: center; color: #9ca3af; }
  </style>
</head>
<body>
<nav class="navbar navbar-dark shadow-sm mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold" href="dashboard.php"><i class="bi bi-book-half me-2"></i>Mini Digital Library</a>
    <div class="d-flex align-items-center text-white">
      <span class="me-3 small d-none d-sm-inline"><i class="bi bi-person-circle me-1"></i><?= e($_SESSION['nama']) ?></span>
      <a href="logout.php" class="btn btn-sm btn-light"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
  </div>
</nav>
<div class="container pb-5">
<?php if (!empty($_SESSION['flash'])): [$tipe, $teks] = $_SESSION['flash']; unset($_SESSION['flash']); ?>
  <div class="alert alert-<?= $tipe ?> alert-dismissible fade show">
    <?= $teks ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>
