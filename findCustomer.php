<?php
session_start();
include 'DbConnector.php';

$connector = new DbConnector();
$pdo = $connector->getConnection();

$firstName = $_GET['firstName'] ?? '';
$lastName = $_GET['lastName'] ?? '';
$nic = $_GET['nic'] ?? '';

$query = "SELECT * FROM customer WHERE 1=1";
$params = [];

if ($firstName) {
    $query .= " AND coust_FirstName LIKE :firstName";
    $params[':firstName'] = "%$firstName%";
}

if ($lastName) {
    $query .= " AND coust_LastName LIKE :lastName";
    $params[':lastName'] = "%$lastName%";
}

if ($nic) {
    $query .= " AND coust_NIC = :nic";
    $params[':nic'] = $nic;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Search</title>
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
    <h2>Find a Customer</h2>
    <form method="get" class="mb-4">
        <div class="form-row">
            <div class="form-group col-md-4">
                <input type="text" class="form-control" name="firstName" placeholder="Search by First Name" value="<?= htmlspecialchars($firstName) ?>">
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" name="lastName" placeholder="Search by Last Name" value="<?= htmlspecialchars($lastName) ?>">
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" name="nic" placeholder="Search by NIC" value="<?= htmlspecialchars($nic) ?>">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <?php if ($customers): ?>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>NIC</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone</th>
                <th>Email</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?= htmlspecialchars($customer['coust_NIC']) ?></td>
                    <td><?= htmlspecialchars($customer['coust_FirstName']) ?></td>
                    <td><?= htmlspecialchars($customer['coust_LastName']) ?></td>
                    <td><?= htmlspecialchars($customer['coust_PhoneNo']) ?></td>
                    <td><?= htmlspecialchars($customer['coust_Email']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No customers found.</p>
    <?php endif; ?>
</div>
<?php include 'footerNav.php'?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
