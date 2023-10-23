<?php

class Login {

    private $conn;

    public function __construct($conn) {
        $this -> conn = $conn;
    }

    public function login($id, $password) {
        $sql = "SELECT * FROM member WHERE id = :id";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":id", $id);
        $stmt -> execute();

        // 1. 아이디가 일치해서 존재한다면
        if ($stmt -> rowCount()) {

            // 데이터 가지고 오기
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);
            
            // 비밀번호 해쉬 값 비교
            if (password_verify($password, $row["password"])) {
                $sql = "UPDATE member SET login_dt = NOW() WHERE id = :id;";
                $stmt = $this -> conn -> prepare($sql);
                $stmt -> bindParam(":id", $id);
                $stmt -> execute();

                return true;
            } else {
                return false;
            }
        // 2. 아이디가 존재하지 않는다면 
        } else {
            return false;
        }
    }

    public function logout() {
        session_start();
        session_destroy();

        die("<script>self.location.href = '../index.php';</script>");
    }
}