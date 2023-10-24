const btn_search = document.querySelector("#btn_search");
btn_search.addEventListener("click", () => {

    const sf = document.querySelector("#sf");
    const sn = document.querySelector("#sn");
    if (sf.value == "") {
        alert("검색어를 입력해주세요.");
        sf.focus();
        return;
    }

    self.location.href = "./member.php?sn=" + sn.value + "&sf=" + sf.value;

});

const btn_all = document.querySelector("#btn_all");
btn_all.addEventListener("click", () => {
    self.location.href = "./member.php";
});

const btn_excel = document.querySelector("#btn_excel");
btn_excel.addEventListener("click", () => {
    self.location.href = "./member_to_excel.php";
});

const btn_mem_deletes = document.querySelectorAll(".btn_mem_delete");
btn_mem_deletes.forEach( (box) => {
    box.addEventListener("click", () => {
        if (confirm("회원을 삭제하시겠습니까?")) {

            const idx = box.dataset.idx;
            const xhr = new XMLHttpRequest();

            const f1 = new FormData();
            f1.append("idx", idx);

            xhr.open("POST", "./member_del.php", true);
            xhr.send(f1);

            xhr.onload = () => {
                if (xhr.status == 200) {
                    const data = JSON.parse(xhr.response);

                    if (data.result == "success") {
                        self.location.reload();
                    }
                } else {
                    alert("통신 실패");
                }
            }
            
        } else {
            alert("삭제 취소");
        }
    });
});

const btn_mem_edits = document.querySelectorAll(".btn_mem_edit");
btn_mem_edits.forEach( (box) => {
    box.addEventListener("click", () => {
        const idx = box.dataset.idx;
        self.location.href = "./member_edit.php?idx=" + idx;
    });
});