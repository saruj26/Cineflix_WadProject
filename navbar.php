<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NavBar</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <script src="https://kit.fontawesome.com/5bdc1c9d60.js" crossorigin="anonymous"></script>
    <style>
        .nav-link{
            border-radius: 50px;
        }
        .nav-link:hover{
            transform: scale(1.08);
        }

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg fixed-top" style="background-color: #001f3f;height: 70px;">
    <a class="navbar-brand text-white" href="sale.php"><i class="fa-solid fa-clapperboard"></i>   CineFlix</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white" href="sale.php">Rent Movies</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="requestMovie.php">Requested Movies</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="recieveMovie.php">Receive Movies</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="findMovie.php">Find Movie</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="findCustomer.php">Find Customer</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="addCustomer.php">Add Customer</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="editCustomer.php">Edit Customer</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="addMovie.php">Add Movie</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="editMovie.php">Edit Movie</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">

            <li class="nav-item">
                <a class="nav-link text-white" href="#">
                    <?php
                    if(isset($_SESSION['fname'])){
                        echo htmlspecialchars($_SESSION['fname']);
                    }else{
                        header("location: login.php");
                    }
                    ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="login.php">Logout</a>
            </li>

        </ul>

    </div>
</nav>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
