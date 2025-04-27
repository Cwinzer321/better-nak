<div class="container">
    <h2 class="mb-4">Shopping Cart</h2>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <?= $this->session->flashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if($this->cart->total_items() > 0): ?>
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($this->cart->contents() as $item): ?>
                        <tr>
                            <td><?= $item['name'] ?></td>
                            <td><?= rupiah($item['price']) ?></td>
                            <td><?= $item['qty'] ?></td>
                            <td><?= rupiah($item['subtotal']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                            <td><strong><?= rupiah($this->cart->total()) ?></strong></td>
                        </tr>
                    </tfoot>
                </table>

                <div class="text-end mt-3">
                    <a href="<?= base_url('products') ?>" class="btn btn-secondary">
                        <i class="fas fa-shopping-bag"></i> Continue Shopping
                    </a>
                    <a href="<?= base_url('products/checkout') ?>" class="btn btn-success">
                        <i class="fas fa-check"></i> Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            Your cart is empty. <a href="<?= base_url('products') ?>">Continue shopping</a>
        </div>
    <?php endif; ?>
</div>