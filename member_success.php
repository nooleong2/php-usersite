<?php
$js_arr = ["js/member_success.js"];
$g_title = "가입 축하";
$menu_code = "register";

include "./common_php/inc_header.php";
?>

<main class="w-75 mx-auto border rounded-5 p-5 d-flex gap-5" style="height: calc(100vh - 257px);">
    <img src="./images/logo.svg" class="w-50" alt="">
    <div>
        <h3>회원 가입을 축하드립니다.</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati minus, ea aliquid ratione, et saepe fuga natus, totam optio quibusdam repellat velit? Libero cupiditate tempore ab, dicta dolore non hic?</p>
        <button class="btn btn-primary" id="btn_login">로그인 하러가기</button>
    </div>
</main> 

<?php
include "./common_php/inc_footer.php";
?>