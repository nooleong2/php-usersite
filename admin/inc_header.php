<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ( isset($g_title) && $g_title ) != "" ? $g_title : "YD"; ?></title>

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JAVASCRIPT -->
    <?php
        if ( isset($js_arr) ) {
            foreach ($js_arr as $val) {
                echo "<script src='" . $val . "' defer></script>".PHP_EOL;
            }
        }
    ?>
    
</head>
<body>

    <div class="container">
        <!-- 해더 메뉴 -->
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                <img src="../images/logo.svg" class="me-2" style="width:2rem">
                <span class="fs-4">누렁이 컴퍼니</span>
            </a>
      
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="./index.php" class="nav-link <?= ($menu_code == "index") ? "active" : "" ?>" aria-current="page">Home</a></li>
                <li class="nav-item"><a href="./member.php" class="nav-link <?= ($menu_code == "member") ? "active" : "" ?>">회원관리</a></li>
                <li class="nav-item"><a href="./board.php" class="nav-link <?= ($menu_code == "board") ? "active" : "" ?>">게시판관리</a></li>
                <li class="nav-item"><a href="../process/logout_process.php" class="nav-link">로그아웃</a></li>
            </ul>
        </header>