<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NavBar</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg" style="background-color: #001f3f;">
    <a class="navbar-brand text-white" href="#">CineFlix</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white" href="sale.php">Customer Manangement </a>
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
            <?php
            if($_SESSION["is_admin"]){?>
                <li class="nav-item">
                    <a class="nav-link text-white" href="admin.php">Admin Panal</a>
                </li>
            <?php }
            ?>
        </ul>
    </div>
</nav>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
