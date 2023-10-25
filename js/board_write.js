'use strict';
function getUrlParams() {
    const params = {};
    window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, 
    function(str, key, value) {
        params[key] = value;
    });
    return params;
}

// 게시판 목록 버튼 이벤트
const btn_board_list = document.querySelector("#btn_board_list");
btn_board_list.addEventListener("click", () => {
    const params = getUrlParams();
    self.location.href = "./board.php?bcode=" + params["bcode"];
});

// 게시판 확인 버튼 이벤트
const btn_write_submit = document.querySelector("#btn_write_submit");
btn_write_submit.addEventListener("click", () => {
    const id_subject = document.querySelector("#id_subject");
    if (id_subject.value == "") {
        alert("게시물 제목을 입력해주세요.");
        id_subject.focus();
        return;
    }
    
    const markupStr = $("#summernote").summernote('code');
    if (markupStr == "<p><br></p>") {
        alert("게시물 내용을 입력해주세요.");
        return;
    }

    const params = getUrlParams();
    const bcode = params["bcode"];

    const f1 = new FormData();
    f1.append("subject", id_subject.value);
    f1.append("content", markupStr);
    f1.append("bcode", bcode);
    f1.append("mode", "input");

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./process/board_process.php", true);
    xhr.send(f1);

    xhr.onload = () => {
        if (xhr.status == 200) {
            const data = JSON.parse(xhr.response);
            
            if (data.result == "success_input") {
                alert("게시글 작성되었습니다.");
                self.location.href = "./board.php?bcode=" + bcode;
            }
        } else {
            alert("통신 실패");
        }
    }
});