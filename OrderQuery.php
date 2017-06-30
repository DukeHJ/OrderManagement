<?php include_once 'template/sessionstart.php';?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title>华铸ERP订单管理系统 | 订单管理</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- ================== BEGIN BASE CSS STYLE ================== -->

    <link href="assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="assets/css/animate.min.css" rel="stylesheet" />
    <link href="assets/css/style.min.css" rel="stylesheet" />
    <link href="assets/css/style-responsive.min.css" rel="stylesheet" />
    <link href="assets/css/theme/default.css" rel="stylesheet" id="theme" />
    <link rel="stylesheet" type="text/css" href="css/order-query.css">
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
    <link href="assets/plugins/DataTables/css/data-table.css" rel="stylesheet" />
    <!-- ================== END PAGE LEVEL STYLE ================== -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="assets/plugins/pace/pace.min.js"></script>
    <script src="assets/plugins/jquery/jquery-1.9.1.min.js"></script>
    <!-- ================== END BASE JS ================== -->
</head>
<body>
    <?php include_once 'template/pageloader.php';?>

    <!-- begin #page-container -->
    <div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
        <?php include_once 'template/header.php';?>
        <?php include_once 'template/sidebar.php';?>

        <!-- begin #content -->
        <div id="content" class="content">
            <!-- begin breadcrumb -->
            <ol class="breadcrumb pull-right">
                <li><a href="javascript:;">首页</a></li>
                <li><a href="javascript:;">订单管理</a></li>
                <li class="active">订单查询</li>
            </ol>
            <!-- end breadcrumb -->
            <!-- begin page-header -->
            <h1 class="page-header">订单查询</h1>
            <!-- end page-header -->

            <!-- begin row -->
            <div class="row">
                <!-- begin col-12 -->
                <div class="col-md-12">
                    <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="data-table" class="table table-striped table-bordered text-center" style="width: 2300px;">
                                        <thead>
                                            <tr>
                                                <td class="col1">订单编号</td>
                                                <td class="col1">内部合同号</td>
                                                <td class="col1">合同号</td>
                                                <td class="col2">客户</td>
                                                <td class="col3">订货日期</td>
                                                <td class="col2">订单描述</td>
                                                <td class="col6">合同链接</td>
                                                <td class="col4">跟单部门</td>
                                                <td class="col4">跟单员</td>
                                                <td class="col4">登记员</td>
                                                <td class="col4">校核员</td>
                                                <td class="col4">订单处置</td>
                                                <td class="col4">订货项数</td>
                                                <td class="col4">订货件数</td>
                                                <td class="col4">需转运输</td>
                                                <td class="col4">已转运数</td>
                                                <td class="col4">发货件数</td>
                                                <td class="col4">单件数</td>
                                                <td class="col4">终止数</td>
                                                <td class="col4">完成数</td>
                                                <td class="col4">完成进度</td>
                                                <td class="col5">完成</td>
                                                <td class="col4">备件订单</td>
                                                <td class="col6">备注</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php include_once 'search/SearchOrderInfo.php';?>
                                        </tbody>
                                        <tfoot>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="visibility-hidden"></td>
                                            <td class="visibility-hidden"></td>
                                            <td class="visibility-hidden"></td>
                                            <td class="visibility-hidden"></td>
                                            <td class="visibility-hidden"></td>
                                            <td class="visibility-hidden"></td>
                                            <td class="visibility-hidden"></td>
                                            <td class="visibility-hidden"></td>
                                            <td class="visibility-hidden"></td>
                                            <td class="visibility-hidden"></td>
                                            <td class="visibility-hidden"></td>
                                            <td class="visibility-hidden"></td>
                                            <td class="visibility-hidden"></td>
                                            <td class="visibility-hidden"></td>
                                            <td class="visibility-hidden"></td>
                                            <td class="visibility-hidden"></td>
                                            <td class="visibility-hidden"></td>
                                            <td class="visibility-hidden"></td>
                                            <td class="visibility-hidden"></td>
                                        </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-12 -->
            </div>
            <!-- end row -->
        </div>
        <!-- end #content -->

        <!-- begin scroll to top btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        <!-- end scroll to top btn -->
    </div>
    <!-- end page container -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
    <script src="assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!--[if lt IE 9]>
        <script src="assets/crossbrowserjs/html5shiv.js"></script>
        <script src="assets/crossbrowserjs/respond.min.js"></script>
        <script src="assets/crossbrowserjs/excanvas.min.js"></script>
        <script type="text/javascript" src="vendor/jquery-placeholder/jquery.placeholder.js"></script>
        <script type="text/javascript">
        $(function () {
            $('input, textarea').placeholder();
        });
    </script>
    <![endif]-->
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/plugins/jquery-cookie/jquery.cookie.js"></script>
    <!-- ================== END BASE JS ================== -->

    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <script src="assets/plugins/DataTables/js/jquery.dataTables.js"></script>
    <script src="assets/js/apps.min.js"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->

    <script>
        $(document).ready(function() {
            App.init();

            $('#data-table tfoot td').each( function () {
                var title = $('#data-table thead td').eq( $(this).index() ).text();
                $(this).html( '<input type="text" class="S'+title+'" placeholder="搜索 '+title+'" />' );
            } );
            var table = $('#data-table').DataTable({
                stateSave: true
            });

            table.columns().eq( 0 ).each( function (colIdx) {
                $( 'input', table.column( colIdx ).footer() ).on( 'keyup change', function () {
                    table
                        .column( colIdx )
                        .search( this.value )
                        .draw();
                });
            });
        });
        $("#订单查询").addClass("active");
    </script>

</body>
</html>
