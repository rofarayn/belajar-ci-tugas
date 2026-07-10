<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<?php
if (session()->getFlashData('success')) {
?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
?>
<div class="row">
    <?php foreach ($products as $key => $item) : ?>
        <?php 
            // LOGIKA DISKON: Tentukan harga akhir yang akan masuk ke keranjang
            $hargaAkhir = $item['harga'];
            if (isset($diskon) && $diskon > 0) {
                $hargaAkhir = $item['harga'] - $diskon;
            }
        ?>
        <div class="col-lg-6">
            <?= form_open('keranjang') ?>
            
            <?= form_hidden([
                'id'    => $item['id'],
                'nama'  => $item['nama'],
                'harga' => $hargaAkhir, 
                'foto'  => $item['foto']
            ]) ?>

            <div class="card">
                <div class="card-body">
                    <img src="<?= base_url() . "img/" . $item['foto'] ?>" alt="..." width="50%">
                    
                    <h5 class="card-title">
                        <?= $item['nama'] ?><br>
                        
                        <?php if (isset($diskon) && $diskon > 0): ?>
                            <span class="text-danger" style="text-decoration: line-through; font-size: 14px;">
                                <?= number_to_currency($item['harga'], 'IDR') ?>
                            </span>
                            <span class="text-primary fw-bold ms-2">
                                <?= number_to_currency($hargaAkhir, 'IDR') ?>
                            </span>
                        <?php else: ?>
                            <span class="text-primary fw-bold">
                                <?= number_to_currency($item['harga'], 'IDR') ?>
                            </span>
                        <?php endif; ?>
                    </h5>
                    
                    <button type="submit" class="btn btn-info rounded-pill">Beli</button>
                </div>
            </div>

            <?= form_close() ?>
        </div>
    <?php endforeach ?>
</div>
<?= $this->endSection() ?>