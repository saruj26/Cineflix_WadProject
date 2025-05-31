<?php
session_start();
require_once 'DbConnector.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customerNIC = $_POST['customer_nic'] ?? '';


    $db = new DbConnector();
    $con = $db->getConnection();

    $stmt = $con->prepare("SELECT * FROM rented JOIN movie ON rented.movie_ID = movie.movie_ID WHERE coust_NIC = :nic AND is_Received=0");
    $stmt->execute([':nic' => $customerNIC]);
    $rentedMovies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $recieve = $_POST['order_id'] ?? '';
    if ($recieve ) {
        $movie_Id = $_POST['movie_id'] ?? '';
        $stmt1 = $con->prepare("UPDATE rented SET is_Received = 1 WHERE order_ID = :id");
        $stmt1->execute([':id' => $recieve]);



        $query3 = "UPDATE movie SET no_copies = no_copies + 1 WHERE movie_ID = ?";
        $stmt3 = $con->prepare($query3);
        $stmt3->bindParam(1, $movie_Id);
        $stmt3->execute();
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receive Movies</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container h1{
            margin-top:80px ;
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
    <h1>Receive Movies</h1>
    <form method="post" class="mb-3">
        <div class="form-group">
            <label for="customer_nic">Enter Customer NIC:</label>
            <input type="text" id="customer_nic" name="customer_nic" class="form-control" value="<?= htmlspecialchars($customerNIC ?? '') ?>" placeholder="Enter NIC">
            <button type="submit" class="btn btn-primary mt-2">Find Customer</button>
        </div>
    </form>

    <?php if (!empty($rentedMovies)): ?>
        <h2>Rented Movies</h2>
        <table class="table">
            <thead>
            <tr>
                <th>Movie Name</th>
                <th>Genre</th>
                <th>Rental Date</th>
                <th>Days Rented</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($rentedMovies as $movie): ?>
                <tr>
                    <td><?= htmlspecialchars($movie['movie_Name']) ?></td>
                    <td><?= htmlspecialchars($movie['movie_Genre']) ?></td>
                    <td><?= htmlspecialchars($movie['date']) ?></td>
                    <td><?= htmlspecialchars($movie['days']) ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="order_id" value="<?= htmlspecialchars($movie['order_ID']) ?>">
                            <input type="hidden" name="movie_id" value="<?= htmlspecialchars($movie['movie_ID']) ?>">
                            <button type="submit" class="btn btn-success">Receive</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <p>No rented movies found for this customer.</p>
    <?php endif; ?>

</div>
<?php include 'footerNav.php'?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
