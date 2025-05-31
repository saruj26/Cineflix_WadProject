<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="navBar.css">
    <title>Navigation</title>
</head>
<body>
<header class="navbar_header">
    <input type="checkbox" id="chk1">
    <div class="logo">
        <a href="index.php"><i class='bx bxs-movie'></i>CineFlix</a>
    </div>
    <ul>
<!--        <li><a href="#">Home</a></li>-->
<!--        <li><a href="#">Movies</a></li>-->
<!--        <li><a href="#">Services</a></li>-->
<!--        <li><a href="#">About Us</a></li>-->
<!--        <li><a href="#">Contact Us</a></li>-->
        <?php
        if(isset($_SESSION['coust_NIC'])):
        ?>
        <li class="login-mobile"><a href="./HTML/logout.php">Logout</a></li>
        <?php else: ?>
        <li class="login-mobile"><a href="./HTML/movieRentalSystemLogin.php">Login</a></li>
        <?php endif;?>
    </ul>
    <?php
    if(isset($_SESSION['coust_NIC'])):
    ?>
    <div class="login">
        <a href="./HTML/logout.php">Logout</a>
    </div>
    <?php else: ?>
    <div class="login">
        <a href="./HTML/movieRentalSystemLogin.php">Login</a>
    </div>
    <?php endif;?>
    <div class="menu">
        <label for="chk1">
            <i class="fa fa-bars"></i>
        </label>
    </div>
</header>

<script>
    document.querySelectorAll('header ul li a').forEach(link => {
        link.addEventListener('click', () => {
            document.getElementById('chk1').checked = false;
        });
    });
</script>
</body>
</html>
