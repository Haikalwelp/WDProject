<?php
// Include the necessary files and classes
require_once "../config/autoload.php";
include "usernavigation.php";
// Create an instance of the ProductController
$productController = new ProductController();

// Retrieve the products
$products = $productController->getProductsController();

// Start the session
session_start();

// Check if the cart array exists in the session, if not, initialize it
if (!isset($_SESSION["cart_item"])) {
    $_SESSION["cart_item"] = array();
}

// Process the add to cart action
if (isset($_POST["addToCart"])) {
    $productId = $_POST["productId"];
    $product = $productController->getProductIdByController($productId);
    
    // Check if the product exists
    if ($product) {
        // Create an item array with product details
        $itemArray = array(
            "id" => $product['productid'],
            "name" => $product['product_name'],
            "price" => $product['selling'],
            "quantity" => 1
        );
        
        // Check if the product is already in the cart
        if (isset($_SESSION["cart_item"][$productId])) {
            // Update the quantity if the product is already in the cart
            $_SESSION["cart_item"][$productId]["quantity"] += 1;
        } else {
            // Add the product to the cart
            $_SESSION["cart_item"][$productId] = $itemArray;
        }
        
        // Display the Bootstrap alert for "Added to Cart"
        echo '<div class="alert alert-success" role="alert">Product added to cart successfully!</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<html>
<head>
    <title>Product Information</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        .card-img-top {
            object-fit: cover;
            height: 350px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Product Information</h1>
        <div class="row">
            <?php foreach ($products as $product): ?>
            <div class="col-md-4">
                <div class="card mt-4">
                    <img src="data:image/jpeg;base64,<?php echo $product['productphoto']; ?>" class="card-img-top" alt="Product Image">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['product_name']; ?></h5>
                        <p class="card-text">Category: <?php echo $product['category']; ?></p>
                        <p class="card-text">Price: RM<?php echo $product['selling']; ?></p>
                        <p class="card-text"><?php echo $product['balance']; ?> units left</p>
                        <form method="post" action="">
                            <input type="hidden" name="productId" value="<?php echo $product['productid']; ?>">
                            <button type="submit" name="addToCart" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                                    <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
                                </svg>
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
