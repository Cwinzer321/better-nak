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
                                <img src="<?= base_url('fruitables/img/' . ($seller_data['foto'] ?? 'default.jpg')) ?>"
                                    class="rounded-circle"
                                    alt="Profile"
                                    style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #fff; cursor: pointer;">
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
                            <a class="nav-link active" href="<?= site_url('orders') ?>">
                                <i class="fas fa-shopping-cart me-2"></i> Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('seller/product_reviews') ?>">
                                <i class="fas fa-comments me-2"></i> Reviews
                            </a>
                        </li>
                        <li class="nav-item mt-3">
                            <a class="nav-link text-danger" href="<?= site_url('auth/logout') ?>">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Kelola Pesanan</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Ekspor</button>
                        </div>
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#ID</th>
                                        <th>Pelanggan</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td>#<?= $order['id'] ?? '' ?></td>
                                            <td>
                                                <?= htmlspecialchars($order['customer_name'] ?? 'N/A') ?><br>
                                                <small class="text-muted"><?= $order['customer_email'] ?? '' ?></small>
                                            </td>
                                            <td>
                                                <?= date('d M Y', strtotime($order['created_at'] ?? '')) ?><br>
                                                <small class="text-muted"><?= date('H:i', strtotime($order['created_at'] ?? '')) ?></small>
                                            </td>
                                            <td>
                                                Rp<?= number_format($order['total_amount'] ?? 0, 0, ',', '.') ?><br>
                                                <small class="text-muted"><?= $order['item_count'] ?? 0 ?> items</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= 
                                                    ($order['order_status'] ?? 'pending') === 'pending' ? 'warning' : 
                                                    (($order['order_status'] ?? 'pending') === 'processing' ? 'info' : 
                                                    (($order['order_status'] ?? 'pending') === 'shipped' ? 'primary' : 'success')) 
                                                ?>">
                                                    <?= ucfirst($order['order_status'] ?? 'pending') ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="<?= site_url('seller/orders/view/' . ($order['id'] ?? '')) ?>" 
                                                    class="btn btn-sm btn-primary me-1"
                                                    title="Detail Pesanan">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <?php if (($order['order_status'] ?? '') === 'pending'): ?>
                                                    <form method="POST" action="<?= site_url('seller/orders/update_status') ?>" class="d-inline">
                                                        <input type="hidden" name="order_id" value="<?= $order['id'] ?? '' ?>">
                                                        <input type="hidden" name="new_status" value="success">
                                                        <button type="submit" class="btn btn-sm btn-success me-1" 
                                                            title="Konfirmasi Pesanan"
                                                            onclick="return confirm('Apakah Anda yakin mengkonfirmasi pesanan ini?')">
                                                            Konfirmasi
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="<?= site_url('seller/orders/update_status') ?>" class="d-inline">
                                                        <input type="hidden" name="order_id" value="<?= $order['id'] ?? '' ?>">
                                                        <input type="hidden" name="new_status" value="cancelled">
                                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                            title="Batalkan Pesanan"
                                                            onclick="return confirm('Apakah Anda yakin membatalkan pesanan ini?')">
                                                            Batal
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
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
</body>
</html>