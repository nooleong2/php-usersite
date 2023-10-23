<?php

// Member Class File

class Member {

    // 멤버 변수
    private $conn;

    // 생성자
    public function __construct($conn) {
        $this -> conn = $conn;
    }

    // 아이디 중복 체크 메소드
    public function id_exists($id) {
        $sql = "SELECT * FROM member WHERE id = :id";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":id", $id);
        $stmt -> execute();

        // 개수가 rowCount의 개수가 찍힐 경우 true 안찍힐 경우 false
        return $stmt -> rowCount() ? true : false;
    }

    // 이메일 중복 체크 메소드
    public function email_exists($email) {
        $sql = "SELECT * FROM member WHERE email = :email";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":email", $email);
        $stmt -> execute();

        // 개수가 rowCount의 개수가 찍힐 경우 true 안찍힐 경우 false
        return $stmt -> rowCount() ? true : false;
    }

    // 회원 정보 입력
    public function input($member_array) {
        $sql = "INSERT INTO member (id, password, email, name, zipcode, addr1, addr2, photo, ip) VALUES 
                (:id, :password, :email, :name, :zipcode, :addr1, :addr2, :photo, :ip);";

        // 단방향 암호화
        $enc_password = password_hash($member_array["password"], PASSWORD_BCRYPT);

        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":id", $member_array["id"]);
        $stmt -> bindParam(":password", $enc_password);
        $stmt -> bindParam(":email", $member_array["email"]);
        $stmt -> bindParam(":name", $member_array["name"]);
        $stmt -> bindParam(":zipcode", $member_array["zipcode"]);
        $stmt -> bindParam(":addr1", $member_array["addr1"]);
        $stmt -> bindParam(":addr2", $member_array["addr2"]);
        $stmt -> bindParam(":photo", $member_array["photo"]);
        $stmt -> bindParam(":ip", $_SERVER["REMOTE_ADDR"]);
        $stmt -> execute();
    }
}
