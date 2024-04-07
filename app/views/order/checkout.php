<?php include_once 'app/views/share/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
</head>
<body>
    <h1>Checkout</h1>
    
    <!-- Hiển thị thông tin từ giỏ hàng -->
    <h2>Thông tin giỏ hàng</h2>
    <form action="/QLBanXe/order/createOrder" method="post">
    <?php
        // Tính toán tổng giá trị từ giỏ hàng
        $totalCartValue = 0;
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $totalCartValue += $item->price * $item->quantity;
            }
        }
    ?>
    <input type="hidden" name="total" value="<?php echo $totalCartValue; ?>"> <!-- Sử dụng giá trị từ giỏ hàng -->
    <input type="hidden" name="orderDetails" value="<?php echo htmlspecialchars(json_encode($_SESSION['cart'])); ?>"> <!-- Truyền thông tin giỏ hàng dưới dạng JSON -->

    <button type="submit">Hoàn tất đơn hàng</button>
   
</form>
</body>
</html>
<?php include_once 'app/views/share/footer.php'; ?>
