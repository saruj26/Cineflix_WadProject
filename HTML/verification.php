<?php

session_start();

if(isset($_SESSION['coust_NIC'])) {
    header("location:../index.php");
    exit();
}else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<h1>Please Verify email</h1>
</body>
</html>


    <?php
}?>