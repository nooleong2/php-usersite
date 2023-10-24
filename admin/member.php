<?php
$g_title = "회원 관리";
$js_arr = ["./js/member.js"];
$menu_code = "member";

include "./inc_common.php";
include "./inc_header.php";
include "../config/db_config.php";
include "../class/login.php";
include "../common_php/lib.php";

$sn = ( isset($_GET["sn"]) && $_GET["sn"] != "" && is_numeric($_GET["sn"]) ) ? $_GET["sn"] : "";
$sf = ( isset($_GET["sf"]) && $_GET["sf"] != "" ) ? $_GET["sf"] : "";
$paramArr = [
    "sn" => $sn,
    "sf" => $sf,
];

$mem = new Login($conn);
$total = $mem -> total($paramArr);
$limit = 5;
$page_limit = 5;
$page = ( isset($_GET["page"]) && $_GET["page"] != "" && is_numeric($_GET["page"])) ? $_GET["page"] : 1;
$param = "";


$memArr = $mem -> list($page, $limit, $paramArr);
?>

<main class="border rounded-3 p-5">
    
    <div class="container">
        <h3>회원관리</h3>
        <div class="mt-3 d-flex gap-2">
        <select name="sn" id="sn" class="form-select w-25">
            <option value="1">이름</option>
            <option value="2">아이디</option>
            <option value="3">이메일</option>
        </select>
        <input type="text" class="form-control" name="sf" id="sf">
        <button class="btn btn-primary w-25" id="btn_search">검색</button>
        <button class="btn btn-success w-25" id="btn_all">전체 목록</button>
    </div>
    </div>

    <table class="table table-border mt-4">
        <tr>
            <th>번호</th>
            <th>아이디</th>
            <th>이름</th>
            <th>이메일</th>
            <th>가입일</th>
            <th>관리</th>
        </tr>
        <?php
            foreach($memArr as $row) {
        ?>
            <tr>
                <td><?= $row["idx"] ?></td>
                <td><?= $row["id"] ?></td>
                <td><?= $row["name"] ?></td>
                <td><?= $row["email"] ?></td>
                <td><?= $row["create_at"] ?></td>
                <td>
                    <button class="btn btn-sm btn-primary btn_mem_edit" data-idx="<?= $row["idx"] ?>">수정</button>
                    <button class="btn btn-sm btn-danger btn_mem_delete" data-idx="<?= $row["idx"] ?>">삭제</button>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>

    <div class="d-flex justify-content-between align-items-start">
        <div>
            <?php
                $param = "&sn=" .$sn. "&sf=" .$sf;
                echo my_pagination($total, $limit, $page_limit, $page, $param);  
            ?>
        </div>
        <div>
            <button class="btn btn-primary" id="btn_excel">Excel 저장</button>
        </div>
    </div>

</main>

<?php
include "./inc_footer.php";
?>

