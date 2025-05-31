<?php
session_start();
include 'DbConnector.php';

$connector = new DbConnector();
$pdo = $connector->getConnection();

$name = $_GET['name'] ?? '';
$id = $_GET['id'] ?? '';
$category = $_GET['category'] ?? '';

$query = "SELECT * FROM movie WHERE 1=1";
$params = [];

if ($name) {
    $query .= " AND movie_Name LIKE :name";
    $params[':name'] = "%$name%";
}

if ($id) {
    $query .= " AND movie_ID = :id";
    $params[':id'] = $id;
}

if ($category) {
    $query .= " AND movie_Category = :category";
    $params[':category'] = $category;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Search</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container h2{
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
    <h2>Find a Movie</h2>
    <form method="get" class="mb-4">
        <div class="form-row">
            <div class="form-group col-md-4">
                <input type="text" class="form-control" name="name" placeholder="Search by Name" value="<?= htmlspecialchars($name) ?>">
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" name="id" placeholder="Search by ID" value="<?= htmlspecialchars($id) ?>">
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="category">
                    <option value="">Select Category</option>
                    <!-- Add your categories here -->
                    <option value="Adventure" <?= $category == 'Adventure' ? 'selected' : '' ?>>Adventure</option>
                    <option value="Comedy" <?= $category == 'Comedy' ? 'selected' : '' ?>>Comedy</option>
                    <!-- Add more options as needed -->
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <?php if ($movies): ?>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Price(for One Day)</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($movies as $movie): ?>
                <tr>
                    <td><?= htmlspecialchars($movie['movie_ID']) ?></td>
                    <td><?= htmlspecialchars($movie['movie_Name']) ?></td>
                    <td><?= htmlspecialchars($movie['movie_Description']) ?></td>
                    <td><?= htmlspecialchars($movie['movie_Category']) ?></td>
                    <td><?= htmlspecialchars($movie['rental_Price']).".00" ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No movies found.</p>
    <?php endif; ?>
</div>
<?php include 'footerNav.php'?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
