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
        <div class="row g-5 justify-content-center">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="d-flex flex-column text-start footer-item">
                    <h4 class="text-light mb-3">Navigasi</h4>
                    <a class="btn-link" href="<?= site_url() ?>">Beranda</a>
                    <a class="btn-link" href="<?= site_url('shop') ?>">Belanja</a>
                    <a class="btn-link" href="<?= site_url('contact') ?>">Kontak</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="d-flex flex-column text-start footer-item h-100">
                    <h4 class="text-light mb-3">Akun Saya</h4>
                    <a class="btn-link" href="<?= site_url('auth') ?>">Masuk/Daftar</a>
                    <a class="btn-link" href="<?= site_url('cart') ?>">Keranjang Belanja</a>
                    <a class="btn-link" href="<?= site_url('order') ?>">Riwayat Pesanan</a>
                    <a class="btn-link" href="<?= site_url('wishlist') ?>">Favorit Saya</a>
                    <a class="btn-link" href="<?= site_url('profile') ?>">Pengaturan Akun</a>
                    <a class="btn-link" href="<?= site_url('auth/logout') ?>">Keluar</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="footer-item h-100">
                    <h4 class="text-light mb-3">Kontak Kami</h4>
                    <p>Jl. Peternakan No. 123, Bandung, Jawa Barat</p>
                    <p>Email: Better-nak@gmail.com</p>
                    <p>Telepon: +62 123 4567 8910</p>
                    <p>WhatsApp: +62 987 6543 210</p>
                    <p class="mb-3">Buka Setiap Hari: 08.00 - 17.00 WIB</p>

                    <div class="position-relative w-100">
                </div>
            </div>
        </div>
    </div>
</div>
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