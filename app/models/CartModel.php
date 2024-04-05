<?php

class CartModel
{
    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($product)
    {
        // Khởi tạo một phiên cart nếu chưa tồn tại
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
        $productExist = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item->id == $product->id) {
                $item->quantity++;
                $productExist = true;
                break;
            }
        }

        // Nếu sản phẩm chưa tồn tại trong giỏ hàng, thêm mới vào
        if (!$productExist) {
            $product->quantity = 1;
            $_SESSION['cart'][] = $product;
        }
    }

    // Cập nhật số lượng của sản phẩm trong giỏ hàng
    public function updateQuantity($productId, $newQuantity)
    {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item->id == $productId) {
                $item->quantity = $newQuantity;
                break;
            }
        }
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart($productId)
    {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item->id == $productId) {
                unset($_SESSION['cart'][$key]);
                break;
            }
        }
    }

    // Lấy danh sách sản phẩm trong giỏ hàng
    public function getCartItems()
    {
        return isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    }
}
?>
