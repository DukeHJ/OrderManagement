<?php
/**
 *防盗链
 */
function checkUrl()
{
    if (!isset($_SERVER['HTTP_REFERER'])) {
        header("location:   login.php");
        exit;
    }
    $urlar = parse_url($_SERVER['HTTP_REFERER']);
    //&&   $urlar["host"]   !=   "202.102.110.204"   &&   $urlar["host"]   !=   "http://blog.163.com/fantasy_lxh/"
    if ($_SERVER['HTTP_HOST'] != $urlar["host"] . ":8080" && $urlar["host"] != "localhost") {
        header("location:   login.php");
        exit($_SERVER['HTTP_HOST'] . $urlar["host"]);
    }
}

/**
 *检查是否登录
 */
function checkLogined()
{
    if (!isset($_SESSION['userid'])) {
        header("Location: login.php");
        exit;
    }
}

/**
 * 检查是否具有访问权限
 * @param $p
 */
function checkPurview($p)
{
    if (!$p) {
        exit('您没有访问权限！<a href="index.php">返回</a>');
    }
}

/**
 * 取二维数组中某列的最值
 * @param $arr
 * @param $colx
 * @param $m
 * @return mixed
 */
function get2Dm($arr, $colx, $m)
{
    $temp = array();
    $i = 0;
    foreach ($arr as $val) {
        $temp[$i] = $val[$colx];
        sort($temp);
        $i++;
    }
    if ($m == 'max') {
        return $temp[count($temp) - 1];
    } elseif ($m == 'min') {
        return $temp[0];
    }
}

/**
 * 计算两个日期相差天数
 * @param $day1
 * @param $day2
 * @return float|int
 */
function diffBetweenTwoDays($day1, $day2)
{
    $second1 = strtotime($day1);
    $second2 = strtotime($day2);
    /*  if ($second1 < $second2) {
          $tmp = $second2;
          $second2 = $second1;
          $second1 = $tmp;
      }*/
    return ($second1 - $second2) / 86400;
}


/**
 * 二维数组分组
 * @param $arr
 * @param $key
 * @return array
 */
function array_group_by($arr, $key)
{
    $grouped = [];
    foreach ($arr as $value) {
        $grouped[$value[$key]][] = $value;
    }
    if (func_num_args() > 2) {
        $args = func_get_args();
        foreach ($grouped as $key => $value) {
            $parms = array_merge([$value], array_slice($args, 2, func_num_args()));
            $grouped[$key] = call_user_func_array('array_group_by', $parms);
        }
    }
    return $grouped;
}

/**
 * 取数组中的某一列值
 * @param $arr
 * @param $key
 * @return array
 */
function array_column_unique($arr, $key)
{
    return array_merge(array_unique(array_column($arr, $key)));
}


/**
 * 统计数组不同val值个数
 * @param $arr
 * @return array
 */
function countArr($arr)
{
    $arr2 = array();
    foreach ($arr as $k => $v) {
        foreach ($v as $k2 => $v2) {
            if (!isset($arr2[$k2][$v2])) {
                $arr2[$k2][$v2] = 1;
            } else {
                ++$arr2[$k2][$v2];
            }
        }
    }
    return $arr2;
}

function array_sort($arr, $keys, $type = 'desc')
{
    $key_value = $new_array = array();
    foreach ($arr as $k => $v) {
        $key_value[$k] = $v[$keys];
    }
    if ($type == 'asc') {
        asort($key_value);
    } else {
        arsort($key_value);
    }
    reset($key_value);
    foreach ($key_value as $k => $v) {
        $new_array[$k] = $arr[$k];
    }
    return $new_array;
}