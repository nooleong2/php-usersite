<?php

class Login {

    private $conn;

    public function __construct($conn) {
        $this -> conn = $conn;
    }

    // 로그인
    public function login($id, $password) {
        $sql = "SELECT * FROM member WHERE id = :id";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":id", $id);
        $stmt -> execute();

        // 1. 아이디가 일치해서 존재한다면
        if ($stmt -> rowCount()) {

            // 데이터 가지고 오기
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);
            
            // 비밀번호 해쉬 값 비교
            if (password_verify($password, $row["password"])) {
                $sql = "UPDATE member SET login_dt = NOW() WHERE id = :id;";
                $stmt = $this -> conn -> prepare($sql);
                $stmt -> bindParam(":id", $id);
                $stmt -> execute();

                return true;
            } else {
                return false;
            }
        // 2. 아이디가 존재하지 않는다면 
        } else {
            return false;
        }
    }

    // 로그아웃
    public function logout() {
        session_start();
        session_destroy();

        die("<script>self.location.href = '../index.php';</script>");
    }

    // id 기분으로 회원 정보가져오기
    public function getInfo($session_id) {
        $sql = "SELECT * FROM member WHERE id = :id;";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":id", $session_id);
        $stmt -> execute();
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    // idx로 회원 정보 가져오기
    public function getInfoFromIdx($idx) {
        $sql = "SELECT * FROM member WHERE idx = :idx;";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":idx", $idx);
        $stmt -> execute();
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    // 회원 수정
    public function edit($marr) {
        
        $sql = "UPDATE member SET name = :name, email = :email, zipcode = :zipcode, addr1 = :addr1, addr2 = :addr2, photo = :photo";
        $params = [
            ":name" => $marr["name"],
            ":email" => $marr["email"],
            ":zipcode" => $marr["zipcode"],
            ":addr1" => $marr["addr1"],
            ":addr2" => $marr["addr2"],
            ":photo" => $marr["photo"],
        ];

        // 비밀번호 변경 했을 시
        if ($marr["password"] != "") {
            $enc_password = password_hash($marr["password"], PASSWORD_BCRYPT);
            $params[":password"] = $enc_password;

            $sql .= ", password = :password";
        }

        if ($_SESSION["session_level"] == 10 && isset($marr["idx"]) && $marr["idx"] != "") {
            $params[":level"] = $marr["level"];
            $params[":idx"] = $marr["idx"];
            $sql .= ", level = :level";
            $sql .= " WHERE idx = :idx";
        } else {
            $params[":id"] = $marr["id"];
            $sql .= " WHERE id = :id";
        }

        $stmt = $this -> conn -> prepare($sql);
        $stmt -> execute($params);

    }

    // 회원 목록
    public function list($page, $limit, $paramArr) {
        $start = ($page - 1) * $limit;

        $where = "";
        if ($paramArr["sn"] != "" && $paramArr["sf"] != "") {
            switch ($paramArr["sn"]) {
                case 1: $sn_str = "name"; break;
                case 2: $sn_str = "id"; break;
                case 3: $sn_str = "email"; break;
            }
            $where = "WHERE " .$sn_str. "=:sf ";
        }

        $sql = "SELECT idx, id, name, email, DATE_FORMAT(create_at, '%Y-%m-%d %H:%m') AS create_at 
                FROM member " .$where. "
                ORDER BY create_at DESC LIMIT " .$start. "," .$limit.";";
        $stmt = $this -> conn -> prepare($sql);

        if ($where != "") {
            $stmt -> bindParam(":sf", $paramArr["sf"]);
        }

        $stmt -> execute();
        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

    public function total($paramArr) {
        $where = "";
        if ($paramArr["sn"] != "" && $paramArr["sf"] != "") {
            switch ($paramArr["sn"]) {
                case 1: $sn_str = "name"; break;
                case 2: $sn_str = "id"; break;
                case 3: $sn_str = "email"; break;
            }
            $where = "WHERE " .$sn_str. "=:sf ";
        }

        $sql = "SELECT COUNT(*) AS cnt FROM member " .$where. ";";
        $stmt = $this -> conn -> prepare($sql);
        if ($where != "") {
            $stmt -> bindParam(":sf", $paramArr["sf"]);
        }

        $stmt -> execute();
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        return $row['cnt'];
    }

    public function getMemberAll() {

        $sql = "SELECT * FROM member ORDER BY idx ASC";
        $stmt = $this -> conn -> prepare($sql);

        $stmt -> execute();
        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

    public function member_del($f_idx) {
        $sql = "DELETE FROM member WHERE idx = :idx;";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(":idx", $f_idx);
        $stmt -> execute();
    }

    // 프로필 이미지 업로드
    public function profile_upload($f_id, $new_photo, $old_photo = "") {
        // 기존 이미지 삭제
        if ($old_photo != "") {
            unlink(PROFILE_DIR."/".$old_photo);
        }

        $tmp_arr = explode(".", $new_photo["name"]);
        $ext = end($tmp_arr); # 마지막 배열 값 추출
        $f_photo = $f_id . '.' . $ext;

        copy($new_photo["tmp_name"], PROFILE_DIR ."/" . $f_photo);
        return $f_photo;
    }
}
