<?php
require_once 'include.php';
$filter="";
if($date1=isset($_REQUEST['date1'])?$_REQUEST['date1']:null){
    $filter.=" AND (convert(char(10),订单.订货日期,120)>='{$date1}')";
}
if($date2=isset($_REQUEST['date2'])?$_REQUEST['date2']:null){
    $filter.=" AND (convert(char(10),订单.订货日期,120)<='{$date2}')";
}
if($date3=isset($_REQUEST['date3'])?$_REQUEST['date3']:null){
    $filter.="";
}
if($date4=isset($_REQUEST['date4'])?$_REQUEST['date4']:null){
    $filter.="";
}
if($client=isset($_REQUEST['client'])?$_REQUEST['client']:null){
    $filter.="";
}
if($contract=isset($_REQUEST['contract'])?$_REQUEST['contract']:null){
    $filter.="";
}
$sql= "SELECT
  订单.订单编号 ,  订单.客户 ,  订单.订货项数 ,  订单.订货日期 ,  订单.业务员 ,
  订单.备件订单 ,  订单.应收金额 ,  订单.订单描述 ,  订单.合同链接 ,  订单.校核员 ,
  订单.订单处置 ,  订单.登记员 ,  订单.备注 ,  订单.合同号 ,  V订货.订货件数 ,
  V发货.发货件数 ,  订单.跟单员 ,  职工信息.部门编号 ,  订单.内部合同号 ,  V订货.需转运数 ,
  V发货.已转运数量 AS 已转运数 ,
  V订货.订单完成 AS 订单完成 ,
  订单.下单日期 ,  V订货.订单总重
FROM
  订单 WITH ( NOLOCK )
  LEFT OUTER JOIN 客户 ON 客户.客户=订单.客户
  LEFT OUTER JOIN (

  SELECT
    订单细则.订单编号 ,
    SUM ( 订单细则.订货数量 ) AS 订货件数 ,
    SUM ( 订单细则.订货数量*V_订单细则简略视图.参考重量 ) AS 订单总重 ,
    SUM ( CASE WHEN 订单细则.金工 ='1' THEN 订单细则.订货数量 ELSE NULL END ) AS 需转运数 ,
    CASE WHEN AVG ( CAST ( 订单细则.发货结束 AS INT ) ) =1 THEN 'Y' ELSE 'N' END AS 订单完成
  FROM
    订单细则 WITH ( NOLOCK )
    LEFT OUTER JOIN V_订单细则简略视图 WITH ( NOLOCK ) ON V_订单细则简略视图.订单细则号=订单细则.订单细则号
  GROUP BY
    订单细则.订单编号

) V订货 ON 订单.订单编号 = V订货.订单编号
  LEFT OUTER JOIN (

  SELECT
    订单细则.订单编号 ,
    SUM ( CASE WHEN 发货记录主表.发货类型 ='转运' THEN 发货记录.发货数量 ELSE NULL END ) AS 已转运数量 ,
    SUM ( CASE WHEN 发货记录主表.发货类型 ='发货' THEN 发货记录.发货数量 ELSE NULL END ) AS 发货件数
  FROM
    发货记录 WITH ( NOLOCK )
    LEFT OUTER JOIN 订单细则 WITH ( NOLOCK ) ON 订单细则.订单细则号=发货记录.订单细则号
    LEFT OUTER JOIN 发货记录主表 WITH ( NOLOCK ) ON 发货记录.发运编号=发货记录主表.发运编号
  GROUP BY
    订单细则.订单编号

) V发货 ON 订单.订单编号 = V发货.订单编号
  LEFT OUTER JOIN 职工信息 WITH ( NOLOCK ) ON 职工信息.职工编号 = 订单.跟单员



WHERE ('A0801' not in (select 系统角色.职工号 from 系统角色 where 系统角色.系统角色='跟单员' )) --or (客户.权限一='A0801' ) or (客户.权限二='A0801' )or (客户.权限三='A0801'))
 
 ";
$res=fetchAll($sql);
var_dump($res);
?>
<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <title>华铸ERP订单管理系统 | 订单查询</title>
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
            <li><a href="#">首页</a></li>
            <li><a href="#">订单管理</a></li>
            <li class="active">订单信息查询</li>
        </ol>
        <h1 class="page-header">订单信息查询</h1>

        <div class="row">
            <div class="col-md-5">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h5 class="panel-title">搜索</h5>
                    </div>
                    <div class="panel-body">
                        <form id="form" action="<?php print $_SERVER['PHP_SELF'] ?>" >
                            <table class="search_table ">
                                <tr>
                                    <td class="col-md-3 text-center"><label for="date1">订货日期：</label>
                                    </td>
                                    <td class="col-md-9">
                                        <input type="datetime" name="date1" class="date"
                                               onClick="laydate({istime: true, format: 'YYYY-MM-DD'})">
                                        — <input type="datetime" name="date2" class="date"
                                                 onClick="laydate({istime: true, format: 'YYYY-MM-DD'})">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center"><label for="date3 ">发货日期：</label>
                                    </td>
                                    <td>
                                        <input type="datetime" name="date3" class="date"
                                               onClick="laydate({istime: true, format: 'YYYY-MM-DD'})">
                                        — <input type="datetime" name="date4" class="date"
                                                 onClick="laydate({istime: true, format: 'YYYY-MM-DD'})">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center"><label for="contract">业&nbsp;&nbsp;务&nbsp;&nbsp;员：</label>
                                    </td>
                                    <td>
                                        <select name="contract" id="contract" class="selectpicker" data-size="6" data-live-search="true"
                                                data-style="btn-white" form="form">
                                            <option value=""></option>
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
                                        <select name="client" id="client" class="selectpicker" data-size="6" data-live-search="true"
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
                                    <td></td>
                                    <td>
                                        <button type="submit" class="btn btn-sm btn-inverse"
                                                aria-label="Left Align">
                                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-inverse" aria-label="Left Align">
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
            <div class="col-md-8">
                <div id="res_div" class="res_div">

                </div>
            </div>
        </div>

    </div>

    <a href="#" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i
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
<script src="js/alert_rewrite.js"></script>
<script type="text/javascript" src="vendor/laydate/laydate.js"></script>

<script src="vendor/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script>
    $(document).ready(function () {
        App.init();
    });
    $("#订单管理,#订单信息查询").addClass("active");
    $("#index").removeClass("active");
</script>


</body>
</html>
