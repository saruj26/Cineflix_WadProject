<?php
session_start();
require_once 'DbConnector.php';

$db = new DbConnector();
$conn = $db->getConnection();


$nic = $_POST['customer_nic'] ?? '';
$customer = null;
if ($nic) {
    $sql = "SELECT * FROM customer WHERE coust_NIC = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nic]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $nic = $_POST['id'];
    $firstName = $_POST['coust_FirstName'];
    $lastName = $_POST['coust_LastName'];
    $address = $_POST['coust_Address'];
    $phone = $_POST['coust_PhoneNo'];
    $gender = $_POST['coust_Gender'];
    $email = $_POST['coust_Email'];
    $bod = $_POST['coust_Bod'];
    echo '1';
    echo $nic;
    try {
        $updateSql = "UPDATE customer SET 
                  coust_FirstName = ?, coust_LastName = ?, coust_Address = ?, 
                  coust_PhoneNo = ?, coust_Gender = ?, coust_Email = ?, coust_Bod = ?
                  WHERE coust_NIC = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bindParam(1, $firstName);
        $updateStmt->bindParam(2, $lastName);
        $updateStmt->bindParam(3, $address);
        $updateStmt->bindParam(4, $phone);
        $updateStmt->bindParam(5, $gender);
        $updateStmt->bindParam(6, $email);
        $updateStmt->bindParam(7, $bod);
        $updateStmt->bindParam(8, $nic);
        $updateStmt->execute();
    }catch (PDOException $e){
        echo $e->getMessage();
    }
    $success = "Customer details updated successfully!";
    header("Location: editCustomer.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Customer</title>
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
    <h1>Edit Customer</h1>

    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label for="customer_nic">Enter Customer NIC:</label>
            <input type="text" id="customer_nic" name="customer_nic" class="form-control" value="<?= htmlspecialchars($nic) ?>" required>
            <button type="submit" class="btn btn-primary mt-2">Find Customer</button>
        </div>
    </form>

    <?php if ($customer): ?>
        <form method="post">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="coust_FirstName">First Name</label>
                    <input type="text" id="coust_FirstName" name="coust_FirstName" class="form-control" value="<?= htmlspecialchars($customer['coust_FirstName']) ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="coust_LastName">Last Name</label>
                    <input type="text" id="coust_LastName" name="coust_LastName" class="form-control" value="<?= htmlspecialchars($customer['coust_LastName']) ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="coust_Address">Address</label>
                    <input type="text" id="coust_Address" name="coust_Address" class="form-control" value="<?= htmlspecialchars($customer['coust_Address']) ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="coust_PhoneNo">Phone No</label>
                    <input type="text" id="coust_PhoneNo" name="coust_PhoneNo" class="form-control" value="<?= htmlspecialchars($customer['coust_PhoneNo']) ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="coust_Gender">Gender</label>
                    <select id="coust_Gender" name="coust_Gender" class="form-control">
                        <option value="Male" <?= $customer['coust_Gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= $customer['coust_Gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                        <option value="Other" <?= $customer['coust_Gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="coust_Email">Email</label>
                    <input type="email" id="coust_Email" name="coust_Email" class="form-control" value="<?= htmlspecialchars($customer['coust_Email']) ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="coust_Bod">Date of Birth</label>
                    <input type="date" id="coust_Bod" name="coust_Bod" class="form-control" value="<?= htmlspecialchars($customer['coust_Bod']) ?>" required>
                    <input type="number" id="id" name="id" class="form-control" value="<?= htmlspecialchars($customer['coust_NIC']) ?>" hidden>
                </div>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update Customer</button>
        </form>
    <?php elseif ($nic): ?>
        <div class="alert alert-danger">Customer not found.</div>
    <?php endif; ?>
</div>
<?php include 'footerNav.php'?>
</body>
</html>
