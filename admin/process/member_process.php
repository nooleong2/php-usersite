<?php

include "../../config/db_config.php";
include "../../class/register.php";
include "../../class/login.php";
include "../inc_common.php";

$login = new Login($conn);

$f_idx = ( isset($_POST["f_idx"]) && $_POST["f_idx"] != "" ? $_POST["f_idx"] : "");
$f_id = ( isset($_POST["f_id"]) && $_POST["f_id"] != "" ? $_POST["f_id"] : "");
$f_password = ( isset($_POST["f_password"]) && $_POST["f_password"] != "" ? $_POST["f_password"] : "");
$f_email = ( isset($_POST["f_email"]) && $_POST["f_email"] != "" ? $_POST["f_email"] : "");
$f_name = ( isset($_POST["f_name"]) && $_POST["f_name"] != "" ? $_POST["f_name"] : "");
$f_zipcode = ( isset($_POST["f_zipcode"]) && $_POST["f_zipcode"] != "" ? $_POST["f_zipcode"] : "");
$f_addr1 = ( isset($_POST["f_addr1"]) && $_POST["f_addr1"] != "" ? $_POST["f_addr1"] : "");
$f_addr2 = ( isset($_POST["f_addr2"]) && $_POST["f_addr2"] != "" ? $_POST["f_addr2"] : "");
$f_level = ( isset($_POST["f_level"]) && $_POST["f_level"] != "" ? $_POST["f_level"] : "");
$old_photo = ( isset($_POST["old_photo"]) && $_POST["old_photo"] != "" ) ? $_POST["old_photo"] : "";


if (isset($_FILES["f_photo"]) && $_FILES["f_photo"]["name"] != "" ) {
    $new_photo = $_FILES["f_photo"];

    $old_photo = $login -> profile_upload($f_id, $new_photo, $old_photo);
}

$arr = [
    "idx" => $f_idx,
    "id" => $f_id,
    "password" => $f_password,
    "email" => $f_email,
    "name" => $f_name,
    "zipcode" => $f_zipcode,
    "addr1" => $f_addr1,
    "addr2" => $f_addr2,
    "photo" => $old_photo,
    "level" => $f_level,
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




