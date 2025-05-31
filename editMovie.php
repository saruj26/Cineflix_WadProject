<?php
session_start();
require_once 'DbConnector.php';

$db = new DbConnector();
$conn = $db->getConnection();
$movie = null;
$search_error = null;
$update_success = null;
$update_error = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    $search_term = $_POST['search_term'];
    $search_by = $_POST['search_by'];

    $sql = "SELECT * FROM movie WHERE " . $search_by . " = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$search_term]);

    if ($stmt->rowCount() > 0) {
        $movie = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $search_error = "Movie not found!";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $movie_ID = $_POST['movie_ID'];
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
    $updatePhoto = "";
    if (!empty($photo['name'])) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($photo["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $check = getimagesize($photo["tmp_name"]);
        if ($check === false) {
            $update_error = "File is not an image.";
            $uploadOk = 0;
        }

        if ($photo["size"] > 5000000) {
            $update_error = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $update_error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            $update_error = "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($photo["tmp_name"], $targetFile)) {
                $updatePhoto = file_get_contents($targetFile);
            } else {
                $update_error = "Sorry, there was an error uploading your file.";
            }
        }
    }

    if ($update_error === null) {
        $sql = "UPDATE movie SET movie_Name = ?, movie_Genre = ?, movie_Description = ?, movie_Category = ?, no_copies = ?, Actors = ?, rental_Price = ?, movie_year = ?, movie_time = ?, director = ?, writer = ?, audio = ?, rating = ?, subtitle = ?" . ($updatePhoto ? ", movie_picture = ?" : "") . " WHERE movie_ID = ?";
        $params = [$movie_Name, $movie_Genre, $movie_Description, $movie_Category, $no_copies, $actors, $rental_Price, $movie_year, $movie_time, $director, $writer, $audio, $rating, $subtitle];
        if ($updatePhoto) {
            $params[] = $updatePhoto;
        }
        $params[] = $movie_ID;
        $stmt = $conn->prepare($sql);
        if ($stmt->execute($params)) {
            $update_success = "Movie updated successfully!";
        } else {
            $update_error = "Failed to update the movie!";
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
    <title>Edit Movie</title>
    <style>
        .container h3{
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
    <h3>Search Movie</h3>
    <form method="post">
        <div class="form-group">
            <label for="search_term">Search Term</label>
            <input type="text" id="search_term" name="search_term" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="search_by">Search By</label>
            <select id="search_by" name="search_by" class="form-control" required>
                <option value="movie_ID">ID</option>
                <option value="movie_Name">Name</option>
            </select>
        </div>
        <button type="submit" name="search" class="btn btn-primary">Search</button>
    </form>
    <?php if ($search_error): ?>
        <div class="alert alert-danger mt-3"><?= htmlspecialchars($search_error) ?></div>
    <?php endif; ?>

    <?php if ($movie): ?>
        <h3 class="mt-5">Edit Movie</h3>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="movie_ID" value="<?= htmlspecialchars($movie['movie_ID']) ?>">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="movie_Name">Movie Name</label>
                    <input type="text" id="movie_Name" name="movie_Name" class="form-control" value="<?= htmlspecialchars($movie['movie_Name']) ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="movie_Genre">Movie Genre</label>
                    <input type="text" id="movie_Genre" name="movie_Genre" class="form-control" value="<?= htmlspecialchars($movie['movie_Genre']) ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="movie_Description">Movie Description</label>
                    <textarea id="movie_Description" name="movie_Description" class="form-control" required><?= htmlspecialchars($movie['movie_Description']) ?></textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="movie_Category">Movie Category</label>
                    <input type="text" id="movie_Category" name="movie_Category" class="form-control" value="<?= htmlspecialchars($movie['movie_Category']) ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="no_copies">No. of Copies</label>
                    <input type="number" id="no_copies" name="no_copies" class="form-control" value="<?= htmlspecialchars($movie['no_copies']) ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="actors">Actors</label>
                    <input type="text" id="actors" name="actors" class="form-control" value="<?= htmlspecialchars($movie['Actors']) ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="rental_Price">Rental Price</label>
                    <input type="number" id="rental_Price" name="rental_Price" class="form-control" value="<?= htmlspecialchars($movie['rental_Price']) ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="movie_year">Year of Movie</label>
                    <input type="number" id="movie_year" name="movie_year" class="form-control" value="<?= htmlspecialchars($movie['movie_year']) ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="movie_time">Time of Movie</label>
                    <input type="text" id="movie_time" name="movie_time" class="form-control" value="<?= htmlspecialchars($movie['movie_time']) ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="director">Director</label>
                    <input type="text" id="director" name="director" class="form-control" value="<?= htmlspecialchars($movie['director']) ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="writer">Writer</label>
                    <input type="text" id="writer" name="writer" class="form-control" value="<?= htmlspecialchars($movie['writer']) ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="audio">Audio</label>
                    <input type="text" id="audio" name="audio" class="form-control" value="<?= htmlspecialchars($movie['audio']) ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="rating">Rating</label>
                    <input type="text" id="rating" name="rating" class="form-control" value="<?= htmlspecialchars($movie['rating']) ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="subtitle">Subtitle</label>
                    <input type="text" id="subtitle" name="subtitle" class="form-control" value="<?= htmlspecialchars($movie['subtitle']) ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="photo">Upload Photo of Movie</label>
                    <input type="file" id="photo" name="photo" class="form-control-file">
                </div>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update Movie</button>
        </form>
    <?php endif; ?>
    <?php if ($update_success): ?>
        <div class="alert alert-success mt-3"><?= htmlspecialchars($update_success) ?></div>
    <?php elseif ($update_error): ?>
        <div class="alert alert-danger mt-3"><?= htmlspecialchars($update_error) ?></div>
    <?php endif; ?>
</div>
<?php include 'footerNav.php'?>
</body>
</html>
