<?php

session_start();
require_once '../dbConnection/DBConnection.php';

class UserRegistration
{
    private $con;

    public function __construct()
    {
        $DBobj = new DBConnection();
        $this->con = $DBobj->dbConnect();
    }

    public function InsertLibraryUserDetails($fName,$lName, $birthday, $nic, $email, $password, $verificationCode,$phoneNumber,$address,$gender)
    {
        $resultCheckExistsOrNot = $this->checkExistsOrNot($nic, $email);
        if ($resultCheckExistsOrNot == "NicExist") {
            $data = array('resultMessage' => 'Nic Already Exist!');
            echo json_encode($data);
        } elseif ($resultCheckExistsOrNot == "EmailExist") {
            $data = array('resultMessage' => 'Email Already Exist!');
            echo json_encode($data);
        } elseif ($resultCheckExistsOrNot == "queryError") {
            $data = array('resultMessage' => 'Query Failed!');
            echo json_encode($data);
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query1 = "INSERT INTO customer  (coust_FirstName,coust_LastName,coust_Bod,coust_NIC,coust_Email,coust_password,Is_Active,Verification_Code,coust_PhoneNo,coust_Address,coust_Gender)  VALUES (?, ?, ?, ?, ?,?,false,?,?,?,?)";
            $stmt = $this->con->prepare($query1);
            $stmt->bind_param("ssssssssss", $fName,$lName, $birthday, $nic, $email,  $hashedPassword, $verificationCode,$phoneNumber,$address,$gender);
            $result = $stmt->execute();

            if ($result) {
                $response = array(
                    'message' => 'success!'
                );
                $stmt->close();
                return $response;
            } else {
                $data = array('resultMessage' => $stmt->error);
                $stmt->close();
                echo json_encode($data);
            }
        }
    }

    public function checkExistsOrNot($nic, $email)
    {
        $query1 = "SELECT COUNT(*) AS count FROM customer WHERE coust_NIC = ?";
        $stmt1 = $this->con->prepare($query1);
        $stmt1->bind_param("s", $nic);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        $row1 = $result1->fetch_assoc();
        $stmt1->close();

        $query3 = "SELECT COUNT(*) AS count FROM customer WHERE coust_Email = ?";
        $stmt3 = $this->con->prepare($query3);
        $stmt3->bind_param("s", $email);
        $stmt3->execute();
        $result3 = $stmt3->get_result();
        $row3 = $result3->fetch_assoc();
        $stmt3->close();

        if ($result1 && $result3) {
            if ($row1['count'] > 0) {
                return "NicExist";
            } elseif ($row3['count'] > 0) {
                return "EmailExist";
            } else {
                return "validData";
            }
        } else {
            return "queryError";
        }
    }
}


//$x=new UserRegistration();
//$x->checkExistsOrNot('aaa','sss');