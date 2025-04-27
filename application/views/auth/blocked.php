<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid mt-5">

                    <!-- 404 Error Text -->
                    <!-- Fix role checking -->
                    <div class="text-center">
                        <div class="error mx-auto">403</div>
                        <p class="lead text-gray-800 mb-5">Access Forbidden</p>
                        <?php if ($this->session->userdata('role') === 'penjual') : ?>
                            <a href="<?= base_url('seller/dashboard') ?>">&larr; Kembali ke Dashboard</a>
                        <?php elseif ($this->session->userdata('role') === 'pembeli') : ?>
                            <a href="<?= base_url('beranda') ?>">&larr; Kembali ke Beranda</a>
                        <?php else : ?>
                            <a href="<?= base_url('auth') ?>">&larr; Kembali ke Login</a>
                        <?php endif; ?>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <?php if (isset($role_id)): ?>
        <!-- Your existing role-based content -->

        <?php else: ?>
        <p>Anda tidak memiliki akses ke halaman ini</p>
    <?php endif; ?>