<?php
include "../inc_common.php";
include "../../config/db_config.php";
include "../../class/board_manage.php"; // 게시판 클래스

$board_title = ( isset($_POST["board_title"]) && $_POST["board_title"] != "" ) ? $_POST["board_title"] : "";
$board_type = ( isset($_POST["board_type"]) && $_POST["board_type"] != "" ) ? $_POST["board_type"] : "";
$mode = ( isset($_POST["mode"]) && $_POST["mode"] != "" ) ? $_POST["mode"] : "";
$idx = ( isset($_POST["idx"]) && $_POST["idx"] != "" && is_numeric($_POST["idx"]) ) ? $_POST["idx"] : 0;

if ($mode == "") {
    $arr = ["result" => "empty_mode"];
    die(json_encode($arr));
}

$board = new BoardManage($conn);

if ($mode == "input") {
    if ($board_title == "") {
        $arr = ["result" => "empty_title"];
        die(json_encode($arr));
    }

    if ($board_type == "") {
        $arr = ["result" => "empty_btype"];
        die(json_encode($arr));
    }

    // 게시판 코드 생성
    $bcode = $board -> bcode_create();

    // 게시판 생성
    $arr = [
        "name" => $board_title,
        "bcode" => $bcode,
        "btype" => $board_type,
    ];
    $board -> create($arr);
    $arr = ["result" => "success"];
    die(json_encode($arr));

} else if ($mode == "delete") {
    if ($idx == 0) {
        $arr = ["result" => "empty_idx"];
        die(json_encode($arr));
    }

    $board -> delete($idx);
    $arr = ["result" => "success"];
    die(json_encode($arr));

} else if ($mode == "edit") {
    if ($idx == 0) {
        $arr = ["result" => "empty_idx"];
        die(json_encode($arr));
    }

    if ($board_title == "") {
        $arr = ["result" => "empty_title"];
        die(json_encode($arr));
    }

    if ($board_type == "") {
        $arr = ["result" => "empty_btype"];
        die(json_encode($arr));
    }

    // 게시판 수정
    $arr = [
        "name" => $board_title,
        "btype" => $board_type,
        "idx" => $idx,
    ];

    $board -> update($arr);
    $arr = ["result" => "success_edit"];
    die(json_encode($arr));
    
} else if ($mode == "getInfo") {
    if ($idx == 0) {
        $arr = ["result" => "empty_idx"];
        die(json_encode($arr));
    }

    $row = $board -> getInfo($idx);
    $arr = [
        "result" => "success",
        "list" => $row, # 2차원 배열
    ];
    die(json_encode($arr));
}