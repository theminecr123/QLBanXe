<?php
class DefaultController{
    private $productModel;
    private $db;
    public function __construct(){
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);

    }
    public function index(){
        //Gatewaycx
        if(!SessionHelper::isLoggedIn()){
            header('Location: /QLBanXe/account/login');
        }else{
            header('Location: /QLBanXe/product/listProducts');
        }

        $products = $this->productModel->readAll();
        include_once 'app/views/share/index.php';
    }
}