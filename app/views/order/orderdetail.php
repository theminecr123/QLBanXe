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
    <h1 class='order-detail'>Order Detail</h1>
    
    <!-- Display order details in DataTable -->
    <table id="orderDetailsTable" class="display" >
        <thead>
            <tr style="background-color:#f8f9fc;">
                <th class="table-header-order-detail">Product ID</th>
                <th class="table-header-order-detail">Quantity</th>
                <th class="table-header-order-detail">Image</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderDetails as $detail): ?>
                <tr style="background-color:#f8f9fc;">
                    <td style="background-color:#f8f9fc;" class="table-header-order-detail-item" id="order-detail-item-id"><?php echo $detail->productID; ?></td>
                    <td class="table-header-order-detail-item" id="order-detail-item-quantity"><?php echo $detail->quantity; ?></td>
                    <td class="table-header-order-detail-item"><img src="../<?php echo $detail->image; ?>" alt="Product Image" style='width:120px; height:120px; border-radius:10px;'>

                </td>
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
