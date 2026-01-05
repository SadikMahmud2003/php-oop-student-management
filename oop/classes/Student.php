<?php
class Student {
    private $conn;
    private $table = "students";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addStudent($name, $email, $course, $phone, $enrollment_date) {
        $sql = "INSERT INTO $this->table 
                (name, email, course, phone, enrollment_date)
                VALUES 
                (:name, :email, :course, :phone, :enrollment_date)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'course' => $course,
            'phone' => $phone,
            'enrollment_date' => $enrollment_date
        ]);
    }

    public function getStudents() {
        return $this->conn
            ->query("SELECT * FROM $this->table ORDER BY id ASC")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStudentById($id) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM $this->table WHERE id = :id"
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStudent($id, $name, $email, $course, $phone, $enrollment_date) {
        $sql = "UPDATE $this->table SET
                name = :name,
                email = :email,
                course = :course,
                phone = :phone,
                enrollment_date = :enrollment_date
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'course' => $course,
            'phone' => $phone,
            'enrollment_date' => $enrollment_date
        ]);
    }

    public function deleteStudent($id) {
        $stmt = $this->conn->prepare(
            "DELETE FROM $this->table WHERE id = :id"
        );
        return $stmt->execute(['id' => $id]);
    }
}
