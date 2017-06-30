<?php
require_once 'include.php';

$date1 = isset($_REQUEST['date1']) ? $_REQUEST['date1'] : null;

$date3 = isset($_REQUEST['date3']) ? $_REQUEST['date3'] : null;

$client = isset($_REQUEST['client']) ? $_REQUEST['client'] : null;
$contract = isset($_REQUEST['contract']) ? $_REQUEST['contract'] : null;
$ddbh = isset($_REQUEST['ddbh']) ? $_REQUEST['ddbh'] : null;
$filter='';
$filter2='';
if ($date1) {
    $filter .= " AND (left(convert(char(10),V_订单细则简略视图.订货日期,120),7)='{$date1}')";
}

if ($date3) {
    $filter .= " AND (left(convert(char(10),V_订单细则简略视图.细则交货日期,120),7) ='{$date3}')";
}else {
    $filter .= " AND (left(convert(char(10),V_订单细则简略视图.细则交货日期,120),7) ='" . date("Y-m", time()) . "') ";
}

if ($client) {
    $filter .= " AND V_订单细则简略视图.客户='{$client}'";
}
if ($contract && $contract != "all" && $contract != 'null') {
    $filter .= " AND V_订单细则简略视图.业务员=( SELECT 职工编号 FROM 职工信息 WHERE 职工姓名='{$contract}') ";
} elseif ($contract && $contract != "all" && $contract == 'null') {
    $filter .= " AND V_订单细则简略视图.业务员 IS  NULL ";
}
if ($ddbh) {
    $filter2  = " AND  V_订单细则简略视图.订单编号='{$ddbh}'";
}
$sql = "SELECT 铸件单件.细则号,V_订单细则简略视图.订单编号 FROM 
(SELECT  造型蜡型编号, 等待作业, 终止, SUM(1) AS 件数, 细则号
FROM 铸件单件 AS 铸件单件_1 with (nolock)
GROUP BY 造型蜡型编号, 等待作业, 终止, 细则号
) AS 铸件单件 
LEFT OUTER JOIN
V_订单细则简略视图 with (nolock) ON V_订单细则简略视图.订单细则号 = 铸件单件.细则号
WHERE 1=1 {$filter}   ";
$pageSize = 8;
$totalRows = getResultNum($sql.$filter2);
$totalPage = ceil($totalRows / $pageSize);

$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
if ($page < 1 || $page == null || !is_numeric($page)) {
    $page = 1;
}
if ($page >= $totalPage) $page = $totalPage;

$query = "SELECT   * FROM (
SELECT ROW_NUMBER() OVER(ORDER BY tmp.订单编号) 行号,* FROM(
SELECT   铸件单件.造型蜡型编号, 铸件单件.等待作业, 铸件单件.终止, 铸件单件.件数, 铸件单件.细则号, 
                V_订单细则简略视图.订单编号, V_订单细则简略视图.客户, V_订单细则简略视图.客户类别, 
                V_订单细则简略视图.铸件编号, V_订单细则简略视图.类别, V_订单细则简略视图.铸件名称, 
                (SELECT 职工姓名 FROM 职工信息 WHERE 职工编号=V_订单细则简略视图.业务员) 业务员, V_订单细则简略视图.投产, V_订单细则简略视图.细则交货日期, 
                V_订单细则简略视图.订货日期, V_订单细则简略视图.材质, V_订单细则简略视图.合同号, 
                V_订单细则简略视图.新品
FROM      (SELECT   造型蜡型编号, 等待作业, 终止, SUM(1) AS 件数, 细则号
                 FROM      铸件单件 AS 铸件单件_1 with (nolock)
                 GROUP BY 造型蜡型编号, 等待作业, 终止, 细则号) AS 铸件单件 
LEFT OUTER JOIN
                V_订单细则简略视图 with (nolock) ON V_订单细则简略视图.订单细则号 = 铸件单件.细则号
             WHERE 1=1 {$filter} {$filter2}   
) tmp
) tmp2 
WHERE 行号>=" . (($page - 1) * $pageSize) . " AND 行号<=" . ($page * $pageSize)."
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
            <li class="active">施工单跟踪</li>
        </ol>
        <h1 class="page-header">施工单跟踪</h1>

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
                    <?php endif;?>

                    <?php if ($res): ?>
                        <?php $i = 0;
                        foreach ($res as $key => $val): ?>
                            <div <?php if ($i++ % 2 == 1) {
                                echo "style='background-color:#e8ecf1;'";
                            } ?> class="info_div">
                                细则号：<span  class="ddxzh" style="color: #0e90d2;"><?php echo $val['细则号']; ?></span>
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
                                订单编号：<span  class="ddbh" style="color: #0e90d2;"><?php echo $val['订单编号']; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="tool_div2">
                                    <a href="javascript:void(0);" style="text-decoration: none;" class="track_xz_pro">跟踪细则进度</a><br>
                                    <a href="javascript:void(0);" style="text-decoration: none;" class="track_xz_pro_r">跟踪细则进度比</a><br>
                                </div>

                                <br class="visible-xxs">
                                <?php echo $val['造型蜡型编号'] ? $val['造型蜡型编号'] : '(null)'; ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="red">等待：<?php echo $val['等待作业'] ? $val['等待作业'] : '\\'; ?>
                                    (<?php echo $val['件数']; ?>)</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                <?php if ($val['终止'] == "Y") {
                                    echo " 终止：<span class='red'>" . $val['终止'] . "</span>&nbsp;&nbsp;&nbsp;&nbsp;";
                                } elseif ($val['终止'] == "N") {
                                    echo " 终止：<span>" . $val['终止'] . "</span>&nbsp;&nbsp;&nbsp;&nbsp;";
                                }
                                ?>

                                <br>
                                铸件名称：<?php echo $val['铸件名称']; ?>&nbsp;&nbsp;&nbsp;
                                （&nbsp;<?php echo $val['铸件编号']; ?>&nbsp;&nbsp;&nbsp;<?php echo $val['材质']; ?>&nbsp;）
                                <br>
                                客户：<?php echo $val['客户']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                业务员：<?php echo $val['业务员'] ? $val['业务员'] : '(null)'; ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                <br class="visible-xxs">
                                订货日期：<?php echo date('Y-m-d', strtotime($val['订货日期'])); ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="red">交货日期：<?php echo date('Y-m-d', strtotime($val['细则交货日期'])); ?></span>
                            </div>
                            <br>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if(!$res){
                        echo "<p>未查询到满足条件的记录！</p>";
                    }?>
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

    <a href="javascript:void(0);" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i
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
    $("#订单跟踪,#施工单跟踪").addClass("active");
    $("#index").removeClass("active");
</script>
<script>
    <?php if ($date1 && $date1) {
        echo " $(\"#date1\").val('{$date1}');";
    };

    if ($date3 && $date3) {
        echo " $(\"#date3\").val('{$date3}');";
    }else{
        echo " $(\"#date3\").val('".date('Y-m',time())."');";
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
