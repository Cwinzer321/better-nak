<?php
$this->load->view('templates/header');
?>

<div class="container mt-4">
    <h2 class="mb-4">Notifikasi Anda</h2>

    <div class="mb-3">
        <a href="<?= base_url('notification/mark_all_read') ?>" class="btn btn-secondary">Tandai Semua Sudah Dibaca</a>
    </div>

    <?php if (!empty($notifications)) : ?>
        <div class="list-group">
            <?php foreach ($notifications as $notif) : ?>
                <a href="#" class="list-group-item list-group-item-action <?= $notif->is_read ? '' : 'list-group-item-primary' ?>">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1"><?= $notif->title ?></h5>
                        <small><?= timespan(strtotime($notif->created_at), time()) ?> yang lalu</small>
                    </div>
                    <p class="mb-1"><?= $notif->message ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <div class="alert alert-info">
            Tidak ada notifikasi
        </div>
    <?php endif; ?>
</div>

<?php
$this->load->view('templates/footer');
?>