<?php
$this->load->view('templates/header');
?>

<div class="container-fluid page-header py-5">
    <div class="container text-center">
        <h1 class="text-white display-6">Detail Produk</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="<?= site_url('beranda') ?>">Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?= site_url('shop') ?>">Belanja</a></li>
            <li class="breadcrumb-item active text-white">Detail Produk</li>
        </ol>
    </div>
</div>

<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <div class="row g-4">
            <!-- Main Image -->
            <div class="col-lg-5">
                <div class="border rounded-4 mb-4">
                    <img src="<?= site_url('uploads/' . ($product['gambar'] ?? 'default.jpg')) ?>" 
                         class="img-fluid rounded-4" 
                         style="object-fit: cover; height: 500px;"
                         alt="<?= htmlspecialchars($product['name'] ?? 'Produk Ternak') ?>">
                </div>
                <div class="row g-4">
                    <?php foreach($product['gambar_lain'] ?? [] as $gambar): ?>
                    <div class="col-3">
                        <div class="border rounded-2 p-1">
                            <img src="<?= site_url('uploads/' . $gambar) ?>" 
                                 class="img-fluid rounded-2" 
                                 style="object-fit: cover; height: 100px;"
                                 alt="Gallery Image">
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-lg-7">
                <div class="ps-lg-4">
                    <h2 class="mb-4"><?= htmlspecialchars($product['name'] ?? 'Produk Ternak', ENT_QUOTES, 'UTF-8') ?></h2>
                    <div class="d-flex align-items-center mb-4">
                        <h3 class="text-primary me-3">Rp <?= number_format($product['price'] ?? 0, 0, ',', '.') ?></h3>
                    </div>
                    
                    <div class="mb-4">
                        <h4 class="mb-3">Spesifikasi</h4>
                        <div class="row g-3">
                            <?php foreach(json_decode($product['spesifikasi'] ?? '[]', true) as $spec): ?>
                            <div class="col-6">
                                <div class="bg-light p-3 rounded">
                                    <span class="text-muted"><?= $spec['key'] ?>:</span>
                                    <span class="fw-bold"><?= $spec['value'] ?></span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h4 class="mb-3">Deskripsi</h4>
                        <p><?= nl2br(htmlspecialchars($product['deskripsi'] ?? 'Tidak ada deskripsi', ENT_QUOTES, 'UTF-8')) ?></p>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="input-group border rounded-pill">
                                <span class="input-group-text bg-transparent border-0">Qty</span>
                                <input type="number" class="form-control border-0" 
                                       name="quantity" value="1" min="1" 
                                       style="max-width: 80px">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <form action="<?= site_url('cart/add') ?>" method="post" class="d-grid gap-3">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <button type="submit" class="btn btn-primary rounded-pill w-100 py-3">
                                    <i class="fa fa-shopping-cart me-2"></i>Tambah ke Keranjang
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="mt-5">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                            <h5 class="mb-0">Lokasi Peternakan</h5>
                        </div>
                        <p class="mt-2"><?= htmlspecialchars($product['farm_address'] ?? 'Alamat peternakan tidak tersedia', ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <?php if(!empty($related_products)): ?>
        <div class="mt-5">
            <h3 class="mb-4">Produk Terkait</h3>
            <div class="row g-4">
                <?php foreach($related_products as $product): ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="rounded position-relative fruite-item h-100 shadow-sm">
                        <div class="fruite-img" style="aspect-ratio: 4/3;">
                            <a href="<?= site_url('shopdetail/'.$product['id']) ?>">
                                <img src="<?= site_url('uploads/' . ($product['gambar'] ?? 'default.jpg')) ?>" 
                                     class="img-fluid rounded-top" 
                                     style="object-fit: cover; height: 200px;"
                                     alt="<?= htmlspecialchars($product['name'] ?? 'Produk Ternak') ?>">
                            </a>
                        </div>
                        <div class="p-4">
                            <a href="<?= site_url('shopdetail/'.$product['id']) ?>" class="text-decoration-none">
                                <h5 class="text-dark mb-2"><?= htmlspecialchars($product['name'] ?? 'Produk Ternak', ENT_QUOTES, 'UTF-8') ?></h5>
                                <p class="mt-2 fw-bold">Rp <?= number_format($product['price'] ?? 0, 0, ',', '.') ?></p>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php
$this->load->view('templates/footer');
?>