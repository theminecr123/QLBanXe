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
    <h1>Order History</h1>
    
    <!-- Display order history in a data table -->
    <table id="orderTable">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Total</th>
                <th>Date</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderHistory as $order): ?>
                <tr class="orderRow" data-orderid="<?php echo $order->id; ?>">
                    <td><?php echo $order->id; ?></td>
                    <td><?php echo $order->total; ?></td>
                    <td><?php echo $order->orderdate; ?></td>
                    <td><a href="showOrderDetail?orderid=<?php echo $order->id; ?>" target="_blank">Detail</a></td>
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
