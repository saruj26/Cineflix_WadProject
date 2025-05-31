<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
include '../models/UserRegistration.php';
include '../models/SendMail.php';


class UserRegistrationController
{
    private $UserRegistrationObj;

    public function __construct()
    {
        $this->UserRegistrationObj = new UserRegistration();
    }

    public function handleRequest()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case "GET":


            case "POST":
                $fName = isset($_POST['fName']) ? trim($_POST['fName']) : '';
                $fName = filter_var($fName, FILTER_SANITIZE_STRING);

                $lName = isset($_POST['lName']) ? trim($_POST['lName']) : '';
                $lName = filter_var($lName, FILTER_SANITIZE_STRING);

                $birthday = isset($_POST['birthday']) ? trim($_POST['birthday']) : '';
                $birthday = filter_var($birthday, FILTER_SANITIZE_STRING);

                $nic = isset($_POST['nic']) ? trim($_POST['nic']) : '';
                $nic = filter_var($nic, FILTER_SANITIZE_STRING);

                $address = isset($_POST['address']) ? trim($_POST['address']) : '';
                $address = filter_var($address, FILTER_SANITIZE_STRING);

                $gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
                $gender = filter_var($gender, FILTER_SANITIZE_STRING);

                $phoneNumber = isset($_POST['phoneNumber']) ? trim($_POST['phoneNumber']) : '';
                $phoneNumber = filter_var($phoneNumber, FILTER_SANITIZE_NUMBER_INT);

                $email = isset($_POST['email']) ? trim($_POST['email']) : '';
                $email = filter_var($email, FILTER_VALIDATE_EMAIL);

                $password = isset($_POST['password']) ? trim($_POST['password']) : '';
                $password = filter_var($password, FILTER_SANITIZE_STRING);

                $confirmPassword = isset($_POST['confirmPassword']) ? trim($_POST['confirmPassword']) : '';
                $confirmPassword = filter_var($confirmPassword, FILTER_SANITIZE_STRING);

                $verificationCode = sha1($email . time());
                $verification_Url = 'http://localhost:80/cineflix/LoginAndRegistration/controllers/VerifyEmailController.php?code=' . $verificationCode;

                if (!empty($fName) && !empty($lName) && !empty($address) && !empty($gender) && !empty($phoneNumber) && !empty($birthday) && !empty($nic) && !empty($email)
                    && !empty($password) && !empty($confirmPassword)) {
                    if ($password == $confirmPassword) {
                        $result = $this->UserRegistrationObj->InsertLibraryUserDetails($fName, $lName, $birthday, $nic, $email, $password, $verificationCode, $phoneNumber, $address, $gender);
                        if ($result !== null && isset($result['message'])) {
                            if ($result['message'] == "success!") {
                                $message = "<p> Dear" . $fName . " " . $lName . "</p>" .
                                    "<p>Thank You For Signing Up.There is one more step. Click below link to verify your email address in order to activate your account.</p>" .
                                    "<p> " . $verification_Url . "</p>" .
                                    "<p> Thank you.</p>";

                                $sendMail = new SendMail();
                                $result = $sendMail->sendMailMessage($email, $fName . " " . $lName, "Email Verification", $message);
                                if ($result) {
                                    $data = array('resultMessage' => 'verificationProcessRunning...');
                                    echo json_encode($data);
                                }
                            }
                        }

                    } else {
                        $data = array('resultMessage' => 'Password Not Matched!');
                        echo json_encode($data);
                    }
                } else {
                    $data = array('resultMessage' => 'Fill all inputs');
                    echo json_encode($data);
                }
        }
    }
}

$UserRegistrationController = new UserRegistrationController();
$UserRegistrationController->handleRequest();