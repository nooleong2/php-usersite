<?php
include "../common_php/inc_session.php";

if ($session_id == "") {
    die("
    <script>
        alert('로그인한 회원만 다운로드 가능합니다.');
        self.location.href = '../login.php';
    </script>
    ");
}

$idx = ( isset($_GET["idx"]) && $_GET["idx"] != "" && is_numeric($_GET["idx"]) ) ? $_GET["idx"] : "";
$th = ( isset($_GET["th"]) && $_GET["th"] != "" && is_numeric($_GET["th"]) ) ? $_GET["th"] : "";

include "../config/db_config.php";
include "../class/board.php";
$board = new Board($conn);
$file_info = $board -> getAttachFile($idx, $th);
list($file_source, $file_name, $total_file) = explode("|", $file_info);

$downhit = $board -> getDownHit($idx);

if ($downhit == "") {
    $tmp_arr = [];
    for ($i = 0; $i < $total_file; $i++) {
        if ($th == $i) {
            $tmp_arr[] = 1;
        } else {
            $tmp_arr[] = 0;
        }
    }
} else {
    $tmp_arr = explode("?", $downhit);
    $tmp_arr[$th] = $tmp_arr[$th] + 1;
}

$downhit_str = implode("?", $tmp_arr);

$str = $idx ."?". $th;
if ( isset($_SESSION["lastdownhit"]) && $_SESSION["lastdownhit"] != "" ) {
    if ($str != $_SESSION["lastdownhit"]) {
        // 다운로드 횟수
        $board -> increaseDownHit($idx, $downhit_str);
        $_SESSION["lastdownhit"] = $str;
    }
} else {
    // 다운로드 횟수
    $board -> increaseDownHit($idx, $downhit_str);
    $_SESSION["lastdownhit"] = $str;
}

if ($idx == "") {
    die("<script>alert('게시물 번호가 비었습니다..');</script>");
}

if ($th == "") {
    die("<script>alert('몇 번째 파일인지 알 수가 없습니다...');</script>");
}


if ($file_source == "" || $file_name == "") {
    die("<script>alert('파일정보를 제대로 가져오지 못했습니다.');</script>");
}

$down = BOARD_DIR . "/" . $file_source;

if (!file_exists($down)) {
    die("<script>alert('존재하지 않는 파일입니다.');</script>");
}

$file_size = filesize($down);
header("Content-Type:application/octet-stream");
header("Content-Disposition:attachment;filename=$file_name"); // 다운로드 받을 파일 이름을 지정
header("Content-Transfer-Encoding:binary");
header("Content-Length:$file_size"); // 파일 사이즈
header("Cache-Control:cache,must-revalidate");
header("Pragma:no-cache");
header("Expires:0");

$fp = fopen($down, "r");
while (!feof($fp)) {
    $buf = fread($fp, 8096);
    print($buf);
    flush();
}

fclose($fp);
?>