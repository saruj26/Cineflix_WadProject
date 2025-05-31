<?php

session_start();
require_once '../dbConnection/DBConnection.php';

class IsVerify
{
    private $con;

    public function __construct()
    {
        $DBobj = new DBConnection();
        $this->con = $DBobj->dbConnect();
    }

    public function checkVerification($userID, $checkParaForIDOrEmail)
    {
        $query = "SELECT * FROM customer WHERE coust_Email = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("s", $userID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (isset($row['Is_Active']) && $row['Is_Active']) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}