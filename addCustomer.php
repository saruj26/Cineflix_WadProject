<?php
session_start();
require_once 'DbConnector.php';

$db = new DbConnector();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nic = $_POST['coust_NIC'];
    $firstName = $_POST['coust_FirstName'];
    $lastName = $_POST['coust_LastName'];
    $address = $_POST['coust_Address'];
    $phone = $_POST['coust_PhoneNo'];
    $gender = $_POST['coust_Gender'];
    $email = $_POST['coust_Email'];
    $bod = $_POST['coust_Bod'];


    $checkSql = "SELECT * FROM customer WHERE coust_NIC = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->execute([$nic]);

    if ($checkStmt->rowCount() > 0) {
        $error = "NIC already exists!";
    } else {
        $sql = "INSERT INTO customer (coust_NIC, coust_FirstName, coust_LastName, coust_Address, coust_PhoneNo, coust_Gender, coust_Email, coust_Bod) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nic, $firstName, $lastName, $address, $phone, $gender, $email, $bod]);

        $success = "Customer added successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Add Customer</title>
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
    <h1>Add Customer</h1>

    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="coust_NIC">NIC</label>
                <input type="text" id="coust_NIC" name="coust_NIC" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
                <label for="coust_FirstName">First Name</label>
                <input type="text" id="coust_FirstName" name="coust_FirstName" class="form-control" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="coust_LastName">Last Name</label>
                <input type="text" id="coust_LastName" name="coust_LastName" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
                <label for="coust_Address">Address</label>
                <input type="text" id="coust_Address" name="coust_Address" class="form-control" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="coust_PhoneNo">Phone No</label>
                <input type="text" id="coust_PhoneNo" name="coust_PhoneNo" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
                <label for="coust_Gender">Gender</label>
                <select id="coust_Gender" name="coust_Gender" class="form-control">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="coust_Email">Email</label>
                <input type="email" id="coust_Email" name="coust_Email" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
                <label for="coust_Bod">Date of Birth</label>
                <input type="date" id="coust_Bod" name="coust_Bod" class="form-control" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Add Customer</button>
    </form>
</div>
<?php include 'footerNav.php'?>
</body>
</html>
