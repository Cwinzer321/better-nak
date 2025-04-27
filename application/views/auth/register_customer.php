<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Registrasi Customer | Better-nak' ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Favicon -->
    <link rel="icon" href="<?= site_url("fruitables/img/Better-nak.ico"); ?>" type="image/x-icon">
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
            background: none;
            box-shadow: none;
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
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            padding-left: 45px;
            padding-right: 45px;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 15px;
            border: none;
            background: none;
            color: #4CAF50;
            cursor: pointer;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(76, 175, 80, 0.25);
            border-color: #4CAF50;
        }

        .form-icon {
            position: absolute;
            left: 15px;
            top: 15px;
            color: #4CAF50;
        }

        .btn-success {
            background-color: #4CAF50;
            border: none;
            height: 50px;
            font-weight: 600;
            border-radius: 5px;
            width: 100%;
            font-size: 1.1rem;
        }

        .btn-success:hover {
            background-color: #388E3C;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
            color: #4CAF50;
            text-decoration: none;
            font-weight: 500;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }
            .logo-section {
                margin-bottom: 30px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="logo-section">
            <div class="logo-container">
                <img src="<?= base_url('fruitables/img/Logo-Better-nak.png') ?>" alt="Better-Nak Logo" class="img-fluid">
            </div>
        </div>
        <div class="form-section">
            <div class="card">
                <div class="card-header">
                    <h3>Registrasi Pembeli</h3>
                </div>
                <div class="card-body">
                    <form class="users" method="POST" action="">
                        <div class="form-group mb-3">
                            <div class="position-relative">
                                <i class="fas fa-user form-icon"></i>
                                <input type="text" class="form-control" id="nama" placeholder="Username" name="nama" value="<?= set_value('nama'); ?>">
                            </div>
                            <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <div class="form-group mb-3">
                            <div class="position-relative">
                                <i class="fas fa-envelope form-icon"></i>
                                <input type="email" class="form-control" id="email" placeholder="Email Address" name="email" value="<?= set_value('email'); ?>">
                            </div>
                            <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <div class="form-group mb-3">
                            <div class="position-relative">
                                <i class="fas fa-lock form-icon"></i>
                                <input type="password" class="form-control" id="password1" placeholder="Password" name="password1">
                                <button type="button" class="password-toggle" onclick="togglePassword('password1')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <?= form_error('password1', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <div class="form-group mb-4">
                            <div class="position-relative">
                                <i class="fas fa-lock form-icon"></i>
                                <input type="password" class="form-control" id="password2" placeholder="Konfirmasi Password" name="password2">
                                <button type="button" class="password-toggle" onclick="togglePassword('password2')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">
                            Daftar
                        </button>
                    </form>
                    
                    <div class="text-center mt-3">
                        <a href="<?= base_url('auth/login'); ?>" class="back-link">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    </div>
    </div>

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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        <?php if ($this->session->flashdata('success_register')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Registrasi Berhasil!',
                text: 'Akun berhasil dibuat. Silakan login',
                confirmButtonColor: '#2e7d32',
                timer: 3000
            });
        <?php endif; ?>
    </script>

</body>

</html>