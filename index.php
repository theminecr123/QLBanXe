<?php
// Require necessary files
require_once 'config/database.php';
require_once 'app/controllers/ProductController.php';
require_once 'app/controllers/OrderController.php'; // Include OrderController
require_once 'app/models/ProductModel.php';
require_once 'app/libs/SessionHelper.php';
require_once 'app/models/AccountModel.php';

// Start session
session_start();

// Parse URL
$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$urlParts = explode('?', $url); // Split URL into path and query parameters
$path = $urlParts[0]; // Get the path part of the URL

// Determine controller and action
$controllerName = '';
$action = '';
if (!empty($path)) {
    $pathParts = explode('/', $path);
    $controllerName = ucfirst($pathParts[0]) . 'Controller';
    $action = isset($pathParts[1]) && $pathParts[1] != '' ? $pathParts[1] : 'index';
}

// Check if the controller file exists
if (!file_exists('app/controllers/' . $controllerName . '.php')) {
    die('Controller not found');
}

// Include the controller file
require_once 'app/controllers/' . $controllerName . '.php';

// Create controller instance
$controller = new $controllerName();

// Special handling for 'showOrderDetail'
if ($controllerName == 'OrderController' && $action == 'showOrderDetail') {
    // Check if the order ID is provided as a query parameter
    if (isset($_GET['orderid']) && $_GET['orderid'] != '') {
        // Call the showOrderDetail method with the order ID
        $controller->showOrderDetail($_GET['orderid']);
        exit(); // Stop further execution
    } else {
        // Handle the case where the order ID is missing
        die('Order ID is missing');
    }
}

// Special handling for 'product/add'
if ($controllerName == 'ProductController' && $action == 'add') {
    $controller->add();
    exit(); // Stop further execution
}

// Call the action method with any additional parameters
call_user_func_array([$controller, $action], array_slice($pathParts, 2));
?>
