<?php
require_once 'include.php';

$date1 = isset($_REQUEST['date1']) ? $_REQUEST['date1'] : null;

$date3 = isset($_REQUEST['date3']) ? $_REQUEST['date3'] : null;

$client = isset($_REQUEST['client']) ? $_REQUEST['client'] : null;
$contract = isset($_REQUEST['contract']) ? $_REQUEST['contract'] : null;
$workshop = isset($_REQUEST['workshop']) ? $_REQUEST['workshop'] : null;
$ddbh = isset($_REQUEST['ddbh']) ? $_REQUEST['ddbh'] : null;
$filter = '';
$filter2 = '';
if ($date1) {
    $filter .= " AND (convert(char(7),V_订单细则简略视图.订货日期,120) ='{$date1}')";
} else {
    $filter .= " AND (convert(char(7),V_订单细则简略视图.订货日期,120) ='" . date("Y-m", time()) . "') ";
}

if ($date3) {
    $filter .= " AND (convert(char(7),V_订单细则简略视图.细则交货日期,120) ='{$date3}')";
}

if ($client) {
    $filter .= " AND V_订单细则简略视图.客户='{$client}'";
}
if ($contract && $contract != 'all') {
    $filter .= " AND V_订单细则简略视图.业务员=( SELECT 职工编号 FROM 职工信息 WHERE 职工姓名='{$contract}') ";
}
if ($workshop) {
    $filter .= " AND V投产.投产部门=( SELECT 部门编号 FROM 部门 WHERE 部门名称='{$workshop}') ";
}
if ($ddbh) {
    $filter2 = " AND 订单细则.订单编号='{$ddbh}'";
}
$sql = "SELECT
  V_订单细则简略视图.订单细则号 , V_订单细则简略视图.客户 , 
   V_订单细则简略视图.订货日期 , V_订单细则简略视图.细则交货日期 , 
  (SELECT 职工姓名 FROM 职工信息 WHERE 职工编号=订单.跟单员) 跟单员,       
  (SELECT 部门名称 FROM 部门 WHERE 部门编号=V投产.投产部门) AS 投产部门 
FROM
  V_订单细则_欠货
  LEFT OUTER JOIN V_订单细则简略视图 WITH ( nolock ) ON V_订单细则简略视图.订单细则号 = V_订单细则_欠货.细则号
  LEFT OUTER JOIN 订单 WITH ( nolock ) ON V_订单细则简略视图.订单编号=订单.订单编号
  LEFT OUTER JOIN (
  SELECT
    细则号 ,
    MAX ( 投产部门 ) AS 投产部门
  FROM
    计划投产
  GROUP BY
    细则号
) V投产 ON V投产.细则号 = V_订单细则简略视图.订单细则号
WHERE 1=1 {$filter}   ";
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
  V_订单细则简略视图.订单细则号 ,  V_订单细则简略视图.合同号 ,  V_订单细则简略视图.客户 ,  V_订单细则简略视图.铸件编号 ,  V_订单细则简略视图.铸件名称 ,
  V_订单细则简略视图.订货数量 ,  V_订单细则简略视图.订货日期 ,  V_订单细则简略视图.图号 ,  V_订单细则简略视图.客户简称 ,  V_订单细则简略视图.材质 ,
  V_订单细则简略视图.客户描述 ,  V_订单细则简略视图.客户类别 ,  V_订单细则简略视图.细则交货日期 ,  V_订单细则简略视图.类别 ,  V_订单细则简略视图.客户行号 ,
  V_订单细则_欠货.减任务 已发货数 ,
  V_订单细则_欠货.剩余任务 需发货数 ,
  (SELECT 职工姓名 FROM 职工信息 WHERE 职工编号=订单.跟单员) 跟单员,  职工信息.部门编号 ,  订单.内部合同号 ,  铸件清单.加工图号 ,  铸件清单.毛坯图号 ,
  铸件清单.参考重量 AS 毛坯单重 ,
  铸件清单.加工参考重量 AS 成品单重 ,
  铸件清单.零件图号 ,  V_订单细则简略视图.单件价格 ,  铸件清单.备注 ,  V_订单细则_欠货.加任务 ,  铸件清单.客户物料号 ,
  (SELECT 部门名称 FROM 部门 WHERE 部门编号=V投产.投产部门) AS 投产部门 ,
  订单细则.备注 AS 细则备注,
   V_订单细则_欠货. 已转运数 ,
  CASE WHEN 订单细则.金工=1 THEN (加任务-ISNULL(已转运数,0)) ELSE 0 END   AS 还需转运数
FROM
  V_订单细则_欠货
  LEFT OUTER JOIN V_订单细则简略视图 WITH ( nolock ) ON V_订单细则简略视图.订单细则号 = V_订单细则_欠货.细则号
  LEFT OUTER JOIN 订单细则 WITH ( nolock ) ON 订单细则.订单细则号=V_订单细则简略视图.订单细则号
  LEFT OUTER JOIN 订单 WITH ( nolock ) ON V_订单细则简略视图.订单编号=订单.订单编号
  LEFT OUTER JOIN 职工信息 WITH ( nolock ) ON 职工信息.职工编号 = 订单.跟单员
  LEFT OUTER JOIN 铸件清单 WITH ( nolock ) ON 铸件清单.铸件编号 = V_订单细则简略视图.铸件编号
  LEFT OUTER JOIN (

  SELECT
    细则号 ,
    MAX ( 投产部门 ) AS 投产部门
  FROM
    计划投产
  GROUP BY
    细则号

) V投产 ON V投产.细则号 = V_订单细则简略视图.订单细则号
WHERE 1=1 {$filter} {$filter2}
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
            <li class="active">订单实时欠货</li>
        </ol>
        <h1 class="page-header">订单实时欠货</h1>

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
                                    <td class="text-center"><label for="contract">跟&nbsp;&nbsp;单&nbsp;&nbsp;员：</label>
                                    </td>
                                    <td>
                                        <select name="contract" id="contract" id="contract" class="selectpicker"
                                                data-size="6"
                                                data-live-search="true"
                                                data-style="btn-white" form="form">
                                            <option value="all"></option>
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
                                                data-live-search="true" data-style="btn-white" form="form">
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
                                <!--<tr>
                                    <td class="text-center"><label for="workshop">投产部门：</label>
                                    </td>
                                    <td>
                                        <select name="workshop" id="workshop" class="selectpicker" data-size="6"
                                                data-live-search="true" data-style="btn-white" form="form">
                                            <option value=""></option>
                                            <?php
                                /*                                            $sqlws = "SELECT 部门.部门编号 ,  部门.部门名称 ,  部门.备注 ,  部门.厂区 ,  部门.车间 , 部门.车间生产方式 ,  部门.车间代号 FROM 部门 WHERE 部门.车间='1'";
                                                                            $wss = fetchAll($sqlws);
                                                                            foreach ($wss as $k1 => $v1) {
                                                                                echo "<option value=\"" . trim($v1['部门名称']) . "\">" . trim($v1['部门名称']) . "</option>";
                                                                            }
                                                                            */ ?>
                                        </select>
                                    </td>
                                </tr>-->
                                <tr>
                                    <td><input type="hidden" name="page" value="<?php echo $page; ?>"></td>
                                    <td>
                                        <button type="submit" class="btn btn-sm btn-inverse"
                                                aria-label="Left Align">
                                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-inverse" aria-label="Left Align"
                                                onclick="$('#date1').val('');$('#date3').val('');$('#client').val('');$('#contract').val('');$('#workshop').val('');$('.filter-option').html('');">
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
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <br class="visible-xxs">
                                客户：<?php echo $val['客户']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                跟单员：<?php echo $val['跟单员']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                <br>
                                订货日期：<?php echo date('Y-m-d', strtotime($val['订货日期'])); ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                <span
                                    style="color:  #00acac;">交货日期：<?php echo date('Y-m-d', strtotime($val['细则交货日期'])); ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                <br class="visible-xxs">
                                铸件名称：<?php echo $val['铸件名称']; ?>
                                （&nbsp;<?php echo $val['铸件编号']; ?>&nbsp;&nbsp;&nbsp;<?php echo $val['材质']; ?>&nbsp;）
                                <br>
                                <div style="font-weight: 600;">
                                    订货数：<?php echo $val['订货数量']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span style="color: #00acac;">总任务：<?php echo $val['加任务'] ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <br class="visible-xxs">
                                    还需转运：<?php echo $val['还需转运数'] ? $val['还需转运数'] : 0; ?>
                                    （<?php echo $val['已转运数'] ? $val['已转运数'] : 0; ?>）&nbsp;&nbsp;&nbsp;
                                    <span
                                        style="color:red;">需发货：<?php echo $val['需发货数'] ? $val['需发货数'] : 0; ?></span>（<?php echo $val['已发货数'] ? $val['已发货数'] : 0; ?>
                                    ）
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
    $("#订单跟踪,#订单实时欠货").addClass("active");
    $("#index").removeClass("active");
</script>
<script>
    <?php if ($date1 && $date1) {
        echo " $(\"#date1\").val('{$date1}');";
    } else {
        echo " $(\"#date1\").val('" . date('Y-m', time()) . "');";
    };

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
