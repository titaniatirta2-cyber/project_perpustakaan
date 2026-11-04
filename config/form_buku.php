<?php
/* Form bersama. Variabel: $aksi (url proses), $b (data buku/array kosong), $judul_form */
$b = $b + ['id' => '', 'judul' => '', 'kategori' => '', 'penulis' => '', 'tahun_terbit' => '', 'stok' => 1, 'sampul' => null];
$kategori_list = ['Teknologi', 'Sistem Informasi', 'Bisnis', 'Sains', 'Sastra', 'Agama', 'Lainnya'];
?>
<div class="card shadow-sm mx-auto" style="max-width: 720px;">
  <div class="card-body p-4">
    <h5 class="fw-bold mb-4"><?= e($judul_form) ?></h5>
    <form action="<?= $aksi ?>" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
      <input type="hidden" name="id" value="<?= e($b['id']) ?>">
      <div class="mb-3">
        <label class="form-label">Judul Buku</label>
        <input type="text" name="judul" class="form-control" value="<?= e($b['judul']) ?>" required>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Kategori</label>
          <select name="kategori" class="form-select" required>
            <?php foreach ($kategori_list as $k): ?>
              <option <?= $b['kategori'] === $k ? 'selected' : '' ?>><?= $k ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Penulis</label>
          <input type="text" name="penulis" class="form-control" value="<?= e($b['penulis']) ?>" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Tahun Terbit</label>
          <input type="number" name="tahun" class="form-control" min="1900" max="<?= date('Y') ?>" value="<?= e($b['tahun_terbit']) ?>" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Stok <small class="text-muted">(0 = Dipinjam)</small></label>
          <input type="number" name="stok" class="form-control" min="0" value="<?= e($b['stok']) ?>" required>
        </div>
      </div>
      <div class="mb-4">
        <label class="form-label">Sampul Buku <small class="text-muted">(.jpg/.png, maks 2MB)</small></label>
        <?php if ($b['sampul'] && is_file('uploads/' . $b['sampul'])): ?>
          <div class="mb-2"><img src="uploads/<?= e($b['sampul']) ?>" style="height:120px;border-radius:.5rem" alt="Sampul saat ini">
          <div class="form-text">Kosongkan input jika tidak ingin mengganti sampul.</div></div>
        <?php endif; ?>
        <input type="file" name="sampul" class="form-control" accept=".jpg,.jpeg,.png" id="inputSampul">
        <img id="preview" class="mt-2 d-none" style="height:120px;border-radius:.5rem" alt="Preview">
      </div>
      <div class="d-flex gap-2">
        <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
        <a href="dashboard.php" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>
<script>
  // Preview gambar sebelum diupload
  document.getElementById('inputSampul').addEventListener('change', function () {
    const img = document.getElementById('preview');
    if (this.files[0]) { img.src = URL.createObjectURL(this.files[0]); img.classList.remove('d-none'); }
    else { img.classList.add('d-none'); }
  });
</script>
