<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Registrasi Admin | Better-nak' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Favicon -->
       <link rel="icon" href="<?= site_url('fruitables/img/favicon.ico') ?>" type="image/x-icon">
    <style>
        body {
            background: linear-gradient(135deg, #dc3545 0%, #a71e2c 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .login-container {
            background: #fff;
            max-width: 1000px;
            margin: 2rem auto;
            border-radius: 5px;
        }

        .left-panel {
            background: rgba(220, 53, 69, 0.03);
            padding: 3rem;
        }

        .right-panel {
            padding: 3rem;
        }

        .input-group {
            border: 1px solid #ced4da;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .input-group:focus-within {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15);
        }

        .btn-danger {
            padding: 0.75rem;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #a71e2c;
            border-color: #a71e2c;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .login-container {
                margin: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-container shadow">
        <div class="container">
            <div class="row g-0">
                <div class="col-md-6 left-panel d-flex align-items-center justify-content-center">
                    <img src="<?= base_url('fruitables/img/Better-nak512x512.png'); ?>"
                        alt="Better-nak Logo"
                        class="img-fluid"
                        style="max-width: 280px;">
                </div>
                <div class="col-md-6 right-panel">
                    <h3 class="text-center mb-4 fw-bold">Registrasi Admin</h3>
                    <form class="user" method="POST" action="">
                        <div class="form-group mb-4">
                            <label class="form-label">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control form-control-user" id="nama" placeholder="Nama Lengkap" name="nama" autocomplete="off" value="<?= set_value('nama'); ?>">
                            </div>
                            <?= form_error('nama', '<small class="form-text text-danger mt-1">', '</small>'); ?>
                        </div>
                        <div class="form-group mb-4">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control form-control-user" id="email" placeholder="Email Address" name="email" autocomplete="off" value="<?= set_value('email'); ?>">
                            </div>
                            <?= form_error('email', '<small class="form-text text-danger mt-1">', '</small>'); ?>
                        </div>
                        <div class="form-group row mb-4">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control form-control-user" id="password1" placeholder="Password" name="password" required>
                                    <button class="btn" type="button" id="togglePassword1"><i class="fas fa-eye"></i></button>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control form-control-user" id="password2" placeholder="Konfirmasi Password" name="password_confirmation" required>
                                    <button class="btn" type="button" id="togglePassword2"><i class="fas fa-eye"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-danger btn-user btn-block">
                                Register Akun
                            </button>
                        </div>
                    </form>
                    <?php if ($this->session->flashdata('success_register')) : ?>
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Registrasi Berhasil!',
                                text: '<?= $this->session->flashdata('success_register') ?>',
                                confirmButtonColor: '#dc3545',
                                timer: 3000
                            });
                        </script>
                    <?php endif; ?>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="<?= base_url('auth'); ?>" class="text-danger">Sudah punya akun? Login disini</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('togglePassword1').addEventListener('click', function() {
            const passwordField = document.getElementById('password1');
            const icon = this.querySelector('i');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        document.getElementById('togglePassword2').addEventListener('click', function() {
            const passwordField = document.getElementById('password2');
            const icon = this.querySelector('i');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    <?php if ($this->session->flashdata('success_register')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Registrasi Berhasil!',
            text: '<?= $this->session->flashdata('success_register') ?>',
            confirmButtonColor: '#dc3545',
            timer: 3000
        });
    <?php endif; ?>
</script>