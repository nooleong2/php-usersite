<?php
session_start();
$session_id = ( isset($_SESSION["session_id"]) && $_SESSION["session_id"] != "" ) ? $_SESSION["session_id"] : "";

if ($session_id == "") {
    echo
    "
        <script>
            alert('로그인 후 접근 가능한 페이지입니다.');
            self.location.href = './index.php';
        </script>
    ";
    exit;
}

$js_arr = ["js/mypage.js"];

$g_title = "회원수정";
$menu_code = "mypage";

include "./common_php/inc_header.php";
include "./config/db_config.php";
include "./class/login.php";

$login = new Login($conn);
$loginArr = $login -> getInfo($session_id);
?>

<!-- 카카오 우편 찾기 API -->
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

<main class="w-50 mx-auto p-5 border rounded-5">
    <h1 class="text-center">회원정보 수정</h1>

    <form name="register_form" action="./process/register_process.php" method="POST" enctype="multipart/form-data">
        <!-- 히든 값 -->
        <input type="hidden" name="email_chk" value="0">
        <input type="hidden" name="mode" value="edit">
        <input type="hidden" name="old_email" value="<?= $loginArr["email"] ?>">
        <input type="hidden" name="old_photo" value="<?= $loginArr["photo"] ?>">

        <!-- 아이디 --> 
        <div class="d-flex gap-2 align-items-end">
            <div class="flex-grow-1">
                <label for="f_id" class="form-label">아이디</label>
                <input type="text" class="form-control" name="f_id" id="f_id" value="<?= $loginArr["id"] ?>" placeholder="아이디를 입력해주세요." readonly>
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
                <input type="email" class="form-control" name="f_email" id="f_email" value="<?= $loginArr["email"] ?>" placeholder="이메일을 입력해주세요.">
            </div>
            <button type="button" class="btn btn-secondary" id="btn_email_chk">이메일 중복확인</button>
        </div>

        <!-- 이름 --> 
        <div class="d-flex mt-3 gap-2 align-items-end">
            <div class="w-50">
                <label for="f_name" class="form-label">이름</label>
                <input type="text" class="form-control" name="f_name" id="f_name" value="<?= $loginArr["name"] ?>" placeholder="이름을 입력해주세요.">
            </div>
        </div>

        <!-- 우편번호 찾기 -->
        <div class="mt-3 d-flex align-items-end gap-2">
            <div>
                <label for="f_zipcode">우편번호</label>
                <input type="text" name="f_zipcode" id="f_zipcode" class="form-control" value="<?= $loginArr["zipcode"] ?>"  maxlength="5" minlength="5">
            </div>
            <button type="button" class="btn btn-secondary" id="btn_zipcode">우편번호 찾기</button>
        </div>

        <!-- 주소 / 상세주소 -->
        <div class="d-flex mt-3 gap-2 justify-content-between">
            <div class="flex-grow-1">
                <label for="f_addr1" class="form-label">주소</label>
                <input type="text" class="form-control" name="f_addr1" id="f_addr1" value="<?= $loginArr["addr1"] ?>" >
            </div>
            <div class="flex-grow-1">
                <label for="f_addr2" class="form-label">상세 주소</label>
                <input type="text" class="form-control" name="f_addr2" id="f_addr2" value="<?= $loginArr["addr2"] ?>" >
            </div>
        </div>

        <!-- 프로필 이미지 -->
        <div class="mt-3 d-flex gap-5">
            <div>
                <label for="f_photo">프로필 이미지</label>
                <input type="file" name="f_photo" class="form-control" name="f_photo" id="f_photo">
            </div>
            <?php
                if ($loginArr["photo"]) {
                    echo '<img src="./data/profile/' . $loginArr["photo"] . '" id="f_preview" alt="profile image" class="w-25">';
            ?>
            <?php
                } else {
                    echo '<img src="./images/person.png" id="f_preview" alt="profile image" class="w-25">';
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
include "./common_php/inc_footer.php";
?>
