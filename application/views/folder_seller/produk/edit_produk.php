<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Seller Better-nak</title>
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
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('beranda') ?>">
                                <i class="fas fa-globe me-2"></i> Ke Beranda Utama
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('seller/dashboard') ?>">
                                <i class="fas fa-home me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= site_url('seller/produk') ?>">
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

            <!-- Main Content Area -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <div class="pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Edit Produk</h1>
                </div>

                <!-- Flash Message Display -->
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Form Edit Produk</h5>
                    </div>
                    <div class="card-body">
                        <form id="editProductForm" action="<?= site_url('seller/update/' . $product['id_produk']) ?>" method="POST" enctype="multipart/form-data"> <!-- Updated action URL -->
                            <div class="mb-3">
                                <label for="namaProduk" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" id="namaProduk" name="nama_produk" value="<?= htmlspecialchars($product['nama_produk'] ?? '') ?>" required> <!-- Updated name and value -->
                            </div>
                            <div class="mb-3">
                                <label for="jenisProduk" class="form-label">Jenis Produk</label>
                                <select class="form-select" id="jenisProduk" name="jenis_produk" required onchange="toggleHewanFieldsEdit(this.value)">
                                    <option value="" disabled>Pilih Jenis Produk</option>
                                    <option value="hewan_ternak" <?= ($product['jenis_produk'] ?? '') == 'hewan_ternak' ? 'selected' : '' ?>>Hewan Ternak</option>
                                    <option value="produk_turunan" <?= ($product['jenis_produk'] ?? '') == 'produk_turunan' ? 'selected' : '' ?>>Produk Turunan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kategoriProduk" class="form-label">Kategori</label>
                                <select class="form-select" id="kategoriProduk" name="kategori_id" required>
                                    <option value="" disabled>Pilih Kategori</option>
                                    <!-- Populate categories dynamically later if needed -->
                                    <option value="1" <?= ($product['kategori_id'] ?? '') == 1 ? 'selected' : '' ?>>Sapi</option>
                                    <option value="2" <?= ($product['kategori_id'] ?? '') == 2 ? 'selected' : '' ?>>Domba</option>
                                    <option value="3" <?= ($product['kategori_id'] ?? '') == 3 ? 'selected' : '' ?>>Kambing</option>
                                    <option value="4" <?= ($product['kategori_id'] ?? '') == 4 ? 'selected' : '' ?>>Daging</option>
                                    <option value="5" <?= ($product['kategori_id'] ?? '') == 5 ? 'selected' : '' ?>>Susu</option>
                                </select>
                            </div>

                            <!-- Fields specific to Hewan Ternak -->
                            <div id="hewanFieldsEdit" style="display: <?= ($product['jenis_produk'] ?? '') == 'hewan_ternak' ? 'block' : 'none' ?>;">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="umurProduk" class="form-label">Umur (bulan)</label>
                                        <input type="number" class="form-control" id="umurProduk" name="umur" value="<?= htmlspecialchars($product['umur'] ?? '') ?>" min="0">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="beratProduk" class="form-label">Berat (kg)</label>
                                        <input type="number" class="form-control" id="beratProduk" name="berat" value="<?= htmlspecialchars($product['berat'] ?? '') ?>" step="0.1" min="0">
                                    </div>
                                </div>
                            </div>
                            <!-- End Hewan Ternak Fields -->

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="harga" value="<?= htmlspecialchars($product['harga'] ?? '') ?>" min="1000" step="500" required>
                                    <div class="invalid-feedback">Harap isi harga yang valid (minimal Rp 1.000)</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Stok <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="stok" value="<?= htmlspecialchars($product['stok'] ?? '') ?>" min="0" max="1000" required>
                                    <div class="invalid-feedback">Harap isi stok yang valid (0-1000)</div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" rows="3" minlength="10"><?= htmlspecialchars($product['deskripsi'] ?? '') ?></textarea>
                                <div class="invalid-feedback">Deskripsi minimal 10 karakter</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Gambar Produk</label>
                                <input type="file" class="form-control" name="gambar" accept="image/*">
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar. Format: JPG, PNG (Maks. 2MB)</small>
                                <?php if (!empty($product['gambar'])): ?>
                                    <div class="mt-2">
                                        <img src="<?= base_url('uploads/produk/' . $product['gambar']) ?>" alt="Gambar Produk Saat Ini" style="max-height: 100px; border-radius: 5px;">
                                        <p><small>Gambar saat ini</small></p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- <div class="mb-3">
                                <label class="form-label">Gambar Produk</label>
                                <input type="file" class="form-control" name="gambar" accept="image/*">
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar. Format: JPG, PNG (Maks. 2MB)</small>
                                <?php // if (!empty($product['gambar'])): 
                                ?>
                                    <div class="mt-2">
                                        <img src="<?= base_url('uploads/products/' . $product['gambar']) ?>" alt="Gambar Produk Saat Ini" style="max-height: 100px; border-radius: 5px;">
                                        <p><small>Gambar saat ini</small></p>
                                    </div>
                                <?php // endif; 
                                ?>
                            </div> --> <!-- Commented out: 'gambar' column does not exist -->

                            <div class="mt-4">
                                <a href="<?= site_url('seller/produk') ?>" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleHewanFieldsEdit(jenis) {
            const hewanFields = document.getElementById('hewanFieldsEdit');
            if (jenis === 'hewan_ternak') {
                hewanFields.style.display = 'block';
            } else {
                hewanFields.style.display = 'none';
                // Clear hewan-specific fields if switching away
                // document.getElementById('umurProduk').value = ''; // Keep values on edit
                // document.getElementById('beratProduk').value = ''; // Keep values on edit
            }
        }

        // Initialize fields visibility on page load
        document.addEventListener('DOMContentLoaded', function() {
            const initialJenis = document.getElementById('jenisProduk').value;
            toggleHewanFieldsEdit(initialJenis);
        });
    </script>
</body>

</html>