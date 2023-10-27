<?php
include "./common_php/inc_session.php";
include "./config/db_config.php";
include "./class/board_manage.php"; # 게시판 목록
$boardm = new BoardManage($conn);
$boardArr = $boardm -> list();

$js_arr = ["./js/board_edit.js"];
$g_title = "게시판";
include "./common_php/inc_header.php";

include "./class/board.php";

$bcode = ( isset($_GET["bcode"]) && $_GET["bcode"] != "" ) ? $_GET["bcode"] : "";
if ($bcode == "") {
    die("<script>alert('게시판 코드가 빠졌습니다.'); history.go(-1)</script>");
}

$idx = ( isset($_GET["idx"]) && $_GET["idx"] != "" ) ? $_GET["idx"] : "";
if ($idx == "") {
    die("<script>alert('게시물 번호가 빠졌습니다.'); history.go(-1)</script>");
}

$board = new Board($conn);
$boardRow = $board -> view($idx);

if ($boardRow["id"] != $session_id) {
    die("<script>alert('본인 게시물이 아닙니다.'); self.location.href = './board.php?bcode=$bcode';</script>");
}

$boardRow["content"] = str_replace("`", "\"", $boardRow["content"]);

?>
<!-- SUMMER NOTE -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<main class="border rounded-3 p-5">
    <h1 class="text-center">글 수정</h1>
    
    <div class="mb-3">
        <input type="text" name="subject" id="id_subject" class="form-control" value="<?= $boardRow["subject"] ?>" placeholder="제목을 입력하세요." autocomplete="off">
    </div>

    <div class="mb-3">
        <?php
                $th = 0;
                // 첨부파일 출력
                if ($boardRow["files"] != "") {
                    $filelist = explode("?", $boardRow["files"]);

                    if ($boardRow["downhit"] == "") {
                        $downhit_arr = array_fill(0, count($filelist), 0); // 시작 번호, 끝 번호, 채울 값
                    }
                    
                    foreach($filelist as $file) {
                        list($file_source, $file_name) = explode("|", $file);
                        echo '<a href="./process/board_download.php?idx=' .$idx. '&th=' .$th. '">' .$file_name. '</a> <button class="btn btn-sm btn_file_del mb-2 py-0 btn-danger" data-th='.$th.'>삭제</button><br>';
                        $th++;
                    }

                }
            ?>
    </div>
    <?php if ($th < 3) { ?>
        <div class="mb-3">
            <input type="file" name="attach" id="id_attach" class="form-control">
        </div>
    <?php }?>

    <div id="summernote"></div>

    <div class="mt-3 d-flex gap-1 justify-content-end">
        <button class="btn btn-primary" id="btn_edit_submit">확인</button>
        <button class="btn btn-success" id="btn_board_list">목록</button>
    </div>

</main>

<script>
    $('#summernote').summernote({
        placeholder: '내용을 입력해주세요.',
        tabsize: 2,
        height: 300,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });

    const markupStr = `<?= $boardRow["content"] ?>`;
    $('#summernote').summernote("code", markupStr);
</script>
<?php
include "./common_php/inc_footer.php";
?>