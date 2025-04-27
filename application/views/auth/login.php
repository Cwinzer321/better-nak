<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | Better-Nak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="<?= site_url('fruitables/img/favicon.ico') ?>" type="image/x-icon">

    <style>
        body {
            background: linear-gradient(to right, #4CAF50, #2E7D32);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            padding: 20px;
        }

        .login-container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
        }

        .logo-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .logo-container {
            max-width: 400px;
        }

        .form-section {
            flex: 1;
            padding: 20px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background-color: white;
        }

        .card-header {
            padding: 1.5rem;
            background-color: white;
            border-bottom: none;
        }

        .card-header h3 {
            font-size: 1.75rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0;
        }

        .card-body {
            padding: 1.5rem;
        }

        .form-control {
            height: 50px;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            margin-bottom: 20px;
            padding-left: 45px;
            padding-right: 45px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 8px rgba(76, 175, 80, 0.2);
        }

        .form-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #4CAF50;
            z-index: 2;
        }

        .btn-success {
            background-color: #4CAF50;
            border: none;
            height: 50px;
            font-weight: 600;
            border-radius: 8px;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background-color: #45a049;
            transform: translateY(-2px);
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #4CAF50;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .register-link {
            text-align: center;
        }
    </style>
    // In head section
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>
    <div class="login-container">
        <div class="logo-section">
            <div class="logo-container">
                <img src="<?= site_url('fruitables/img/Logo-Better-nak.png') ?>" alt="Logo" class="img-fluid">
            </div>
        </div>

        <div class="form-section">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Masuk ke Better-Nak</h3>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('auth/login') ?>" method="post">
                        <div class="mb-3">
                            <div class="position-relative">
                                <i class="fas fa-envelope form-icon"></i>
                                <input type="email" name="email" class="form-control" id="email" 
                                       placeholder="Alamat Email" value="<?= set_value('email') ?>" required>
                            </div>
                            <?= form_error('email', '<small class="text-danger">', '</small>') ?>
                        </div>
                        
                        <div class="mb-4">
                            <div class="position-relative">
                                <i class="fas fa-lock form-icon"></i>
                                <input type="password" name="password" class="form-control" 
                                       id="password" placeholder="Kata Sandi" required>
                                <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <?= form_error('password', '<small class="text-danger">', '</small>') ?>
                        </div>
                        
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-sign-in-alt me-2"></i>Masuk Sekarang
                        </button>
                    </form>

                    <div class="register-link" style="margin-top: 20px;">
                        <span>Belum punya akun? </span>
                        <a href="<?= base_url('auth/pilih') ?>">Daftar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = event.currentTarget.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
    // Before closing body
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    // Add this script after form
    <script>
        <?php if(validation_errors() || isset($error)): ?>
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                html: `<?= validation_errors() ?><?= isset($error) ? $error : '' ?>`,
                confirmButtonColor: '#4CAF50'
            });
        <?php endif; ?>
    
        document.querySelector('form').addEventListener('submit', function(e) {
            const form = this;
            if(form.checkValidity()) {
                e.preventDefault();
                Swal.fire({
                    title: 'Memproses Login',
                    html: 'Harap tunggu...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                        form.submit();
                    }
                });
            }
        });
    </script>
</body>

</html>
