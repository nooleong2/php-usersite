<?php
// 게시판 클래스

class Board {
    private $conn;

    public function __construct($db) {
        $this -> conn = $db;
    }

    // 글 등록
    public function input($arr) {
        $sql = "INSERT INTO board (bcode, id, name, subject, content, ip)
                VALUES (:bcode, :id, :name, :subject, :content, :ip);";
        
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":bcode", $arr["bcode"]);
        $stmt -> bindParam(":id", $arr["id"]);
        $stmt -> bindParam(":name", $arr["name"]);
        $stmt -> bindParam(":subject", $arr["subject"]);
        $stmt -> bindParam(":content", $arr["content"]);
        $stmt -> bindParam(":ip", $arr["ip"]);
        $stmt -> execute();
    } 
}