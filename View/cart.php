<?php
// Include the necessary files and classes
require_once "../config/autoload.php";
include "usernavigation.php";
// Create an instance of the ProductController
$productController = new ProductController();

// Start the session
session_start();

// Check if the cart array exists in the session, if not, initialize it
if (!isset($_SESSION["cart_item"])) {
    $_SESSION["cart_item"] = array();
}

// Process the remove action
if (isset($_GET["action"])) {
    if ($_GET["action"] === "remove" && isset($_GET["code"])) {
        $productId = $_GET["code"];

        // Check if the product is in the cart
        if (isset($_SESSION["cart_item"][$productId])) {
            // Remove the product from the cart
            unset($_SESSION["cart_item"][$productId]);

            // Redirect back to the shopping cart page
            header("Location: cart.php");
            exit();
        }
    } elseif ($_GET["action"] === "empty") {
        // Empty the cart
        unset($_SESSION["cart_item"]);

        // Redirect back to the shopping cart page
        header("Location: cart.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<html>
<head>
    <title>Shopping Cart</title>
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
        <h1 class="mt-4">Shopping Cart</h1>
        <?php if (empty($_SESSION["cart_item"])): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <table class="table mt-4">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalPrice = 0;
                    foreach ($_SESSION["cart_item"] as $productId => $item):
                        $product = $productController->getProductIdByController($productId);
                        if (!$product) {
                            continue;
                        }
                        $productPrice = $product['selling'];
                        $productName = $product['product_name'];
                        $quantity = $item['quantity'];
                        $itemTotal = $productPrice * $quantity;
                        $totalPrice += $itemTotal;
                        ?>
                        <tr>
                            <td><?php echo $productName; ?></td>
                            <td>RM<?php echo $productPrice; ?></td>
                            <td><?php echo $quantity; ?></td>
                            <td>RM<?php echo $itemTotal; ?></td>
                            <td>
                                <a href="cart.php?action=remove&code=<?php echo $productId; ?>" class="btn btn-danger btn-sm">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" align="right">Total:</td>
                        <td colspan="2">RM<?php echo $totalPrice; ?></td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-4">
                <a href="cart.php?action=empty" class="btn btn-secondary">Clear Cart</a>
                <a href="catalog.php" class="btn btn-primary">Continue Shopping</a>
            </div>
        <?php endif; ?>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
