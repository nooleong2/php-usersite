<?php
include "./common_php/inc_session.php";
include "./config/db_config.php";
include "./class/board_manage.php"; # 게시판 목록
$boardm = new BoardManage($conn);
$boardArr = $boardm -> list();

$js_arr = ["./js/board.js"];
$g_title = "게시판";
include "./common_php/inc_header.php";
include "./class/board.php";

$bcode = ( isset($_GET["bcode"]) && $_GET["bcode"] != "" ) ? $_GET["bcode"] : "";
if ($bcode == "") {
    die("<script>alert('게시판 코드가 빠졌습니다.'); history.go(-1)</script>");
}

$board_title = $boardm -> getBoardName($bcode);
?>

<main class="border rounded-3 p-5">
    <h1 class="text-center"><?= $board_title ?></h1>
    <table class="table table-hover mt-4">
        <tr>
            <th>번호</th>
            <th>제목</th>
            <th>이름</th>
            <th>날짜</th>
            <th>조회수</th>
        </tr>
        <tr>
            <td>1</td>
            <td>happy</td>
            <td>yellowdog</td>
            <td>2022-12-12</td>
            <td>0</td>
        </tr>
        <tr>
            <td>1</td>
            <td>happy</td>
            <td>yellowdog</td>
            <td>2022-12-12</td>
            <td>0</td>
        </tr><tr>
            <td>1</td>
            <td>happy</td>
            <td>yellowdog</td>
            <td>2022-12-12</td>
            <td>0</td>
        </tr>
    </table>

    <div class="d-flex justify-content-between align-items-start">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                <a class="page-link">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
        <button class="btn btn-primary" id="btn_write">글쓰기</button>
    </div>
</main>
<?php
include "./common_php/inc_footer.php";
?>