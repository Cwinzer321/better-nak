<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4"><?= $title ?></h1>

            <?php if (empty($kategori)): ?>
                <div class="alert alert-info">
                    Tidak ada kategori yang tersedia.
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($kategori as $item): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <?php if (!empty($item['icon'])): ?>
                                    <div class="card-img-top text-center p-3">
                                        <i class="<?= $item['icon'] ?> fa-3x text-primary"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?= $item['nama_kategori'] ?></h5>
                                    <?php if (!empty($item['deskripsi'])): ?>
                                        <p class="card-text"><?= $item['deskripsi'] ?></p>
                                    <?php endif; ?>
                                    <p class="card-text"><small class="text-muted">Jenis: <?= ucfirst($item['jenis']) ?></small></p>
                                </div>
                                <div class="card-footer">
                                    <a href="<?= base_url('products/by_category/' . $item['id']) ?>" class="btn btn-primary btn-sm">
                                        Lihat Produk
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>