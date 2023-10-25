<?php
$g_title = "게시판 관리";
$js_arr = ["./js/board.js"];
$menu_code = "board";

include "./inc_common.php";
include "./inc_header.php";
include "../config/db_config.php";
include "../class/board_manage.php";
include "../common_php/lib.php";

$sn = ( isset($_GET["sn"]) && $_GET["sn"] != "" && is_numeric($_GET["sn"]) ) ? $_GET["sn"] : "";
$sf = ( isset($_GET["sf"]) && $_GET["sf"] != "" ) ? $_GET["sf"] : "";
$paramArr = [
    "sn" => $sn,
    "sf" => $sf,
];

$board = new BoardManage($conn);

$boardArr = $board -> list();
?>

<main class="border rounded-3 p-5">
    
    <div class="container">
        <h3>게시판 관리</h3>
    </div>

    <table class="table table-border mt-4">
        <tr>
            <th>번호</th>
            <th>게시판 이름</th>
            <th>게시판 코드</th>
            <th>게시판 타입</th>
            <th>게시물 수</th>
            <th>등록일시</th>
            <th>관리</th>
        </tr>
        <?php
            foreach($boardArr as $row) {
        ?>
            <tr>
                <td><?= $row["idx"] ?></td>
                <td><?= $row["name"] ?></td>
                <td><?= $row["bcode"] ?></td>
                <td><?= $row["btype"] ?></td>
                <td><?= $row["cnt"] ?></td>
                <td><?= $row["create_at"] ?></td>
                <td>
                    <button class="btn btn-sm btn-primary btn_board_view" data-bcode="<?= $row["bcode"] ?>">보기</button>
                    <button class="btn btn-sm btn-warning btn_mem_edit" data-bs-toggle="modal" data-bs-target="#board_create_modal" data-idx="<?= $row["idx"] ?>">수정</button>
                    <button class="btn btn-sm btn-danger btn_mem_delete" data-idx="<?= $row["idx"] ?>">삭제</button>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>

    <div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#board_create_modal" id="btn_create_modal">게시판 생성</button>
    </div>

</main>

<!-- Modal -->
<div class="modal fade" id="board_create_modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modal_title">게시판 생성</h1>
        <!-- hidden -->
        <input type="hidden" name="mode" id="board_mode" value="">
        <input type="hidden" name="idx" id="board_idx" value="">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body d-flex gap-2">
        <input type="text" name="board_title" id="board_title" class="form-control" placeholder="게시판 이름">
        <select name="board_type" id="board_type" class="form-select">
            <option value="board">게시판</option>
            <option value="gallery">갤러리</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
        <button type="button" class="btn btn-primary" id="btn_board_create">확인</button>
      </div>
    </div>
  </div>
</div>

<?php
include "./inc_footer.php";
?>

