<?php

include "../config/db_config.php";
include "../class/login.php";

$id = ( isset($_POST["f_id"]) && $_POST["f_id"] != "" ) ? $_POST["f_id"] : "";
$password = ( isset($_POST["f_password"]) && $_POST["f_password"] != "" ) ? $_POST["f_password"] : "";

if ($id == "") {
    $arr = ["result" => "empty_id"];
    die(json_encode($arr));
}

if ($password == "") {
    $arr = ["result" => "empty_password"];
    die(json_encode($arr));
}

$login = new Login($conn);
if ($login -> login($id, $password)) {
    $arr = ["result" => "login_success"];

    session_start();
    $_SESSION["session_id"] = $id;

} else {
    $arr = ["result" => "login_fail"];
}

die(json_encode($arr));