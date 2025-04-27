    <?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="container">
    <h2>Manajemen Produk</h2>
    <a href="<?= site_url('product/create'); ?>" class="btn btn-primary mb-3">Tambah Produk</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['name']; ?></td>
                    <td>Rp <?= number_format($product['price'], 0, ',', '.'); ?></td>
                    <td><?= $product['stock']; ?></td>
                    <td><?= $product['category_id']; ?></td>
                    <td>
                        <a href="<?= site_url('product/edit/' . $product['id']); ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="<?= site_url('product/delete/' . $product['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin menghapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>