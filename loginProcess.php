<?php
session_start();
include ('dbConnector.php');

// Dummy credentials for demonstration
$dbcon = new dbConnector();
$con = $dbcon->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $con->prepare("SELECT * FROM user WHERE user_Email = ? ");
    $stmt->bindValue(1, $email);
    $stmt->execute();

    $rs = $stmt->fetchAll(PDO::FETCH_OBJ);
    foreach ($rs as $row){
        if (password_verify($password, $row->user_Password)) {
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['fname'] = $row->user_FirstName;
            $_SESSION['userID'] = $row->user_ID;
            if($row->is_Admin){
                $_SESSION['is_admin'] = true;
            }
            header("Location: sale.php");
        }else {
            echo "<div class='alert alert-danger text-center'>Invalid email or password</div>";
        }
    }

}
?>
