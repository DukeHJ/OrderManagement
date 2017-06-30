<?php
require_once 'include.php';

$date1 = isset($_REQUEST['date1']) ? $_REQUEST['date1'] : null;

$date3 = isset($_REQUEST['date3']) ? $_REQUEST['date3'] : null;

$client = isset($_REQUEST['client']) ? $_REQUEST['client'] : null;
$contract = isset($_REQUEST['contract']) ? $_REQUEST['contract'] : null;
$ddbh = isset($_REQUEST['ddbh']) ? $_REQUEST['ddbh'] : null;
$filter = '';
$filter2 = '';
if ($date1) {
    $filter .= " AND (left(convert(char(10),订单.订货日期,120),7)='{$date1}')";
}/*else {
    $filter .= " AND (left(convert(char(10),V订单.订货日期,120),7) ='" . date("Y-m", time()) . "') ";
}*/

if ($date3) {
    $filter .= " AND (left(convert(char(10),订单细则.细则交货日期,120),7) ='{$date3}')";
}

if ($client) {
    $filter .= " AND 客户.客户='{$client}'";
}
if ($contract && $contract != "all" && $contract != 'null') {
    $filter .= " AND 订单.业务员=(SELECT 职工编号 FROM 职工信息 WHERE 职工姓名='{$contract}' )  ";
} elseif ($contract && $contract != "all" && $contract == 'null') {
    $filter .= " AND V订单.业务员 IS  NULL ";
}
if ($ddbh) {
    $filter2 = " AND 订单细则.订单编号='{$ddbh}'";
}
$sql = "SELECT 
  客户.客户 ,
  订单细则.订单编号 ,
  订单细则.订单细则号 ,
  订单细则.铸件编号 ,
  订单细则.细则交货日期 AS 交货日期 ,
  订单.订货日期  ,
	(SELECT 职工姓名 FROM 职工信息 WHERE 职工编号=订单.业务员) 业务员
FROM
  (
  SELECT
    计划生产.订单细则号 ,
    SUM ( 计划数 ) AS 计划数 ,
    MAX ( 计划生产.制表日期 ) AS 投产日期 
  FROM
    计划生产 WITH ( nolock )
  WHERE
    ( 计划生产.工序 IN ( '造型' , '蜡型' ) )
  GROUP BY
    计划生产.订单细则号
) V投产
  LEFT OUTER JOIN (
  SELECT
    SUM ( A.料废数 ) AS 料废数 ,
    A.订单细则号
  FROM
    (
    SELECT
      SUM ( 质检批量.料废数 ) AS 料废数 ,
      质检批量.订单细则号
    FROM
      质检批量 WITH ( nolock )
    GROUP BY
      质检批量.订单细则号   
    UNION ALL   
    SELECT
      SUM ( 计划生产.料废数 ) AS 料废数 ,
      计划生产.订单细则号
    FROM
      计划生产 WITH ( nolock )
    GROUP BY
      计划生产.订单细则号 
  ) A
  GROUP BY
    A.订单细则号
) 料废 ON  V投产.订单细则号=料废.订单细则号 LEFT  outer  JOIN (
  SELECT
    SUM ( 合格数 ) AS 入库数量 ,
    MAX ( 制表日期 ) AS 入库日期 ,
    订单细则号
  FROM
    质检批量 WITH ( nolock )
  WHERE
    工序='入库'
  GROUP BY
    订单细则号
) 入库 ON  V投产.订单细则号=入库.订单细则号
  RIGHT OUTER JOIN 订单细则 WITH ( nolock ) ON 料废.订单细则号 = 订单细则.订单细则号
  AND V投产.订单细则号 COLLATE Chinese_PRC_CI_AS = 订单细则.订单细则号
  LEFT OUTER JOIN (
  SELECT
    细则号 ,
    SUM ( 计划耗时 ) AS 计划总耗时
  FROM
    铸件作业路线 WITH ( nolock )
  GROUP BY
    细则号
) V投产时间 ON 订单细则.订单细则号 = V投产时间.细则号 COLLATE Chinese_PRC_CI_AS
  LEFT OUTER JOIN 订单 WITH ( nolock ) ON 订单细则.订单编号 = 订单.订单编号
  LEFT OUTER JOIN 计划投产 WITH ( nolock ) ON 计划投产.细则号=订单细则.订单细则号
  LEFT OUTER JOIN 客户 WITH ( nolock ) ON 客户.客户=订单.客户
WHERE
  订单细则.处置='1'
  {$filter} 
 ";
$pageSize = 8;
$totalRows = getResultNum($sql . $filter2);
$totalPage = ceil($totalRows / $pageSize);

$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
if ($page < 1 || $page == null || !is_numeric($page)) {
    $page = 1;
}
if ($page >= $totalPage) $page = $totalPage;

$query = "SELECT   * FROM (
SELECT ROW_NUMBER() OVER(ORDER BY tmp.订单细则号) 行号,* FROM(
SELECT
  部门.厂区 ,
  客户.客户 ,
  订单.合同号 ,
  订单细则.订单编号 ,
  订单细则.订单细则号 ,
  订单细则.铸件编号 ,
  铸件清单.铸件名称 ,
  铸件清单.材质 ,
  订单细则.客户标识 AS 商标 ,
  订单细则.细则交货日期 AS 交货日期 ,
  订单细则.投产时间 ,
  V投产.计划数 AS 计划数量 ,
  V投产.计划数 * 订单细则.细则重量 AS 计划重量 ,
  V投产.投产日期 ,
  DATEADD ( HOUR , V投产时间.计划总耗时 , V投产.投产日期 ) AS 要求入库日期 ,
  入库.入库数量 AS 入库数量 ,
  入库.入库数量 * 订单细则.细则重量 AS 入库重量 ,
  入库.入库日期 AS 实际入库日期 ,
  CASE WHEN 入库.入库日期 > DATEADD ( HOUR , V投产时间.计划总耗时 , V投产.投产日期 ) THEN  '是' ELSE '否' END  是否拖期,
  料废.料废数 AS 报废数量 ,
  料废.料废数 * 订单细则.细则重量 AS 报废重量 ,
  铸件清单.图号 ,
  铸件清单.客户描述 ,
  铸件清单.零件图号 ,
  铸件清单.毛坯图号 ,
  (SELECT 部门名称 FROM 部门 WHERE 部门编号=订单细则.原生产车间) 原生产车间 ,
  订单.下单日期 ,
	(SELECT 职工姓名 FROM 职工信息 WHERE 职工编号=订单.业务员) 业务员,
  订单.内部合同号 ,
  订单.订货日期 ,
  订单细则.生产方式 ,
  订单细则.细则重量 ,
  铸件清单.参考重量 ,
  铸件清单.加工图号 ,
  订单细则.客户行号
FROM
  (
  SELECT
    计划生产.订单细则号 ,
    SUM ( 计划数 ) AS 计划数 ,
    MAX ( 计划生产.制表日期 ) AS 投产日期 
  FROM
    计划生产 WITH ( nolock )
  WHERE
    ( 计划生产.工序 IN ( '造型' , '蜡型' ) )
  GROUP BY
    计划生产.订单细则号
) V投产
  LEFT OUTER JOIN (
  SELECT
    SUM ( A.料废数 ) AS 料废数 ,
    A.订单细则号
  FROM
    (
    SELECT
      SUM ( 质检批量.料废数 ) AS 料废数 ,
      质检批量.订单细则号
    FROM
      质检批量 WITH ( nolock )
    GROUP BY
      质检批量.订单细则号   
    UNION ALL   
    SELECT
      SUM ( 计划生产.料废数 ) AS 料废数 ,
      计划生产.订单细则号
    FROM
      计划生产 WITH ( nolock )
    GROUP BY
      计划生产.订单细则号 
  ) A
  GROUP BY
    A.订单细则号
) 料废 ON  V投产.订单细则号=料废.订单细则号 LEFT  outer  JOIN (
  SELECT
    SUM ( 合格数 ) AS 入库数量 ,
    MAX ( 制表日期 ) AS 入库日期 ,
    订单细则号
  FROM
    质检批量 WITH ( nolock )
  WHERE
    工序='入库'
  GROUP BY
    订单细则号
) 入库 ON  V投产.订单细则号=入库.订单细则号
  RIGHT OUTER JOIN 订单细则 WITH ( nolock ) ON 料废.订单细则号 = 订单细则.订单细则号
  AND V投产.订单细则号 COLLATE Chinese_PRC_CI_AS = 订单细则.订单细则号
  LEFT OUTER JOIN (
  SELECT
    细则号 ,
    SUM ( 计划耗时 ) AS 计划总耗时
  FROM
    铸件作业路线 WITH ( nolock )
  GROUP BY
    细则号
) V投产时间 ON 订单细则.订单细则号 = V投产时间.细则号 COLLATE Chinese_PRC_CI_AS
  LEFT OUTER JOIN 铸件清单 WITH ( nolock ) ON 订单细则.铸件编号 = 铸件清单.铸件编号
  LEFT OUTER JOIN 订单 WITH ( nolock ) ON 订单细则.订单编号 = 订单.订单编号
  LEFT OUTER JOIN 计划投产 WITH ( nolock ) ON 计划投产.细则号=订单细则.订单细则号
  LEFT OUTER JOIN 部门 WITH ( nolock ) ON 计划投产.投产部门 = 部门.部门编号
  LEFT OUTER JOIN 客户 WITH ( nolock ) ON 客户.客户=订单.客户
WHERE
  订单细则.处置='1' {$filter} {$filter2}
) tmp
) tmp2 
WHERE 行号>=" . (($page - 1) * $pageSize) . " AND 行号<=" . ($page * $pageSize) . "
 ";

$res = fetchAll($query);
?>
<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <title>华铸ERP订单管理系统 | 订单跟踪</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>

    <link href="vendor/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet"/>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="vendor/css/animate.min.css" rel="stylesheet"/>
    <link href="vendor/css/style.min.css" rel="stylesheet"/>
    <link href="vendor/css/style-responsive.min.css" rel="stylesheet"/>
    <link href="vendor/css/theme/default.css" rel="stylesheet" id="theme"/>
    <link href="vendor/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
    <link href="vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/order_track.css">

    <script src="vendor/pace/pace.min.js"></script>
    <script src="vendor/jquery/jquery-1.9.1.min.js"></script>
</head>
<body>
<?php include_once 'template/pageloader.php'; ?>

<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
    <?php include_once 'template/header.php'; ?>
    <?php include_once 'template/sidebar.php'; ?>

    <div id="content" class="content">
        <ol class="breadcrumb pull-right">
            <li><a href="javascript:void(0);">首页</a></li>
            <li><a href="javascript:void(0);">订单跟踪</a></li>
            <li class="active">订单全程跟踪</li>
        </ol>
        <h1 class="page-header">订单全程跟踪</h1>

        <div class="row">
            <div class="col-md-5">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h5 class="panel-title">搜索</h5>
                    </div>
                    <div class="panel-body">
                        <form id="form" action="<?php print $_SERVER['PHP_SELF'] ?>">
                            <table class="search_table ">
                                <tr>
                                    <td class="col-md-3 text-center"><label for="date1">订货日期：</label>
                                    </td>
                                    <td class="col-md-9">
                                        <input type="datetime" name="date1" id="date1" style="width:220px;">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center"><label for="date3">交货日期：</label>
                                    </td>
                                    <td>
                                        <input type="datetime" name="date3" id="date3" style="width:220px;">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center"><label for="contract">业&nbsp;&nbsp;务&nbsp;&nbsp;员：</label>
                                    </td>
                                    <td>
                                        <select name="contract" id="contract" id="contract" class="selectpicker"
                                                data-size="6"
                                                data-live-search="true"
                                                data-style="btn-white" form="form">
                                            <option value="all"></option>
                                            <option value="huazhu">huazhu</option>
                                            <option value="null">(null)</option>
                                            <?php
                                            $sqlgdy = "SELECT 系统角色.职工号 , 职工信息.职工姓名 FROM 系统角色 LEFT OUTER JOIN 职工信息 ON 系统角色.职工号 = 职工信息.职工编号 WHERE 系统角色.系统角色='跟单员'";
                                            $gdy = fetchAll($sqlgdy);
                                            foreach ($gdy as $k1 => $v1) {
                                                echo "<option value=\"" . trim($v1['职工姓名']) . "\">" . trim($v1['职工姓名']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center"><label for="client">客&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;户：</label>
                                    </td>
                                    <td>
                                        <select name="client" id="client" class="selectpicker" data-size="6"
                                                data-live-search="true"
                                                data-style="btn-white" form="form">
                                            <option value=""></option>
                                            <?php
                                            $sqlkh = "SELECT 客户 FROM 客户";
                                            $khs = fetchAll($sqlkh);
                                            foreach ($khs as $k1 => $v1) {
                                                foreach ($v1 as $k2 => $v2) {
                                                    echo "<option value=\"" . trim($v2) . "\">" . trim($v2) . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="hidden" name="page" value="<?php echo $page; ?>"></td>
                                    <td>
                                        <button type="submit" class="btn btn-sm btn-inverse"
                                                aria-label="Left Align">
                                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-inverse" aria-label="Left Align"
                                                onclick="$('#date1').val('');$('#date3').val('');$('#client').val('');$('#contract').val('');$('.filter-option').html('');">
                                            <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="res_div">
                    <?php if ($res): ?>
                        <div class="res_select">
                            <label for="ddbh">订单编号</label>
                            <select name="ddbh" id="ddbh" form="form">
                                <option value=""></option>
                                <?php
                                $ddbhs = array_column_unique(fetchAll($sql), '订单编号');
                                foreach ($ddbhs as $key => $val) {
                                    echo "<option value='{$val}'>{$val}</option>";
                                }
                                ?>
                            </select>
                            <hr style="border-bottom:solid 0;margin: 0.8rem;">
                        </div>
                    <?php endif; ?>

                    <?php if ($res): ?>
                        <?php $i = 0;
                        foreach ($res as $key => $val): ?>
                            <div <?php if ($i++ % 2 == 1) {
                                echo "style='background-color:#e8ecf1;'";
                            } ?> class="info_div">
                                细则号：<span class="ddxzh" style="color: #0e90d2;"><?php echo $val['订单细则号']; ?></span>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="tool_div">
                                    <a href="javascript:void(0);" style="text-decoration: none;"
                                       class="track_xz_overview">跟踪细则一览</a><br>
                                    <a href="javascript:void(0);" style="text-decoration: none;" class="track_xz_pro">跟踪细则进度</a><br>
                                    <a href="javascript:void(0);" style="text-decoration: none;" class="track_xz_pro_r">跟踪细则进度比</a><br>
                                    <hr style="padding-bottom: 0;margin: 0.4rem;">
                                    <a href="javascript:void(0);" style="text-decoration: none;"
                                       class="track_single_pro">跟踪单件过程</a><br>
                                </div>
                                订单编号：<span class="ddbh" style="color: #0e90d2;"><?php echo $val['订单编号']; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="tool_div2">
                                    <a href="javascript:void(0);" style="text-decoration: none;" class="track_xz_pro">跟踪细则进度</a><br>
                                    <a href="javascript:void(0);" style="text-decoration: none;" class="track_xz_pro_r">跟踪细则进度比</a><br>
                                </div>
                                <br class="visible-xxs">
                                客户：<?php echo $val['客户']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                业务员：<?php echo $val['业务员'] ? $val['业务员'] : "\\"; ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                <br>
                                订货日期：<?php echo date('Y-m-d', strtotime($val['订货日期'])); ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                <span
                                    style="color:  #00acac;">交货日期：<?php echo date('Y-m-d', strtotime($val['交货日期'])); ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                <br class="visible-xxs">
                                铸件名称：<?php echo $val['铸件名称']; ?>
                                （&nbsp;<?php echo $val['铸件编号']; ?>&nbsp;&nbsp;&nbsp;<?php echo $val['材质']; ?>&nbsp;）
                                <br>
                                <div style="font-weight: 500;">
                                    计划数：<?php echo number_format($val['计划数量']); ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                    入库数：<?php echo number_format($val['入库数量']); ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                    报废数：<?php echo number_format($val['报废数量']); ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                    拖期数：<?php echo number_format($val['计划数量'] - ($val['入库数量'] ? $val['入库数量'] : 0) - ($val['报废数量'] ? $val['报废数量'] : 0)); ?>
                                    <br>
                                    拖期：<?php if ($val['是否拖期'] == '是') {
                                        echo "<span style='color: red;'>{$val['是否拖期']}</span>";
                                    } else {
                                        echo "<span style='color: #00acac;'>{$val['是否拖期']}</span>";
                                    }; ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                    投产：<?php if ($val['是否拖期'] == '是') {
                                        echo "<span style='color: red;'>" . ($val['投产日期'] ? date('Y-m-d', strtotime($val['投产日期'])) : '(null)') . "</span>";
                                    } else {
                                        echo "<span style='color: #00acac;'>" . ($val['投产日期'] ? date('Y-m-d', strtotime($val['投产日期'])) : '(null)') . "</span>";
                                    } ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                    要求入库：<?php if ($val['是否拖期'] == '是') {
                                        echo "<span style='color: red;'>" . ($val['要求入库日期'] ? date('Y-m-d', strtotime($val['要求入库日期'])) : '(null)') . "</span>";
                                    } else {
                                        echo "<span style='color: #00acac;'>" . ($val['要求入库日期'] ? date('Y-m-d', strtotime($val['要求入库日期'])) : '(null)') . "</span>";
                                    } ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                    实际入库：<?php if ($val['是否拖期'] == '是') {
                                        echo "<span style='color: red;'>" . ($val['实际入库日期'] ? date('Y-m-d', strtotime($val['实际入库日期'])) : '(null)') . "</span>";
                                    } else {
                                        echo "<span style='color: #00acac;'>" . ($val['实际入库日期'] ? date('Y-m-d', strtotime($val['实际入库日期'])) : '(null)') . "</span>";
                                    } ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <br>
                                    计划重：<?php echo number_format($val['计划重量']); ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                    入库重：<?php echo number_format($val['入库重量']); ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                    报废重：<?php echo number_format($val['报废重量']); ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                    拖期重：<?php echo number_format(($val['计划数量'] - ($val['入库数量'] ? $val['入库数量'] : 0) - ($val['报废数量'] ? $val['报废数量'] : 0)) * $val['细则重量']); ?>
                                </div>
                            </div>
                            <br>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if (!$res) {
                        echo "<p>未查询到满足条件的记录！</p>";
                    } ?>
                </div>
                <div>
                    <?php
                    $where = "date1={$date1}&date3={$date3}&client={$client}&ddbh={$ddbh}&contract={$contract}";
                    echo showPage2($page, $totalPage, $where); ?>
                </div>
                <div id="tmp" style="background-color: white;display: none;"></div>
            </div>
        </div>
    </div>

    <a href="javascript:void(0);" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade"
       data-click="scroll-top"><i
            class="fa fa-angle-up"></i></a>
</div>

<script src="vendor/jquery/jquery-migrate-1.1.0.min.js"></script>
<script src="vendor/jquery-ui/ui/minified/jquery-ui.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--[if lt IE 9]>
<script src="vendor/crossbrowserjs/html5shiv.js"></script>
<script src="vendor/crossbrowserjs/respond.min.js"></script>
<script src="vendor/crossbrowserjs/excanvas.min.js"></script>
<![endif]-->

<script src="vendor/slimscroll/jquery.slimscroll.min.js"></script>
<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="vendor/js/apps.min.js"></script>

<script src="vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script src="vendor/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="js/alert_rewrite.js"></script>
<script src="js/tool_library.js"></script>
<script>
    $(document).ready(function () {
        App.init();
    });
    $("#订单跟踪,#订单全程跟踪").addClass("active");
    $("#index").removeClass("active");
</script>
<script>
    <?php if ($date1 && $date1) {
        echo " $(\"#date1\").val('{$date1}');";
    }/*else{
        echo " $(\"#date1\").val('".date('Y-m',time())."');";
    }*/;

    if ($date3 && $date3) {
        echo " $(\"#date3\").val('{$date3}');";
    };

    if ($client && $client) {
        echo " $(\"#client\").val('{$client}');";
    };
    if ($contract && $contract) {
        echo " $(\"#contract\").val('{$contract}');";
    };
    if ($ddbh && $ddbh) {
        echo " $(\"#ddbh\").val('{$ddbh}');";
    };
    ?>
</script>
<script>
    $(document).ready(function () {
        $('#date1,#date3').datetimepicker({
            language: 'ch',
            format: 'yyyy-mm',
            autoclose: true,
            startView: 'year',
            minView: 'year',
            maxView: 'decade'
        });
    });
</script>
<script>
    $(document).ready(function () {
        $("#ddbh").change(function () {
            $("form").submit();
        });
    });
</script>
</body>
</html>
