<?php

    /**
     * 페이지 네이션 처리
     * 다중 게시판 이용시 $param 변수 추가
     * a태그 뒤에 ?code=$code&page=$page 방식으로 처리 해줘야 code에 해당 게시판 코드가 들어가기 떄문에 해당 게시판 사용
     */
    function my_pagination($total, $limit, $page_limit, $page, $param) {
        
        $total_page = ceil($total / $limit); # 소수점 발생할 수 있기 때문에 올림 함수 사용 (총 페이지 수)

        $start_page = ((floor(($page - 1) / $page_limit)) * $page_limit) + 1; # 버림 함수를 이용해서 1 ~ 5 페이지는 0 6 ~ 10 페이지는 1
        $end_page = $start_page + $page_limit - 1;
        if ($end_page > $total_page) {
            $end_page = $total_page;
        }

        $rs_str = '<nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">';
        
        $rs_str .= '<li class="page-item">
                        <a class="page-link" href="'.$_SERVER["PHP_SELF"].'?param='.$param.'&page=1">First</a>
                    </li>';

        // 전 페이지
        $prev_page = $start_page - 1;
        if ($prev_page > 1) {
            $rs_str .= '<li class="page-item">
                            <a class="page-link" href="'.$_SERVER["PHP_SELF"].'?param='.$param.'&page='.$prev_page.'">Prev</a>
                        </li>';
        }

        // start ~ end 페이지
        for ($i = $start_page; $i <= $end_page; $i++) {
            if ($page == $i) {
                $rs_str .= '<li class="page-item disabled"><a class="page-link" href="'.$_SERVER["PHP_SELF"].'?param='.$param.'&page='.$i.'">'.$i.'</a></li>';
            } else {
                $rs_str .= '<li class="page-item"><a class="page-link" href="'.$_SERVER["PHP_SELF"].'?param='.$param.'&page='.$i.'">'.$i.'</a></li>';
            }
            
        }

        // 다음 페이지
        $next_page = $end_page + 1;
        if ($next_page <= $total_page) {
            $rs_str .= '<li class="page-item">
                            <a class="page-link" href="'.$_SERVER["PHP_SELF"].'?param='.$param.'&page='.$next_page.'">Next</a>
                        </li>';
        }

        if ($page < $total_page) {
            $rs_str .= '<li class="page-item">
                            <a class="page-link" href="'.$_SERVER["PHP_SELF"].'?param='.$param.'&page='.$total_page.'">Last</a>
                        </li>';
        }
        
        return $rs_str;
    }

    
