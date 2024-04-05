<?php

// Include các file cần thiết
include_once 'app/models/OrderModel.php'; // Đảm bảo đường dẫn phù hợp với cấu trúc của bạn
include_once 'app/models/CartModel.php'; // Đảm bảo đường dẫn phù hợp với cấu trúc của bạn

class OrderController
{
    private $orderModel;
    private $cartModel;

    public function __construct()
    {        
        $this->db = (new Database())->getConnection();
        $this->orderModel = new OrderModel($this->db);
        $this->cartModel = new CartModel();
    }
    // Phương thức để hiển thị form checkout
    public function showCheckoutForm()
    {
        // Lấy thông tin giỏ hàng từ session
        $cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

        // Hiển thị form checkout
        include_once 'app/views/order/checkout.php'; // 
    }

    public function createOrder()
    {
        // Lấy thông tin đơn hàng từ form hoặc request
        $userID = $_SESSION['id'];
        $total = $_POST['total'];
        //$orderDetails = $_SESSION['cart']; 
        // Tạo đơn hàng mới
        $orderId = $this->orderModel->createOrder($userID, $total);

        if ($orderId) {
            // Đơn hàng đã được tạo thành công, xử lý tiếp theo (ví dụ: redirect đến trang thành công)
            include_once 'app/views/order/success.php'; // Đảm bảo đường dẫn phù hợp với cấu trúc của bạn
        } else {
            // Xử lý lỗi (ví dụ: hiển thị thông báo lỗi)
            echo "Đã xảy ra lỗi khi tạo đơn hàng.";
        }
    }
    
    public function showOrderHistory()
{
    // Get the user's ID from the session
    $userID = $_SESSION['id'];

    // Get order history for the user
    $orderHistory = $this->orderModel->getOrderHistory($userID);

    // Pass $orderModel variable to the view file
    $orderModel = $this->orderModel;

    // Include the order history view
    include_once 'app/views/order/orderhistory.php';
}
public function showOrderDetail($orderId)
{
    // Get order details with images
    $orderDetails = $this->orderModel->getOrderDetailsWithImages($orderId);

    // Include the order detail view
    include_once 'app/views/order/orderdetail.php';
}


}
