<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>

    <?php
    session_start();

    if (isset($_POST['logout'])) {
        // Destroy the session
        session_destroy();

        // Unset the user_data cookie
        setcookie('user_data', '', time() - 3600, '/'); // Set the expiration time to a past value

        // Redirect to the login page
        header("Location: adminlogin.php");
        exit();
    }
    ?>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm py-3 px-2 fixed-top z-3">
        <form class="container-fluid" action="" method="post">
            <a class="btn btn-outline-secondary me-3" data-bs-toggle="offcanvas" href="#offcanvas" role="button" aria-controls="offcanvas">
                <!-- Link with href -->
                <span class="navbar-toggler-icon"></span>
            </a>

            <a class="navbar-brand" href="#"><b>Megah Holdings</b></a>

            <?php if (isset($_SESSION['logged_out']) && !$_SESSION['logged_out']) : ?>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto"> <!-- Added ms-auto class -->
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="adminpage.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Inbox</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Profile</a>
                        </li>
                        <button class="btn btn-light mx-2" name="logout">Logout</button>
                    </ul>
                </div>

            <?php else : ?>

                <button type="button" class="btn btn-light" onclick="window.location.href = 'catalog.php'">
                    Store Page
                </button>


            <?php endif; ?>

        </form>
    </nav>
    <?php include "sidebar.php" ?>

</body>

</html>