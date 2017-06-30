<?php
require_once 'include.php';
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
    <link href="vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet"/>
    <link href="vendor/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
    <link rel="stylesheet" href="css/order_statistics_query.css">

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
            <li class="active">订货信息查询</li>
        </ol>
        <h1 class="page-header">订货信息查询</h1>

        <div class="row">
            <div class="col-md-5">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h5 class="panel-title">搜索</h5>
                    </div>
                    <div class="panel-body">
                            <table class="search_table ">
                                <tr>
                                    <td class="text-right"><label for="month">月&nbsp;&nbsp;&nbsp;&nbsp;份&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    </td>
                                    <td><input type="datetime" id="month"></td>
                                </tr>
                                <tr>
                                    <td class="text-right"><label for="contract">业务员&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    </td>
                                    <td>
                                        <select id="contract">
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
                                    <td class="text-right"><label for="client">客&nbsp;&nbsp;&nbsp;&nbsp;户&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    </td>
                                    <td>
                                        <select id="client" class="selectpicker" data-size="6" data-live-search="true"
                                                data-style="btn-white">
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
                                        <button id="submit" class="btn btn-sm btn-inverse"
                                                aria-label="Left Align">
                                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-inverse" aria-label="Left Align">
                                            <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
                                        </button>
                                    </td>
                                </tr>
                            </table>
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

<script src="vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script src="vendor/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script>
    $(document).ready(function () {
        App.init();
        $('#month').datetimepicker({
            language: 'ch',
            format: 'yyyy-mm',
            autoclose: true,
            startView: 'year',
            minView: 'year',
            maxView: 'decade'
        });
    });
    $("#order_statistics,#order_statistics_query").addClass("active");
    $("#index").removeClass("active");
</script>

<script>
    $(document).ready(function () {
        $("#submit").click(function () {
            $.ajax({
                url:'doAction.php?act=order_statistics_query',
                data:{month:$("#month").val(),client:$("#client").val(),contract:$("#contract").val()},
                async:true,
                success:function (data) {
                    $("#res_div").html(data);
                },
                error:function(jqXHR){
                    Modal.alert({
                        msg: '发生错误:'+jqXHR.status,
                        title: '标题',
                        btnok: '确定',
                        btncl:'取消'
                    });
                }
            })
        });
    });
</script>
</body>
</html>
