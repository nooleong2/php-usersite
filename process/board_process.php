<?php
include "../common_php/inc_session.php";
include "../config/db_config.php";
include "../class/board.php";
include "../class/login.php";

$mode = ( isset($_POST["mode"]) && $_POST["mode"] != "" ) ? $_POST["mode"] : "";
$bcode = ( isset($_POST["bcode"]) && $_POST["bcode"] != "" ) ? $_POST["bcode"] : "";
$subject = ( isset($_POST["subject"]) && $_POST["subject"] != "" ) ? $_POST["subject"] : "";
$content = ( isset($_POST["content"]) && $_POST["content"] != "" ) ? $_POST["content"] : "";
$idx = ( isset($_POST["idx"]) && $_POST["idx"] != "" && is_numeric($_POST["idx"]) ) ? $_POST["idx"] : "";
$th = ( isset($_POST["th"]) && $_POST["th"] != "" && is_numeric($_POST["th"]) ) ? $_POST["th"] : "";

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

    // 이미지 변환하여 저장하기
    preg_match_all("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $content, $matches);

    $img_arr = [];
    foreach ($matches[1] as $key => $value) {
        if (substr($value, 0, 5) != "data:") {
            continue;
        }
        list($type, $data) = explode(";", $value);
        list(, $data) = explode(",", $data); // 실제 이미지 데이터
        $data = base64_decode($data);
        list(, $ext) = explode("/", $type); // PNG, JPG, JPEG 타입
        $ext = ($ext == "jpeg") ? "jpg" : $ext;
        $filename = date('YmdHis') .' '. $key .'.'. $ext; // 전체 파일명
        file_put_contents(BOARD_DIR ."/". $filename, $data); // 폴더파일명, 이미지 데이터

        $content = str_replace($value, BOARD_WEB_DIR ."/". $filename, $content);
        $img_arr[] = BOARD_WEB_DIR ."/". $filename;
    }

    if ($subject == "") {
        $arr = ["result" => "empty_subject"];
        die(json_encode($arr));
    }

    if ($content == "" || $content == "<p><br></p>") {
        $arr = ["result" => "empty_content"];
        die(json_encode($arr));
    }

    // 파일 첨부(다중 파일 포함)
    $file_list_str = "";
    $file_cnt = 3;
    if ( isset($_FILES["files"]) ) {
        $file_list_str = $board -> file_attach($_FILES["files"], $file_cnt);
    }

    $row = $login -> getInfo($session_id);
    
    $arr = [
        "bcode" => $bcode,
        "id" => $session_id,
        "name" => $row["name"],
        "subject" => $subject,
        "content" => $content,
        "files" => $file_list_str,
        "ip" => $_SERVER["REMOTE_ADDR"],
    ];

    $board -> input($arr);

    $arr = ["result" => "success_input"];
    die(json_encode($arr));
} else if ($mode == "each_file_del") {

    if ($idx == "") {
        $arr = ["result" => "empty_idx"];
        die(json_encode($arr));
    }

    if ($th == "") {
        $arr = ["result" => "empty_th"];
        die(json_encode($arr));
    }

    $file = $board -> getAttachFile($idx, $th);

    $each_files = explode("|", $file);

    if (file_exists(BOARD_DIR . "/" . $each_files[0])) {
        unlink(BOARD_DIR . "/" . $each_files[0]); // 폴더에서 삭제
    }

    $row = $board -> view($idx);
    $files = explode("?", $row["files"]);
    $tmp_arr = [];
    foreach ($files as $key => $value) {
        if ($key == $th) {
            continue;
        }
        $tmp_arr[] = $value;
    }

    $files = implode("?", $tmp_arr); // 새로 조합된 파일 리스트 문자열

    $downs = explode("?", $row["downhit"]);
    $tmp_arr = [];
    foreach ($downs as $key => $value) {
        if ($key == $th) {
            continue;
        }
        $tmp_arr[] = $value;
    }

    $downs = implode("?", $tmp_arr); // 새로 조합된 다운로드 수 문자열

    $board -> updateFileList($idx, $files, $downs);
    $arr = ["result" => "success_file_delete"];
    die(json_encode($arr));
} else if ($mode == "file_attach") {
    // 수정에서 개별 파일 첨부하기
    $file_list_str = "";
    if ( isset($_FILES["files"]) ) {
        $file_cnt = 1;
        $file_list_str = $board -> file_attach($_FILES["files"], $file_cnt);
    } else {
        $arr = ["result" => "empty_files"];
        die(json_encode($arr));
    }

    $row = $board -> view($idx);
    if ($row["files"] != "") {
        $files = $row["files"]. "?" .$file_list_str;
    } else {
        $files = $file_list_str;
    }

    if ($row["downhit"] != "") {
        $downs = $row["downhit"] . "?0";
    } else {
        $downs = "";
    }

    $board -> updateFileList($idx, $files, $downs);
    $arr = ["result" => "success"];
    die(json_encode($arr));
} else if ($mode == "edit") {
    // 수정 권한
    $row = $board -> view($idx);
    if ($session_id != $row["id"]) {
        $arr = ["result" => "permission_denied"];
        die(json_encode($arr));
    }

    $old_image_arr = $board -> extract_image($row["content"]);

    // 이미지 변환하여 저장하기
    preg_match_all("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $content, $matches);

    $current_img_arr = [];
    foreach ($matches[1] as $key => $value) {
        if (substr($value, 0, 5) != "data:") {
            $current_img_arr[] = $value;
            continue;
        }
        list($type, $data) = explode(";", $value);
        list(, $data) = explode(",", $data); // 실제 이미지 데이터
        $data = base64_decode($data);
        list(, $ext) = explode("/", $type); // PNG, JPG, JPEG 타입
        $ext = ($ext == "jpeg") ? "jpg" : $ext;
        $filename = date('YmdHis') .' '. $key .'.'. $ext; // 전체 파일명
        file_put_contents(BOARD_DIR ."/". $filename, $data); // 폴더파일명, 이미지 데이터

        $content = str_replace($value, BOARD_WEB_DIR ."/". $filename, $content);
    }

    $diff_img_arr = array_diff($old_image_arr, $current_img_arr);
    foreach($diff_img_arr as $value) {
        unlink("../".$value);
    }

    if ($subject == "") {
        $arr = ["result" => "empty_subject"];
        die(json_encode($arr));
    }

    if ($content == "" || $content == "<p><br></p>") {
        $arr = ["result" => "empty_content"];
        die(json_encode($arr));
    }

    $arr = [
        "idx" => $idx,
        "subject" => $subject,
        "content" => $content,
    ];

    $board -> edit($arr);

    $arr = ["result" => "success_edit"];
    die(json_encode($arr));

} else if ($mode == "delete") {
    // db 글 삭제
    // 첨부 파일 삭제
    // 본문 이미지 삭제

    $row = $board -> view($idx);

    // 본문 이미지 삭제
    $img_arr = $board -> extract_image($row["content"]);
    foreach($img_arr as $value) {
        unlink("../".$value);
    }

    // 첨부 파일 삭제
    if ($row["files"] != "") {
        $file_list = explode("?", $row["files"]);
        foreach($file_list as $value) {
            list($file_src, ) = explode("|", $value);
            unlink(BOARD_DIR . "/" . $file_src);
        }
    }

    $board -> delete($idx);
    
    $arr = ["result" => "success_delete"];
    die(json_encode($arr));
    
}