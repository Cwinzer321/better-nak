<div class="container">
    <div class="jumbotron text-center mb-4">
        <h1 class="display-4">Selamat Datang di Better-nak</h1>
        <p class="lead">Penjualan Ternak Terpercaya dan Transparan</p>
        <hr class="my-4">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <i class="fas fa-shopping-cart fa-3x mb-3 text-primary"></i>
                        <h5>Shopping Cart</h5>
                        <p>Browse and purchase products</p>
                        <a href="<?= base_url('products') ?>" class="btn btn-primary">Go Shopping</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <i class="fas fa-plus-circle fa-3x mb-3 text-success"></i>
                        <h5>Add Products</h5>
                        <p>Manage product inventory</p>
                        <a href="<?= base_url('welcome/create') ?>" class="btn btn-success">Add Product</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if(!empty($latest_products)): ?>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Latest Products</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <?php foreach($latest_products as $product): ?>
                <div class="col-md-3 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="card-title"><?= $product['name'] ?></h6>
                            <p class="card-text text-muted small"><?= substr($product['description'], 0, 50) ?>...</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h6 mb-0"><?= rupiah($product['price']) ?></span>
                                <a href="<?= base_url('products/add_to_cart/'.$product['id']) ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-cart-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if($total_orders > 0): ?>
    <div class="alert alert-info mt-4">
        <i class="fas fa-info-circle"></i> Total orders processed: <?= $total_orders ?>
    </div>
    <?php endif; ?>
</div>
