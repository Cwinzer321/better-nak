<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Better-nak</title>
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
                            <a class="nav-link active" href="<?= site_url('seller/dashboard') ?>">
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
                            <a class="nav-link" href="<?= site_url('seller/analytics') ?>">
                                <i class="fas fa-chart-line me-2"></i> Analytics
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('seller/reviews') ?>">
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

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                            <i class="fas fa-calendar"></i> This week
                        </button>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card text-white bg-primary mb-3 dashboard-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Total Produk</h5>
                                        <h2 class="mb-0"><?= $stats['total_products'] ?></h2>
                                    </div>
                                    <i class="fas fa-box fa-3x"></i>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-success mb-3 dashboard-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Total Orders</h5>
                                        <h2 class="mb-0"><?= $stats['total_orders'] ?></h2>
                                    </div>
                                    <i class="fas fa-shopping-cart fa-3x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-info mb-3 dashboard-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Total Revenue</h5>
                                        <h2 class="mb-0">Rp<?= number_format($stats['total_revenue'] ?? 0, 0, ',', '.') ?></h2>

                                    </div>
                                    <i class="fas fa-money-bill-wave fa-3x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-warning mb-3 dashboard-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Pending Orders</h5>
                                        <h2 class="mb-0"><?= $stats['pending_orders'] ?></h2>
                                    </div>
                                    <i class="fas fa-clock fa-3x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Recent Orders</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Change $recent_orders to $orders -->
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td>#<?= $order['id'] ?></td>
                                            <td>
                                                <?= htmlspecialchars($order['customer_name']) ?><br>
                                                <small class="text-muted"><?= $order['customer_email'] ?></small>
                                            </td>
                                            <td>
                                                <?= date('d M Y', strtotime($order['created_at'])) ?><br>
                                                <small class="text-muted"><?= date('H:i', strtotime($order['created_at'])) ?></small>
                                            </td>
                                            <td>
                                                Rp<?= number_format($order['total_amount'], 0, ',', '.') ?><br>
                                                <small class="text-muted"><?= $order['item_count'] ?> items</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?=
                                                                        $order['order_status'] == 'pending' ? 'warning' : ($order['order_status'] == 'processing' ? 'info' : ($order['order_status'] == 'shipped' ? 'primary' : 'success'))
                                                                        ?>">
                                                    <?= ucfirst($order['order_status']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="<?= site_url('seller/orders/view/' . $order['id']) ?>"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete(productId) {
            if (confirm('Are you sure you want to delete this product?')) {
                window.location.href = '<?= site_url('seller/products/delete/') ?>' + productId;
            }
        }
    </script>
</body>

</html>