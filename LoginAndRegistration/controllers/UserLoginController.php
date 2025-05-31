<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
include '../models/UserLogin.php';

class UserLoginController
{
    private $UserLogin;

    public function __construct()
    {
        $this->UserLogin = new UserLogin();
    }

    public function handleRequest()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $filterParameter = isset($_POST['filterParameter']) ? $_POST['filterParameter'] : '';
        switch ($method) {
            case "GET":
                break;

            case "POST":
                switch ($filterParameter) {
                    case 0:
                        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
                        $email = filter_var($email, FILTER_VALIDATE_EMAIL);

                        $password = isset($_POST['password']) ? trim($_POST['password']) : '';

                        if (!empty($email) && !empty($password)) {
                            $this->UserLogin->loginDetailsValidate($email, $password);
                        } else {
                            $data = array('resultMessage' => 'Fill all inputs');
                            echo json_encode($data);
                        }
                        break;
                    case 1:
                        $email = isset($_POST['email']) ? $_POST['email'] : '';
                        if (!empty($email)) {
                            $result = $this->UserLogin->forgotPassword($email);
                            $data = array('resultMessage' => $result);
                            echo json_encode($data);
                        }
                        break;
                    case 2:
                        $num1 = isset($_POST['num1']) ? trim($_POST['num1']) : '';
                        $num1 = filter_var($num1, FILTER_SANITIZE_NUMBER_INT);

                        $num2 = isset($_POST['num2']) ? trim($_POST['num2']) : '';
                        $num2 = filter_var($num2, FILTER_SANITIZE_NUMBER_INT);

                        $num3 = isset($_POST['num3']) ? trim($_POST['num3']) : '';
                        $num3 = filter_var($num3, FILTER_SANITIZE_NUMBER_INT);

                        $num4 = isset($_POST['num4']) ? trim($_POST['num4']) : '';
                        $num4 = filter_var($num4, FILTER_SANITIZE_NUMBER_INT);

                        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
                        $email = filter_var($email, FILTER_VALIDATE_EMAIL);

                        $newPassword = isset($_POST['newPassword']) ? trim($_POST['newPassword']) : '';
                        $newPassword = filter_var($newPassword, FILTER_SANITIZE_STRING);

                        $verificationCode = $num1 . $num2 . $num3 . $num4;
                        if (!empty($email) && !empty($newPassword) ) {
                            $result = $this->UserLogin->forgotPasswordUpdateDatabase($email, $newPassword, $verificationCode);
                            $data = array('resultMessage' => $result);
                            echo json_encode($data);
                        }
                        break;
                }

                break;
        }
    }
}

$UserLoginController = new UserLoginController();
$UserLoginController->handleRequest();