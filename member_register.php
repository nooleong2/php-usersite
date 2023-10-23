<?php

// if (!isset($_POST) || $_POST["chk"] != 1) {
//     die("<script>
//             alert('이용약관 확인 후 접근 가능합니다.');
//             self.location.href = './stipulation.php';
//         </script>");
// }

$js_arr = ["js/register_chk.js"];

$g_title = "회원가입";
$menu_code = "register";

include "./common_php/inc_header.php";
include "./config/db_config.php";
?>

<!-- 카카오 우편 찾기 API -->
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

<main class="w-50 mx-auto p-5 border rounded-5">
    <h1 class="text-center">회원가입</h1>

    <form name="register_form" action="./process/register_process.php" method="POST" enctype="multipart/form-data">
        <!-- 히든 값 -->
        <input type="hidden" name="id_chk" value="0">
        <input type="hidden" name="email_chk" value="0">
        <input type="hidden" name="mode" value="input">

        <!-- 아이디 --> 
        <div class="d-flex gap-2 align-items-end">
            <div class="flex-grow-1">
                <label for="f_id" class="form-label">아이디</label>
                <input type="text" class="form-control" name="f_id" id="f_id" placeholder="아이디를 입력해주세요.">
            </div>
            <button type="button" class="btn btn-secondary" name="btn_id_chk" id="btn_id_chk">아이디 중복확인</button>
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
                <input type="email" class="form-control" name="f_email" id="f_email" placeholder="이메일을 입력해주세요.">
            </div>
            <button type="button" class="btn btn-secondary" id="btn_email_chk">이메일 중복확인</button>
        </div>

        <!-- 이름 --> 
        <div class="d-flex mt-3 gap-2 align-items-end">
            <div class="w-50">
                <label for="f_name" class="form-label">이름</label>
                <input type="text" class="form-control" name="f_name" id="f_name" placeholder="이름을 입력해주세요.">
            </div>
        </div>

        <!-- 우편번호 찾기 -->
        <div class="mt-3 d-flex align-items-end gap-2">
            <div>
                <label for="f_zipcode">우편번호</label>
                <input type="text" name="f_zipcode" id="f_zipcode" class="form-control" maxlength="5" minlength="5">
            </div>
            <button type="button" class="btn btn-secondary" id="btn_zipcode">우편번호 찾기</button>
        </div>

        <!-- 주소 / 상세주소 -->
        <div class="d-flex mt-3 gap-2 justify-content-between">
            <div class="flex-grow-1">
                <label for="f_addr1" class="form-label">주소</label>
                <input type="text" class="form-control" name="f_addr1" id="f_addr1">
            </div>
            <div class="flex-grow-1">
                <label for="f_addr2" class="form-label">상세 주소</label>
                <input type="text" class="form-control" name="f_addr2" id="f_addr2">
            </div>
        </div>

        <!-- 프로필 이미지 -->
        <div class="mt-3 d-flex gap-5">
            <div>
                <label for="f_photo">프로필 이미지</label>
                <input type="file" name="f_photo" class="form-control" name="f_photo" id="f_photo">
            </div>
            <img src="./images/person.png" id="f_preview" alt="profile image" class="w-25">
        </div>

        <!-- 버튼 -->
        <div class="mt-3 d-flex gap-2">
            <button type="button" class="btn btn-primary w-50" id="btn_submit">가입하기</button>
            <button type="button" class="btn btn-secondary w-50">가입취소</button>
        </div>
    </form>

</main>

<?php
include "./common_php/inc_footer.php";
?>
