<?php

class OrderModel
{
    private $conn;
    private $table_name = "orders";
    private $table_child = "detailorders";
    public $id;
    public $userID;
    public $order_date;
    public $total;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createOrder($userID, $total)
    {
        // Tạo bản ghi mới trong bảng 'orders'
        $query = "INSERT INTO $this->table_name (userID, orderdate, total) VALUES (?, NOW(), ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userID, $total]);
        $orderId = $this->conn->lastInsertId();

        // Tạo các bản ghi trong bảng 'orderdetails' cho từng sản phẩm trong giỏ hàng
        $query = "INSERT INTO $this->table_child (orderID, productID, quantity) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        foreach ($_SESSION['cart'] as &$item) {
            $stmt->execute([$orderId, $item->id, $item->quantity]);
        }


        return $orderId;
    }

    public function getOrderHistory($userID)
    {
        $query = "SELECT * FROM $this->table_name WHERE userID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userID]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function getOrderDetails($orderId)
    {
        // Query to get order details for a specific order ID
        $query = "SELECT * FROM $this->table_child WHERE orderID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$orderId]);
        $orderDetails = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $orderDetails;
        
        
    }
    public function getOrderDetailsWithImages($orderId)
    {
        $query = "SELECT od.productID, od.quantity, p.image 
                  FROM detailorders od
                  INNER JOIN products p ON od.productID = p.id
                  WHERE od.orderID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
}
