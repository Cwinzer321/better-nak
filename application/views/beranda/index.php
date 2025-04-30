<?php
// Load header template
$this->load->view('templates/header');
?>

<!-- Hero Start -->
<div class="container-fluid py-5 mb-5 hero-header">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-7 mb-5 mb-lg-0">
                <h4 class="mb-4 text-secondary fs-3">★★★★★ 100% Ternak Berkualitas!</h4>
                <h1 class="display-3 text-primary mb-4">Jual Beli Ternak</h1>
                <p class="lead text-muted mb-4">Platform terpercaya untuk transaksi hewan ternak berkualitas</p>
                <div class="d-grid gap-3 d-sm-flex">
                    <a href="#products" class="btn btn-primary btn-lg px-5">Belanja Sekarang</a>
                    <a href="#features" class="btn btn-outline-secondary btn-lg px-5">Tentang Kami</a>
                </div>
            </div>
            <div class="col-lg-5">
                <div id="heroCarousel" class="carousel slide shadow-lg rounded-3 overflow-hidden" data-bs-ride="carousel" data-bs-interval="3000">
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active rounded">
                            <img src="<?= site_url('fruitables/') ?>img/kambing1.jpg" class="img-fluid w-100 h-100 bg-secondary rounded" alt="First slide">
                        </div>
                        <div class="carousel-item rounded">
                            <img src="<?= site_url('fruitables/') ?>img/sapi1.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                        </div>
                        <div class="carousel-item rounded">
                            <img src="<?= site_url('fruitables/') ?>img/domba-garut1.jpg" class="img-fluid w-100 h-100 rounded" alt="Third slide">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero End -->

<!-- Features Start -->
<div class="container-fluid featurs py-5" id="features">
    <div class="container py-5">
        <div class="row g-4">
            <?php
            $features = [
                ['icon' => 'fa-car-side', 'title' => 'Pengiriman Aman', 'desc' => 'Gratis untuk pembelian di atas Rp 3.000.000'],
                ['icon' => 'fa-user-shield', 'title' => 'Pembayaran Aman', 'desc' => '100% transaksi terjamin'],
                ['icon' => 'fa-exchange-alt', 'title' => 'Garansi 7 Hari', 'desc' => 'Jaminan hewan ternak sehat'],
                ['icon' => 'fa-phone-alt', 'title' => 'Layanan 24/7', 'desc' => 'Dukungan cepat setiap saat'],
            ];
            foreach ($features as $feature): ?>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-4 mx-auto">
                            <i class="fas <?= $feature['icon'] ?> fa-3x text-white"></i>
                        </div>
                        <h5><?= $feature['title'] ?></h5>
                        <p><?= $feature['desc'] ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!-- Features End -->

<!-- Products Start -->
<div class="container-fluid fruite py-5" id="products">
    <div class="container py-5">
        <div class="tab-class text-center">
            <div class="row g-4">
                <div class="col-lg-4 text-start">
                    <h1>Produk Ternak Kami</h1>
                </div>
                <div class="col-lg-8 text-end">
                    <ul class="nav nav-pills d-inline-flex text-center mb-5">
                        <?php
                        $tabs = [
                            ['id' => 'tab-1', 'label' => 'Semua Produk', 'active' => true],
                            ['id' => 'tab-2', 'label' => 'Sapi'],
                            ['id' => 'tab-3', 'label' => 'Kambing'],
                            ['id' => 'tab-4', 'label' => 'Domba'],
                        ];
                        foreach ($tabs as $tab): ?>
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill <?= isset($tab['active']) ? 'active' : '' ?>" data-bs-toggle="pill" href="#<?= $tab['id'] ?>">
                                    <span class="text-dark" style="width: 130px;"><?= $tab['label'] ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="tab-content">
                <div id="tab-1" class="tab-pane fade show p-0 active">
                    <div class="row g-4">
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="rounded position-relative fruite-item h-100">
                                        <div class="fruite-img" style="aspect-ratio: 4/3; background-color: #f8f9fa; overflow: hidden;">
                                            <img src="<?= site_url('uploads/' . ($product['image'] ?? 'default.jpg')) ?>" class="img-fluid w-100 rounded-top" alt="<?= htmlspecialchars($product['name'] ?? 'Produk') ?>" style="object-fit: cover;">
                                        </div>
                                        <div class="p-4">
                                            <h5><?= htmlspecialchars($product['name'] ?? '') ?></h5>
                                            <p>Harga Rp <?= number_format($product['price'] ?? 0, 0, ',', '.') ?></p>
                                            <small class="text-muted d-block mt-1">
                                                <i class="fas fa-map-marker-alt me-1"></i> <?= htmlspecialchars($product['farm_address'] ?? 'Alamat peternakan tidak tersedia') ?>
                                            </small>
                                            <div class="d-flex flex-wrap gap-2 mt-3">
                                                <a href="<?= site_url('products/detail/' . ($product['id'] ?? '')) ?>" class="btn btn-outline-secondary rounded-pill px-3">
                                                    <i class="fa fa-eye me-2"></i>Detail
                                                </a>
                                                <a href="<?= site_url('cart/add/' . ($product['id'] ?? '')) ?>" class="btn btn-primary rounded-pill px-3">
                                                    <i class="fa fa-shopping-cart me-2"></i>Keranjang
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12 text-center py-5">
                                <h3>Tidak ada produk tersedia saat ini</h3>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Products End -->

<!-- Banner Section Start -->
<div class="container-fluid banner bg-secondary my-5">
    <div class="container py-5">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <div class="py-4">
                    <h1 class="display-3 text-white">Hewan Sehat<br>Peternak Hebat</h1>
                    <p class="fw-normal display-3 text-dark mb-4">Di marketplace kami</p>
                    <p class="mb-4 text-dark">Dari peternakan hebat, untuk keluarga sehat!</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="<?= site_url('fruitables/') ?>img/sapi.png" class="img-fluid w-100 rounded" alt="Banner Sapi">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Banner Section End -->

<!-- Footer Start -->
<?php $this->load->view('templates/footer'); ?>
<!-- Footer End -->