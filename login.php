<?php
$g_title = "로그인";
$js_arr = ["./js/login.js"];
$menu_code = "login";

include "./common_php/inc_header.php";
?>

<main class="w-75 mx-auto border rounded-3 p-5 d-flex gap-5">
    <form action="" class="w-50 mt-5 m-auto" method="POST" autocomplete="off">
        <img src="./images/logo.svg" width="72" alt="">
        <h1 class="h3 mb-3">로그인</h1>
        
        <div class="form-floating mt-2">
            <input type="text" name="f_id" id="f_id" class="form-control">
            <label for="f_id">아이디</label>
        </div>

        <div class="form-floating mt-2">
            <input type="password" name="f_password" id="f_password" class="form-control">
            <label for="f_password">비밀번호</label>
        </div>
        <button type="button" class="btn btn-primary w-100 mt-2" id="btn_login">로그인</button>
    </form>
</main>

<?php
include "./common_php/inc_footer.php";
?>

