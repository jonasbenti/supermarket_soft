<?php
include __DIR__ . '/../begin_html.php';
?>
<div class="container">
    <div class="text-center mb-2">
        <a class="btn btn-<?= $button_type; ?>" href="/order-sale-create" role="button">
            <?= $button_text; ?>
        </a>
    </div>
    <table class="table table-striped table-hover caption-top rounded">
        <thead class="table-primary" style="border-radius: 5px;">
            <tr>
                <td></td>
                <td><b>Id</b></td>
                <td><b>Data</b></td>
                <td><b>V. Total</b></td>
                <td><b>V. Total Imp.</b></td>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($sales_orders as $sale_order): 
                extract($sale_order);
            ?>
                <tr>
                    <td>
                        <a href='/order-sale-create?id=<?= $id; ?>' class='btn btn-primary btn-sm'>
                            visualizar
                        </a>
                    </td>
                    <td><?= $id; ?></td>
                    <td><?= $order_date; ?></td>
                    <td><?= $order_total; ?></td>
                    <td><?= $order_total_tax; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/../end_html.php'; ?>