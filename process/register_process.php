<?php

include "../config/db_config.php";
include "../class/register.php";
include "../class/login.php";

$member = new Member($conn);
$login = new Login($conn);
$mode =  ( isset($_POST["mode"]) && $_POST["mode"] != "" ? $_POST["mode"] : "" );

$f_id = ( isset($_POST["f_id"]) && $_POST["f_id"] != "" ? $_POST["f_id"] : "");
$f_password = ( isset($_POST["f_password"]) && $_POST["f_password"] != "" ? $_POST["f_password"] : "");
$f_email = ( isset($_POST["f_email"]) && $_POST["f_email"] != "" ? $_POST["f_email"] : "");
$f_name = ( isset($_POST["f_name"]) && $_POST["f_name"] != "" ? $_POST["f_name"] : "");
$f_zipcode = ( isset($_POST["f_zipcode"]) && $_POST["f_zipcode"] != "" ? $_POST["f_zipcode"] : "");
$f_addr1 = ( isset($_POST["f_addr1"]) && $_POST["f_addr1"] != "" ? $_POST["f_addr1"] : "");
$f_addr2 = ( isset($_POST["f_addr2"]) && $_POST["f_addr2"] != "" ? $_POST["f_addr2"] : "");
$old_photo = ( isset($_POST["old_photo"]) && $_POST["old_photo"] != "" ) ? $_POST["old_photo"] : "";

if ($mode == "id_chk") {
    // 아이디 중복 체크
    $id =  ( isset($_POST["id"]) && $_POST["id"] != "" ? $_POST["id"] : "" );

    if ($id == "") {
        $arr = ["result" => "empty_id"];
        die(json_encode($arr));
    }

    if ($member -> id_exists($id)) {
        $arr = ["result" => "fail"];
        die(json_encode($arr));
    } else {
        $arr = ["result" => "success"];
        die(json_encode($arr));
    }
} else if ($mode == "email_chk") {
    // 이메일 중복 체크
    $email =  ( isset($_POST["email"]) && $_POST["email"] != "" ? $_POST["email"] : "" );

    if ($email == "") {
        $arr = ["result" => "empty_email"];
        die(json_encode($arr));
    }

    if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
        $arr = ["result" => "wrong_email"];
        die(json_encode($arr));
    }

    if ($member -> email_exists($email)) {
        $arr = ["result" => "fail"];
        die(json_encode($arr));
    } else {
        $arr = ["result" => "success"];
        die(json_encode($arr));
    }
} else if ($mode == "input") {
    $f_photo = "";

    if (isset($_FILES["f_photo"]) && $_FILES["f_photo"]["name"] != "" ) {
        $tmp_arr = explode(".", $_FILES["f_photo"]["name"]);
        $ext = end($tmp_arr); # 마지막 배열 값 추출
        $f_photo = $f_id . '.' . $ext;

        copy($_FILES["f_photo"]["tmp_name"], "../data/profile/" . $f_photo);
    }
    
    $arr = [
        "id" => $f_id,
        "password" => $f_password,
        "email" => $f_email,
        "name" => $f_name,
        "zipcode" => $f_zipcode,
        "addr1" => $f_addr1,
        "addr2" => $f_addr2,
        "photo" => $f_photo,
    ];

    $member -> input($arr);

    // 가입 완료 후
    echo
    "
        <script>
            self.location.href = '../member_success.php';
        </script>
    ";
    
} else if ($mode == "edit") {

    

    if (isset($_FILES["f_photo"]) && $_FILES["f_photo"]["name"] != "" ) {
        $new_photo = $_FILES["f_photo"];
    
        $old_photo = $login -> profile_upload($f_id, $new_photo, $old_photo);
    }

    session_start();

    $arr = [
        "id" => $_SESSION["session_id"],
        "password" => $f_password,
        "email" => $f_email,
        "name" => $f_name,
        "zipcode" => $f_zipcode,
        "addr1" => $f_addr1,
        "addr2" => $f_addr2,
        "photo" => $old_photo,
    ];

    $login -> edit($arr);

    // 수정 완료 후
    echo
    "
        <script>
            alert('수정이 완료되었습니다.');
            self.location.href = '../index.php';
        </script>
    ";
    
}



