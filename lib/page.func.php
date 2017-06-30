<?php
/**
 * @param $page
 * @param $totalPage
 * @param null $where
 * @return string
 */
function showPage($page, $totalPage, $where = null)
{
    $where = $where == null ? null : "&" . $where;
    $url = $_SERVER['PHP_SELF'];
    $index = ($page == 1) ? "首页" : "<a href='{$url}?page=1{$where}'>首页</a>";
    $last = ($page == $totalPage) ? "尾页" : "<a href='{$url}?page={$totalPage}{$where}'>尾页</a>";
    $prev = ($page == 1) ? "上一页" : "<a href='{$url}?page=" . ($page - 1) . "{$where}'>«</a>";
    $next = ($page == $totalPage) ? "下一页" : "<a href='{$url}?page=" . ($page + 1) . "{$where}'>»</a>";
    $str = "共{$totalPage}页/当前是第{$page}页";
    $p = '';
    for ($i = 1; $i <= $totalPage; $i++) {
        if ($page == $i) {
            $p .= "[{$i}]";
        } else {
            $p .= "<a href='{$url}?page={$i}'>[{$i}]</a>";
        }
    }
    $pageStr = $str . $index . $prev . $p . $next . $last;
    return $pageStr;
}

function showPage2($page, $totalPage, $where = null)
{
    $where = ($where == null ? null : "&" . $where);
    $url = $_SERVER['PHP_SELF'];
    $index = ($page == 1) ? null : "<li><a href='{$url}?page=1{$where}'>1</a></li>";
    $last = ($page == $totalPage) ? null : "<li><a href='{$url}?page={$totalPage}{$where}'>{$totalPage}</a></li>";
    $prev = ($page == 1) ? "<li><a>«</a></li>" : "<li><a href='{$url}?page=" . ($page - 1) . "{$where}'>«</a></li>";
    $next = ($page == $totalPage) ? "<li><a>»</a></li>" : "<li><a href='{$url}?page=" . ($page + 1) . "{$where}'>»</a></li>";
    $p = '';
    for ($i = 1; $i <= $totalPage; $i++) {
        if ($i == $page) {
            $p .= "<li class='active'><a href='{$url}?page={$i}{$where}'>{$i}</a></li>";
        } elseif ((($i - $page) <= 2 && 0 < ($i - $page)) || (($page - $i) <= 2 && ($page - $i) > 0)) {
            $p .= "<li><a href='{$url}?page={$i}{$where}'>{$i}</a></li>";
        } elseif (($i - $page) == 4 || ($page - $i) == 4) {
            $p .= "<li><a >...</a></li>";
        }
    }
    $pageStr = " <ul class=\"pagination pagination-without-border pull-right m-t-0\">" .   (($page - 1) <= 2 ? null : $index) . $p . (($totalPage - $page) <= 2 ? null : $last)  . "</ul>";
    return $pageStr;
}