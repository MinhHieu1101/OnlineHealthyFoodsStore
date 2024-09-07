<?php
class DbHandler {
    private $host = "feenix-mariadb.swin.edu.au";
    private $db_name = "s103846676_db";
    private $username = "s103846676";
    private $password = "170803";
    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>
