<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Path shortcut
$fruitables_path = site_url("fruitables/");
$css_path = $fruitables_path . "css/";
$js_path = $fruitables_path . "js/";
$img_path = $fruitables_path . "img/";
$lib_path = $fruitables_path . "lib/";

// Default user info
$profile_picture = '';
$user_data = null;
$cart_count = 0;
$unread_count = 0;
$notifications = [];

if ($this->session->userdata('logged_in')) {
    $user_id = $this->session->userdata('user_id');

    // Get user data
    $user_data = $this->User_model->getUserById($user_id);

    $profile_picture = !empty($user_data['profile_picture'])
        ? base_url('uploads/profile_pictures/' . $user_data['profile_picture'])
        : $img_path . 'avatar.jpg';

    // Add timestamp to avoid cache issues
    $profile_picture .= '?v=' . time();

    // Get cart items safely
    $cart_items = $this->Cart_model->getCart($user_id);
    $cart_count = is_array($cart_items) ? count($cart_items) : 0;

    // Get notifications
    $unread_count = $this->Notification_model->getUnreadCount($user_id);
    $notifications = $this->Notification_model->getNotifications($user_id, 5);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Better-nak | Website Peternakan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Fonts & Icon -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- CSS -->
    <link href="<?= $lib_path ?>lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="<?= $lib_path ?>owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="<?= $css_path ?>bootstrap.min.css" rel="stylesheet">
    <link href="<?= $css_path ?>style.css" rel="stylesheet">
    <link rel="icon" href="<?= $img_path ?>favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        /* Modified dropdown animation for both menus */
        .dropdown-menu {
            transform-origin: top right;
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.2s ease, transform 0.3s ease, visibility 0.2s;
            visibility: hidden;
            display: block;
        }

        .show .dropdown-menu {
            opacity: 1;
            transform: translateY(0);
            visibility: visible;
        }

        /* Dropdown toggle arrows */
        .dropdown-toggle::after {
            display: inline-block;
            margin-left: 0.255em;
            vertical-align: 0.255em;
            content: "";
            border-top: 0.3em solid;
            border-right: 0.3em solid transparent;
            border-bottom: 0;
            border-left: 0.3em solid transparent;
            transition: transform 0.2s ease-in-out;
        }

        .show .dropdown-toggle::after {
            transform: rotate(-180deg);
        }

        /* Notification dropdown specific styling */
        .notification-dropdown {
            min-width: 320px;
            padding: 0;
        }

        .unread {
            background-color: #f8f9fa;
        }

        /* Ensure dropdown is above other elements */
        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            position: absolute;
            z-index: 1000;
        }
    </style>
</head>

<body>

    <!-- Header Bar -->
    <div class="container-fluid fixed-top">
        <div class="bg-primary py-2 px-5 text-white">
            <?php if ($this->session->userdata('logged_in')): ?>
                Selamat datang, <strong><?= htmlspecialchars($this->session->userdata('name') ?? '', ENT_QUOTES, 'UTF-8') ?></strong>
            <?php else: ?>
                Selamat datang di <strong>better-nak</strong>, <a href="<?= base_url('auth/login'); ?>" class="text-white text-decoration-underline">silakan login</a>
            <?php endif; ?>
        </div>

        <div class="container px-0">
            <nav class="navbar navbar-expand-lg navbar-light bg-white px-3">
                <a class="navbar-brand" href="<?= site_url('beranda'); ?>">
                    <h1 class="text-primary display-6">better-nak</h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto mb-2 mb-lg-0 justify-content-center">
                        <a href="<?= site_url('beranda'); ?>" class="nav-item nav-link <?= strpos(current_url(), 'beranda') !== false ? 'active' : '' ?>">Home</a>
                        <a href="<?= site_url('shop'); ?>" class="nav-item nav-link <?= uri_string() === 'shop' ? 'active' : '' ?>">Shop</a>
                        <a href="<?= site_url('contact') ?>" class="nav-item nav-link <?= uri_string() === 'contact' ? 'active' : '' ?>">Contact</a>
                        <a href="<?= site_url('aboutus') ?>" class="nav-item nav-link <?= uri_string() === 'aboutus' ? 'active' : '' ?>">About Us</a>
                    </div>

                    <?php if ($this->session->userdata('logged_in')): ?>
                        <div class="d-flex align-items-center">
                            <!-- Cart -->
                            <a href="<?= site_url('cart'); ?>" class="btn border-0 bg-transparent me-4 position-relative">
                                <i class="fas fa-shopping-cart text-primary fa-lg"></i>
                                <?php if ($cart_count > 0): ?>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?= $cart_count ?></span>
                                <?php endif; ?>
                            </a>

                            <!-- Notifications -->
                            <div class="dropdown me-4">
                                <a class="dropdown-toggle" href="#" role="button" id="notifDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-bell text-primary fa-lg position-relative"></i>
                                    <?php if ($unread_count > 0): ?>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?= $unread_count ?></span>
                                    <?php endif; ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow notification-dropdown"
                                    aria-labelledby="notifDropdown">
                                    <li class="dropdown-header d-flex justify-content-between align-items-center mb-2">
                                        <span class="fs-6">Notifikasi Terbaru</span>
                                        <a href="<?= site_url('notification/mark_all_read') ?>" class="text-decoration-none fs-6">Tandai sudah dibaca</a>
                                    </li>
                                    <?php foreach ($notifications as $notif): ?>
                                        <li>
                                            <a class="dropdown-item <?= $notif['is_read'] ? '' : 'fw-bold unread' ?>" href="<?= $notif['link'] ?>">
                                                <i class="fas fa-<?= $notif['type'] === 'order' ? 'shopping-cart' : 'info-circle' ?> me-2 text-primary"></i>
                                                <div class="d-flex flex-column">
                                                    <?= htmlspecialchars($notif['message'], ENT_QUOTES, 'UTF-8') ?>
                                                    <small class="text-muted mt-1"><?= timespan($notif['created_at'], time()) ?> lalu</small>
                                                </div>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                    <li>
                                        <hr class="dropdown-divider m-0">
                                    </li>
                                    <li><a class="dropdown-item text-center py-2 bg-light" href="<?= site_url('notification') ?>">Lihat Semua Notifikasi</a></li>
                                </ul>
                            </div>

                            <!-- Profile -->
                            <div class="dropdown">
                                <a class="dropdown-toggle d-flex align-items-center text-decoration-none"
                                    href="#"
                                    role="button"
                                    id="profileDropdown"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="<?= $profile_picture ?>" class="rounded-circle me-2"
                                        width="40" height="40" alt="Profile"
                                        style="object-fit: cover; border: 2px solid #f8f9fa;">
                                    <span class="text-dark fw-medium"><?= htmlspecialchars($this->session->userdata('name') ?? '', ENT_QUOTES, 'UTF-8') ?></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow"
                                    aria-labelledby="profileDropdown"
                                    style="min-width: 220px; padding: 0.5rem 0;">
                                    <li><a class="dropdown-item py-2 px-3 d-flex align-items-center" href="<?= site_url('profile') ?>">
                                            <i class="fas fa-user me-2 text-primary fs-6"></i>Profil
                                        </a></li>
                                    <?php if ($this->session->userdata('role') == 'penjual'): ?>
                                        <li>
                                            <hr class="dropdown-divider my-2">
                                        </li>
                                        <li><a class="dropdown-item py-2 px-3 d-flex align-items-center" href="<?= site_url('seller/dashboard') ?>">
                                                <i class="fas fa-tachometer-alt me-2 text-primary fs-6"></i>Dashboard Seller
                                            </a></li>
                                    <?php endif; ?>
                                    <li>
                                        <hr class="dropdown-divider my-2">
                                    </li>
                                    <li><a class="dropdown-item py-2 px-3 d-flex align-items-center text-danger" href="#" onclick="confirmLogout()">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </a></li>
                                </ul>
                            </div>
                        </div>

                    <?php else: ?>
                        <a href="<?= base_url('auth/login') ?>" class="btn btn-primary rounded-pill px-4 py-2">
                            <i class="fas fa-sign-in-alt me-2"></i> Login
                        </a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script>
        // Initialize Bootstrap dropdowns
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi dropdown manual
            var dropdownElements = document.querySelectorAll('.dropdown-toggle');
            dropdownElements.forEach(function(dropdownEl) {
                new bootstrap.Dropdown(dropdownEl);
            });

            // Menangani klik di luar dropdown untuk menutupnya
            document.addEventListener('click', function(event) {
                var dropdowns = document.querySelectorAll('.dropdown');
                dropdowns.forEach(function(dropdown) {
                    var dropdownMenu = dropdown.querySelector('.dropdown-menu');
                    if (!dropdown.contains(event.target) && dropdownMenu.classList.contains('show')) {
                        var dropdownToggle = dropdown.querySelector('.dropdown-toggle');
                        var dropdownInstance = bootstrap.Dropdown.getInstance(dropdownToggle);
                        dropdownInstance.hide();
                    }
                });
            });
        });

        function confirmLogout() {
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: "Apakah Anda yakin ingin keluar?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= site_url('auth/logout') ?>";
                }
            });
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            var dropdowns = document.querySelectorAll('.dropdown');
            dropdowns.forEach(function(dropdown) {
                if (!dropdown.contains(event.target)) {
                    var dropdownMenu = dropdown.querySelector('.dropdown-menu');
                    if (dropdownMenu.classList.contains('show')) {
                        var dropdownToggle = dropdown.querySelector('.dropdown-toggle');
                        bootstrap.Dropdown.getInstance(dropdownToggle).hide();
                    }
                }
            });
        });
    </script>
</body>

</html>