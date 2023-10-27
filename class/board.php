<?php
// 게시판 클래스

class Board {
    private $conn;

    public function __construct($db) {
        $this -> conn = $db;
    }

    // 글 등록
    public function input($arr) {
        $sql = "INSERT INTO board (bcode, id, name, subject, content, files, ip)
                VALUES (:bcode, :id, :name, :subject, :content, :files, :ip);";
        
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":bcode", $arr["bcode"]);
        $stmt -> bindParam(":id", $arr["id"]);
        $stmt -> bindParam(":name", $arr["name"]);
        $stmt -> bindParam(":subject", $arr["subject"]);
        $stmt -> bindParam(":content", $arr["content"]);
        $stmt -> bindParam(":files", $arr["files"]);
        $stmt -> bindParam(":ip", $arr["ip"]);
        $stmt -> execute();
    } 

    // 글 수정
    public function edit($arr) {
        $sql = "UPDATE board SET subject = :subject, content = :content WHERE idx = :idx";
        $stmt = $this -> conn -> prepare($sql);
        $params = [
            ":subject" => $arr["subject"],
            ":content" => $arr["content"],
            ":idx" => $arr["idx"],
        ];
        $stmt -> execute($params);
    }

    // 글 삭제
    public function delete($idx) {
        $sql = "DELETE FROM board WHERE idx = :idx";
        $stmt = $this -> conn -> prepare($sql);
        $params = [":idx" => $idx];
        $stmt -> execute($params);
    }

    // 글 목록
    public function list($bcode, $page, $limit, $paramArr) {
        $start = ($page - 1) * $limit;

        $where = "WHERE bcode = :bcode ";
        $params = [":bcode" => $bcode];
        if (isset($paramArr["sn"]) && $paramArr["sn"] != "" && isset($paramArr["sf"]) && $paramArr["sf"] != "") {
            switch ($paramArr["sn"]) {
                case 1: 
                    // 제목 + 내용
                    $where .= " AND (subject LIKE CONCAT('%', :sf, '%') OR content LIKE CONCAT('%', :sf2, '%'))"; 
                    $params = [":bcode" => $bcode, ":sf" => $paramArr["sf"], ":sf2" => $paramArr["sf"]];
                    break;

                case 2: 
                    // 제목
                    $where .= " AND (subject LIKE CONCAT('%', :sf, '%')) "; 
                    $params = [":bcode" => $bcode, ":sf" => $paramArr["sf"]];
                    break;

                case 3: 
                    // 내용
                    $where .= " AND (content LIKE CONCAT('%', :sf, '%')) "; 
                    $params = [":bcode" => $bcode, ":sf" => $paramArr["sf"]];
                    break;

                case 4: 
                    // 작성자
                    $where .= " AND (name = :sf) "; 
                    $params = [":bcode" => $bcode, ":sf" => $paramArr["sf"]];
                    break;
            }
        }

        $sql = "SELECT idx, id, subject, name, hit, DATE_FORMAT(create_at, '%Y-%m-%d %H:%m') AS create_at 
                FROM board " .$where. "
                ORDER BY create_at DESC LIMIT " .$start. "," .$limit.";";
        
        $stmt = $this -> conn -> prepare($sql);

        $stmt -> execute($params);
        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

    // 전체 글 수
    public function total($bcode, $paramArr) {
        $where = "WHERE bcode = :bcode ";
        $params = [":bcode" => $bcode];
        if (isset($paramArr["sn"]) && $paramArr["sn"] != "" && isset($paramArr["sf"]) && $paramArr["sf"] != "") {
            switch ($paramArr["sn"]) {
                case 1: 
                    // 제목 + 내용
                    $where .= " AND (subject LIKE CONCAT('%', :sf, '%') OR content LIKE CONCAT('%', :sf2, '%'))"; 
                    $params = [":bcode" => $bcode, ":sf" => $paramArr["sf"], ":sf2" => $paramArr["sf"]];
                    break;

                case 2: 
                    // 제목
                    $where .= " AND (subject LIKE CONCAT('%', :sf, '%')) "; 
                    $params = [":bcode" => $bcode, ":sf" => $paramArr["sf"]];
                    break;

                case 3: 
                    // 내용
                    $where .= " AND (content LIKE CONCAT('%', :sf, '%')) "; 
                    $params = [":bcode" => $bcode, ":sf" => $paramArr["sf"]];
                    break;

                case 4: 
                    // 작성자
                    $where .= " AND (name = :sf) "; 
                    $params = [":bcode" => $bcode, ":sf" => $paramArr["sf"]];
                    break;
            }
        }

        $sql = "SELECT COUNT(*) AS cnt FROM board " .$where. ";";
        
        $stmt = $this -> conn -> prepare($sql);

        $stmt -> execute($params);
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        return $row['cnt'];
    }

    // 글 보기
    public function view($idx) {
        $sql = "SELECT * FROM board WHERE idx = :idx";
        $stmt = $this -> conn -> prepare($sql);
        $params = [
            ":idx" => $idx,
        ];

        $stmt -> execute($params);
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    // 글 조회 수 +1
    public function hitInc($idx) {
        $sql = "UPDATE board SET hit = hit + 1 WHERE idx = :idx";
        $stmt = $this -> conn -> prepare($sql);
        $params = [":idx" => $idx];
        $stmt -> execute($params);
    }

    // 파일 목록 업데이트
    public function updateFileList($idx, $files, $downs) {
        $sql = "UPDATE board SET files = :files, downhit = :downs WHERE idx = :idx";
        $stmt = $this -> conn -> prepare($sql);
        $params = [
            ":idx" => $idx,
            ":files" => $files,
            ":downs" => $downs,
        ];
        $stmt -> execute($params);
    }

    //  첨부 파일 다운로드
    public function getAttachFile($idx, $th) {
        $sql = "SELECT files FROM board WHERE idx = :idx";
        $stmt = $this -> conn -> prepare($sql);
        $params = [":idx" => $idx];
        $stmt -> execute($params);
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        $filelist = explode("?", $row["files"]);

        return $filelist[$th] ."|". count($filelist);
    }

    // 다운로드 횟수 구하기
    public function getDownHit($idx) {
        $sql = "SELECT downhit FROM board WHERE idx = :idx";
        $stmt = $this -> conn -> prepare($sql);
        $params = [":idx" => $idx];
        $stmt -> execute($params);
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        return $row["downhit"];
    }

    // 다운로드 횟수 증가
    public function increaseDownHit($idx, $downhit) {
        $sql = "UPDATE board SET downhit = :downhit WHERE idx = :idx";
        $stmt = $this -> conn -> prepare($sql);
        $params = [
            ":downhit" => $downhit,
            ":idx" => $idx,
        ];
        $stmt -> execute($params);
    }

    // last_reader 값 변경
    public function updateLastReader($idx, $str) {
        $sql = "UPDATE board SET last_reader = :last_reader WHERE idx = :idx";
        $stmt = $this -> conn -> prepare($sql);
        $params = [
            ":last_reader" => $str,
            ":idx" => $idx,
        ];
        $stmt -> execute($params);
    }

    // 파일 첨부
    public function file_attach($files, $file_cnt) {

        // 백엔드 파일 첨부 3개 제한 기능
        if (sizeof($files["name"]) > $file_cnt) {
            $arr = ["result" => "file_upload_count_exeed"];
            die(json_encode($arr));
        }

        $tmp_arr = [];
        foreach ($files["name"] as $key => $val) {
            // $_FILES["files"]["name"][$key];

            $tmparr = explode(".", $files["name"][$key]);
            $ext = end($tmparr); // 배열의 마지막 값을 반환

            $not_arrowed_file_ext = ["txt", "exe", "sql"];
            // 확장자 제한
            if (in_array($ext, $not_arrowed_file_ext)) { # 앞에있는 값이 뒤에 배열에 존재하는지 판단
                $arr = ["result" => "not_allowed_file"];
                die(json_encode($arr));
            }
            
            $flag = rand(1000, 9999);
            $filename = "a" .date("YmdHis") .$flag. "." .$ext;
            $file_ori = $_FILES["files"]["name"][$key];

            copy($files["tmp_name"][$key], BOARD_DIR ."/". $filename); // 폴더에 파일 추가

            $full_str = $filename .'|'. $file_ori;
            $tmp_arr[] = $full_str;
        }

        $file_list_str = implode("?", $tmp_arr); // ? 구분자를 통해 여러개를 하나의 DB 컬럼에 넣는다        
        return $file_list_str;
    }

    // 이미지 짜른거 가져오기
    public function extract_image($content) {
        preg_match_all("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $content, $matches);

        $img_arr = [];
        foreach ($matches[1] as $key => $value) {
            $img_arr[] = $value;
        }

        return $img_arr;
    }

}