<?php
class CartController
{
    private $productModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    // Hàm để thêm sản phẩm vào giỏ hàng
    public function add($id){
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $product = $this->productModel->getProductById($id);
        if ($product) {
            $productExist = false;
            foreach ($_SESSION['cart'] as &$item) {
                if ($item->id == $id) {
                    $item->quantity++;
                    $productExist = true;
                    break;
                }
            }
            if (!$productExist) {
                $product->quantity = 1;
                $_SESSION['cart'][] = $product;
            }
            header('Location: /QLBanXe/cart/show');
        } else {
            echo "Không tìm thấy sản phẩm với ID này!";
        }
    }

    // Hàm để hiển thị giỏ hàng
    public function show(){
        include_once 'app/views/cart/index.php';
    }

    // Hàm để xoá sản phẩm khỏi giỏ hàng
    public function deleteItem($id){
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item->id == $id) {
                unset($_SESSION['cart'][$key]);
                break;
            }
        }
        header('Location: /QLBanXe/cart/show');
    }

    // Hàm để cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateQuantity(){
        $id = $_POST['id'];
        $quantity = $_POST['quantity'];

        foreach ($_SESSION['cart'] as &$item) {
            if ($item->id == $id) {
                $item->quantity = $quantity;
                break;
            }
        }

        // Trả về kết quả cập nhật thành công dưới dạng JSON
        header('Content-Type: application/json');
        echo json_encode(array('success' => true));
    }

    // Hàm để tính toán và trả về tổng giá trị của giỏ hàng dưới dạng JSON
    public function getTotalCartValue() {
        $totalCartValue = 0;

        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $totalCartValue += $item->price * $item->quantity;
            }
        }

        header('Content-Type: application/json');
        echo json_encode(array('total' => $totalCartValue));
    }
}
?>
