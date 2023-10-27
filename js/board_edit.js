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

// GET 주소 쿼리스트링 Key Value형식으로 받기
const params = getUrlParams();

// 파일 삭제
const btn_file_del = document.querySelectorAll(".btn_file_del");
btn_file_del.forEach((box) => {
    box.addEventListener("click", () => {

        if (!confirm("해당 첨부파일을 삭제하시겠습니까?")) {
            return;
        }

        const f1 = new FormData();
        f1.append("th", box.dataset.th);
        f1.append("bcode", params["bcode"]);
        f1.append("idx", params["idx"]);
        f1.append("mode", "each_file_del");

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "./process/board_process.php", true);
        xhr.send(f1);
        xhr.onload = () => {
            if (xhr.status == 200) {
                const data = JSON.parse(xhr.response);
                
                if (data.result == "success_file_delete") {
                    alert("정상적으로 파일이 삭제되었습니다.");
                    self.location.reload();
                    return;
                } else if (data.result == "empty_idx") {
                    alert("게시물 번호가 없습니다.");
                    return;
                } else if (data.result == "empty_th") {
                    alert("게시물 파일 번호가 없습니다.");
                    return;
                }
            } else {
                alert("통신 실패");
            }
        }
        
    });
});

// 파일 추가 등록
const id_attach = document.querySelector("#id_attach");
if (id_attach) {
    id_attach.addEventListener("change", () => {
        const f1 = new FormData();
        f1.append("bcode", params["bcode"]); // 게시판 코드
        f1.append("mode", "file_attach"); // 파일만 첨부
        f1.append("idx", params["idx"]); // 게시물 번호
        // console.log(id_attach.files[0]);

        ext = getExtensionOfFilename(id_attach.files[0].name);
        if (ext == "sql" || ext == "exe" || ext == "php" || ext == "js") {
            alert("f제한된 확장자 파일입니다.");
                id_attach.value = "";
                return;
        }

        f1.append("files[]", id_attach.files[0]); // 단일

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "./process/board_process.php", true);
        xhr.send(f1);
        xhr.onload = () => {
            if (xhr.status == 200) {
                const data = JSON.parse(xhr.response);

                if (data.result == "success") {
                    alert("파일 첨부 완료");
                    self.location.reload();
                } else if (data.result == "empty_files") {
                    alert("파일 첨부 되지 않았습니다.");
                }
            } else {
                alert("통신 실패");
            }
        }

    });
}

// 글 목록
const btn_board_list = document.querySelector("#btn_board_list");
btn_board_list.addEventListener("click", () => {
    self.location.href = "./board.php?bcode=" + params["bcode"];
});

// 글 수정
const btn_edit_submit = document.querySelector("#btn_edit_submit");
btn_edit_submit.addEventListener("click", () => {
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

    const f1 = new FormData();
    f1.append("subject", id_subject.value);
    f1.append("content", markupStr);
    f1.append("bcode", params["bcode"]);
    f1.append("mode", "edit");
    f1.append("idx", params["idx"]);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./process/board_process.php", true);
    xhr.send(f1);

    xhr.onload = () => {
        if (xhr.status == 200) {
            const data = JSON.parse(xhr.response);

            if (data.result == "success_edit") {
                alert("게시글 수정 되었습니다.");
                self.location.href = "./board.php?bcode=" + params["bcode"];
            } else if (data.result == "permission_denied") {
                alert("게시물 수정 권한이 없습니다.");
                self.location.href = "./board.php?bcode=" + params["bcode"];
            }
        } else {
            alert("통신 실패");
        }
    }
});