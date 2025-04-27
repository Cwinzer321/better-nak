<?php
// Load header template
$this->load->view('templates/header');
?>


<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Shop Detail</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="<?= site_url('beranda') ?>">Home</a></li>
        <li class="breadcrumb-item active text-white">Shop Detail</li>
    </ol>
</div>
<!-- Single Page Header End -->

<!-- Single Product Start -->
<?php
// Add this at the very top of the file
if (!isset($product)) {
    echo '<div class="alert alert-danger">Product not found</div>';
    exit();
}
?>

<div class="container-fluid py-5 mt-5">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="input-group border border-primary rounded-pill p-1">
                    <input type="number" class="form-control border-0 rounded-pill" value="1" min="1">
                    <a href="<?= site_url('cart/add/' . $product['id']) ?>" class="btn border-secondary rounded-pill px-4 py-3 text-primary fw-bold">
                        <i class="fa fa-shopping-bag me-2"></i>Tambahkan ke Keranjang
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-xl-9">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="input-group border border-primary rounded-pill p-1">
                        <input type="number" class="form-control border-0 rounded-pill" value="1" min="1">
                        <a href="<?= site_url('cart/add/' . $product['id']) ?>" class="btn border-secondary rounded-pill px-4 py-3 text-primary fw-bold">
                            <i class="fa fa-shopping-bag me-2"></i>Tambahkan ke Keranjang
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="border rounded position-relative">
                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"><?= htmlspecialchars($product['kategori'] ?? 'Produk') ?></div>
                    <img src="<?= base_url('uploads/produk/' . ($product['gambar'] ?? 'default.jpg')) ?>"
                        class="img-fluid rounded-top"
                        alt="<?= htmlspecialchars($product['nama_produk'] ?? '-') ?>">
                    alt="<?= htmlspecialchars($product['nama_produk'] ?? 'Product Image') ?>">
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <h4 class="fw-bold mb-3"><?= htmlspecialchars($product['nama_produk'] ?? 'Nama Produk') ?></h4>
                <p class="mb-3">Kategori: <?= htmlspecialchars($product['nama_kategori'] ?? 'Umum') ?></p>
                <h4 class="fw-bold mb-3">Rp <?= isset($product['harga']) ? number_format($product['harga'], 0, ',', '.') : '0' ?></h4>

                <!-- Add to Cart Form -->
                <form action="<?= site_url('cart/add') ?>" method="POST">
                    <input type="hidden" name="product_id" value="<?= $product['id_produk'] ?>">
                    <div class="input-group quantity mb-5" style="width: 100px;">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-sm btn-minus rounded-circle bg-light border">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input type="number" class="form-control form-control-sm text-center border-0"
                            name="quantity" value="1" min="1" max="<?= $product['stok'] ?? 0 ?>">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-sm btn-plus rounded-circle bg-light border">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary">
                        <i class="fa fa-shopping-bag me-2 text-primary"></i> Tambah ke Keranjang
                    </button>
                </form>
            </div>
            <div class="col-lg-12">
                <nav>
                    <div class="nav nav-tabs mb-3">
                        <button class="nav-link active border-white border-bottom-0" type="button"
                            id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                            aria-controls="nav-about" aria-selected="true">Deskripsi</button>
                    </div>
                </nav>
                <div class="tab-content mb-5">
                    <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                        <h3 class="mb-4"><?= htmlspecialchars($product['nama_produk'] ?? '-') ?></h3>
                        <p class="mb-4"><?= nl2br(htmlspecialchars($product['deskripsi'] ?? '')) ?></p>
                        <div class="px-2">
                            <div class="row g-4">
                                <div class="col-6">
                                    <div class="row bg-light align-items-center text-center justify-content-center py-2">
                                        <div class="col-6">
                                            <p class="mb-0">Berat</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="mb-0"><?= $product['berat'] ?? 0 ?> kg</p>
                                        </div>
                                    </div>
                                    <div class="row text-center align-items-center justify-content-center py-2">
                                        <div class="col-6">
                                            <p class="mb-0">Stok Tersedia</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="mb-0"><?= $product['stok'] ?? 0 ?></p>
                                        </div>
                                    </div>
                                    <div class="row bg-light text-center align-items-center justify-content-center py-2">
                                        <div class="col-6">
                                            <p class="mb-0">Jenis Produk</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="mb-0"><?= $product['jenis_produk'] ?? '' ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-xl-3">
        <div class="row g-4 fruite">
            <div class="col-lg-12">
                <div class="input-group w-100 mx-auto d-flex mb-4">
                    <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                    <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                </div>
                <div class="mb-4">
                    <h4>Categories</h4>
                    <ul class="list-unstyled fruite-categorie">
                        <li>
                            <div class="d-flex justify-content-between fruite-name">
                                <a href="#"><i class="fas fa-apple-alt me-2"></i>Apples</a>
                                <span>(3)</span>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex justify-content-between fruite-name">
                                <a href="#"><i class="fas fa-apple-alt me-2"></i>Oranges</a>
                                <span>(5)</span>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex justify-content-between fruite-name">
                                <a href="#"><i class="fas fa-apple-alt me-2"></i>Strawbery</a>
                                <span>(2)</span>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex justify-content-between fruite-name">
                                <a href="#"><i class="fas fa-apple-alt me-2"></i>Banana</a>
                                <span>(8)</span>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex justify-content-between fruite-name">
                                <a href="#"><i class="fas fa-apple-alt me-2"></i>Pumpkin</a>
                                <span>(5)</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-12">
                <h4 class="mb-4">Featured products</h4>
                <div class="d-flex align-items-center justify-content-start">
                    <div class="rounded" style="width: 100px; height: 100px;">
                        <img src="img/featur-1.jpg" class="img-fluid rounded" alt="Image">
                    </div>
                    <div>
                        <h6 class="mb-2">Big Banana</h6>
                        <div class="d-flex mb-2">
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="d-flex mb-2">
                            <h5 class="fw-bold me-2">2.99 $</h5>
                            <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-start">
                    <div class="rounded" style="width: 100px; height: 100px;">
                        <img src="img/featur-2.jpg" class="img-fluid rounded" alt="">
                    </div>
                    <div>
                        <h6 class="mb-2">Big Banana</h6>
                        <div class="d-flex mb-2">
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="d-flex mb-2">
                            <h5 class="fw-bold me-2">2.99 $</h5>
                            <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-start">
                    <div class="rounded" style="width: 100px; height: 100px;">
                        <img src="img/featur-3.jpg" class="img-fluid rounded" alt="">
                    </div>
                    <div>
                        <h6 class="mb-2">Big Banana</h6>
                        <div class="d-flex mb-2">
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="d-flex mb-2">
                            <h5 class="fw-bold me-2">2.99 $</h5>
                            <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-start">
                    <div class="rounded me-4" style="width: 100px; height: 100px;">
                        <img src="img/vegetable-item-4.jpg" class="img-fluid rounded" alt="">
                    </div>
                    <div>
                        <h6 class="mb-2">Big Banana</h6>
                        <div class="d-flex mb-2">
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="d-flex mb-2">
                            <h5 class="fw-bold me-2">2.99 $</h5>
                            <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-start">
                    <div class="rounded me-4" style="width: 100px; height: 100px;">
                        <img src="img/vegetable-item-5.jpg" class="img-fluid rounded" alt="">
                    </div>
                    <div>
                        <h6 class="mb-2">Big Banana</h6>
                        <div class="d-flex mb-2">
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="d-flex mb-2">
                            <h5 class="fw-bold me-2">2.99 $</h5>
                            <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-start">
                    <div class="rounded me-4" style="width: 100px; height: 100px;">
                        <img src="img/vegetable-item-6.jpg" class="img-fluid rounded" alt="">
                    </div>
                    <div>
                        <h6 class="mb-2">Big Banana</h6>
                        <div class="d-flex mb-2">
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="d-flex mb-2">
                            <h5 class="fw-bold me-2">2.99 $</h5>
                            <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center my-4">
                    <a href="#" class="btn border border-secondary px-4 py-3 rounded-pill text-primary w-100">Vew More</a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="position-relative">
                    <img src="img/banner-fruits.jpg" class="img-fluid w-100 rounded" alt="">
                    <div class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);">
                        <h3 class="text-secondary fw-bold">Fresh <br> Fruits <br> Banner</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<h1 class="fw-bold mb-0">Related products</h1>
<div class="vesitable">
    <div class="owl-carousel vegetable-carousel justify-content-center">
        <div class="border border-primary rounded position-relative vesitable-item">
            <div class="vesitable-img">
                <img src="img/vegetable-item-6.jpg" class="img-fluid w-100 rounded-top" alt="">
            </div>
            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
            <div class="p-4 pb-0 rounded-bottom">
                <h4>Parsely</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                <div class="d-flex justify-content-between flex-lg-wrap">
                    <p class="text-dark fs-5 fw-bold">$4.99 / kg</p>
                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                </div>
            </div>
        </div>
        <div class="border border-primary rounded position-relative vesitable-item">
            <div class="vesitable-img">
                <img src="img/vegetable-item-1.jpg" class="img-fluid w-100 rounded-top" alt="">
            </div>
            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
            <div class="p-4 pb-0 rounded-bottom">
                <h4>Parsely</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                <div class="d-flex justify-content-between flex-lg-wrap">
                    <p class="text-dark fs-5 fw-bold">$4.99 / kg</p>
                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                </div>
            </div>
        </div>
        <div class="border border-primary rounded position-relative vesitable-item">
            <div class="vesitable-img">
                <img src="img/vegetable-item-3.png" class="img-fluid w-100 rounded-top bg-light" alt="">
            </div>
            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
            <div class="p-4 pb-0 rounded-bottom">
                <h4>Banana</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                <div class="d-flex justify-content-between flex-lg-wrap">
                    <p class="text-dark fs-5 fw-bold">$7.99 / kg</p>
                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                </div>
            </div>
        </div>
        <div class="border border-primary rounded position-relative vesitable-item">
            <div class="vesitable-img">
                <img src="img/vegetable-item-4.jpg" class="img-fluid w-100 rounded-top" alt="">
            </div>
            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
            <div class="p-4 pb-0 rounded-bottom">
                <h4>Bell Papper</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                <div class="d-flex justify-content-between flex-lg-wrap">
                    <p class="text-dark fs-5 fw-bold">$7.99 / kg</p>
                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                </div>
            </div>
        </div>
        <div class="border border-primary rounded position-relative vesitable-item">
            <div class="vesitable-img">
                <img src="img/vegetable-item-5.jpg" class="img-fluid w-100 rounded-top" alt="">
            </div>
            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
            <div class="p-4 pb-0 rounded-bottom">
                <h4>Potatoes</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                <div class="d-flex justify-content-between flex-lg-wrap">
                    <p class="text-dark fs-5 fw-bold">$7.99 / kg</p>
                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                </div>
            </div>
        </div>
        <div class="border border-primary rounded position-relative vesitable-item">
            <div class="vesitable-img">
                <img src="img/vegetable-item-6.jpg" class="img-fluid w-100 rounded-top" alt="">
            </div>
            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
            <div class="p-4 pb-0 rounded-bottom">
                <h4>Parsely</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                <div class="d-flex justify-content-between flex-lg-wrap">
                    <p class="text-dark fs-5 fw-bold">$7.99 / kg</p>
                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                </div>
            </div>
        </div>
        <div class="border border-primary rounded position-relative vesitable-item">
            <div class="vesitable-img">
                <img src="img/vegetable-item-5.jpg" class="img-fluid w-100 rounded-top" alt="">
            </div>
            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
            <div class="p-4 pb-0 rounded-bottom">
                <h4>Potatoes</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                <div class="d-flex justify-content-between flex-lg-wrap">
                    <p class="text-dark fs-5 fw-bold">$7.99 / kg</p>
                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                </div>
            </div>
        </div>
        <div class="border border-primary rounded position-relative vesitable-item">
            <div class="vesitable-img">
                <img src="img/vegetable-item-6.jpg" class="img-fluid w-100 rounded-top" alt="">
            </div>
            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
            <div class="p-4 pb-0 rounded-bottom">
                <h4>Parsely</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                <div class="d-flex justify-content-between flex-lg-wrap">
                    <p class="text-dark fs-5 fw-bold">$7.99 / kg</p>
                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                </div>
            </div>
        </div>
        <div class="border border-primary rounded position-relative vesitable-item">
            <div class="vesitable-img">
                <img src="img/vegetable-item-5.jpg" class="img-fluid w-100 rounded-top" alt="">
            </div>
            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
            <div class="p-4 pb-0 rounded-bottom">
                <h4>Potatoes</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                <div class="d-flex justify-content-between flex-lg-wrap">
                    <p class="text-dark fs-5 fw-bold">$7.99 / kg</p>
                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                </div>
            </div>
        </div>
        <div class="border border-primary rounded position-relative vesitable-item">
            <div class="vesitable-img">
                <img src="img/vegetable-item-6.jpg" class="img-fluid w-100 rounded-top" alt="">
            </div>
            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
            <div class="p-4 pb-0 rounded-bottom">
                <h4>Parsely</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                <div class="d-flex justify-content-between flex-lg-wrap">
                    <p class="text-dark fs-5 fw-bold">$7.99 / kg</p>
                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                </div>
            </div>
        </div>
        <div class="border border-primary rounded position-relative vesitable-item">
            <div class="vesitable-img">
                <img src="img/vegetable-item-5.jpg" class="img-fluid w-100 rounded-top" alt="">
            </div>
            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
            <div class="p-4 pb-0 rounded-bottom">
                <h4>Potatoes</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                <div class="d-flex justify-content-between flex-lg-wrap">
                    <p class="text-dark fs-5 fw-bold">$7.99 / kg</p>
                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                </div>
            </div>
        </div>
        <div class="border border-primary rounded position-relative vesitable-item">
            <div class="vesitable-img">
                <img src="img/vegetable-item-6.jpg" class="img-fluid w-100 rounded-top" alt="">
            </div>
            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
            <div class="p-4 pb-0 rounded-bottom">
                <h4>Parsely</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                <div class="d-flex justify-content-between flex-lg-wrap">
                    <p class="text-dark fs-5 fw-bold">$7.99 / kg</p>
                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<!-- Single Product End -->


<!-- Footer Start -->
<div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
    <div class="container py-5">
        <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5);">
            <div class="row g-4">
                <div class="col-lg-3">
                    <a href="<?= base_url() ?>">
                        <h1 class="text-primary mb-0">Better-nak</h1>
                        <p class="text-secondary mb-0">Solusi Ternak Berkualitas</p>
                    </a>
                </div>
                <div class="col-lg-3">
                    <div class="d-flex justify-content-end pt-3">
                        <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-whatsapp"></i></a>
                        <a class="btn btn-outline-secondary btn-md-square rounded-circle" href=""><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-5">
            <!-- <div class="col-lg-3 col-md-6">
                <div class="footer-item">
                    <h4 class="text-light mb-3">Tentang Kami</h4>
                    <p class="mb-4">Better-nak adalah platform jual beli ternak online yang menghubungkan peternak langsung dengan pembeli, menjamin kualitas dan keaslian produk ternak.</p>
                    <a href="<?= site_url('about') ?>" class="btn border-secondary py-2 px-4 rounded-pill text-primary">Selengkapnya</a>
                </div>
            </div> -->
            <div class="col-lg-3 col-md-6">
                <div class="d-flex flex-column text-start footer-item">
                    <h4 class="text-light mb-3">Navigasi</h4>
                    <a class="btn-link" href="<?= site_url() ?>">Beranda</a>
                    <a class="btn-link" href="<?= site_url('shop') ?>">Produk Ternak</a>
                    <!-- <a class="btn-link" href="<?= site_url('blog') ?>">Artikel Peternakan</a>
                    <a class="btn-link" href="<?= site_url('tips') ?>">Tips Beternak</a>
                    <a class="btn-link" href="<?= site_url('faq') ?>">Pertanyaan Umum</a> -->
                    <a class="btn-link" href="<?= site_url('contact') ?>">Contact Us</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="d-flex flex-column text-start footer-item">
                    <h4 class="text-light mb-3">Akun Saya</h4>
                    <a class="btn-link" href="<?= site_url('auth') ?>">Masuk/Daftar</a>
                    <a class="btn-link" href="<?= site_url('cart') ?>">Keranjang Belanja</a>
                    <a class="btn-link" href="<?= site_url('order') ?>">Riwayat Pesanan</a>
                    <a class="btn-link" href="<?= site_url('wishlist') ?>">Favorit Saya</a>
                    <a class="btn-link" href="<?= site_url('profile') ?>">Pengaturan Akun</a>
                    <a class="btn-link" href="<?= site_url('auth/logout') ?>">Keluar</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-item">
                    <h4 class="text-light mb-3">Kontak</h4>
                    <p>Jl. Peternakan No. 123, Bandung, Jawa Barat</p>
                    <p>Email: info@betternak.com</p>
                    <p>Telepon: +62 123 4567 8910</p>
                    <p>WhatsApp: +62 987 6543 210</p>
                    <p class="mb-3">Buka Setiap Hari: 08.00 - 17.00 WIB</p>
                    <img src="<?= base_url("fruitables/img/payment.png"); ?>" class="img-fluid" alt="Metode Pembayaran">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Copyright Start -->
<div class="container-fluid copyright bg-dark py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>Better-nak</a>, All right reserved.</span>
            </div>
            <div class="col-md-6 my-auto text-center text-md-end text-white">
                <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                Designed By <a class="border-bottom" href="#">Better-nak</a> Distributed By <a class="border-bottom" href="https://horizon.ac.id/en_us/">Horizon University Indonesia</a>
            </div>
        </div>
    </div>
</div>
<!-- Copyright End -->



<!-- Back to Top -->
<a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>


<!-- JavaScript Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= site_url('fruitables/lib/easing/easing.min.js') ?>"></script>
<script src="<?= site_url('fruitables/lib/waypoints/waypoints.min.js') ?>"></script>
<script src="<?= site_url('fruitables/lib/lightbox/js/lightbox.min.js') ?>"></script>
<script src="<?= site_url('fruitables/lib/owlcarousel/owl.carousel.min.js') ?>"></script>

<!-- Template Javascript -->
<script src="<?= site_url('fruitables/js/main.js') ?>"></script>
</body>

</html>