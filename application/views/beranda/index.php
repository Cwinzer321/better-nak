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
            <div class="col-md-6 col-lg-3">
                <div class="featurs-item text-center rounded bg-light p-4">
                    <div class="featurs-icon btn-square rounded-circle bg-secondary mb-4 mx-auto">
                        <i class="fas fa-car-side fa-3x text-white"></i>
                    </div>
                    <h5>Pengiriman Aman</h5>
                    <p>Gratis untuk pembelian di atas Rp 3.000.000</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="featurs-item text-center rounded bg-light p-4">
                    <div class="featurs-icon btn-square rounded-circle bg-secondary mb-4 mx-auto">
                        <i class="fas fa-user-shield fa-3x text-white"></i>
                    </div>
                    <h5>Pembayaran Aman</h5>
                    <p>100% transaksi terjamin</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="featurs-item text-center rounded bg-light p-4">
                    <div class="featurs-icon btn-square rounded-circle bg-secondary mb-4 mx-auto">
                        <i class="fas fa-exchange-alt fa-3x text-white"></i>
                    </div>
                    <h5>Garansi 7 Hari</h5>
                    <p>Jaminan hewan ternak sehat</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="featurs-item text-center rounded bg-light p-4">
                    <div class="featurs-icon btn-square rounded-circle bg-secondary mb-4 mx-auto">
                        <i class="fa fa-phone-alt fa-3x text-white"></i>
                    </div>
                    <h5>Layanan 24/7</h5>
                    <p>Dukungan cepat setiap saat</p>
                </div>
            </div>
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
                        <li class="nav-item">
                            <a class="d-flex m-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill" href="#tab-1">
                                <span class="text-dark" style="width: 130px;">Semua Produk</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-2">
                                <span class="text-dark" style="width: 130px;">Sapi</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-3">
                                <span class="text-dark" style="width: 130px;">Kambing</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-4">
                                <span class="text-dark" style="width: 130px;">Domba</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="tab-content">
                <div id="tab-1" class="tab-pane fade show p-0 active">
                    <div class="row g-4">
                        <?php
                        // Remove this line: $this->load->model('Produk_model');
                        // Remove this line: $products = $this->Produk_model->getProducts();
                        if (!empty($products)):
                        ?>
                        <?php foreach($products as $product): ?>
                        ?>
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="rounded position-relative fruite-item h-100">
                                    <div class="fruite-img" style="aspect-ratio: 4/3; background-color: #f8f9fa; overflow: hidden;">
                                        <img src="<?= site_url('uploads/' . ($product['image'] ?? 'default.jpg')) ?>" class="img-fluid w-100 rounded-top" alt="<?= $product['name'] ?? 'Produk' ?>" style="object-fit: cover;">
                                    </div>
                                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">
                                        Rp <?= number_format($product['price'] ?? 0, 0, ',', '.') ?>
                                    </div>
                                    <div class="p-4">
                                        <h5><?= htmlspecialchars($product['name'] ?? '', ENT_QUOTES, 'UTF-8') ?></h5>
                                        <div class="d-flex justify-content-between mt-3">
                                            <a href="<?= site_url('produk/detail/' . ($product['id'] ?? '')) ?>" class="btn btn-outline-secondary rounded-pill px-3">
                                                <i class="fa fa-eye me-2"></i>Lihat Detail
                                            </a>
                                            <a href="<?= site_url('cart/add/' . ($product['id'] ?? '')) ?>" class="btn btn-primary rounded-pill px-3">
                                                <i class="fa fa-shopping-cart me-2"></i>Tambah
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                            endforeach;
                        else:
                        ?>
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
                    <h1 class="display-3 text-white">Hewan Sehat <br> Wal A'fiat</h1>
                    <p class="fw-normal display-3 text-dark mb-4">Di marketplace kami</p>
                    <p class="mb-4 text-dark">Dari peternakan terbaik, untuk keluarga sehat!</p>
                    <a href="#products" class="banner-btn btn border-2 border-white rounded-pill text-dark py-3 px-5">Belanja Sekarang</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="<?= site_url('fruitables/') ?>img/baner-1.png" class="img-fluid w-100 rounded" alt="">
                    <div class="d-flex align-items-center justify-content-center bg-white rounded-circle position-absolute" style="width: 140px; height: 140px; top: 0; left: 0;">
                        <h1 style="font-size: 80px;" class="text-primary">1</h1>
                        <div class="d-flex flex-column">
                            <span class="h4 mb-0">50$</span>
                            <span class="text-muted mb-0">/kg</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Banner Section End -->

<!-- Footer Start -->
<?php $this->load->view('templates/footer'); ?>
<!-- Footer End -->
