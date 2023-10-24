<?php
session_start();

$session_id = ( isset($_SESSION["session_id"]) && $_SESSION["session_id"] != "") ? $_SESSION["session_id"] : "";
$session_level = ( isset($_SESSION["session_level"]) && $_SESSION["session_level"] != "") ? $_SESSION["session_level"] : "";

if ($session_id == "" || $session_level != 10) {
    $arr = ["result" => "access_denied"];
    die(json_encode($arr));
}

include "../config/db_config.php";
include "../class/login.php";

$idx = ( isset($_POST["idx"]) && $_POST["idx"] != "" && is_numeric($_POST["idx"]) ) ? $_POST["idx"] : "";

if ($idx == "") {
    $arr = ["result" => "empty_idx"];
    die(json_encode($arr));
}

$mem = new Login($conn);
$mem -> member_del($idx);

$arr = ["result" => "success"];
die(json_encode($arr));
