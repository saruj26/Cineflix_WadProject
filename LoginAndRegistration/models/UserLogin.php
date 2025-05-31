<?php
require_once '../DBConnection/DBConnection.php';
include '../models/IsVerify.php';
include '../models/SendMail.php';

class UserLogin
{
    private $con;
    private $isVerify;

    public function __construct()
    {
        $DBobj = new DBConnection();
        $this->con = $DBobj->dbConnect();
        $this->isVerify = new IsVerify();
    }

    public function loginDetailsValidate($userIDOrEmail, $password)
    {
        if (strpos($userIDOrEmail, '@gmail.com') !== false || strpos($userIDOrEmail, '@std.uwu.ac.lk') !== false) {
            $resultOfVerification = $this->isVerify->checkVerification($userIDOrEmail, 1);
            $query = "SELECT * FROM customer WHERE coust_Email = ?";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("s", $userIDOrEmail);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['coust_password'])) {
                if ($resultOfVerification) {
                    $_SESSION['coust_NIC'] = $row['coust_NIC'];
                    $data = array(
                        'resultMessage' => 'Login_Success'

                    );

                    echo json_encode($data);
                } else {
                    $data = array(
                        'resultMessage' => 'NotVerifiedAccount'
                    );
                    echo json_encode($data);
                }
            } else {
                $data = array(
                    'resultMessage' => 'Login details not matched!'
                );
                echo json_encode($data);
            }
        } else {
            $data = array(
                'resultMessage' => 'Login details not matched!'
            );
            echo json_encode($data);
        }

        $stmt->close();
    }

    public function forgotPassword($email)
    {
        $isEmailExistQuery = "SELECT coust_Email, coust_FirstName,coust_LastName,coust_password FROM customer WHERE coust_Email = ?";
        $stmt = $this->con->prepare($isEmailExistQuery);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result1 = $stmt->get_result();

        if ($result1->num_rows > 0) {
            $row = $result1->fetch_assoc();
            $name = $row['coust_FirstName']. " ".$row['coust_LastName'];
            $confirmationCode = rand(1000, 9999);
            $message = "<p>FORGOT PASSWORD VERIFICATION CODE: $confirmationCode </p>";
            $sendMailMessage = new SendMail();
            $sendMailMessage->sendMailMessage($email, $name, "Verification Code", $message);

            if ($sendMailMessage) {
                $insertVerificationCode = "UPDATE customer SET Verification_Code = ? WHERE coust_Email = ?";
                $stmtUpdate = $this->con->prepare($insertVerificationCode);
                $stmtUpdate->bind_param("ss", $confirmationCode, $email);
                $stmtUpdate->execute();

                if ($stmtUpdate->affected_rows > 0) {
                    $stmt->close();
                    $stmtUpdate->close();
                    return "verification code sent.";
                } else {
                    $stmt->close();
                    $stmtUpdate->close();
                    return "Failed!";
                }
            } else {
                $stmt->close();
                return "Failed!";
            }
        } else {
            $stmt->close();
            return "Email Not Exist!";
        }
    }

    public function forgotPasswordUpdateDatabase($email, $newPassword, $verificationCode)
    {
        $getVerificationCode = "SELECT Verification_Code FROM customer WHERE coust_Email = ?";
        $stmt = $this->con->prepare($getVerificationCode);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $savedConfirmationCode = $row['Verification_Code'];
            if ($savedConfirmationCode == $verificationCode) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $changePassword = "UPDATE customer SET coust_password = ? WHERE coust_Email = ?";
                $stmtUpdate = $this->con->prepare($changePassword);
                $stmtUpdate->bind_param("ss", $hashedPassword, $email);
                $stmtUpdate->execute();

                if ($stmtUpdate->affected_rows > 0) {
                    $deleteVerificationCode = "UPDATE customer SET Verification_Code = NULL WHERE coust_Email= ?";
                    $stmtDelete = $this->con->prepare($deleteVerificationCode);
                    $stmtDelete->bind_param("s", $email);
                    $stmtDelete->execute();

                    $stmt->close();
                    $stmtUpdate->close();
                    $stmtDelete->close();
                    return "Password Changed.";
                } else {
                    $stmt->close();
                    $stmtUpdate->close();
                    return "Failed! Password Not Changed.";
                }
            } else {
                $stmt->close();
                return "Verification Code Not matched!!!";
            }
        }
    }
}