<?php
include "./common_php/inc_session.php";
include "./config/db_config.php";
include "./class/board_manage.php"; # 게시판 목록
$boardm = new BoardManage($conn);
$boardArr = $boardm -> list();

$g_title = "메인 화면";
$js_arr = ["./js/index.js"];
$menu_code = "index";

include "./common_php/inc_header.php";
?>

<main class="w-75 mx-auto border rounded-3 p-5 d-flex gap-5">
    <img src="./images/logo.svg" width="72" alt="">
    <div>
        <h3>Home 입니다.</h3>
    </div>
</main>

<?php
include "./common_php/inc_footer.php";
?>

