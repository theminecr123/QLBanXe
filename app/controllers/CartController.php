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

    public function updateQuality($id)
    {
        if(isset($_POST['quality'])) {
            $newQuantity = $_POST['quality'];
            foreach ($_SESSION['cart'] as &$item) {
                if ($item->id == $id) {
                    $item->quantity = $newQuantity;
                    break;
                }
            }
        }
        echo json_encode(['cart' => $_SESSION['cart']]);
    }

    public function deleteItem($id)
    {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item->id == $id) {
                unset($_SESSION['cart'][$key]);
                break;
            }
        }
        echo json_encode(['cart' => $_SESSION['cart']]);
    }

    public function add($id)
    {
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

    public function show()
    {
        include_once 'app/views/cart/index.php';
    }

}
