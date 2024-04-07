<?php
class ProductController
{
    private $productModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }
    public function listProducts()
    {
        $database = new Database();
        $db = $database->getConnection();

        $product = new ProductModel($db);
        $stmt = $product->readAll();

        include_once 'app/views/share/index.php';
    }
    public function add()
    {
        if (!SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập trang này";
            exit;
        }else{
        // Xử lý tạo sản phẩm
            include_once 'app/views/product/add.php';
        }

    }

    public function uploadImage($file)
    {
        $targetDirectory = "uploads/";
        $targetFile = $targetDirectory . basename($file["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Kiểm tra xem file có phải là hình ảnh thực sự hay không
        $check = getimagesize($file["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        // Kiểm tra kích thước file
        if ($file["size"] > 500000) { // Ví dụ: giới hạn 500KB
            $uploadOk = 0;
        }

        // Kiểm tra định dạng file
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $uploadOk = 0;
        }

        // Kiểm tra nếu $uploadOk bằng 0
        if ($uploadOk == 0) {
            return false;
        } else {
            if (move_uploaded_file($file["tmp_name"], $targetFile)) {
                return $targetFile;
            } else {
                return false;
            }
        }
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $uploadResult = false;
            if (isset($_FILES["image"])) {
                $uploadResult = $this->uploadImage($_FILES["image"]);
            }
            $result = $this->productModel->createProduct($name, $description, $price, $uploadResult);
            if (is_array($result)) {
                $errors = $result;
                include_once 'app/views/product/add.php';
            } else {
                //header('Location: /QLBanXe  ');
                header('Location: /QLBanXe/product/listProducts');
            }
        }
    }

    public function edit()
{
    if (!SessionHelper::isAdmin()) {
        echo "Bạn không có quyền truy cập trang này";
        exit;
    }else{
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            // Check if form is submitted
            $id = $_POST['id'] ?? '';
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $uploadResult = false;
            if (isset($_FILES["image"])) {
                $uploadResult = $this->uploadImage($_FILES["image"]);
            }

            // Update product data
            $result = $this->productModel->updateProduct($id, $name, $description, $price, $uploadResult);
            if ($result) {
                // Redirect to the product list page after successful update
                //header('Location: /QLBanXe');
                header('Location: /QLBanXe/product/listProducts');
                exit;
            } else {
                // Handle error scenario, if any
                // For example, you can include an error message and re-display the edit form
                $errors = array("Failed to update product. Please try again.");
                include_once 'app/views/product/edit.php';
            }
        } else {
            // Handle the case where the form is not submitted
            // This block will be executed when the user navigates to the edit page without submitting the form
            // Retrieve the 'id' parameter from the URL
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
            } else {
                // Handle the case where 'id' parameter is not provided
                // For example, redirect to the homepage
                //header('Location: /QLBanXe');
                header('Location: /QLBanXe/product/listProducts');
                exit;
            }

            // Use the retrieved 'id' to fetch the product
            $product = $this->productModel->getProductById($id);
            if (!$product) {
                // Handle the case where product is not found
                //header('Location: /QLBanXe');
                header('Location: /QLBanXe/product/listProducts');
                exit;
            }

            // Pass the retrieved product data to the view for display
            include_once 'app/views/product/edit.php';
        }
    }
}

public function delete($id)
{
    echo "ID sản phẩm cần xoá: " . $id;
    if (!SessionHelper::isAdmin()) {
        echo "Bạn không có quyền truy cập trang này";
        exit;
    }else{
        if ($this->productModel->deleteProduct($id)) {
            echo "Xoá sản phẩm thành công!";
            //header('Location: /QLBanXe');
            header('Location: /QLBanXe/product/listProducts');
            exit;
        } else {
            // Handle error scenario
            // For example, redirect back to the product list page with an error message
            echo "Xảy ra lỗi khi xoá sản phẩm!";
            header('Location: /QLBanXe?error=delete_failed');
            exit;
        }
    }
}
}