"use strict";

// 버튼 조작을 위해 HTML에서 들고 옴
const btn_member = document.querySelector("#btn_member");

// 회원가입 버튼 클릭시 이벤트 발생
btn_member.addEventListener("click", () => {

    const chk_member1 = document.querySelector("#chk_member1");
    const chk_member2 = document.querySelector("#chk_member2");

    // 약관 체크
    if (chk_member1.checked !== true) {
        alert("회원 약관에 동의해주세요.");
        chk_member1.focus();
        return;
    }
    
    // 개인정보 체크
    if (chk_member2.checked !== true) {
        alert("개인정보 처리방침 동의해주세요.");
        chk_member2.focus();
        return;
    }

    /**
     * 둘다 체크 완료
     * 회원가입 페이지 이동 (member_register.phph)
     */
    const f = document.stipulation_form;
    f.chk.value = 1
    f.submit();
});







