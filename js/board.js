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

// 글 쓰기 버튼
const btn_write = document.querySelector("#btn_write");
btn_write.addEventListener("click", () => {
        
    self.location.href = "./board_write.php?bcode=" + params["bcode"];

});

// 글 검색 버튼
const btn_search = document.querySelector("#btn_search");
btn_search.addEventListener("click", () => {
    const sf = document.querySelector("#sf");
    const sn = document.querySelector("#sn");

    if (sf.value == "") {
        alert("검색어를 입력해주세요.");
        sf.focus();
        return;
    }
    self.location.href = "./board.php?bcode=" + params["bcode"] + "&sn=" + sn.value + "&sf=" + sf.value;
});

// 글 목록 버튼
const btn_all = document.querySelector("#btn_all");
btn_all.addEventListener("click", () => {
    
    self.location.href = "./board.php?bcode=" + params["bcode"];
});

// 글 보기
const trs = document.querySelectorAll(".tr");
trs.forEach((box) => {
    box.addEventListener("click", () => {
        const idx = box.dataset.idx;
        self.location.href = "./board_view.php?bcode=" + params["bcode"] + "&idx=" + idx;
    })
});