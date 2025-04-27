<?php
// Load header template
$this->load->view('templates/header');
?>

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Shop</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="<?= site_url('beranda') ?>">Home</a></li>
        <li class="breadcrumb-item active text-white">Shop</li>
    </ol>
</div>
<!-- Single Page Header End -->

<!-- Fruits Shop Start -->
<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <h1 class="mb-4">Shop</h1>
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="row g-4">
                    <!-- Search Bar -->
                    <div class="row justify-content-center py-3">
                        <div class="col-lg-8">
                            <div class="input-group border border-primary rounded-pill p-1" style="min-height: 60px;">
                                <input type="search" class="form-control form-control-lg border-0 rounded-pill h-100" placeholder="Keywords..." aria-describedby="search-icon">
                                <span class="input-group-text bg-transparent border-0 col-auto pe-4 ps-3 text-primary"><i class="fa fa-search fs-5"></i></span>
                            </div>
                        </div>
                    </div>
                    <!-- End Search Bar -->
                </div>

                <div class="row g-4">
                    <!-- Sidebar -->
                    <div class="col-lg-3">
                        <div class="row g-4">
                          
                        </div>
                    </div>
                    <!-- End Sidebar -->

                    <!-- Products -->
                    <div class="col-lg-9">
                        <div class="row g-4 justify-content-center">
                            <?php if (!empty($products)): ?>
                                <?php $i = 0; foreach ($products as $product): ?>
                                    <?php if ($i % 4 == 0): ?>
                                        <?php if ($i > 0): ?></div><?php endif; ?>
                                        <div class="row g-4 mb-3">
                                    <?php endif; ?>
                                    <div class="col-md-6 col-lg-6 col-xl-3">
                                        <div class="rounded position-relative fruite-item h-100" data-category="<?= $product['id_kategori'] ?? '' ?>">
                                            <div class="fruite-img">
                                                <a href="<?= site_url('shopdetail/'.$product['id']) ?>">
                                                    <img src="<?= site_url('uploads/' . ($product['gambar'] ?? 'default.jpg')) ?>" 
                                                         class="img-fluid w-100 rounded-top" 
                                                         style="height: 200px; object-fit: cover" 
                                                         alt="<?= htmlspecialchars($product['name']) ?>">
                                                </a>
                                            </div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom d-flex flex-column" style="min-height: 200px;">
                                                <a href="<?= site_url('shopdetail/'.$product['id']) ?>">
                                                    <h4><?= htmlspecialchars($product['nama_produk'] ?? '', ENT_QUOTES, 'UTF-8') ?></h4>
                                                </a>
                                                <p><?= htmlspecialchars($product['deskripsi'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0">Rp<?= number_format($product['harga'] ?? 0, 0, ',', '.') ?></p>
                                                    <div class="d-flex gap-2">
                                                        <a href="<?= site_url('shopdetail/'.$product['id']) ?>" 
                                                           class="btn btn-outline-secondary rounded-pill btn-sm px-3 py-2">
                                                            <i class="fa fa-eye me-1"></i>Detail
                                                        </a>
                                                        <form action="<?= site_url('cart/add') ?>" method="post">
                                                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                                            <input type="hidden" name="quantity" value="1">
                                                            <button type="submit" class="btn btn-primary rounded-pill btn-sm px-3 py-2">
                                                                <i class="fa fa-shopping-cart me-1"></i>Cart
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p class="text-center">Tidak ada produk tersedia.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- End Products -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fruits Shop End -->

<?php
// Load footer template
$this->load->view('templates/footer');
?>
