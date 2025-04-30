<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Better-nak</title>

    <link rel="icon" href="<?= site_url('fruitables/img/favicon.ico') ?>" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #212529;
        }

        .nav-link {
            color: #adb5bd;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            margin-bottom: 0.25rem;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #fff;
            background-color: #495057;
        }

        .profile-section {
            padding: 1rem 0;
        }

        .dashboard-card {
            transition: transform 0.3s;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar">
                <div class="position-sticky pt-3">
                    <!-- Profile Section -->
                    <div class="profile-section mb-4">
                        <div class="d-flex align-items-center gap-3 px-3">
                            <img src="<?= base_url('uploads/seller_profile/' . ($seller_data['foto'] ?? 'default.jpg')) ?>"
                                class="rounded-circle"
                                alt="Profile"
                                style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #fff">
                            <div>
                                <span class="text-white fw-bold"><?= $seller_data['nama'] ?? 'Seller' ?></span><br>
                                <small class="text-white-50"><?= $seller_data['email'] ?? 'No email' ?></small>
                            </div>
                        </div>
                    </div>

                    <h4 class="px-3 text-white">Seller Panel</h4>
                    <ul class="nav flex-column">
                        <!-- Add new home button -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('beranda') ?>">
                                <i class="fas fa-globe me-2"></i> Ke Beranda Utama
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="<?= site_url('seller/dashboard') ?>">
                                <i class="fas fa-home me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('seller/produk') ?>">
                                <i class="fas fa-box me-2"></i> Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('seller/orders') ?>">
                                <i class="fas fa-shopping-cart me-2"></i> Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= site_url('seller/product_reviews') ?>">
                                <i class="fas fa-comments me-2"></i> Reviews
                            </a>
                        </li>
                        <li class="nav-item mt-3">
                            <a class="nav-link text-danger" href="<?= site_url('auth') ?>">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

</body>

</html>