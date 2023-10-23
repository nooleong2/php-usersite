'use strict';

const btn_login = document.querySelector("#btn_login");

btn_login.addEventListener("click", () => {
    
    const f_id = document.querySelector("#f_id");
    const f_password = document.querySelector("#f_password");

    if (f_id.value == "") {
        alert("아이디를 입력해주세요.");
        f_id.focus();
        return;
    }

    if (f_password.value == "") {
        alert("비밀번호를 입력해주세요.");
        f_password.focus();
        return;
    }

    // AJAX 방식으로 통신
    const f1 = new FormData();
    f1.append("f_id", f_id.value);
    f1.append("f_password", f_password.value);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./process/login_process.php", true);
    xhr.send(f1);

    xhr.onload = () => {
        if (xhr.status == 200) {
            
            const data = JSON.parse(xhr.response);

            if (data.result == "empty_id") {
                alert("아이디를 입력하시기 바랍니다.");
                f_id.focus();

            } else if (data.result == "empty_password") {
                alert("비밀번호를 입력하시기 바랍니다.");
                f_password.focus();

            } else if (data.result == "login_success") {
                alert("로그인 성공했습니다.");
                self.location.href = "./index.php";

            } else if (data.result == "login_fail") {
                alert("아이디 / 비밀번호 확인 부탁드립니다.");
                f_id.value = "";
                f_password.value = "";
                f_id.focus();
            }
        } else {
            alert("통신 실패");
        }
    }

    
});