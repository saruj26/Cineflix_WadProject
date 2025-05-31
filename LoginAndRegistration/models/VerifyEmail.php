<?php
session_start();
require_once '../dbConnection/DBConnection.php';
require_once '../models/SendMail.php';

class VerifyEmail
{
    private $con;

    public function __construct()
    {
        $DBobj = new DBConnection();
        $this->con = $DBobj->dbConnect();
    }

    public function verifyAccount($verificationCode)
    {
        $query = "SELECT * FROM customer WHERE Verification_Code = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("s", $verificationCode);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $stmt->close();

            $query2 = "UPDATE customer SET Is_Active = true, Verification_Code = NULL WHERE Verification_Code = ? LIMIT 1";
            $stmt2 = $this->con->prepare($query2);
            $stmt2->bind_param("s", $verificationCode);
            $stmt2->execute();

            if ($stmt2->affected_rows == 1) {
                $stmt2->close();

                $email = $row['coust_Email'];
                $name = $row['coust_FirstName']." ".$row['coust_FirstName'];
                $coust_NIC = $row['coust_NIC'];
                $message = "<p>Thank You For Registering Our Movie Rental System.Account Verified Successfully!</p>";
                $sendMail = new SendMail();
                $sendMail->sendMailMessage($email, $name, "Complete Verification", $message);
                $_SESSION['coust_NIC'] = $coust_NIC;
                header("Location:http:../../index.php");
                exit();
            } else {
                $stmt2->close();
                echo "Email Not Verified...";
            }
        } else {
            $stmt->close();
            echo "Invalid Verification...";
        }
    }
}