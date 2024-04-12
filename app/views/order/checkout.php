<?php include_once 'app/views/share/header.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!-- Link to CSS file for styling -->
    <link rel="stylesheet" href="/path/to/your/css/style.css">
    <style>
        /* CSS styling */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .checkout-container {
            max-width: 800px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .order-summary {
            margin-top: 20px;
            border-bottom: 1px solid #ccc;
        }
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .cart-table th, .cart-table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        .total-value {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .checkout-form {
            text-align: center;
            margin-top: 20px;
        }
        /* Style for the submit button */
        .complete-order-btn {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .complete-order-btn:hover {
            background-color: #45a049;
        }
        /* Style for the collapsible column */
        .collapsible {
            cursor: pointer;
            padding: 10px;
            border: none;
            outline: none;
            width: 100%;
            background-color: #f1f1f1;
            text-align: left;
        }
        .content {
            display: none;
            padding: 10px;
            border: 1px solid #ccc;
            border-top: none;
        }
    </style>
</head>

<body>
    <div class="checkout-container">
        <h1>Checkout</h1>
        
        <!-- Order Summary -->
        <section class="order-summary">
   
                <?php
                $totalCartValue = 0;
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    echo "<table class='cart-table'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Image</th>";
                    echo "<th>ID</th>";
                    echo "<th>Name</th>";
                    echo "<th>Price</th>";
                    echo "<th>Quantity</th>";
                    echo "<th>Total</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    
                    foreach ($_SESSION['cart'] as $item) {
                        $itemTotal = $item->price * $item->quantity;
                        $totalCartValue += $itemTotal;
                        echo "<tr>";
                        echo "<td><img src='/QLBanXe/{$item->image}' alt='Product Image' width='100' height='100'></td>";
                        echo "<td>{$item->id}</td>";
                        echo "<td>{$item->name}</td>";
                        echo "<td>" . number_format($item->price, 0, ',', '.') . " VND</td>";
                        echo "<td>{$item->quantity}</td>";
                        echo "<td>" . number_format($itemTotal, 0, ',', '.') . " VND</td>";
                        echo "</tr>";
                    }
                    
                    echo "</tbody>";
                    echo "</table>";
                    echo "<p class='total-value'><strong>Total:</strong> " . number_format($totalCartValue, 0, ',', '.') . " VND</p>";
                } else {
                    echo "<p>Your cart is empty!</p>";
                }
                ?>
        </section>
        
        <!-- Checkout Form -->
        <section class="checkout-form">
            <form action="/QLBanXe/order/createOrder" method="post">
                <input type="hidden" name="total" value="<?php echo $totalCartValue; ?>"> <!-- Use cart total -->
                <input type="hidden" name="orderDetails" value="<?php echo htmlspecialchars(json_encode($_SESSION['cart'])); ?>"> <!-- Send cart info as JSON -->
                
                <!-- Complete Order Button -->
                <button type="submit" class="complete-order-btn">Complete Order</button>
            </form>
        </section>
    </div>
    

</body>

</html>

<?php include_once 'app/views/share/footer.php'; ?>
        