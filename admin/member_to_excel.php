<?php
include "../config/db_config.php";
include "../class/login.php";
include "./inc_common.php";

$mem = new Login($conn);

$rows = $mem -> getMemberAll();

/**
 * EXCEL로 받는 방법
 * 1. header() 함수 사용
 */

header("Content-Type: application/vnd.vs-excel");
header("Content-Disposition: attachement; filename=member.xls");
header("Content-Description:PHP8 Generated Data");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
        <tr>
            <td colspan="6" align="center">회원목록</td>
        </tr>
    </table>
    <table border="1">
        <tr>
            <th>아이디</th>
            <th>이름</th>
            <th>이메일</th>
            <th>우편번호</th>
            <th>주소</th>
            <th>등록일시</th>
        </tr>
        <?php
            foreach ($rows as $row) {
                echo
                "
                    <tr>
                        <td>" .$row["id"]. "</td>
                        <td>" .$row["name"]. "</td>
                        <td>" .$row["email"]. "</td>
                        <td>" .$row["zipcode"]. "</td>
                        <td>" .$row["addr1"]. "</td>
                        <td>" .$row["create_at"]. "</td>
                    </td>
                ";
            }
        ?>
    </table>
</body>
</html>
