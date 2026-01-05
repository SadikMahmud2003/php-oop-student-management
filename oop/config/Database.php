<?php
class Database {
    private $host = "localhost";
    private $db   = "student_oop";
    private $user = "root";
    private $pass = "";
    public $conn;

    public function connect() {
        $this->conn = new PDO(
            "mysql:host=$this->host;dbname=$this->db",
            $this->user,
            $this->pass
        );
        return $this->conn;
    }
}
