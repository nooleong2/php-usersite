'use strict';

// 주소 값 배열로 가져오기
function getUrlParams() {
    const params = {};
    window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, 
    function(str, key, value) {
        params[key] = value;
    });
    return params;
}

const params = getUrlParams();

// 글 목록
const btn_list = document.querySelector("#btn_list");
btn_list.addEventListener("click", () => {
    self.location.href = "./board.php?bcode=" + params["bcode"];
});

// 글 수정
const btn_edit = document.querySelector("#btn_edit");
if (btn_edit){
    btn_edit.addEventListener("click", () => {
        self.location.href = "./board_edit.php?bcode=" + params["bcode"] + "&idx=" + params["idx"];
    });
}

// 글 삭제
const btn_delete = document.querySelector("#btn_delete");
if (btn_delete){
    btn_delete.addEventListener("click", () => {
        if (confirm("삭제하시겠습니까?")) {

            const f1 = new FormData();
            f1.append("idx", params["idx"]);
            f1.append("bcode", params["bcode"]);
            f1.append("mode", "delete");
            
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "./process/board_process.php", true);
            xhr.send(f1);
            xhr.onload = () => {
                if (xhr.status == 200) {
                    const data = JSON.parse(xhr.response);
                    
                    if (data.result == "success_delete") {
                        alert("게시글 삭제 완료되었습니다.");
                        self.location.href = "./board.php?bcode=" + params["bcode"];
                    }
                    
                } else {
                    alert("통신 실패");
                }
            }
        }
    });
}

