<?php
require 'config/auth.php';
require 'config/koneksi.php';
require 'config/fungsi.php';

$judul_halaman = 'Dashboard';
$cari = trim($_GET['cari'] ?? '');

// Read: ambil data buku (dengan pencarian opsional)
$like = "%$cari%";
$stmt = $conn->prepare('SELECT * FROM buku WHERE judul LIKE ? OR penulis LIKE ? OR kategori LIKE ? ORDER BY id DESC');
$stmt->bind_param('sss', $like, $like, $like);
$stmt->execute();
$buku = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$total = $conn->query('SELECT COUNT(*) c FROM buku')->fetch_assoc()['c'];
$tersedia = $conn->query('SELECT COUNT(*) c FROM buku WHERE stok > 0')->fetch_assoc()['c'];
$dipinjam = $total - $tersedia;

include 'config/header.php';
?>
<div class="row g-3 mb-4">
  <?php foreach ([['Total Buku', $total, 'primary', 'collection'], ['Tersedia', $tersedia, 'success', 'check-circle'], ['Dipinjam', $dipinjam, 'danger', 'clock-history']] as [$t, $n, $w, $i]): ?>
  <div class="col-12 col-md-4">
    <div class="card shadow-sm"><div class="card-body d-flex align-items-center">
      <i class="bi bi-<?= $i ?> fs-1 text-<?= $w ?> me-3"></i>
      <div><div class="text-muted small"><?= $t ?></div><div class="fs-3 fw-bold"><?= $n ?></div></div>
    </div></div>
  </div>
  <?php endforeach; ?>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
      <h5 class="fw-bold mb-0">Data Buku</h5>
      <div class="d-flex gap-2">
        <form class="d-flex" method="GET">
          <input type="text" name="cari" class="form-control form-control-sm" placeholder="Cari judul/penulis..." value="<?= e($cari) ?>">
          <button class="btn btn-sm btn-outline-primary ms-1"><i class="bi bi-search"></i></button>
        </form>
        <a href="tambah_buku.php" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg"></i> Tambah Buku</a>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr><th>No</th><th>Sampul</th><th>Judul</th><th>Kategori</th><th>Penulis</th><th>Tahun</th><th>Stok</th><th>Status</th><th class="text-center">Aksi</th></tr>
        </thead>
        <tbody>
        <?php if (!$buku): ?>
          <tr><td colspan="9" class="text-center text-muted py-4">Belum ada data buku.</td></tr>
        <?php endif; ?>
        <?php foreach ($buku as $no => $b): [$label, $warna] = label_status((int)$b['stok']); ?>
          <tr>
            <td><?= $no + 1 ?></td>
            <td>
              <?php if ($b['sampul'] && is_file('uploads/' . $b['sampul'])): ?>
                <img src="uploads/<?= e($b['sampul']) ?>" class="thumb" alt="Sampul">
              <?php else: ?>
                <div class="thumb-kosong"><i class="bi bi-image"></i></div>
              <?php endif; ?>
            </td>
            <td class="fw-semibold"><?= e($b['judul']) ?></td>
            <td><?= e($b['kategori']) ?></td>
            <td><?= e($b['penulis']) ?></td>
            <td><?= e($b['tahun_terbit']) ?></td>
            <td><?= (int)$b['stok'] ?></td>
            <td><span class="badge text-bg-<?= $warna ?>"><?= $label ?></span></td>
            <td class="text-center text-nowrap">
              <a href="edit_buku.php?id=<?= $b['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
              <form action="hapus_buku.php" method="POST" class="d-inline" onsubmit="return confirm('Hapus buku ini beserta sampulnya?')">
                <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                <input type="hidden" name="id" value="<?= $b['id'] ?>">
                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php include 'config/footer.php'; ?>
