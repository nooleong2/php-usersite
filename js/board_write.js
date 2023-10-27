'use strict';
function getUrlParams() {
    const params = {};
    window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, 
    function(str, key, value) {
        params[key] = value;
    });
    return params;
}


function getExtensionOfFilename(filename) {
    const file_len = filename.length;
    const lastdot = filename.lastIndexOf("."); // 해당 문자열의 마지막 . 을 구함
    const ext = filename.substring(lastdot + 1, file_len).toLowerCase();
    return ext;
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

    // 파일 첨부
    const id_attach = document.querySelector("#id_attach");
    // const file = id_attach.files[0]; 단일 첨부 파일 

    // 파일 첨부 개수 제한
    if (id_attach.files.length > 3) {
        alert("첨부할 파일 수는 3개까지 입니다.");
        id_attach.value = "";
        return;
    }


    const params = getUrlParams();

    const f1 = new FormData();
    f1.append("subject", id_subject.value);
    f1.append("content", markupStr);
    f1.append("bcode", params["bcode"]);
    f1.append("mode", "input");
    // f1.append("files", file); 단일 첨부 파일

    let ext = "";
    for (const file of id_attach.files) {

        ext = getExtensionOfFilename(file.name);
        if (ext == "sql" || ext == "exe" || ext == "php" || ext == "js") {
            alert("f제한된 확장자 파일입니다.");
                id_attach.value = "";
                return;
        }

        f1.append("files[]", file); // 복수
    }

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./process/board_process.php", true);
    xhr.send(f1);

    xhr.onload = () => {
        if (xhr.status == 200) {
            const data = JSON.parse(xhr.response);
            
            if (data.result == "success_input") {
                self.location.href = "./board.php?bcode=" + params["bcode"];
            } else if (data.result == "file_upload_count_exeed") {
                alert("파일 업로드 개수 초과했습니다.");
                id_attach.value = "";
                return;
            } else if (data.result == "not_allowed_file") {
                alert("제한된 확장자 파일입니다.");
                id_attach.value = "";
                return;
            }
        } else {
            alert("통신 실패");
        }
    }
});

// 파일 첨부 제한
const id_attach = document.querySelector("#id_attach");
id_attach.addEventListener("change", () => {
    if (id_attach.files.length > 3) {
        alert("파일은 3개까지만 첨부가 가능합니다.");
        id_attach.value = "";
        return;
    }
});