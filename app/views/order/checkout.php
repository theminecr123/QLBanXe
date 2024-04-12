<?php include_once 'app/views/share/header.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
            // Hiển thị giỏ hàng dưới dạng bảng
            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>Hình ảnh</th>";
            echo "<th>ID</th>";
            echo "<th>Tên</th>";
            echo "<th>Giá</th>";
            echo "<th>Số lượng</th>";
            echo "<th>Tổng</th>";
            echo "</tr>";
            
            // Lặp qua các mục trong giỏ hàng và hiển thị thông tin
            foreach ($_SESSION['cart'] as $item) {
                // Tính tổng tiền cho từng mục
                $itemTotal = $item->price * $item->quantity;
                
                // Cộng vào tổng giá trị giỏ hàng
                $totalCartValue += $itemTotal;
                
                // Hiển thị thông tin sản phẩm trong bảng
                echo "<tr>";
                echo "<td><img src='/QLBanXe/{$item->image}' alt='Hình ảnh sản phẩm' width='100' height='100'></td>";
                echo "<td>{$item->id}</td>";
                echo "<td>{$item->name}</td>";
                echo "<td>" . number_format($item->price, 0, ',', '.') . " VND</td>";
                echo "<td>{$item->quantity}</td>";
                echo "<td>" . number_format($itemTotal, 0, ',', '.') . " VND</td>";
                echo "</tr>";
            }
            
            // Kết thúc bảng
            echo "</table>";
            
            // Hiển thị tổng giá trị giỏ hàng
            echo "<p><strong>Tổng giá trị giỏ hàng:</strong> " . number_format($totalCartValue, 0, ',', '.') . " VND</p>";
        } else {
            echo "<p>Giỏ hàng trống!</p>";
        }
        ?>

        <!-- Truyền thông tin giỏ hàng và tổng giá trị vào form -->
        <input type="hidden" name="total" value="<?php echo $totalCartValue; ?>"> <!-- Sử dụng giá trị từ giỏ hàng -->
        <input type="hidden" name="orderDetails" value="<?php echo htmlspecialchars(json_encode($_SESSION['cart'])); ?>"> <!-- Truyền thông tin giỏ hàng dưới dạng JSON -->
        
        <!-- Nút hoàn tất đơn hàng -->
        <button type="submit">Hoàn tất đơn hàng</button>
    </form>
</body>
</html>
<?php include_once 'app/views/share/footer.php'; ?>
