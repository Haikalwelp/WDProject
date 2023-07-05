<?php
// Include necessary files and initialize classes
require_once "../config/autoload.php";
$orderController = new OrderController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form is submitted
    if (isset($_POST['orderId']) && isset($_POST['orderStatus'])) {
        $orderId = $_POST['orderId'];
        $newStatus = $_POST['orderStatus'];

        // Update the order status
        $orderController = new OrderController();
        $result = $orderController->updateOrderStatusController($orderId, $newStatus);

        if ($result) {
            // Redirect to avoid form resubmission
            header("Location: ordermanagement.php");
            exit;
        } else {
            $errorMessage = "Failed to update order status.";
        }
    }
}

// Retrieve the message from the URL query parameter (if present)
$message = isset($_GET['message']) ? $_GET['message'] : "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Orders with Users</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Styles/style.css">
    <style>
        /* Custom CSS styles */
        .form-control[readonly] {
            background-color: #f8f9fa; /* Set the desired background color for read-only fields */
        }
    </style>
</head>

<body>
    <?php include "adminnavigation.php"; ?>
    <br><br><br><br>
    <div class="container">
        <h1>Order Management</h1>
        <?php
        // Display the message if present
        if (!empty($message)) {
            echo "<div class='alert alert-info'>$message</div>";
        }
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>Address</th>
                    <th>Payment Method</th>
                    <th>Order Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Include necessary files and initialize classes
                $userController = new UserController();

                // Get all orders
                $orders = $orderController->getOrdersController();

                if ($orders) {
                    foreach ($orders as $order) {
                        $orderId = $order['orderid'];
                        $userId = $order['userid'];

                        // Get user details based on user ID
                        $user = $userController->getUserByIdController($userId);

                        if ($user) {
                            $userName = $user['username'];
                        } else {
                            $userName = "User Not Found";
                        }

                        $orderStatus = $order['orderstatus'];
                        $statusClass = '';

                        switch ($orderStatus) {
                            case 'Pending':
                                $statusClass = 'pending';
                                break;
                            case 'Shipped':
                                $statusClass = 'shipped';
                                break;
                            case 'Cancelled':
                                $statusClass = 'cancelled';
                                break;
                            case 'Refund':
                                $statusClass = 'refund';
                                break;
                            default:
                                $statusClass = '';
                        }

                        // Generate a unique ID for the edit modal
                        $editModalId = "editModal_$orderId";

                        echo "<tr>";
                        echo "<td>$orderId</td>";
                        echo "<td>$userId</td>";
                        echo "<td>$userName</td>";
                        echo "<td>{$order['address']}</td>";
                        echo "<td>{$order['paymentmethod']}</td>";
                        echo "<td><span class='order-status $statusClass'>$orderStatus</span></td>";

                        // Add the Edit button
                        echo "<td><button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#$editModalId'>Edit</button></td>";

                        echo "</tr>";

                        // Create the Edit modal
                        echo "<div class='modal fade' id='$editModalId' tabindex='-1' role='dialog' aria-labelledby='editModalLabel' aria-hidden='true'>";
                        echo "<div class='modal-dialog' role='document'>";
                        echo "<div class='modal-content'>";
                        echo "<div class='modal-header'>";
                        echo "<h5 class='modal-title' id='editModalLabel'>Edit Order</h5>";
                        echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                        echo "</div>";
                        echo "<div class='modal-body'>";
                        echo "<form method='post' action=''>";
                        // Add input fields for editing the order details
                        echo "<div class='form-group'>";
                        echo "<label for='orderId'>Order ID:</label>";
                        echo "<input type='text' class='form-control' id='orderId' name='orderId' value='$orderId' readonly>";
                        echo "</div>";
                        echo "<div class='form-group'>";
                        echo "<label for='userId'>User ID:</label>";
                        echo "<input type='text' class='form-control' id='userId' name='userId' value='$userId' readonly>";
                        echo "</div>";
                        echo "<div class='form-group'>";
                        echo "<label for='userName'>User Name:</label>";
                        echo "<input type='text' class='form-control' id='userName' name='userName' value='$userName' readonly>";
                        echo "</div>";
                        echo "<div class='form-group'>";
                        echo "<label for='address'>Address:</label>";
                        echo "<input type='text' class='form-control' id='address' name='address' value='{$order['address']}' readonly>";
                        echo "</div>";
                        echo "<div class='form-group'>";
                        echo "<label for='paymentMethod'>Payment Method:</label>";
                        echo "<input type='text' class='form-control' id='paymentMethod' name='paymentMethod' value='{$order['paymentmethod']}' readonly>";
                        echo "</div>";
                        echo "<div class='form-group'>";
                        echo "<label for='orderStatus'>Order Status:</label>";
                        echo "<div class='dropdown'>";
                        echo "<button class='btn btn-secondary dropdown-toggle' type='button' id='orderStatusDropdown' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
                        echo "$orderStatus";
                        echo "</button>";
                        echo "<div class='dropdown-menu' aria-labelledby='orderStatusDropdown'>";
                        echo "<a class='dropdown-item' href='#' data-status='Pending'>Pending</a>";
                        echo "<a class='dropdown-item' href='#' data-status='Shipped'>Shipped</a>";
                        echo "<a class='dropdown-item' href='#' data-status='Cancelled'>Cancelled</a>";
                        echo "<a class='dropdown-item' href='#' data-status='Refund'>Refund</a>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "<div class='modal-footer'>";
                        echo "<button type='submit' class='btn btn-primary'>Save Changes</button>";
                        echo "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>";
                        echo "</div>";
                        echo "</form>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No orders found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script>
        // Handle order status selection in the edit modal
        const dropdownItems = document.querySelectorAll('.dropdown-item[data-status]');
        dropdownItems.forEach(item => {
            item.addEventListener('click', function(event) {
                event.preventDefault();
                const selectedStatus = this.getAttribute('data-status');
                const dropdownToggle = this.closest('.dropdown').querySelector('.dropdown-toggle');
                dropdownToggle.textContent = selectedStatus;
            });
        });
    </script>
</body>

</html>
