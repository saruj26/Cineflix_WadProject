<?php
session_start();
require_once 'DbConnector.php';

$db = new DbConnector();
$conn = $db->getConnection();

if (!isset($_SESSION['checkout'])) {
    $_SESSION['checkout'] = [];
}


if (isset($_POST['add'])) {
    $movieId = $_POST['movie_id'];
    if (!isset($_SESSION['checkout'][$movieId])) {
        $_SESSION['checkout'][$movieId] = 1;
    } else {
        $_SESSION['checkout'][$movieId]++;
    }
}


if (isset($_POST['remove'])) {
    $movieId = $_POST['movie_id'];
    if (isset($_SESSION['checkout'][$movieId])) {
        $_SESSION['checkout'][$movieId]--;
        if ($_SESSION['checkout'][$movieId] <= 0) {
            unset($_SESSION['checkout'][$movieId]);
        }
    }
}

$categoryQuery = "SELECT DISTINCT movie_Category FROM movie";
$categoryStmt = $conn->query($categoryQuery);
$categories = $categoryStmt->fetchAll(PDO::FETCH_COLUMN);


$search = $_POST['search'] ?? '';
$category = $_POST['category'] ?? '';

$sql = "SELECT * FROM movie WHERE 
        (movie_Name LIKE :search OR :search = '') 
        AND (movie_Category = :category OR :category = '')";

$stmt = $conn->prepare($sql);
$stmt->execute([
    ':search' => "%$search%",
    ':category' => $category
]);
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);


$customerNIC = $_POST['customer_nic'] ?? '';
$customer = null;
if ($customerNIC) {
    $customerSql = "SELECT coust_NIC, coust_FirstName, coust_LastName FROM customer WHERE coust_NIC = :customerNIC";
    $customerStmt = $conn->prepare($customerSql);
    $customerStmt->execute([':customerNIC' => $customerNIC]);
    $customer = $customerStmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION['customerNIC'] = $customer['coust_NIC'];
}


$proceed = $_POST['days'] ?? '';
if ($proceed) {
    foreach ($_SESSION['checkout'] as $movieId => $quantity) {
        for ($i = 0; $i < $quantity; $i++) {
            $orderID = uniqid('O');
            $currentDateTime = date('Y-m-d');
            $userID = $_SESSION['userID'];
            $coustNIC = $_SESSION['customerNIC'];


            $order = "INSERT INTO rented (order_ID,date, user_ID, coust_NIC, movie_ID, days, is_Expired) VALUES (?,?,?,?,?,?,?)";
            $stmt = $conn->prepare($order);
            $stmt->execute([$orderID,$currentDateTime, $userID, $coustNIC, $movieId, $proceed, 0]);
        }


        $updateCopies = "UPDATE movie SET no_copies = no_copies - ? WHERE movie_ID = ?";
        $stmt = $conn->prepare($updateCopies);
        $stmt->execute([$quantity, $movieId]);
    }
    $_SESSION['checkout'] = [];
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Movie Rental System</title>
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
    <h1>Rent Movies</h1>
    <form method="post" class="mb-4">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="search">Search by Name:</label>
                <input type="text" id="search" name="search" class="form-control" value="<?= htmlspecialchars($search) ?>" placeholder="Enter part of movie name">
            </div>
            <div class="form-group col-md-6">
                <label for="category">Filter by Category:</label>
                <select id="category" name="category" class="form-control">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= htmlspecialchars($cat) ?>" <?= $cat == $category ? 'selected' : '' ?>><?= htmlspecialchars($cat) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <div class="row">
        <!-- Movies List -->
        <div class="col-md-6">
            <h4>Movies</h4>
            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Copies</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($movies as $movie): ?>
                    <tr>
                        <td><?= htmlspecialchars($movie['movie_Name']) ?></td>
                        <td><?= htmlspecialchars($movie['movie_Category']) ?></td>
                        <td><?= htmlspecialchars($movie['no_copies']) ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="movie_id" value="<?= $movie['movie_ID'] ?>">
                                <button type="submit" name="add" class="btn btn-success">Add to Checkout</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Checkout -->
        <div class="col-md-6">
            <h4>Checkout</h4>
            <form method="post" class="mb-3">
                <div class="form-group">
                    <label for="customer_nic">Enter Customer NIC:</label>
                    <input type="text" id="customer_nic" name="customer_nic" class="form-control" value="<?= htmlspecialchars($customerNIC) ?>" placeholder="Enter NIC">
                    <button type="submit" class="btn btn-primary mt-2">Find Customer</button>
                </div>
            </form>

            <?php if ($customer): ?>
                <div class="alert alert-info">
                    <strong>Customer:</strong> <?= htmlspecialchars($customer['coust_FirstName']) ?> <?= htmlspecialchars($customer['coust_LastName']) ?>
                </div>
            <?php endif; ?>

            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Copies</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($_SESSION['checkout'] as $movieId => $quantity): ?>
                    <?php
                    $sql = "SELECT movie_Name, movie_Category FROM movie WHERE movie_ID = :movieId";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([':movieId' => $movieId]);
                    $movie = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($movie['movie_Name']) ?></td>
                        <td><?= htmlspecialchars($movie['movie_Category']) ?></td>
                        <td><?= htmlspecialchars($quantity) ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="movie_id" value="<?= $movieId ?>">
                                <button type="submit" name="remove" class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <form method="post" class="mb-3">
                <div class="form-group">
                    <label for="days">Days</label>
                    <input type="number" name="days" class="form-control" required>
                    <br>
                    <button type="submit" class="btn btn-primary">Proceed to Checkout</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include 'footerNav.php'?>
</body>
</html>
