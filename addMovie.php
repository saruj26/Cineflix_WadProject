<?php
session_start();
require_once 'DbConnector.php';

$db = new DbConnector();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $movie_ID = uniqid("M");
    $movie_Name = $_POST['movie_Name'];
    $movie_Genre = $_POST['movie_Genre'];
    $movie_Description = $_POST['movie_Description'];
    $movie_Category = $_POST['movie_Category'];
    $no_copies = $_POST['no_copies'];
    $actors = $_POST['actors'];
    $rental_Price = $_POST['rental_Price'];
    $movie_year = $_POST['movie_year'];
    $movie_time = $_POST['movie_time'];
    $director = $_POST['director'];
    $writer = $_POST['writer'];
    $audio = $_POST['audio'];
    $rating = $_POST['rating'];
    $subtitle = $_POST['subtitle'];

    $photo = $_FILES['photo'];

    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($photo["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));


    $check = getimagesize($photo["tmp_name"]);
    if ($check === false) {
        $error = "File is not an image.";
        $uploadOk = 0;
    }


    if ($photo["size"] > 5000000) {
        $error = "Sorry, your file is too large.";
        $uploadOk = 0;
    }


    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }


    if ($uploadOk == 0) {
        $error = "Sorry, your file was not uploaded.";
    } else {

        if (move_uploaded_file($photo["tmp_name"], $targetFile)) {

            $sql = "INSERT INTO movie (movie_ID, movie_Name, movie_Genre, movie_Description, movie_Category, no_copies, Actors, rental_Price, movie_year, movie_time, director, writer, audio, rating, subtitle, movie_picture) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$movie_ID, $movie_Name, $movie_Genre, $movie_Description, $movie_Category, $no_copies, $actors, $rental_Price, $movie_year, $movie_time, $director, $writer, $audio, $rating, $subtitle, file_get_contents($targetFile)]);

            $success = "Movie added successfully!";
        } else {
            $error = "Sorry, there was an error uploading your file.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Add Movie</title>
    <style>
        .container h1{
            margin-top:90px ;
        }
        .container{
            width: 100%;
            min-height:85vh ;
            height: 100%;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-5">
    <h1>Add Movie</h1>

    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="movie_Name">Movie Name</label>
                <input type="text" id="movie_Name" name="movie_Name" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
                <label for="movie_Genre">Movie Genre</label>
                <input type="text" id="movie_Genre" name="movie_Genre" class="form-control" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="movie_Description">Movie Description</label>
                <textarea id="movie_Description" name="movie_Description" class="form-control" required></textarea>
            </div>
            <div class="form-group col-md-6">
                <label for="movie_Category">Movie Category</label>
                <input type="text" id="movie_Category" name="movie_Category" class="form-control" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="no_copies">No. of Copies</label>
                <input type="number" id="no_copies" name="no_copies" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
                <label for="actors">Actors</label>
                <input type="text" id="actors" name="actors" class="form-control" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="rental_Price">Rental Price</label>
                <input type="number" id="rental_Price" name="rental_Price" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
                <label for="movie_year">Year of Movie</label>
                <input type="number" id="movie_year" name="movie_year" class="form-control" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="movie_time">Time of Movie</label>
                <input type="text" id="movie_time" name="movie_time" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
                <label for="director">Director</label>
                <input type="text" id="director" name="director" class="form-control" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="writer">Writer</label>
                <input type="text" id="writer" name="writer" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
                <label for="audio">Audio</label>
                <input type="text" id="audio" name="audio" class="form-control" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="rating">Rating</label>
                <input type="text" id="rating" name="rating" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
                <label for="subtitle">Subtitle</label>
                <input type="text" id="subtitle" name="subtitle" class="form-control" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="photo">Upload Photo of Movie</label>
                <input type="file" id="photo" name="photo" class="form-control-file" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Add Movie</button>
    </form>
</div>
<?php include 'footerNav.php'?>
</body>
</html>
