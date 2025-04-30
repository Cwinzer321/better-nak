<?php
// Load header template
$this->load->view('templates/header');
?>



<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Keranjang</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="<?= site_url('beranda') ?>">Beranda</a></li>
        <li class="breadcrumb-item"><a href="<?= site_url('shop') ?>">Belanja</a></li>
        <li class="breadcrumb-item active text-white">Keranjang</li>
    </ol>
</div>
<!-- Single Page Header End -->


<!-- Cart Page Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Products</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total</th>
                        <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="mt-5">
            <!-- Cart Status Indicator -->
            <div class="d-inline-block me-4">
                <?php
                $user_id = $this->session->userdata('user_id') ?? null;
                $cart_count = 0;
                
                if ($user_id) {
                    $this->db->select_sum('quantity');
                    $this->db->where('user_id', $user_id);
                    $cart_data = $this->db->get('carts')->row();
                    $cart_count = $cart_data->quantity ?? 0;
                }
                ?>
                <a href="<?= site_url('cart') ?>" class="btn border-0 bg-transparent position-relative">
                    <i class="fas fa-shopping-cart text-primary fa-lg"></i>
                    <?php if ($cart_count > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?= $cart_count ?>
                        </span>
                    <?php endif; ?>
                </a>
                <span class="ms-2">Total Item: <?= $cart_count ?></span>
            </div>
            
            <a href="<?= site_url('checkout') ?>" class="btn btn-success rounded-pill px-4 py-3 ms-2">Checkout</a>
            <script>
                function saveCart() {
                    $.ajax({
                        url: '<?= site_url('cart/save') ?>',
                        type: 'POST',
                        success: function(response) {
                            alert('Keranjang berhasil disimpan');
                        },
                        error: function(xhr) {
                            alert('Gagal menyimpan keranjang');
                        }
                    });
                }
            </script>
        </div>
        <div class="row g-4 justify-content-end">
            <div class="col-8"></div>
            <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                <div class="bg-light rounded">
                    <div class="p-4">
                        <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0 me-4">Subtotal:</h5>
                            <?php
                            $subtotal = 0;
                            foreach ($cart_items as $item) {
                                $subtotal += ($item['harga'] ?? 0) * ($item['quantity'] ?? 0);
                            }
                            ?>
                            <p class="mb-0"><?= 'Rp ' . number_format($subtotal, 0, ',', '.') ?></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0 me-4">Shipping</h5>
                            <div class="">
                                <p class="mb-0"><?= 'Rp ' . number_format($shipping_rate, 0, ',', '.') ?></p>
                            </div>
                        </div>
                        <p class="mb-0 text-end">Shipping to <?= $shipping_destination ?>.</p>
                    </div>
                    <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                        <h5 class="mb-0 ps-4 me-4">Total</h5>
                        <p class="mb-0 pe-4"><?= 'Rp ' . number_format($subtotal + $shipping_rate, 0, ',', '.') ?></p>
                    </div>
                    <button class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4" type="button">Proceed Checkout</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart Page End -->

<?php
// Load footer template
$this->load->view('templates/footer');
?>

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
<tbody>
    <?php foreach ($cart_items as $item): ?>
        <tr>
            <td><img src="<?= site_url('uploads/' . ($item['gambar'] ?? 'default.jpg')) ?>" style="width: 50px;" alt="<?= $item['nama_produk'] ?? '' ?>"></td>
            <td><?= htmlspecialchars($item['nama_produk'] ?? 'Produk Tidak Dikenal', ENT_QUOTES, 'UTF-8') ?></td>
            <td>Rp<?= number_format($item['harga'] ?? 0, 0, ',', '.') ?></td>
            <td><?= $item['quantity'] ?? 0 ?></td>
            <td>Rp<?= number_format(($item['harga'] ?? 0) * ($item['quantity'] ?? 0), 0, ',', '.') ?></td>
            <td>
                <a href="<?= site_url('cart/remove/' . $item['id']) ?>" class="btn btn-danger btn-sm">
                    <i class="fa fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>