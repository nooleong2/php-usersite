<?php
session_start();

$session_id = ( isset($_SESSION["session_id"]) && $_SESSION["session_id"] != "") ? $_SESSION["session_id"] : "";
$session_level = ( isset($_SESSION["session_level"]) && $_SESSION["session_level"] != "") ? $_SESSION["session_level"] : "";

if ($session_id == "" || $session_level != 10) {
    die(
        "<script>
            alert('관리자만 접근 가능합니다.');
            self.location.href = '../index.php'; 
        </script>"
    );
}