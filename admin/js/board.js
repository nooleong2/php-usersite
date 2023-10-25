'use strict';
const board_title = document.querySelector("#board_title");

// 모달 확인 버튼 이벤트
const btn_board_create = document.querySelector("#btn_board_create");
btn_board_create.addEventListener("click", () => {

    const board_type = document.querySelector("#board_type");

    if (board_title.value == "") {
        alert("게시판 이름을 입력해주세요.");
        board_title.focus();
        return;
    }

    // 네트워크가 느려졌을 때 중복 생성 방지
    btn_board_create.disabled = true;

    const board_mode = document.querySelector("#board_mode");

    const f1 = new FormData();
    f1.append("board_title", board_title.value);
    f1.append("board_type", board_type.value);
    f1.append("mode", board_mode.value);
    f1.append("idx", document.querySelector("#board_idx").value);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./process/board_process.php", true);
    xhr.send(f1);
    xhr.onload = () => {
        if (xhr.status == 200) {
            const data = JSON.parse(xhr.response);
            
            if (data.result == "empty_mode") {
                alert("MODE 값이 누락되었습니다.");
                btn_board_create.disabled = false;
                return;
            } else if (data.result == "empty_title") {
                alert("게시판 명이 누락되었습니다.");
                board_title.focus();
                btn_board_create.disabled = false;
                return;
            } else if (data.result == "empty_btype") {
                alert("게시판 타입이 누락되었습니다.");
                btn_board_create.disabled = false;
                return;
            } else if (data.result == "success") {
                alert("게시판 생성되었습니다.");
                self.location.reload();
            } else if (data.result == "success_edit") {
                alert("게시판 수정되었습니다.");
                self.location.reload();
            }
            
        } else {
            alert("통신 실패: " + xhr.status);
            btn_board_create.disabled = false;
        }
    }
});

// 게시판 생성 버튼 이벤트
const btn_create_modal = document.querySelector("#btn_create_modal");
btn_create_modal.addEventListener("click", () => {
    board_title.value = "";

    const board_mode = document.querySelector("#board_mode");
    board_mode.value = "input";

    document.querySelector("#modal_title").textContent = "게시판 생성";

});

// 게시판 메뉴 수정 버튼 이벤트
const btn_mem_edit = document.querySelectorAll(".btn_mem_edit");
btn_mem_edit.forEach((box) => {
    box.addEventListener("click", () => {
        document.querySelector("#modal_title").textContent = "게시판 수정";

        const idx = box.dataset.idx;
        const board_mode = document.querySelector("#board_mode");
        const board_idx = document.querySelector("#board_idx");
        board_mode.value = "edit";
        board_idx.value = idx;
        
        const f1 = new FormData();
        f1.append("idx", idx);
        f1.append("mode", "getInfo");
        
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "./process/board_process.php", true);
        xhr.send(f1);
        xhr.onload = () => {
            if (xhr.status == 200) {
                const data = JSON.parse(xhr.response);
                if (data.result == "empty_idx") {
                    alert("idx 값이 누락되었습니다.");
                    return;

                } else if (data.result == "success") {
                    board_title.value = data.list.name;
                    document.querySelector("#board_type").value = data.list.btype;
                }
            } else {
                alert("통신 실패" + xhr.status);
            }
        }
    });
});

// 게시판 메뉴 삭제 버튼 이벤트
const btn_mem_delete = document.querySelectorAll(".btn_mem_delete");
btn_mem_delete.forEach((box) => {
    box.addEventListener("click", () => {
        const idx = box.dataset.idx;

        if (!confirm("본 게시판을 삭제하시겠습니까?")) {
            return;
        }

        const f1 = new FormData();
        f1.append("idx", idx);
        f1.append("mode", "delete");

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "./process/board_process.php", true);
        xhr.send(f1);
        xhr.onload = () => {
            if (xhr.status == 200) {
                const data = JSON.parse(xhr.response);
                if (data.result == "empty_idx") {
                    alert("idx 값이 누락되었습니다.");
                    return;
                } else if (data.result == "success") {
                    self.location.reload();
                }
            } else {
                alert("통신 실패");
            }
        }
    })
});

// 게시판 메뉴 보기 버튼 이벤트 발생
const btn_board_view = document.querySelectorAll(".btn_board_view");
btn_board_view.forEach((box) => {
    box.addEventListener("click", () => {
        const bcode = box.dataset.bcode;
        self.location.href = "../board.php?bcode=" + bcode;
    });
});