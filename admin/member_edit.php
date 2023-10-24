<?php
$g_title = "회원 관리";
$js_arr = ["./js/member_edit.js"];
$menu_code = "member";

include "./inc_common.php";
include "./inc_header.php";
include "../config/db_config.php";
include "../class/login.php";
include "../common_php/lib.php";

$mem = new Login($conn);

$idx = ( isset($_GET["idx"]) && $_GET["idx"] != "" && is_numeric($_GET["idx"]) ) ? $_GET["idx"] : "";

if ($idx == "") {
    die("<script>alert('idx 값이 비었습니다.'); history.go(-1);</script>");
}

$row = $mem -> getInfoFromIdx($idx);
?>

<!-- 카카오 우편 찾기 API -->
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

<main class="w-50 mx-auto p-5 border rounded-5">
    <h1 class="text-center">회원정보수정</h1>

    <form name="edit_form" action="./process/member_process.php" method="POST" enctype="multipart/form-data">
        <!-- 히든 값 -->
        <input type="hidden" name="f_idx" value="<?= $row["idx"]; ?>">
        <input type="hidden" name="email_chk" value="0">
        <input type="hidden" name="mode" value="edit">
        <input type="hidden" name="old_email" value="<?= $row["email"]; ?>">
        <input type="hidden" name="old_photo" value="<?= $row["photo"]; ?>">

        <!-- 아이디 --> 
        <div class="d-flex gap-2 align-items-end">
            <div class="flex-grow-1">
                <label for="f_id" class="form-label">아이디</label>
                <input type="text" class="form-control" name="f_id" id="f_id" value="<?= $row["id"]; ?>" placeholder="아이디를 입력해주세요." readonly>
            </div>
        </div>

        <!-- 비밀번호 -->
        <div class="d-flex mt-3 gap-2 justify-content-between">
            <div class="flex-grow-1">
                <label for="f_password" class="form-label">비밀번호</label>
                <input type="password" class="form-control" name="f_password" id="f_password" placeholder="비밀번호를 입력해주세요.">
            </div>
            <div class="flex-grow-1">
                <label for="f_password2" class="form-label">비밀번호 확인</label>
                <input type="password" class="form-control" name="f_password2" id="f_password2" placeholder="비밀번호를 입력해주세요.">
            </div>
        </div>

        <!-- 이메일 --> 
        <div class="d-flex mt-3 gap-2 align-items-end">
            <div class="flex-grow-1">
                <label for="f_email" class="form-label">이메일</label>
                <input type="email" class="form-control" name="f_email" id="f_email" value="<?= $row["email"]; ?>" placeholder="이메일을 입력해주세요.">
            </div>
            <button type="button" class="btn btn-secondary" id="btn_email_chk">이메일 중복확인</button>
        </div>

        <!-- 이름 // 레벨 --> 
        <div class="d-flex mt-3 gap-2 align-items-end">
            <div class="w-50">
                <label for="f_name" class="form-label">이름</label>
                <input type="text" class="form-control" name="f_name" id="f_name" value="<?= $row["name"]; ?>" placeholder="이름을 입력해주세요.">
            </div>

            <div class="w-50">
                <label for="f_level" class="form-label">레벨</label>
                <select name="f_level" id="f_level" class="form-select">
                    <option value="1" <?= $row["level"] == 1 ? "selected" : "" ?>>가입대기</option>
                    <option value="2" <?= $row["level"] == 2 ? "selected" : "" ?>>준회원</option>
                    <option value="3" <?= $row["level"] == 3 ? "selected" : "" ?>>정회원</option>
                    <option value="10" <?= $row["level"] == 10 ? "selected" : "" ?>>관리자</option>
                </select>
            </div>
        </div>

        <!-- 우편번호 찾기 -->
        <div class="mt-3 d-flex align-items-end gap-2">
            <div>
                <label for="f_zipcode">우편번호</label>
                <input type="text" name="f_zipcode" id="f_zipcode" class="form-control" value="<?= $row["zipcode"]; ?>" maxlength="5" minlength="5">
            </div>
            <button type="button" class="btn btn-secondary" id="btn_zipcode">우편번호 찾기</button>
        </div>

        <!-- 주소 / 상세주소 -->
        <div class="d-flex mt-3 gap-2 justify-content-between">
            <div class="flex-grow-1">
                <label for="f_addr1" class="form-label">주소</label>
                <input type="text" class="form-control" name="f_addr1" id="f_addr1" value="<?= $row["addr1"]; ?>">
            </div>
            <div class="flex-grow-1">
                <label for="f_addr2" class="form-label">상세 주소</label>
                <input type="text" class="form-control" name="f_addr2" id="f_addr2" value="<?= $row["addr2"]; ?>">
            </div>
        </div>

        <!-- 프로필 이미지 -->
        <div class="mt-3 d-flex gap-5">
            <div>
                <label for="f_photo">프로필 이미지</label>
                <input type="file" name="f_photo" class="form-control" name="f_photo" id="f_photo">
            </div>
            <?php
                if ($row["photo"]) {
                    echo '<img src="../data/profile/' . $row["photo"] . '" id="f_preview" alt="profile image" class="w-25">';
            ?>
            <?php
                } else {
                    echo '<img src="../images/person.png" id="f_preview" alt="profile image" class="w-25">';
            ?>
            <?php
                }
            ?>
        </div>

        <!-- 버튼 -->
        <div class="mt-3 d-flex gap-2">
            <button type="button" class="btn btn-primary w-50" id="btn_submit">수정확인</button>
            <button type="button" class="btn btn-secondary w-50">수정취소</button>
        </div>
    </form>

</main>

<?php
include "./inc_footer.php";
?>

