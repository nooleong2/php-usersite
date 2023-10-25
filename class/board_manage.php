<?php
// 게시판 관리 클래스

class BoardManage {
    private $conn;

    public function __construct($db) {
        $this -> conn = $db;
    }

    // 게시판 목록
    public function list() {

        $sql = "SELECT idx, name, bcode, btype, cnt, DATE_FORMAT(create_at, '%Y-%m-%d %H:%m') AS create_at 
                FROM board_manage ORDER BY idx ASC;";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> execute();
        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

    // 게시판 생성
    public function create($arr) {
        $sql = "INSERT INTO board_manage (name, bcode, btype) VALUES (:name, :bcode, :btype);";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":name", $arr["name"]);
        $stmt -> bindParam(":bcode", $arr["bcode"]);
        $stmt -> bindParam(":btype", $arr["btype"]);
        $stmt -> execute();
    }

    // 게시판 정보 메뉴 수정
    public function update($arr) {
        $sql = "UPDATE board_manage SET name = :name, btype = :btype WHERE idx = :idx;";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":name", $arr["name"]);
        $stmt -> bindParam(":btype", $arr["btype"]);
        $stmt -> bindParam(":idx", $arr["idx"]);
        $stmt -> execute();
    }

    // idx로 게시판 정보 가져오기
    public function getBcode($idx) {
        $sql = "SELECT bcode FROM board_manage WHERE idx = :idx;";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":idx", $idx);
        $stmt -> execute();
        $row = $stmt -> fetch(PDO::FETCH_COLUMN, 0);

        return $row;
    }

    // 게시판 삭제
    public function delete($idx) {
        // bcode
        $bcode = $this -> getBcode($idx);

        $sql = "DELETE FROM board_manage WHERE idx = :idx;";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":idx", $idx);
        $stmt -> execute();
    }

    // 게시판 코드 생성
    /**
     * 1. 게시판 코드 생성
     * 2. 게시판 생성
     */
    public function bcode_create() {
        $letter = range("a", "z");
        $bcode = "";

        for ($i = 0; $i < 6; $i++) {
            $r = rand(0, 25);
            $bcode .= $letter[$r];    
        }

        return $bcode;
    }

    // 게시판 메뉴 정보 가져오기
    public function getInfo($idx) {
        $sql = "SELECT * FROM board_manage WHERE idx = :idx";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":idx", $idx);
        $stmt -> execute();
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    // 게시판 코드로 게시판 명 가져오기
    public function getBoardName($bcode) {
        $sql = "SELECT name FROM board_manage WHERE bcode = :bcode";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":bcode", $bcode);
        $stmt -> execute();
        $row = $stmt -> fetch(PDO::FETCH_COLUMN, 0);

        return $row;
    }

}