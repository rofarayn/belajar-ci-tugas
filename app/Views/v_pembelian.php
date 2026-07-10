<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="pagetitle">
  <h1>Pembelian</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
      <li class="breadcrumb-item active">Pembelian</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">History Transaksi Pembelian</h5>

          <?php if (session()->getFlashData('success')) : ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <?= session()->getFlashData('success') ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
          <?php endif; ?>

          <div class="table-responsive">
              <table class="table datatable">
                  <thead>
                      <tr>
                          <th scope="col">#</th>
                          <th scope="col">ID Pembelian</th>
                          <th scope="col">Pembeli</th> <th scope="col">Waktu Pembelian</th>
                          <th scope="col">Total Bayar</th>
                          <th scope="col">Alamat</th>
                          <th scope="col">Status</th>
                          <th scope="col">Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                      if (!empty($transactions)) :
                          foreach ($transactions as $index => $item) :
                      ?>
                              <tr>
                                  <th scope="row"><?= $index + 1 ?></th>
                                  <td><?= $item['id'] ?></td>
                                  <td><?= $item['username'] ?></td> <td><?= $item['created_at'] ?></td>
                                  <td><?= number_to_currency($item['total_harga'], 'IDR') ?></td>
                                  <td><?= $item['alamat'] ?></td>
                                  <td>
                                      <?= ($item['status'] == "1")
                                          ? '<span class="badge bg-success">Sudah Selesai</span>'
                                          : '<span class="badge bg-warning text-dark">Belum Selesai</span>' ?>
                                  </td>
                                  <td>
                                      <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal-<?= $item['id'] ?>">
                                          Detail
                                      </button>
                                      <a href="<?= base_url('pembelian/status/' . $item['id']) ?>" class="btn btn-info btn-sm text-white">
                                          Ubah Status
                                      </a>
                                  </td>
                              </tr> 
                      <?php
                          endforeach;
                      endif;
                      ?>
                  </tbody>
              </table>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

<?php if (!empty($transactions)) : ?>
    <?php foreach ($transactions as $item) : ?>
        <div class="modal fade" id="detailModal-<?= $item['id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Transaksi #<?= $item['id'] ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body"> 
                        <?php if (!empty($products[$item['id']])) : ?>
                            <?php foreach ($products[$item['id']] as $index2 => $item2) : ?>
                                <?= $index2 + 1 . ")" ?>
                                
                                <?php
                                $imagePath = FCPATH . 'img/' . $item2['foto'];
                                if (!empty($item2['foto']) && file_exists($imagePath)) :
                                ?>
                                    <div class="my-2">
                                        <img src="<?= base_url('img/' . $item2['foto']) ?>" width="100" class="img-thumbnail">
                                    </div>
                                <?php endif; ?>

                                <strong><?= $item2['nama'] ?></strong>
                                
                                <?php 
                                    $hargaSatuan = $item2['subtotal_harga'] / $item2['jumlah']; 
                                ?>
                                
                                <?php if (isset($item2['diskon']) && $item2['diskon'] > 0): ?>
                                    <?php $hargaAsli = $hargaSatuan + $item2['diskon']; ?>
                                    <span class="text-danger" style="text-decoration: line-through; font-size: 12px;">
                                        (<?= number_to_currency($hargaAsli, 'IDR') ?>)
                                    </span>
                                    <span class="text-primary fw-bold ms-1">
                                        <?= number_to_currency($hargaSatuan, 'IDR') ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-primary fw-bold">
                                        <?= number_to_currency($hargaSatuan, 'IDR') ?>
                                    </span>
                                <?php endif; ?>
                                
                                <br>
                                <?= "(" . $item2['jumlah'] . " pcs)" ?><br>
                                <?= number_to_currency($item2['subtotal_harga'], 'IDR') ?>
                                <hr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        Ongkir <?= number_to_currency($item['ongkir'], 'IDR') ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection() ?>