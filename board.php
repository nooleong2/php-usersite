<?php
include "./common_php/inc_session.php";
include "./config/db_config.php";
include "./class/board_manage.php"; # 게시판 목록
include "./common_php/lib.php"; # 페이지네이션
$boardm = new BoardManage($conn);
$boardArr = $boardm -> list();

$js_arr = ["./js/board.js"];
$g_title = "게시판";
include "./common_php/inc_header.php";
include "./class/board.php";

$board = new Board($conn);

$bcode = ( isset($_GET["bcode"]) && $_GET["bcode"] != "" ) ? $_GET["bcode"] : "";
$page = ( isset($_GET["page"]) && $_GET["page"] != "" && is_numeric($_GET["page"])) ? $_GET["page"] : 1;
$sn = ( isset($_GET["sn"]) && $_GET["sn"] != "" ) ? $_GET["sn"] : "";
$sf = ( isset($_GET["sf"]) && $_GET["sf"] != "" ) ? $_GET["sf"] : "";

$paramArr = ["sn" => $sn, "sf" => $sf];
$total = $board -> total($bcode, $paramArr);
$limit = 10;
$page_limit = 5;

if ($bcode == "") {
    die("<script>alert('게시판 코드가 빠졌습니다.'); history.go(-1)</script>");
}
$board_title = $boardm -> getBoardName($bcode);


$boardRs = $board -> list($bcode, $page, $limit, $paramArr);

?>
<style>
    .tr {cursor: pointer;}
</style>
<main class="border rounded-3 p-5">
    <h1 class="text-center"><?= $board_title ?></h1>

    <div class="container mt-3 w-75 d-flex gap-2">
        <select name="sn" id="sn" class="form-select w-25">
            <option value="1" <?= ($sn == 1) ? "selected" : ""; ?>>제목+내용</option>
            <option value="2" <?= ($sn == 2) ? "selected" : ""; ?>>제목</option>
            <option value="3" <?= ($sn == 3) ? "selected" : ""; ?>>내용</option>
            <option value="4" <?= ($sn == 4) ? "selected" : ""; ?>>작성자</option>
        </select>
        <input type="text" class="form-control w-50" id="sf" value="">
        <button class="btn btn-primary w-5" id="btn_search">검색</button>
        <button class="btn btn-success w-5" id="btn_all">전체 목록</button>
    </div>

    <table class="table table-hover mt-4">
        <colgroup>
            <col width="5%">
            <col width="30%">
            <col width="5%">
            <col width="10%">
            <col width="5%">
        </colgroup>
        <tr>
            <th>번호</th>
            <th>제목</th>
            <th>이름</th>
            <th>날짜</th>
            <th>조회수</th>
        </tr>
        <?php
            $cnt = 0;
            $ntotal = ($total - (($page - 1) * $limit));
            foreach ($boardRs as $row) {
                $number = $ntotal - $cnt;
                $cnt++;
        ?>
        <tr class="tr" data-idx="<?= $row["idx"] ?>">
            <td><?= $number ?></td>
            <td><?= $row["subject"] ?></td>
            <td><?= $row["name"] ?></td>
            <td><?= $row["create_at"] ?></td>
            <td><?= $row["hit"] ?></td>
        </tr>
        <?php
            }
        ?>
    </table>

    <div class="d-flex justify-content-between align-items-start">
        <div>
        <?php
            $param = "&bcode=".$bcode;
            if (isset($sn) && $sn != "" && isset($sf) && $sf != "") {
                $param .= "&sn=" .$sn. "&sf=" .$sf;
            }
            echo my_pagination($total, $limit, $page_limit, $page, $param);
        ?>
        </div>
        <button class="btn btn-primary" id="btn_write">글쓰기</button>
    </div>
</main>
<?php
include "./common_php/inc_footer.php";
?>