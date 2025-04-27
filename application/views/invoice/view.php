<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
        }

        .header {
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .total {
            margin-top: 20px;
            float: right;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Better-nak Invoice #<?= $invoice->invoice_number ?></h2>
        <p>Tanggal: <?= date('d/m/Y H:i', strtotime($invoice->issue_date)) ?></p>
        <p>Jatuh Tempo: <?= date('d/m/Y H:i', strtotime($invoice->due_date)) ?></p>
    </div>

    <div class="customer-info">
        <h4>Kepada:</h4>
        <p><?= $user->nama ?></p>
        <p><?= $user->alamat ?></p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order->items as $item): ?>
                <tr>
                    <td><?= $item->nama_produk ?></td>
                    <td>Rp <?= number_format($item->harga, 0, ',', '.') ?></td>
                    <td><?= $item->quantity ?></td>
                    <td>Rp <?= number_format($item->harga * $item->quantity, 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="total">
        <h3>Total: Rp <?= number_format($invoice->total_amount, 0, ',', '.') ?></h3>
        <p>Status: <?= strtoupper($invoice->status) ?></p>
    </div>

    <div class="footer">
        <p>Terima kasih telah berbelanja di Better-nak</p>
    </div>
</body>

</html>