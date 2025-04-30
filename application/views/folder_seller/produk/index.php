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
    <!-- Loading Overlay Styles -->
    <style>
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            backdrop-filter: blur(3px);
        }

        .loading-overlay .spinner-border {
            width: 3rem;
            height: 3rem;
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
                                <span class="text-white fw-bold"><?= htmlspecialchars($seller_data['nama'] ?? 'Seller') ?></span><br>
                                <small class="text-white-50"><?= htmlspecialchars($seller_data['email'] ?? 'No email') ?></small>
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

            <!-- Main Content Area -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
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

                <!-- Products Card -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Daftar Produk</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahProdukModal">
                            <i class="fas fa-plus me-2"></i>Tambah Produk
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="mb-4">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                        <input type="text" id="productSearch" class="form-control" placeholder="Cari produk...">
                                    </div>
                                </div>
                             
                            </div>
                        </div>

                        <?php if (empty($products)): ?>
                            <div class="text-center py-5">
                                <i class="fas fa-box-open fa-4x text-muted mb-4"></i>
                                <h5 class="text-muted">Belum ada produk</h5>
                                <p class="text-muted">Mulai dengan menambahkan produk pertama Anda</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 100px">Gambar</th>
                                            <th>Nama Produk</th>
                                            <th>Deskripsi</th>
                                            <th style="width: 150px">Harga</th>
                                            <th style="width: 100px">Stok</th>
                                            <th style="width: 150px">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($products as $product): ?>
                                            <tr>
                                                <td>
                                                    <img src="<?= base_url('uploads/products/' . ($product['image'] ?? 'default.jpg')) ?>"
                                                        class="product-image img-thumbnail"
                                                        alt="<?= htmlspecialchars($product['name'] ?? '') ?>">
                                                </td>
                                                <td><?= htmlspecialchars($product['name'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($product['description'] ?? '') ?></td>
                                                <td>Rp <?= number_format($product['price'], 0, ',', '.') ?></td>
                                                <td><?= $product['stock'] ?></td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-sm btn-warning me-1 edit-product"
                                                        title="Edit"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal"
                                                        data-id="<?= $product['id'] ?>"
                                                        data-nama="<?= htmlspecialchars($product['name']) ?>"
                                                        data-harga="<?= $product['price'] ?>"
                                                        data-stok="<?= $product['stock'] ?>"
                                                        data-jenis="<?= $product['type'] ?>"
                                                        data-kategori="<?= $product['category_id'] ?>"
                                                        data-umur="<?= $product['age'] ?? '' ?>"
                                                        data-berat="<?= $product['weight'] ?? '' ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger delete-product"
                                                        title="Hapus" 
                                                        onclick="confirmDelete(<?= $product['id'] ?>)"
                                                        data-id="<?= $product['id'] ?>">    
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <!-- delete button -->
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <nav class="mt-4">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="tambahProdukModal" tabindex="-1" aria-labelledby="tambahProdukModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="productForm" action="<?= site_url('seller/products/store') ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahProdukModalLabel">Tambah Produk Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="namaProduk" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" id="namaProduk" name="nama_produk" required> <!-- Updated name attribute -->
                                <div class="invalid-feedback">Harap isi nama produk</div>
                            </div>
                            <div class="mb-3">
                                <label for="jenisProduk" class="form-label">Jenis Produk</label>
                                <select class="form-select" id="jenisProduk" name="jenis_produk" required onchange="toggleHewanFields(this.value)">
                                    <option value="" selected disabled>Pilih Jenis Produk</option>
                                    <option value="hewan_ternak">Hewan Ternak</option>
                                    <option value="produk_turunan">Produk Turunan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kategoriProduk" class="form-label">Kategori</label>
                                <select class="form-select" id="kategoriProduk" name="kategori_id" required>
                                    <option value="" selected disabled>Pilih Kategori</option>
                                    <!-- Populate categories dynamically later if needed -->
                                    <option value="1">Sapi</option>
                                    <option value="2">Domba</option>
                                    <option value="3">Kambing</option>
                                    <option value="4">Daging</option>
                                    <option value="5">Susu</option>
                                </select>
                            </div>

                            <!-- Fields specific to Hewan Ternak -->
                            <div id="hewanFields" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="umurProduk" class="form-label">Umur (bulan)</label>
                                        <input type="number" class="form-control" id="umurProduk" name="umur" min="0">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="beratProduk" class="form-label">Berat (kg)</label>
                                        <input type="number" class="form-control" id="beratProduk" name="berat" step="0.1" min="0">
                                    </div>
                                </div>
                            </div>
                            <!-- End Hewan Ternak Fields -->
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="harga" min="1000" step="500" required data-error="Harga minimal Rp 1.000">
                                <div class="invalid-feedback">Harap isi harga yang valid</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stok <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="stok" min="0" max="1000" required data-error="Stok tidak boleh negatif">
                                <div class="invalid-feedback">Harap isi stok yang valid</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" rows="3" minlength="10" data-error="Deskripsi minimal 10 karakter"></textarea>
                            <div class="invalid-feedback">Deskripsi terlalu pendek</div>
                        </div>

                        <div class="mb-3">
                            <label for="gambarProduk" class="form-label">Gambar Produk</label>
                            <input type="file" class="form-control" id="gambarProduk" name="gambar" accept="image/*" required>
                            <small class="text-muted">Format: JPG, PNG (Maks. 2MB)</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="saveProductBtn" data-target-table="products">
                            <i class="fas fa-save me-2"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function toggleHewanFields(jenis) {
            const hewanFields = document.getElementById('hewanFields');
            if (jenis === 'hewan_ternak') {
                hewanFields.style.display = 'block';
            } else {
                hewanFields.style.display = 'none';
                // Clear hewan-specific fields if switching away
                document.getElementById('umurProduk').value = '';
                document.getElementById('beratProduk').value = '';
            }
        }

        // Delete product handler
        document.addEventListener('DOMContentLoaded', function() {
            // Add event listeners to delete buttons
            const deleteButtons = document.querySelectorAll('.delete-product');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-id');
                    confirmDelete(productId);
                });
            });
        });

        // Confirm product deletion
        // Loading overlay handler
        const loadingOverlay = {
            show: () => {
                document.body.insertAdjacentHTML('beforeend',
                    `<div id="loadingOverlay" class="loading-overlay">
                <div class="spinner-border text-primary"></div>
            </div>`);
            },
            hide: () => {
                const overlay = document.getElementById('loadingOverlay');
                if (overlay) overlay.remove();
            }
        };

        function confirmDelete(productId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Produk yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#80004d',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    loadingOverlay.show();
                    // Use fetch API for AJAX request
                    fetch('<?= site_url('seller/products/delete/') ?>' + productId, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            loadingOverlay.hide();
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: data.message || 'Terjadi kesalahan saat menghapus produk'
                                });
                            }
                        })
                        .catch(error => {
                            loadingOverlay.hide();
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan pada server'
                            });
                            console.error('Error:', error);
                        });
                }
            });
        }

        // Function to sort products
        function sortProducts(sortBy) {
            const urlParams = new URLSearchParams(window.location.search);
            const currentSort = urlParams.get('sort');
            const currentDir = urlParams.get('dir') || 'asc';
            
            let newDir = 'asc';
            if (currentSort === sortBy) {
                newDir = currentDir === 'asc' ? 'desc' : 'asc';
            }
            
            window.location.href = `<?= site_url('seller/produk?sort=') ?>${sortBy}&dir=${newDir}`;
        }
    </script>

    <!-- Add Edit Modal after Add Product Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="id_produk" id="edit_id">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" name="nama_produk" id="edit_nama" required placeholder="Masukkan nama produk">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga (Rp)</label>
                                <input type="number" class="form-control" name="harga" id="edit_harga" required placeholder="Contoh: 150000">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stok</label>
                                <input type="number" class="form-control" name="stok" id="edit_stok" required placeholder="Jumlah stok tersedia">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Produk</label>
                                <select class="form-select" name="jenis_produk" id="edit_jenis" required onchange="toggleHewanFields(this.value)">
                                    <option value="hewan_ternak">Hewan Ternak</option>
                                    <option value="produk_turunan">Produk Turunan</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kategori</label>
                                <select class="form-select" name="kategori_id" id="edit_kategori" required>
                                    <?php foreach ($kategori_options as $kategori): ?>
                                        <option value="<?= $kategori['id'] ?>"><?= $kategori['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- Add animal-specific fields -->
                            <div id="edit_hewanFields" style="display: none;">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Umur (bulan)</label>
                                    <input type="number" class="form-control" name="umur" id="edit_umur" placeholder="Contoh: 24">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Berat (kg)</label>
                                    <input type="number" class="form-control" name="berat" id="edit_berat" step="0.1" placeholder="Contoh: 250.5">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Edit Modal Handler
            $('.edit-product').on('click', function() {
                const productData = $(this).data();
                $('#edit_id').val(productData.id);
                $('#edit_nama').val(productData.nama);
                $('#edit_harga').val(productData.harga);
                $('#edit_stok').val(productData.stok);
                $('#edit_jenis').val(productData.jenis);
                $('#edit_kategori').val(productData.kategori);
                $('#edit_umur').val(productData.umur);
                $('#edit_berat').val(productData.berat);

                // Toggle animal-specific fields
                toggleHewanFields(productData.jenis);

                $('#editForm').attr('action', '<?= site_url('seller/update/') ?>' + productData.id);
            });

            // Handle form submission
            $('#editForm').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                fetch($(this).attr('action'), {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Network error');
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert(data.message || 'Update failed');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred during update');
                    });
            });
        });
    </script>