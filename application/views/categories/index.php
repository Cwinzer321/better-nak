<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="container">
    <h2>Manajemen Kategori</h2>
    <a href="<?= site_url('category/create'); ?>" class="btn btn-primary mb-3">Tambah Kategori</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Jenis</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= $category['name']; ?></td>
                    <td><?= ucfirst($category['type']); ?></td>
                    <td><?= character_limiter($category['description'], 50); ?></td>
                    <td>
                        <a href="<?= site_url('category/edit/' . $category['id']); ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="<?= site_url('category/delete/' . $category['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin menghapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>