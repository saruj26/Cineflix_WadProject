<?php
session_start();
require 'DbConnector.php';

$db = new DbConnector();
$conn = $db->getConnection();

// Fetch categories for the dropdown
$categoryQuery = "SELECT DISTINCT movie_Category FROM movie";
$categoryStmt = $conn->query($categoryQuery);
$categories = $categoryStmt->fetchAll(PDO::FETCH_COLUMN);

$search = $_POST['search'] ?? '';
$category = $_POST['category'] ?? $_GET['category'] ?? '';

// Fetch movies with images and apply search filters
$sql = "SELECT movie_ID, movie_Name, movie_picture,rating FROM movie WHERE 
        (movie_Name LIKE :search OR :search = '') 
        AND (movie_Category = :category OR :category = '')";

$stmt = $conn->prepare($sql);
$stmt->execute([
    ':search' => "%$search%",
    ':category' => $category
]);
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Movies</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="movies.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">
    <style>
        .container{
            width: 100%;
            min-height:85vh ;
            height: 100%;
        }
    </style>
</head>
<body>
<header>
    <?php include('navigate.php'); ?>
</header>
<div class="container">
    <div class="search-container">
        <form method="post" class="mb-4">
            <div class="input-group mb-3">
                <input type="text" class="form-control search-input" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search by name...">
                <select name="category" class="form-control category-select">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= htmlspecialchars($cat) ?>" <?= $cat == $category ? 'selected' : '' ?>><?= htmlspecialchars($cat) ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="input-group-append">
                    <button class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="row image-container">
        <?php foreach ($movies as $movie): ?>
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4 position-relative">
                <img src="data:image/jpeg;base64,<?= base64_encode($movie['movie_picture']) ?>" class="img-fluid" alt="<?= htmlspecialchars($movie['movie_Name']) ?>">
                <div class="overlay">
                    <a class="btn btn-primary" href="movie.php?s=<?= $movie['movie_ID'] ?>">Preview</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include 'footerNav.php'?>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>
