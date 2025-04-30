<?php
// Load header template
$this->load->view('templates/header');
?>

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Belanja</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="<?= site_url('beranda') ?>">Beranda</a></li>
        <li class="breadcrumb-item active text-white">Belanja</li>
    </ol>
</div>
<!-- Single Page Header End -->

<!-- Fruits Shop Start -->
<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <h1 class="mb-4">Shop</h1>
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="mb-3">Filter Kategori</h5>
                        <div class="list-group list-group-flush">
                            <a href="<?= site_url('shop') ?>"
                                class="list-group-item list-group-item-action <?= !isset($_GET['category_id']) ? 'active' : '' ?>">
                                Semua Kategori
                            </a>
                            <?php foreach ($categories as $category): ?>
                                <a href="<?= site_url('shop?category_id=' . $category['id']) ?>" 
                                   class="list-group-item list-group-item-action <?= (isset($_GET['category_id']) && $_GET['category_id'] == $category['id']) ? 'active' : '' ?>">
                                    <?= htmlspecialchars($category['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Sidebar -->

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Search Bar -->
                <div class="row mb-4">
                    <div class="col-12">
                        <form method="get" action="<?= site_url('shop') ?>">
                            <div class="input-group border border-primary rounded-pill p-2">
                                <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                                    class="form-control border-0 rounded-pill" placeholder="Cari produk...">
                                <button type="submit" class="btn bg-white text-primary rounded-pill">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- End Search Bar -->

                <!-- Products -->
                <div class="row g-4">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="rounded position-relative fruite-item h-100 shadow-sm" style="border: 1px solid #ddd; min-height: 500px; transition: all 0.3s;">
                                    <div class="fruite-img" style="aspect-ratio: 4/3; background-color: #f8f9fa; overflow: hidden;">
                                        <!-- Add category box here -->
                                        <div class="position-absolute top-0 start-0 m-2">
                                            <span class="badge bg-primary bg-opacity-75 text-white rounded-pill px-3 py-2">
                                                <?= htmlspecialchars($product['category_name'] ?? 'Kategori', ENT_QUOTES, 'UTF-8') ?>
                                            </span>
                                        </div>
                                        <a href="<?= site_url('shopdetail/' . $product['id']) ?>">
                                            <img src="<?= site_url('uploads/' . ($product['gambar'] ?? 'default.jpg')) ?>"
                                                class="img-fluid w-100 rounded-top"
                                                style="object-fit: cover; height: 250px;"
                                                alt="<?= htmlspecialchars($product['name'] ?? 'Produk Ternak') ?>">
                                        </a>
                                    </div>
                                    <div class="p-4 d-flex flex-column justify-content-between" style="height: calc(100% - 250px);">
                                        <div>
                                            <a href="<?= site_url('shopdetail/' . $product['id']) ?>" class="text-decoration-none">
                                                <h5 class="text-dark mb-2"><?= htmlspecialchars($product['name'] ?? 'Produk Ternak', ENT_QUOTES, 'UTF-8') ?></h5>
                                            </a>
                                            <p class="mt-3 fs-5 fw-bold">Rp <?= number_format($product['price'] ?? 0, 0, ',', '.') ?></p>
                                            <small class="text-muted d-block mt-1">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                <?= htmlspecialchars($product['farm_address'] ?? 'Alamat peternakan tidak tersedia', ENT_QUOTES, 'UTF-8') ?>
                                            </small>
                                        </div>
                                        <div class="mt-3">
                                            <a href="<?= site_url('shopdetail/' . $product['id']) ?>"
                                                class="btn btn-outline-secondary rounded-pill w-100 mb-2">
                                                <i class="fa fa-eye me-2"></i>Detail
                                            </a>
                                            <form action="<?= site_url('cart/add') ?>" method="post">
                                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-primary rounded-pill w-100">
                                                    <i class="fa fa-shopping-cart me-2"></i>Keranjang
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <p class="text-center">Tidak ada produk tersedia.</p>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- End Products -->
            </div>
            <!-- End Main Content -->
        </div>
    </div>
</div>
<!-- Fruits Shop End -->

<?php
// Load footer template
$this->load->view('templates/footer');
?>