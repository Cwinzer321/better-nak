<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Akun | Better-Nak</title>
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

        .pilih-container {
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

        .role-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            height: 100%;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .role-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .role-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #4CAF50;
        }

        .role-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #333;
        }

        .role-description {
            color: #666;
            margin-bottom: 1.5rem;
        }

        .btn-success {
            background-color: #4CAF50;
            border: none;
            height: 45px;  /* Reduced from 50px */
            padding: 0.5rem 1rem;
            font-weight: 600;
            border-radius: 5px;
            width: 100%;
            font-size: 1rem;  /* Reduced from 1.1rem */
            transition: all 0.2s ease;
        }

        .btn-success:hover {
            background-color: #388E3C;
            transform: scale(1.02);
        }

        .back-link {
            display: block;
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
            .pilih-container {
                flex-direction: column;
            }

            .logo-section {
                margin-bottom: 30px;
            }
        }
    </style>
</head>

<body>
    <div class="pilih-container">
        <div class="logo-section">
            <div class="logo-container">
                <img src="<?= base_url('fruitables/img/Logo-Better-nak.png') ?>" alt="Better-Nak Logo" class="img-fluid">
            </div>
        </div>
        <div class="form-section">
            <div class="card">
                <div class="card-header">
                    <h3>Pilih Akun</h3>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6 d-flex flex-column">
                            <div class="role-card h-100">
                                <i class="fas fa-shopping-cart role-icon"></i>
                                <h4 class="role-title">Pembeli</h4>
                                <p class="role-description">Daftar sebagai pembeli </p>
                                <div class="mt-auto">
                                    <a href="<?= base_url('auth/register_customer') ?>" class="btn btn-success text-center d-block">
                                        Daftar
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex flex-column">
                            <div class="role-card h-100">
                                <i class="fas fa-store role-icon"></i>
                                <h4 class="role-title">Penjual</h4>
                                <p class="role-description">Daftar sebagai penjual </p>
                                <div class="mt-auto">
                                    <a href="<?= base_url('auth/register_seller') ?>" class="btn btn-success text-center d-block">
                                        Daftar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="<?= base_url('auth/login') ?>" class="back-link">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Login
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>