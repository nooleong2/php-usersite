<?php

/**
 * 데이터베이스 연결
 * 
 * $sname : 서버 주소
 * $uname : 데이터베이스 아이디
 * $password : 데이터베이스 비밀번호
 * $dbname : 사용할 데이터베이스
 */

$sname = "localhost";
$uname = "root";
$password = "";
$dbname = "member";

try {

    /**
     * PDO 방식 DATABASE 연결
     * ATTR_EMULATE_PREPARES : Prepared Statement를 지원하지 않는 경우 디비 기능을 사용
     * MYSQL_ATTR_USE_BUFFERED_QUERY : Query 버퍼링 활성화
     * ATTR_ERRMODE, ERRMODE_EXCEPTION : PDO 객체가 에러를 처리하는 방식
     */
    $conn = new PDO("mysql:host={$sname};dbname={$dbname}", $uname, $password);
    $conn -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $conn -> setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "<p>DB Connection Success!!!!</p>";

} catch (PDOException $e) {
    echo $e -> getMssage();
    exit();
}

// $_SERVER 의 DOCUMENT_ROOT 이용
define("DOCUMENT_ROOT", $_SERVER["DOCUMENT_ROOT"] ."/_php/member");
define("ADMIN_DIR", DOCUMENT_ROOT ."/admin");
define("DATA_DIR", DOCUMENT_ROOT ."/data");
define("PROFILE_DIR", DATA_DIR ."/profile");
define("BOARD_DIR", DATA_DIR ."/board"); // 이미지 파일이 저장될 절대 경로
define("BOARD_WEB_DIR", "data/board"); // 웹에서 확인하는 경로