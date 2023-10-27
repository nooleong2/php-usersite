<?php
include "./common_php/inc_session.php";
include "./config/db_config.php";
include "./class/board_manage.php"; # 게시판 목록
include "./common_php/lib.php"; # 페이지네이션
$boardm = new BoardManage($conn);
$boardArr = $boardm -> list();

$js_arr = ["./js/board_view.js"];
$g_title = "게시판";
include "./common_php/inc_header.php";
include "./class/board.php";

$board = new Board($conn);

$bcode = ( isset($_GET["bcode"]) && $_GET["bcode"] != "" ) ? $_GET["bcode"] : "";
$idx = ( isset($_GET["idx"]) && $_GET["idx"] != "" && is_numeric($_GET["idx"]) ) ? $_GET["idx"] : "";

if ($bcode == "") {
    die("<script>alert('게시물 코드가 빠졌습니다.'); history.go(-1)</script>");
}

if ($idx == "") {
    die("<script>alert('게시물 번호 빠졌습니다.'); history.go(-1)</script>");
}
$board_title = $boardm -> getBoardName($bcode);

// $_SERVER["REMOTE_ADDR"] : 현재 접속한 사람의 IP 정보
$boardRow = $board -> view($idx); # 게시물 정보
if ($boardRow["last_reader"] != $_SERVER["REMOTE_ADDR"]) {
    $board -> hitInc($idx); # 조회수
    $board -> updateLastReader($idx, $_SERVER["REMOTE_ADDR"]);
}

$downhit_arr = explode("?", $boardRow["downhit"]);
?>

<main class="border rounded-3 p-5">
    <h1 class="text-center"><?= $board_title ?></h1>

    <div class="vstack w-75 mx-auto">
        <div class="p-3">
            <span class="h3"><?= $boardRow["subject"] ?></span>
        </div>
        <div class="d-flex border border-top-0 border-start-0 border-end-0 border-bottom-1">
            <span><?= $boardRow["name"] ?></span>
            <span class="ms-5 me-auto"><?= $boardRow["hit"] ?></span>
            <span><?= $boardRow["create_at"] ?></span>
        </div>
        <div class="p-3">
            <?= $boardRow["content"] ?>
            <?php
                // 첨부파일 출력
                if ($boardRow["files"] != "") {
                    $filelist = explode("?", $boardRow["files"]);

                    if ($boardRow["downhit"] == "") {
                        $downhit_arr = array_fill(0, count($filelist), 0); // 시작 번호, 끝 번호, 채울 값
                    }

                
                    $th = 0;
                    foreach($filelist as $file) {
                        list($file_source, $file_name) = explode("|", $file);
                        echo '<a href="./process/board_download.php?idx=' .$idx. '&th=' .$th. '">' .$file_name. '</a> (down:'.$downhit_arr[$th].')<br>';
                        $th++;
                    }

                }
            ?>
        </div>
        <div class="d-flex gap-2 p-3">
            <button class="btn btn-success me-auto" id="btn_list">목록</button>
            <?php if ($session_id == $boardRow["id"]) { ?>
                <button class="btn btn-warning" id="btn_edit">수정</button>
                <button class="btn btn-danger" id="btn_delete">삭제</button>
            <?php } ?>
        </div>
    </div>
</main>
<?php
include "./common_php/inc_footer.php";
?>