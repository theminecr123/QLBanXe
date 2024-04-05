<?php include_once 'app/views/share/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Detail</title>
    <!-- Add DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
</head>
<body>
    <h1>Order Detail</h1>
    
    <!-- Display order details in DataTable -->
    <table id="orderDetailsTable" class="display">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Quantity</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderDetails as $detail): ?>
                <tr>
                    <td><?php echo $detail->productID; ?></td>
                    <td><?php echo $detail->quantity; ?></td>
                    <td><img src="../<?php echo $detail->image; ?>" alt="Product Image" style="width: 100px;"></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <!-- Add jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Add DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <!-- Initialize DataTable -->
    <script>
        $(document).ready(function() {
            $('#orderDetailsTable').DataTable();
        });
    </script>
</body>
</html>

<?php include_once 'app/views/share/footer.php'; ?>
