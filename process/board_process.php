<?php
include "../common_php/inc_session.php";
include "../config/db_config.php";
include "../class/board.php";
include "../class/login.php";

$mode = ( isset($_POST["mode"]) && $_POST["mode"] != "" ) ? $_POST["mode"] : "";
$bcode = ( isset($_POST["bcode"]) && $_POST["bcode"] != "" ) ? $_POST["bcode"] : "";
$subject = ( isset($_POST["subject"]) && $_POST["subject"] != "" ) ? $_POST["subject"] : "";
$content = ( isset($_POST["content"]) && $_POST["content"] != "" ) ? $_POST["content"] : "";

if ($mode == "") {
    $arr = ["result" => "empty_mode"];
    die(json_encode($arr));
}

if ($bcode == "") {
    $arr = ["result" => "empty_bcode"];
    die(json_encode($arr));
}

$board = new Board($conn);
$login = new Login($conn);
if ($mode == "input") {

    if ($subject == "") {
        $arr = ["result" => "empty_subject"];
        die(json_encode($arr));
    }

    if ($content == "" || $content == "<p><br></p>") {
        $arr = ["result" => "empty_content"];
        die(json_encode($arr));
    }

    $row = $login -> getInfo($session_id);
    
    $arr = [
        "bcode" => $bcode,
        "id" => $session_id,
        "name" => $row["name"],
        "subject" => $subject,
        "content" => $content,
        "ip" => $_SERVER["REMOTE_ADDR"],
    ];

    $board -> input($arr);

    $arr = ["result" => "success_input"];
    die(json_encode($arr));
}