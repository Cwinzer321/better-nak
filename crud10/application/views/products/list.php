<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h2>Products List</h2>
        </div>
        <div class="col text-end">
            <a href="<?= base_url('welcome/create') ?>" class="btn btn-success">
                <i class="fas fa-plus"></i> Add New Product
            </a>
        </div>
    </div>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php if(isset($products) && !empty($products)): ?>
            <?php foreach($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <?php if($product['image']): ?>
                            <img src="<?= base_url('uploads/products/'.$product['image']) ?>" 
                                 class="card-img-top" 
                                 alt="<?= $product['name'] ?>"
                                 style="height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                 style="height: 200px;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= $product['name'] ?></h5>
                            <p class="card-text"><?= $product['description'] ?></p>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="h5 mb-0 text-primary"><?= rupiah($product['price']) ?></span>
                                <div class="btn-group">
                                    <a href="<?= base_url('products/edit/'.$product['id']) ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="<?= base_url('products/delete/'.$product['id']) ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Are you sure you want to delete this product?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                            <div class="text-end">
                                <a href="<?= base_url('products/add_to_cart/'.$product['id']) ?>" class="btn btn-primary">
                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info">
                    No products available. <a href="<?= base_url('welcome/create') ?>">Add your first product</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>