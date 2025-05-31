<?php
session_start();
include 'DbConnector.php';

$connector = new DbConnector();
$pdo = $connector->getConnection();

$movie_ID = $_GET['movie_ID'] ?? '';
$coust_NIC = $_GET['coust_NIC'] ?? '';

$query = "SELECT * FROM request JOIN customer ON request.coust_NIC = customer.coust_NIC JOIN movie ON request.movie_ID = movie.movie_ID WHERE 1=1";
$params = [];

if ($movie_ID) {
    $query .= " AND movie_ID = :movieId";
    $params[':movieId'] = $movie_ID;
}

if ($coust_NIC) {
    $query .= " AND coust_NIC = :coustNIC";
    $params[':coustNIC'] = $coust_NIC;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $requestId = $_POST['request_id'];

    $query = "SELECT * FROM request WHERE request_ID = :requestID";
    $params = [':requestID' => $requestId];
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $rq = $stmt->fetch(PDO::FETCH_OBJ);

    if (isset($_POST['PickedIn'])) {

        $orderID = uniqid('O');
        $currentDateTime = date('Y-m-d');


        $order = "INSERT INTO rented (order_ID,date, user_ID, coust_NIC, movie_ID, days, is_Expired) VALUES (?,?,?,?,?,?,?)";
        $stmt = $pdo->prepare($order);
        $stmt->execute([$orderID,$currentDateTime, $_SESSION['userID'], $rq->coust_NIC, $rq->movie_ID, $rq->days, 0]);

        $deleteQuery = "DELETE FROM request WHERE request_ID = :requestId";
        $deleteStmt = $pdo->prepare($deleteQuery);
        $deleteStmt->execute([':requestId' => $requestId]);
        header("Location: {$_SERVER['PHP_SELF']}");
        exit;
    }

    if (isset($_POST['Delete'])) {


        $query3 = "UPDATE movie SET no_copies = no_copies +1 WHERE movie_ID = ?";
        $stmt3 = $pdo->prepare($query3);
        $stmt3->bindParam(1, $rq->movie_ID);
        $stmt3->execute();

        $deleteQuery = "DELETE FROM request WHERE request_ID = :requestId";
        $deleteStmt = $pdo->prepare($deleteQuery);
        $deleteStmt->execute([':requestId' => $requestId]);
        header("Location: {$_SERVER['PHP_SELF']}");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request</title>
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
    <h2>Requested Movies</h2>
    <form method="get" class="mb-4">
        <div class="form-row">
            <div class="form-group col-md-4">
                <input type="text" class="form-control" name="user_ID" placeholder="Search by user_ID" value="<?= htmlspecialchars($coust_NIC) ?>">
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" name="movie_ID" placeholder="Search by movie_ID" value="<?= htmlspecialchars($movie_ID) ?>">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <?php if ($requests): ?>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Request ID</th>
                <th>Customer NIC</th>
                <th>Customer Name</th>
                <th>Movie ID</th>
                <th>Movie Name</th>
                <th>Days</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($requests as $request): ?>
                <tr>
                    <td><?= htmlspecialchars($request['request_ID']) ?></td>
                    <td><?= htmlspecialchars($request['coust_NIC']) ?></td>
                    <td><?= htmlspecialchars($request['coust_FirstName']). " ".  htmlspecialchars($request['coust_LastName'])?></td>
                    <td><?= htmlspecialchars($request['movie_ID']) ?></td>
                    <td><?= htmlspecialchars($request['movie_Name']) ?></td>
                    <td><?= htmlspecialchars($request['days']) ?></td>
                    <td><?= htmlspecialchars($request['date']) ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="request_id" value="<?= htmlspecialchars($request['request_ID']) ?>">
                            <button type="submit" name="PickedIn" class="btn btn-success">Picked Up</button>
                            <button type="submit" name="Delete" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No requests found.</p>
    <?php endif; ?>
</div>
<?php include 'footerNav.php'?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
