<?php include_once 'app/views/share/header.php'; ?>
<?php unset($_SESSION['cart']);?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
</head>
<body>
    <p class="order-success" style="margin-left:450px;font-size:32px">Đặt hàng thành công!</p>
    <img style="width: 200px;margin-left: 500px; padding-bottom: 20px;" src="https://cdn1.iconfinder.com/data/icons/toolbar-signs/512/OK-512.png">
    <a href="showOrderHistory" class="btn btn-primary" style="margin-left: -190px;margin-top:250px;">Xem lịch sử đơn hàng</a>
</body>
</html>

<?php include_once 'app/views/share/footer.php'; ?>
