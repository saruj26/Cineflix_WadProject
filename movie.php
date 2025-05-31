<?php
session_start();
require 'DbConnector.php';

$movie_Id = $_GET['s'];

$db = new DbConnector();
$conn = $db->getConnection();

$query = "SELECT * FROM movie WHERE movie_ID = ?";
$stmt = $conn->prepare($query);
$stmt->bindValue(1, $movie_Id);
$stmt->execute();
$movie = $stmt->fetch(PDO::FETCH_ASSOC);

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $days = $_POST['days'];
    $coustNIC = $_SESSION['coust_NIC'];
    $requestID =uniqid('Rq');
    $date = date("Y-m-d");


    $query2 = "SELECT no_copies FROM movie WHERE movie_ID = ?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bindParam(1, $movie_Id);
    $stmt2->execute();
    $rs = $stmt2->fetch(PDO::FETCH_OBJ);
    $copies = $rs->no_copies;
    if($copies == 0) {
        echo '<script>
    alert("Sorry not enough copies");
            </script>';
    }else {
        $query = "INSERT INTO request (request_ID ,coust_NIC,movie_ID,days,date) VALUES (?,?,?,?,?)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $requestID);
        $stmt->bindParam(2, $coustNIC);
        $stmt->bindParam(3, $movie_Id);
        $stmt->bindParam(4, $days);
        $stmt->bindParam(5, $date);
        $stmt->execute();


        $query3 = "UPDATE movie SET no_copies = no_copies - 1 WHERE movie_ID = ?";
        $stmt3 = $conn->prepare($query3);
        $stmt3->bindParam(1, $movie_Id);
        $stmt3->execute();


        echo '<script>
    alert("Your request has been submitted!");
            </script>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Preview</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link href="moviePreview.css" rel="stylesheet">
    <style>
        .container{
            width: 100%;
            min-height:80vh ;
            height: 100%;
        }
    </style>
</head>
<header>
    <?php include 'navigate.php' ?>
</header>
<body style="margin-top: 120px">
<div class="container mt-5">
    <div class="movie-card">
        <img src="data:image/jpeg;base64,<?= base64_encode($movie['movie_picture']) ?>" alt="Kill Bill Poster">
        <div class="details">
            <h2><?= $movie['movie_Name']?></h2>
            <p><?= $movie['movie_year'] ?> | <?= $movie['movie_time'] ?></p>
            <p><?= $movie['movie_Genre']?></p>
            <div class="rating">
                <span>⭐ <?= $movie['rating'] ?></span>
            </div>
            <p><?= $movie['movie_Description']?></p>
            <div class="buttons">
                <form action="movie.php?s=<?=$movie_Id?>" method="POST" >
                    <label for="days">Days: </label>
                    <input type="number" name="days"  /><br/>
                <button class="btn btn-play">Request</button>
                </form>
            </div>
            <div class="mt-3">
                <p><strong>Directed By:</strong> <?= $movie['director'] ?>o</p>
                <p><strong>Written By:</strong><?=$movie['writer'] ?></p>
                <p><strong>Audio:</strong><?= $movie['audio'] ?></p>
                <p><strong>Subtitle:</strong><?= $movie['subtitle'] ?></p>
            </div>
        </div>
    </div>
</div>
<?php include 'footerNav.php'?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

