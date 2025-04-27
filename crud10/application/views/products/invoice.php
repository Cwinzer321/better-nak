<!DOCTYPE html>
<html>
<head>
    <title>Invoice #<?= $order['order_number'] ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            .no-print { display: none; }
            .card { border: none !important; }
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success no-print">
                <?= $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-6">
                        <h2 class="mb-3">INVOICE</h2>
                        <h6>Order #<?= $order['order_number'] ?></h6>
                        <h6>Date: <?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></h6>
                    </div>
                    <div class="col-6 text-end">
                        <h4>CRUD10 Store</h4>
                        <p class="mb-0">123 Store Street</p>
                        <p>Phone: (123) 456-7890</p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($items as $item): ?>
                            <tr>
                                <td><?= $item['name'] ?></td>
                                <td><?= $item['quantity'] ?></td>
                                <td><?= rupiah($item['price']) ?></td>
                                <td><?= rupiah($item['quantity'] * $item['price']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                <td><strong><?= rupiah($order['total_amount']) ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="text-center mt-4 no-print">
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="fas fa-print"></i> Print Invoice
                    </button>
                    <a href="<?= base_url('products') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Products
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>