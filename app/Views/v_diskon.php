<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="pagetitle">
  <h1>Diskon</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
      <li class="breadcrumb-item active">Diskon</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Diskon</h5>

          <?php if (session()->getFlashdata('errors')) : ?>
              <div class="alert alert-danger alert-dismissible fade show" style="background-color: #f8d7da; color: #842029; border: none;">
                  <ul class="mb-0">
                  <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                      <li><?= esc($error) ?></li>
                  <?php endforeach ?>
                  </ul>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
          <?php endif ?>

          <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahModal">
            Tambah Data
          </button>

          <table class="table datatable">
            <thead>
              <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Nominal</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach($daftar_diskon as $d): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= $d['tanggal'] ?></td>
                <td><?= $d['nominal'] ?></td>
                <td>
                  <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $d['id'] ?>">Ubah</button>
                  <a href="<?= base_url('diskon/delete/'.$d['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                </td>
              </tr>

              <div class="modal fade" id="editModal<?= $d['id'] ?>" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Edit Data</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?= base_url('diskon/edit/'.$d['id']) ?>" method="POST">
                        <div class="modal-body">
                          <div class="mb-3">
                              <label>Tanggal</label>
                              <input type="date" name="tanggal" value="<?= $d['tanggal'] ?>" class="form-control" readonly>
                          </div>
                          <div class="mb-3">
                              <label>Nominal</label>
                              <input type="number" name="nominal" value="<?= $d['nominal'] ?>" class="form-control" required>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="tambahModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?= base_url('diskon') ?>" method="POST">
          <div class="modal-body">
            <div class="mb-3">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Nominal</label>
                <input type="number" name="nominal" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>