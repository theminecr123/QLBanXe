<?php include_once 'app/views/share/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
</head>
<body>
    <h1 class="order-history">Order History</h1>
    
    <!-- Display order history in a data table -->
    <table id="orderTable" style="background-color:#f8f9fc;">
        <thead>
            <tr>
                <th class='table-header-order-history'>Order ID</th>
                <th class='table-header-order-history'>Total</th>
                <th class='table-header-order-history'>Date</th>
                <th class='table-header-order-history'>Detail</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderHistory as $order): ?>
                <tr style="background-color:#f8f9fc;" class="orderRow" data-orderid="<?php echo $order->id; ?>">
                    <td class='table-header-order-history-item' id='order-item-id'><?php echo $order->id; ?></td>
                    <td class='table-header-order-history-item' id='order-item-total'><?php echo number_format($order->total,'0',','); ?></td>
                    <td class='table-header-order-history-item' id='order-item-date'><?php echo $order->orderdate; ?></td>
                    <td class="table-header-order-history-item">
                    <button class="button-details" onclick="window.open('showOrderDetail?orderid=<?php echo $order->id; ?>', '_blank')">Detail</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize data table
            $('#orderTable').DataTable();
        });
    </script>
</body>
</html>

<?php include_once 'app/views/share/footer.php'; ?>
