<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .jumbotron {
            background-color: #f8f9fa;
            padding: 2rem 1rem;
            border-radius: 0.3rem;
        }
    
        .card {
            border: 1px solid rgba(0,0,0,.125);
            box-shadow: none;
        }
    
        .card:hover {
            transform: none;
            box-shadow: none;
        }
    
        .btn-primary {
            background-color: #2b4b80;
            border-color: #2b4b80;
        }
    
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
    
        .text-primary {
            color: #2b4b80 !important;
        }
    
        .card-header {
            background-color:rgb(240, 242, 240);
            border-bottom: 1px solid rgba(0,0,0,.125);
        }
        .container {
            background-color:rgb(3, 119, 13);
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark mb-4"> 
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= base_url() ?>">
                <i class="fas fa-database me-2"></i>Better-nak
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= $this->uri->segment(1) == '' ? 'active' : '' ?>" href="<?= base_url() ?>">
                            <i class="fas fa-home me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $this->uri->segment(1) == 'products' ? 'active' : '' ?>" href="<?= base_url('products') ?>">
                            <i class="fas fa-shopping-bag me-1"></i> Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $this->uri->segment(2) == 'cart' ? 'active' : '' ?>" href="<?= base_url('products/cart') ?>">
                            <i class="fas fa-shopping-cart me-1"></i> Cart 
                            <?php if($this->cart->total_items() > 0): ?>
                                <span class="badge bg-danger"><?= $this->cart->total_items() ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $this->uri->segment(2) == 'create' ? 'active' : '' ?>" href="<?= base_url('welcome/create') ?>">
                            <i class="fas fa-plus me-1"></i> Add Item
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#aboutModal">
                            <i class="fas fa-info-circle me-1"></i> About
                        </a>
                    </li>
                </ul>
                <form class="d-flex">
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="Search items...">
                        <button class="btn btn-light" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </nav>

    <!-- About Modal -->
    <div class="modal fade" id="aboutModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">About CRUD10</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>This is a simple CRUD application built with CodeIgniter 3.</p>
                    <p>Features:</p>
                    <ul>
                        <li>Create, Read, Update, and Delete items</li>
                        <li>Responsive design</li>
                        <li>Bootstrap 5 UI</li>
                        <li>Modern dashboard interface</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">