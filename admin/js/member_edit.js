// 이메일 중복 확인
const btn_email_chk = document.querySelector("#btn_email_chk");
btn_email_chk.addEventListener("click", () => {
    const f = document.edit_form;
    if (f.old_email.value == f.f_email.value) {
        alert("이메일 중복이 필요없습니다.");
        return;
    }

    if (f.f_email.value == "") {
        alert("이메일을 입력해주세요.")
        f.f_email.focus();
        return;
    }

    const f1 = new FormData();
    f1.append("email", f.f_email.value);
    f1.append("mode", "email_chk");

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../process/register_process.php", true);
    xhr.send(f1);

    xhr.onload = () => {
        if (xhr.status == 200) {
            const data = JSON.parse(xhr.response);
            
            if (data.result == "success") {
                alert("사용이 가능한 이메일입니다.");
                document.edit_form.email_chk.value = "1";

            } else if (data.result == "fail") {
                alert("이미 사용중인 이메일입니다.");
                document.edit_form.email_chk.value = "0";
                f.f_email.value = "";
                f.f_email.focus();
            } else if (data.result == "empty_email") {
                alert("이메일이 비어있습니다.");
                f.f_email.focus();
            } else if (data.result == "wrong_email") {
                alert("이메일 형식이 잘못되었습니다.");
                f.f_email.focus();
            }
        } else {
            alert("통신 실패");
        }
    }
});

// 우편찾기 버튼 클릭 시 이벤트 발생
const btn_zipcode = document.querySelector("#btn_zipcode");
btn_zipcode.addEventListener("click", () => {
    // 카카오 우편 찾기 API
    new daum.Postcode({
        oncomplete: function(data) {
            console.log(data);
            let addr = ""; // 주소
            let extra_arr = ""; // 법정동

            if (data.userSelectedType == "J") {
                // 지번 == J
                addr = data.jibunAddress;
            } else if (data.userSelectedType == "R") {
                // 도로명 == R
                addr = data.roadAddress;
            }

            // 법정동
            if (data.bname != "") {
                extra_arr = data.bname;
            }

            // 건물 이름
            if (data.buildingName != "") {
                if (extra_arr == "") {
                    extra_arr = data.buildingName;
                } else {
                    extra_arr += ', ' + data.buildingName;
                }   
            }

            if (extra_arr != "") {
                extra_arr = " (" + extra_arr + ")";
            }

            const f_addr1 = document.querySelector("#f_addr1");
            const f_addr2 = document.querySelector("#f_addr2");
            const f_zipcode = document.querySelector("#f_zipcode");
            f_addr1.value = addr + extra_arr;
            f_zipcode.value = data.zonecode;
            f_addr2.focus();


        }
    }).open();
});

// 이미지 미리보기 chagen 이벤트 발생
const f_photo = document.querySelector("#f_photo");
f_photo.addEventListener("change", (event) => {
    // console.log(event);
    const reader = new FileReader();
    reader.readAsDataURL(event.target.files[0]);

    reader.onload = (event) => {
        // console.log(event);
        const f_preivew = document.querySelector("#f_preview");
        f_preivew.setAttribute("src", event.target.result);
    }
});

// 수정 버튼 클릭시 이벤트 발생
const btn_submit = document.querySelector("#btn_submit");
// 수정 버튼 클릭시 이벤트 발생
btn_submit.addEventListener("click", () => {
    const f = document.edit_form;

    /**
     * 비밀번호 체크
     * 1. 비밀번호 입력 여부 체크
     * 2. 비밀번호 확인 입력 여부 체크
     * 3. 두 비밀번호 같은지 체크
     */
    if (f.f_password.value != "" && f.f_password2.value == "") {
        alert("비밀번호 확인을 입력해주세요.");
        f_password2.focus();
        return;
    }

    if (f.f_password.value != f.f_password2.value) {
        alert("비밀번호가 일치하지 않습니다.");
        f.f_password.value = "";
        f.f_password2.value = "";
        f.f_password2.focus();
        return;
    }

    /**
     * 이메일 체크
     * 1. 이메일 입력 여부 체크
     * 2. 이메일 중복 확인 여부 체크
     */
    if (f.f_email.value == "") {
        alert("이메일을 입력해주세요.");
        f.f_email.focus();
        return;
    }

    if (f.f_email.value != f.old_email.value) {
        if (f.email_chk.value == 0) {
            alert("이메일 중복확인을 해주시기바랍니다.");
            f.btn_email_chk.focus();
            return;
        }
    }

    /**
     * 이름 체크
     * 1. 이름 입력 여부 체크
     */
    if (f.f_name.value == "") {
        alert("이름을 입력해주세요.");
        f._fname.focus();
        return;
    }

    /**
     * 우편번호 및 주속 체크 체크
     * 1. 우편번호 입력 여부 체크
     * 2. 주소 입력 여부 체크
     * 3. 상세 주소 입력 여부 체크
     */

    if (f.f_zipcode.value == "") {
        alert("우편번호 입력해주세요.");
        return;
    }

    if (f.f_addr1.value == "") {
        alert("주소 입력해주세요.");
        f.f_addr1.focus();
        return;
    }

    if (f.f_addr2.value == "") {
        alert("상세 주소 입력해주세요.");
        f.f_addr2.focus();
        return;
    }

    // if (f.f_photo.value == "") {
    //     alert("이미지를 추가해주세요");
    //     return;
    // }

    f.submit();
});