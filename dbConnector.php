<?php
class DbConnector{
    private $hostname = "localhost:3306";
    private $username = "root";
    private $password = "";
    private $dbname = "cineflix";

    public function getConnection(){
        $dsn = "mysql:host=".$this->hostname.";dbname=".$this->dbname;
        try {
            $con = new PDO($dsn, $this->username, $this->password);
            return $con;
        } catch (Exception $ex) {
            die("Connection Failed".$ex->getMessage());
        }
    }
}
?>
