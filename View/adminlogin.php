<?php
session_start();

include "../config/autoload.php";
$show_error = false;

if (isset($_SESSION['logged_out']) && !$_SESSION['logged_out']) {
    header("Location: adminpage.php");
    exit();
}

if (isset($_POST['Login'])) {
    // Retrieve the submitted email and password
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Assuming the getAdminController method is part of your class
    $adminController = new AdminController();
    $admin = $adminController->getAdminController($email, $password);

    if ($admin) {
        // Admin authentication successful
        $userData = [
            'login' => true,
            // Other relevant user data
        ];

        // Set the cookie with the user data
        setcookie('user_data', json_encode($userData), time() + (86400 * 30), '/'); // Adjust the expiration time as needed

        $_SESSION['logged_out'] = false;
        header("Location: adminpage.php");
        exit();
    } else {
        // Admin authentication failed
        $_SESSION['logged_out'] = true;
        $show_error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Megah Holdings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>
    <?php include "adminnavigation.php"; ?>

    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card px-5 w-50">
            <div class="card-body">
                <div class="mt-3">
                    <h1>Welcome to Megah Inventory Management</h1>
                </div>
                <div class="mt-3 mb-4">
                    <h3>Login to Start Managing</h3>
                </div>
                <form action="#" method="post">
                    <?php
                    if ($show_error) {
                        if ($show_error == true) {
                            echo '
                           <div class="my-3 alert alert-danger" role="alert">
                                Incorrect email or password
                           </div>
                           ';
                        }
                    };
                    ?>
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" class="form-control" placeholder="name@example.com" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" placeholder="**********" name="password" required>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-link">Forgot password?</button>
                    </div>
                    <div class="my-3">
                        <input type="submit" value="Login" name="Login" class="btn btn-primary w-100">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
        crossorigin="anonymous"></script>
</body>

</html>
