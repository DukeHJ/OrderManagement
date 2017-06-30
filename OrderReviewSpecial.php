<?php include 'include.php'; ?>
<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <title>华铸ERP订单管理系统 | 订单管理</title>
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
    <link rel="stylesheet" type="text/css" href="css/order-review.css">

    <link href="vendor/gritter-1.7.4/css/jquery.gritter.css" rel="stylesheet"/>
    <link href="vendor/DataTables/css/data-table.css" rel="stylesheet"/>

    <script src="vendor/pace/pace.min.js"></script>
    <script src="vendor/jquery/jquery-1.9.1.min.js"></script>
</head>
<body>
<?php include_once 'template/pageloader.php'; ?>

<div id="page-container" class="fade page-header-fixed page-sidebar-fixed">
    <?php include_once 'template/header.php'; ?>
    <?php include_once 'template/sidebar.php'; ?>

    <div id="content" class="content">

        <ol class="breadcrumb pull-right">
            <li><a href="javascript:;">首页</a></li>
            <li><a href="javascript:;">订单管理</a></li>
            <li class="active">订单评审(特殊)</li>
        </ol>
        <h1 class="page-header">订单评审
            <small>(特殊)</small>
        </h1>

        <div class="row">
            <ul id="Reviewtabs1" class="nav nav-tabs">
                <li class="active"><a href="#worklist" data-toggle="tab">工作列表</a></li>
                <?php if (1): ?>
                    <li class=""><a href="#workzone" data-toggle="tab">工作区</a></li>
                <?php endif; ?>
                <li class=''><a href='#tasklist' data-toggle='tab'>任务列表</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade in active" id="worklist">
                    <div class="row">
                        <div class="col-md-12 ui-sorttable">
                            <div class="table-responsive">
                                <table id="data-table"
                                       class="table table-striped table-bordered table-condensed text-center"
                                       style="width: 4200px;">
                                    <thead>
                                    <tr>
                                        <td>传参</td>
                                        <td>铸造</td>
                                        <td>加工</td>
                                        <td>新品</td>
                                        <td>特急</td>
                                        <td>序号</td>
                                        <td>客户简称</td>
                                        <td class="col1">订货日期</td>
                                        <td>合同号</td>
                                        <td>合同要求</td>
                                        <td>订单细则号</td>
                                        <td>铸件编号</td>
                                        <td>产品名称</td>
                                        <td>铸件描述</td>
                                        <td>材质</td>
                                        <td>参考重量</td>
                                        <td>图号</td>
                                        <td class="col1">交货日期</td>
                                        <td>订货数量</td>
                                        <td style="background-color: #3AC4A6;">备件库库存</td>
                                        <td style="background-color: #3AC4A6;">调出仓库</td>
                                        <td style="background-color: #3AC4A6;">调拨数量</td>
                                        <td style="background-color: #3AC4A6;">调入仓库</td>
                                        <td style="background-color: #3AC4A6;">销售部结论</td>
                                        <td style="background-color: #3AC4A6;">销售部</td>
                                        <td class="col1" style="background-color: #3AC4A6;">销售部签名时间</td>
                                        <td style="background-color: #19A9E5;">检测能力</td>
                                        <td style="background-color: #19A9E5;">检验标准书</td>
                                        <td style="background-color: #19A9E5;">历史品质记录</td>
                                        <td style="background-color: #19A9E5;">质量部结论</td>
                                        <td style="background-color: #19A9E5;">质量部</td>
                                        <td class="col1" style="background-color: #19A9E5;">质量部签名时间</td>
                                        <td style="background-color: #CA347D;">供应部结论</td>
                                        <td style="background-color: #CA347D;">供应部</td>
                                        <td class="col1" style="background-color: #CA347D;">供应部签名时间</td>
                                        <td style="background-color: #E2761C;">图纸</td>
                                        <td style="background-color: #E2761C;">工艺成熟</td>
                                        <td style="background-color: #E2761C;">工艺卡</td>
                                        <td style="background-color: #E2761C;">技术部结论</td>
                                        <td style="background-color: #E2761C;">技术部</td>
                                        <td class="col1" style="background-color: #E2761C;">技术部签名时间</td>
                                        <td class="col1" style="background-color: #0F82EF;">加工交期</td>
                                        <td style="background-color: #0F82EF;">加工评审结论</td>
                                        <td style="background-color: #0F82EF;">机加工评审</td>
                                        <td class="col1" style="background-color: #0F82EF;">机加工评审时间</td>
                                        <td style="background-color: #9F4FAF;">模具</td>
                                        <td class="col1" style="background-color: #9F4FAF;">模具交期</td>
                                        <td style="background-color: #9F4FAF;">生产数量</td>
                                        <td class="col1" style="background-color: #9F4FAF;">铸造交期</td>
                                        <td style="background-color: #9F4FAF;">生产部结论</td>
                                        <td style="background-color: #9F4FAF;">生产评审</td>
                                        <td class="col1" style="background-color: #9F4FAF;">生产评审时间</td>
                                        <td style="background-color: #cc4946;">总经理结论</td>
                                        <td style="background-color: #cc4946;">总经理签名</td>
                                        <td class="col1" style="background-color: #cc4946;">总经理签名时间</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php include 'SearchOrderReviewSpecialwork.php'; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (1): ?>
                    <div class="tab-pane fade in " id="workzone">
                        <div id="ReviewBox" class="row">
                            <div class="col-md-10 ui-sorttable">
                                <div id="OrderInfo" class="table-responsive" style="display: none;">
                                    <h5>订单信息</h5>
                                    <table class="table table-bordered table-condensed text-center"
                                           style="margin-bottom:0;">
                                        <tbody>
                                        <tr class="colheader">
                                            <td>铸造</td>
                                            <td>金工</td>
                                            <td>新品</td>
                                            <td>特急</td>
                                            <td>合同号</td>
                                            <td>客户简称</td>
                                            <td>合同要求</td>
                                            <td>订货日期</td>
                                            <td>交货日期</td>
                                            <td>订货数量</td>
                                        </tr>
                                        <tr>
                                            <td class="tdzz"></td>
                                            <td class="tdjg"></td>
                                            <td class="tdxp"></td>
                                            <td class="tdtj"></td>
                                            <td class="tdhth"></td>
                                            <td class="tdkhjc"></td>
                                            <td class="tdhtyq"></td>
                                            <td class="tddhri"></td>
                                            <td class="tdjhrq"></td>
                                            <td class="tddhsl"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered table-condensed text-center"
                                           style="margin-top:0;">
                                        <tbody>
                                        <tr class="colheader">
                                            <td>订单细则号</td>
                                            <td>铸件名称</td>
                                            <td>材质</td>
                                            <td>铸件描述</td>
                                            <td>参考重量</td>
                                            <td>图号</td>
                                            <td>铸件编号</td>
                                            <td style="background-color:gray;">传参</td>
                                        </tr>
                                        <tr>
                                            <td class="tdddxz"></td>
                                            <td class="tdzjmc"></td>
                                            <td class="tdcz"></td>
                                            <td class="tdzjms"></td>
                                            <td class="tdckzl"></td>
                                            <td class="tdxh"></td>
                                            <td class="tdzjbh"></td>
                                            <td><input type="text" id="传参" style="width:35px;"
                                                       onkeyup="if(!  /^[0-9]*[1-9][0-9]*$/.test(this.value)){Modal.alert({msg: &apos;传参必须为正整数！&apos;,title: &apos;标题&apos;,btnok: &apos;确定&apos;,btncl:&apos;取消&apos;});this.value=null;}">
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-4 ui-sorttable">
                                <div id="DpSale" class="table-responsive">
                                    <table class="table table-bordered table-condensed text-center"
                                           style="width:380px;">
                                        <thead><h5>销售部评审</h5></thead>
                                        <tbody>
                                        <tr class="colheader2">
                                            <td>备件库库存</td>
                                            <td>调出仓库</td>
                                            <td>调拨数量</td>
                                            <td>调入仓库</td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" id="备件库库存" class=" col1" readonly="readonly"></td>
                                            <td><select id="调出仓库" class=" col2"></select></td>
                                            <td><input type="text" id="调拨数量" class=" col1"
                                                       onkeyup="if(!  /(^[1-9]+\d*$)|(^0$)/.test(this.value)){Modal.alert({msg: &apos;调拨数量必须为非负整数！&apos;,title: &apos;标题&apos;,btnok: &apos;确定&apos;,btncl:&apos;取消&apos;});this.value=null;}">
                                            </td>
                                            <td><select id="调入仓库" class=" col2"></select></td>
                                        </tr>
                                        <tr>
                                            <td class="colheader2">评审结论</td>
                                            <td colspan="3"><input type="text" id="销售部结论" style="width:100%;"></td>
                                        </tr>
                                        <tr>
                                            <td class="colheader2">签字</td>
                                            <td><input type="text" id="业务部" class="zgxm col2" readonly="readonly"></td>
                                            <td class="colheader2">签名时间</td>
                                            <td><input type="datetime" id="业务签名时间" class="qmsj col2"
                                                       readonly="readonly"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-4 ui-sorttable">
                                <div id="DpQuality" class="table-responsive">
                                    <table class="table table-bordered table-condensed text-center"
                                           style="width:380px;margin: 0;">
                                        <thead><h5>质量部评审</h5></thead>
                                        <tbody>
                                        <tr class="colheader3">
                                            <td>检测能力</td>
                                            <td>检验标准书</td>
                                            <td colspan="3">历史品质记录</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" id="检具量具" class="colck col3" value="0"
                                                       onclick="this.value=(this.value==0)?1:0"></td>
                                            <td><input type="checkbox" id="检验标准书" class="colck col3" value="0"
                                                       onclick="this.value=(this.value==0)?1:0"></td>
                                            <td colspan="3"><input type="text" id="历史品质记录" style="width:100%"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered table-condensed text-center"
                                           style="width:380px;margin: 0;">
                                        <tbody>
                                        <tr>
                                            <td class="colheader3">评审结论</td>
                                            <td colspan="3"><input type="text" id="质量部结论" style="width:100%;"></td>
                                        </tr>
                                        <tr>
                                            <td class="colheader3">签字</td>
                                            <td><input type="text" id="品管部" class="zgxm col2" readonly="readonly"></td>
                                            <td class="colheader3">签名时间</td>
                                            <td><input type="datetime" id="品管签名时间" class="qmsj col2"
                                                       readonly="readonly"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-4 ui-sorttable">
                                <div id="DpSupply" class="table-responsive">
                                    <table class="table table-bordered table-condensed text-center"
                                           style="width:380px;">
                                        <thead><h5>供应部评审</h5></thead>
                                        <tbody>
                                        <tr>
                                            <td class="colheader4">评审结论</td>
                                            <td colspan="3"><input type="text" id="供应部结论" style="width:100%;"></td>
                                        </tr>
                                        <tr>
                                            <td class="colheader4">签字</td>
                                            <td><input type="text" id="PMC" class="zgxm col2" readonly="readonly"></td>
                                            <td class="colheader4">签名时间</td>
                                            <td><input type="datetime" id="PMC签名时间" class="qmsj col2"
                                                       readonly="readonly"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-4 ui-sorttable">
                                <div id="DpTechnology" class="table-responsive">
                                    <table class="table table-bordered table-condensed text-center"
                                           style="width:200px;margin: 0;">
                                        <thead><h5>技术部评审</h5></thead>
                                        <tbody>
                                        <tr class="colheader5">
                                            <td>图纸</td>
                                            <td>工艺成熟</td>
                                            <td>工艺卡</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" id="图纸" class="colck col6" value="0"
                                                       onclick="this.value=(this.value==0)?1:0">
                                            </td>
                                            <td><input type="checkbox" id="工艺成熟" class="colck col6" value="0"
                                                       onclick="this.value=(this.value==0)?1:0"></td>
                                            <td><input type="checkbox" id="工艺卡" class="colck col6" value="0"
                                                       onclick="this.value=(this.value==0)?1:0"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered table-condensed text-center"
                                           style="width:380px;margin: 0;">
                                        <tbody>
                                        <tr>
                                            <td class="colheader5">评审结论</td>
                                            <td colspan="3"><input type="text" id="技术部结论" style="width:100%;"></td>
                                        </tr>
                                        <tr>
                                            <td class="colheader5">签字</td>
                                            <td><input type="text" id="技术部" class="zgxm col2" readonly="readonly"></td>
                                            <td class="colheader5">签名时间</td>
                                            <td><input type="datetime" id="技术签名时间" class="qmsj col2"
                                                       readonly="readonly"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-4 ui-sorttable">
                                <div id="DpMaching" class="table-responsive">
                                    <table class="table table-bordered table-condensed text-center"
                                           style="width:282px;margin: 0;">
                                        <thead><h5>机加工评审</h5></thead>
                                        <tbody>
                                        <tr>
                                            <td class="colheader6">加工交期</td>
                                            <td><input type="datetime" id="加工交期"
                                                       onClick="laydate({istime: true, format: 'YYYY-MM-DD'})">
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered table-condensed text-center"
                                           style="width:380px;margin: 0;">
                                        <tbody>
                                        <tr>
                                            <td class="colheader6">评审结论</td>
                                            <td colspan="3"><input type="text" id="加工评审结论" style="width:100%;"></td>
                                        </tr>
                                        <tr>
                                            <td class="colheader6">签字</td>
                                            <td><input type="text" id="机加工评审" class="zgxm col2" readonly="readonly">
                                            </td>
                                            <td class="colheader6">签名时间</td>
                                            <td><input type="datetime" id="机加工评审时间" class="qmsj col2"
                                                       readonly="readonly"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-4 ui-sorttable">
                                <div id="DpTechnology" class="table-responsive">
                                    <table class="table table-bordered table-condensed text-center"
                                           style="width:380px;margin: 0;">
                                        <thead><h5>生产部评审</h5></thead>
                                        <tbody>
                                        <tr class="colheader7">
                                            <td>模具</td>
                                            <td>模具交期</td>
                                            <td>生产数量</td>
                                            <td>铸造交期</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" id="模具" class="colck col6" value="0"
                                                       onclick="this.value=(this.value==0)?1:0">
                                            </td>
                                            <td><input type="datetime" id="模具交期" class="col2"
                                                       onClick="laydate({istime: true, format: 'YYYY-MM-DD'})"></td>
                                            <td><input type="text" id="生产数量" class="col1"
                                                       onkeyup="if(!  /(^[1-9]+\d*$)|(^0$)/.test(this.value)){Modal.alert({msg: &apos;生产数量必须为非负整数！&apos;,title: &apos;标题&apos;,btnok: &apos;确定&apos;,btncl:&apos;取消&apos;});this.value=null;}">
                                            </td>
                                            <td><input type="datetime" id="生产交期" class="col2"
                                                       onClick="laydate({istime: true, format: 'YYYY-MM-DD'})"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered table-condensed text-center"
                                           style="width:380px;margin: 0;">
                                        <tbody>
                                        <tr>
                                            <td class="colheader7">评审结论</td>
                                            <td colspan="3"><input type="text" id="生产部结论" style="width:100%;"></td>
                                        </tr>
                                        <tr>
                                            <td class="colheader7">签字</td>
                                            <td><input type="text" id="生产评审" class="zgxm col2" readonly="readonly"></td>
                                            <td class="colheader7">签名时间</td>
                                            <td><input type="datetime" id="生产评审时间" class="qmsj col2"
                                                       readonly="readonly"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-4 ui-sorttable">
                                <div id="DpManger" class="table-responsive">
                                    <table class="table table-bordered table-condensed text-center"
                                           style="width:380px;">
                                        <thead><h5>总经理评审</h5></thead>
                                        <tbody>
                                        <tr>
                                            <td class="colheader8">评审结论</td>
                                            <td colspan="3"><input type="text" id="总经理结论" style="width:100%;"></td>
                                        </tr>
                                        <tr>
                                            <td class="colheader8">签字</td>
                                            <td><input type="text" id="确认签名" class="zgxm col2" readonly="readonly"></td>
                                            <td class="colheader8 col5">签名时间</td>
                                            <td><input type="datetime" id="确认签名时间" class="qmsj col2"
                                                       readonly="readonly"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-6 ui-sorttable">
                                <div id="buttonbox">
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endif; ?>

                <div class="tab-pane fade in " id="tasklist">
                    <div class="row">
                        <div class="col-md-12 ui-sorttable">
                            <div class="table-responsive">
                                <table id="data-table2"
                                       class="table table-striped table-bordered table-condensed text-center"
                                       style="width: 1800px;">
                                    <thead>
                                    <tr>
                                        <td>铸造</td>
                                        <td>加工</td>
                                        <td>新品</td>
                                        <td>特急</td>
                                        <td>合同号</td>
                                        <td>客户简称</td>
                                        <td>合同要求</td>
                                        <td>生产方式</td>
                                        <td class="col1">订货日期</td>
                                        <td class="col1">交货日期</td>
                                        <td>订货数量</td>
                                        <td>库存</td>
                                        <td>铸件名称</td>
                                        <td>材质</td>
                                        <td>铸件描述</td>
                                        <td>参考重量</td>
                                        <td>规格</td>
                                        <td>型号</td>
                                        <td>图号</td>
                                        <td>铸件编号</td>
                                        <td>订单细则号</td>
                                        <td>传参</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php include 'SearchOrderReviewSpecialtask.php'; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i
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

<script src="vendor/DataTables/js/jquery.dataTables.js"></script>

<script src="js/myfunction.js"></script>
<script type="text/javascript" src="vendor/laydate/laydate.js"></script>

<script>
    $(document).ready(function () {
        App.init();
        $('#data-table2').dataTable({
            stateSave: true
        });
        $('#data-table').dataTable({
            stateSave: true
        });
    });
    $("#订单管理,#订单评审特殊").addClass("active");
</script>

<?php if (1): ?>
    <script>
        var ck = "<option value=''></option>" + gf_execsql2("SELECT 仓库编号 ,  仓库名称 ,  存放物料类别 FROM 仓库", '仓库编号', '仓库名称', '存放物料类别');
        $("#调出仓库").append(ck);
        $("#调入仓库").append(ck);
        $(document).ready(function () {
            $("#ReviewBox input,#ReviewBox select").attr("disabled", "disabled");
        });
    </script>

    <script>
        $(document).ready(function () {
            $("#业务部,#品管部,#PMC,#技术部,#机加工评审,#生产评审,#确认签名").click(function () {
                var dqreview = $(this).parents(".table-responsive");
                if (!dqreview.find(".zgxm").val()) {
                    Modal.alert({
                        msg: '<form class="form-horizontal"><div class="form-group"><label for="职工姓名" class="col-md-4 control-lable">职工姓名</label><div class="col-md-8"><input type="text" class="form-control" id="职工姓名" name="职工姓名"></div></div><div class="form-group"><label for="认证密码" class="col-md-4 control-lable">认证密码</label><div class="col-md-8"><input type="password" class="form-control" id="认证密码" name="认证密码"></div></div></form>',
                        title: '数字签名',
                        btnok: '确定',
                        btncl: '取消'
                    });
                } else {
                    Modal.alert({
                        msg: '<form class="form-horizontal"><div class="form-group"><label for="职工姓名" class="col-md-4 control-lable">职工姓名</label><div class="col-md-8"><input type="text" class="form-control" id="职工姓名" name="职工姓名" disabled="disabled" value="' + dqreview.find(".zgxm").val() + '"></div></div><div class="form-group"><label for="认证密码" class="col-md-4 control-lable">认证密码</label><div class="col-md-8"><input type="password" class="form-control" id="认证密码" name="认证密码"></div></div></form>',
                        title: '反签名',
                        btnok: '确定',
                        btncl: '取消'
                    });
                }
                $(".ok").click(function () {
                    var dqmodal = $(this).parents(".modal-content");

                    function p(s) {
                        return s < 10 ? '0' + s : s;
                    }

                    var myDate = new Date();
                    var year = myDate.getFullYear();
                    var month = myDate.getMonth() + 1;
                    var date = myDate.getDate();
                    var h = myDate.getHours();
                    var m = myDate.getMinutes();
                    var s = myDate.getSeconds();
                    var now = year + '-' + p(month) + "-" + p(date) + " " + p(h) + ':' + p(m) + ":" + p(s);
                    if (!dqreview.find(".zgxm").val()) {
                        $.ajax({
                            url: "doAction.php",
                            data: {
                                act: 'sign_log',
                                zhigongname: dqmodal.find("#职工姓名").val(),
                                zhigongpassword: dqmodal.find("#认证密码").val()
                            },
                            contentType: "application/json;charset=utf-8",
                            async: true,
                            success: function (data) {
                                if (data != 0 && data != 1) {
                                    Modal.alert({
                                        msg: data,
                                        title: '标题',
                                        btnok: '确定',
                                        btncl: '取消'
                                    });
                                }
                                if (data == 0) {
                                    Modal.alert({
                                        msg: '登录名或密码错误！',
                                        title: '标题',
                                        btnok: '确定',
                                        btncl: '取消'
                                    });
                                    return;
                                }
                                if (data == 1) {
                                    dqreview.find(".zgxm").val(dqmodal.find("#职工姓名").val());
                                    dqreview.find(".qmsj").val(now);
                                    dqreview.find('input,select').attr("disabled", "disabled");
                                    dqreview.find('.zgxm').removeAttr("disabled");
                                }
                            },
                            error: function (jqXHR) {
                                Modal.alert({
                                    msg: '发生错误:' + jqXHR.status,
                                    title: '标题',
                                    btnok: '确定',
                                    btncl: '取消'
                                });
                            }
                        });
                    } else {
                        $.ajax({
                            type: "GET",
                            url: "doAction.php",
                            data: {
                                act: 'sign_log',
                                zhigongname: dqmodal.find("#职工姓名").val(),
                                zhigongpassword: dqmodal.find("#认证密码").val()
                            },
                            contentType: "application/json;charset=utf-8",
                            async: true,
                            success: function (data) {
                                if (data != 0 && data != 1) {
                                    Modal.alert({
                                        msg: data,
                                        title: '标题',
                                        btnok: '确定',
                                        btncl: '取消'
                                    });
                                }
                                if (data == 0) {
                                    Modal.alert({
                                        msg: '登录名或密码错误！',
                                        title: '标题',
                                        btnok: '确定',
                                        btncl: '取消'
                                    });
                                    return;
                                }
                                if (data == 1) {
                                    dqreview.find(".zgxm").val('');
                                    dqreview.find(".qmsj").val('');
                                    dqreview.find('input,select').removeAttr("disabled");
                                }
                            },
                            error: function (jqXHR) {
                                Modal.alert({
                                    msg: '发生错误:' + jqXHR.status,
                                    title: '标题',
                                    btnok: '确定',
                                    btncl: '取消'
                                });
                            },
                        });
                    }
                });
            });
        });
    </script>

    <script>
        var timeout;
        $("#data-table tbody tr").bind('touchstart mousedown', function () {
            var thistr = $(this);
            timeout = setTimeout(function () {
                $("#OrderInfo").css("display", "block");
                $("#ReviewBox input,#ReviewBox select").removeAttr("disabled");
                $("#备件库库存").val(thistr.find(".trkc").html());
                $("#调出仓库").val(gf_execsql("SELECT 仓库编号 FROM 仓库 WHERE 仓库名称='" + thistr.find(".trdcck").html() + "'"));
                $("#调拨数量").val(thistr.find(".trdbsl").html());
                $("#调入仓库").val(gf_execsql("SELECT 仓库编号 FROM 仓库 WHERE 仓库名称='" + thistr.find(".trdrck").html() + "'"));

                $("#销售部结论").val(thistr.find(".trxsbjl").html());
                $("#业务部").val(thistr.find(".trxsb").html());
                $("#业务签名时间").val(thistr.find(".trxsbqmsj").html());

                $("#历史品质记录").val(thistr.find(".trlspzjl").html());
                $("#质量部结论").val(thistr.find(".trzlbjl").html());
                $("#品管部").val(thistr.find(".trzlb").html());
                $("#品管签名时间").val(thistr.find(".trzlbqmsj").html());
                $("#供应部结论").val(thistr.find(".trgybjl").html());
                $("#PMC").val(thistr.find(".trgyb").html());
                $("#PMC签名时间").val(thistr.find(".trgybqmsj").html());
                $("#加工交期").val(thistr.find(".trjgjq").html());
                $("#加工评审结论").val(thistr.find(".trjgpsjl").html());
                $("#机加工评审").val(thistr.find(".trjjgps").html());
                $("#机加工评审时间").val(thistr.find(".trjjgpssj").html());

                $("#模具交期").val(thistr.find(".trmjjq").html());
                $("#生产数量").val(thistr.find(".trscsl").html());
                $("#生产交期").val(thistr.find(".trscjq").html());
                $("#生产部结论").val(thistr.find(".trscbjl").html());
                $("#生产评审").val(thistr.find(".trscps").html());
                $("#生产评审时间").val(thistr.find(".trscpssj").html());

                $("#检具量具").val(thistr.find(".trjcnl").find("input").val());
                if ($("#检具量具").val() == 1) {
                    $("#检具量具").attr("checked", "checked");
                }
                $("#检验标准书").val(thistr.find(".trjybzs").find("input").val());
                if ($("#检验标准书").val() == 1) {
                    $("#检验标准书").attr("checked", "checked");
                }
                $("#模具").val(thistr.find(".trmj").find("input").val());
                if ($("#模具").val() == 1) {
                    $("#模具").attr("checked", "checked");
                }
                $("#图纸").val(thistr.find(".trtz").find("input").val());
                if ($("#图纸").val() == 1) {
                    $("#图纸").attr("checked", "checked");
                }
                $("#工艺成熟").val(thistr.find(".trgycs").find("input").val());
                if ($("#工艺成熟").val() == 1) {
                    $("#工艺成熟").attr("checked", "checked");
                }
                $("#工艺卡").val(thistr.find(".trgyk").find("input").val());
                if ($("#工艺卡").val() == 1) {
                    $("#工艺卡").attr("checked", "checked");
                }

                $("#技术部结论").val(thistr.find(".trjsbjl").html());
                $("#技术部").val(thistr.find(".trjsb").html());
                $("#技术部签名时间").val(thistr.find(".trjsbqmsj").html());
                $("#总经理结论").val(thistr.find(".trzjljl").html());
                $("#确认签名").val(thistr.find(".trqrqm").html());
                $("#确认签名时间").val(thistr.find(".trqrqmsj").html());

                $(".tdddxz").html(thistr.find(".trddxzh").html());
                $(".tdzz").html(thistr.find(".trzz").html());
                $(".tdjg").html(thistr.find(".trjg").html());
                $(".tdxp").html(thistr.find(".trxp").html());
                $(".tdtj").html(thistr.find(".trtj").html());
                $(".tdhth").html(thistr.find(".trhth").html());
                $(".tdkhjc").html(thistr.find(".trkhjc").html());
                $(".tdhtyq").html(thistr.find(".trhtyq").html());
                $(".tddhri").html(thistr.find(".trdhrq").html());
                $(".tdjhrq").html(thistr.find(".trjhrq").html());
                $(".tddhsl").html(thistr.find(".trdhsl").html());
                $(".tdzjmc").html(thistr.find(".trzjmc").html());
                $(".tdcz").html(thistr.find(".trcz").html());
                $(".tdzjms").html(thistr.find(".trzjms").html());
                $(".tdckzl").html(thistr.find(".trckzl").html());
                $(".tdth").html(thistr.find(".trth").html());
                $(".tdzjbh").html(thistr.find(".trzjbh").html());
                $("#传参").val(thistr.find(".trcc").html());

                $("#ReviewBox .table-responsive").each(function () {
                    if ($(this).find(".zgxm").val()) {
                        $(this).find("input,select").attr("disabled", "disabled");
                        $(this).find(".zgxm").removeAttr("disabled");
                    }
                });

                $("#buttonbox").append('<button type="button" id="保存" class="btn btn-sm btn-inverse">保存</button><button type="button" id="刷新" class="btn btn-sm btn-inverse">刷新</button>');
                $('#Reviewtabs1 a[href="#workzone"]').tab('show');
                thistr.remove();
                $("#data-table tr").off("mousedown touchstart");
                $("#data-table2 tr").off("mousedown touchstart");
            }, 1000);
        });
        $("#data-table tbody tr").bind('touchend mouseup mouseout', function () {
            clearTimeout(timeout);
        });
    </script>

    <script>
        var timeout;
        $("#data-table2 tbody tr").bind('touchstart mousedown', function () {
            var thistr = $(this);
            timeout = setTimeout(function () {
                $("#OrderInfo").css("display", "block");
                $("#ReviewBox input,#ReviewBox select").removeAttr("disabled");

                $("#备件库库存").val(thistr.find(".trkc").html());
                $(".tdddxz").html(thistr.find(".trddxzh").html());
                $(".tdzz").html(thistr.find(".trzz").html());
                $(".tdjg").html(thistr.find(".trjg").html());
                $(".tdxp").html(thistr.find(".trxp").html());
                $(".tdtj").html(thistr.find(".trtj").html());
                $(".tdhth").html(thistr.find(".trhth").html());
                $(".tdkhjc").html(thistr.find(".trkhjc").html());
                $(".tdhtyq").html(thistr.find(".trhtyq").html());
                $(".tddhri").html(thistr.find(".trdhrq").html());
                $(".tdjhrq").html(thistr.find(".trjhrq").html());
                $(".tddhsl").html(thistr.find(".trdhsl").html());
                $(".tdzjmc").html(thistr.find(".trzjmc").html());
                $(".tdcz").html(thistr.find(".trcz").html());
                $(".tdzjms").html(thistr.find(".trzjms").html());
                $(".tdckzl").html(thistr.find(".trckzl").html());
                $(".tdth").html(thistr.find(".trth").html());
                $(".tdzjbh").html(thistr.find(".trzjbh").html());
                $("#传参").val(thistr.find(".trcc").html());

                $("#buttonbox").append('<button type="button" id="保存" class="btn btn-sm btn-inverse">保存</button><button type="button" id="刷新" class="btn btn-sm btn-inverse">刷新</button>');
                $('#Reviewtabs1 a[href="#workzone"]').tab('show');
                thistr.remove();
                $("#data-table tr").off("mousedown touchstart");
                $("#data-table2 tr").off("mousedown touchstart");
            }, 1000);
        });
        $("#data-table2 tbody tr").bind('touchend mouseup mouseout', function () {
            clearTimeout(timeout);
        });
    </script>

    <script>
        $(document).ready(function () {
            $(document).on("click", "#保存", function () {
                var C1 = "'" + $(".tdddxz").html() + "'";
                var C2 = "'" + $("#传参").val() + "',";
                var C3 = "'" + $("#调出仓库").val() + "',";
                var C4 = "'" + $("#调拨数量").val() + "',";
                var C5 = "'" + $("#调入仓库").val() + "',";
                var C7 = "'" + $("#销售部结论").val() + "',";
                var C8 = "'" + gf_execsql("SELECT 职工编号 FROM 职工信息 WHERE 职工姓名='" + $("#业务部").val() + "'") + "',";
                var C9 = "'" + $("#业务签名时间").val() + "',";
                var C10 = "'" + $("#检具量具").val() + "',";
                var C11 = "'" + $("#检验标准书").val() + "',";
                var C12 = "'" + $("#历史品质记录").val() + "',";
                var C13 = "'" + $("#质量部结论").val() + "',";
                var C14 = "'" + gf_execsql("SELECT 职工编号 FROM 职工信息 WHERE 职工姓名='" + $("#品管部").val() + "'") + "',";
                var C15 = "'" + $("#品管签名时间").val() + "',";
                var C16 = "'" + $("#供应部结论").val() + "',";
                var C17 = "'" + gf_execsql("SELECT 职工编号 FROM 职工信息 WHERE 职工姓名='" + $("#PMC").val() + "'") + "',";
                var C18 = "'" + $("#PMC签名时间").val() + "',";
                var C19 = "'" + $("#图纸").val() + "',";
                var C20 = "'" + $("#工艺成熟").val() + "',";
                var C21 = "'" + $("#工艺卡").val() + "',";
                var C23 = "'" + $("#技术部结论").val() + "',";
                var C24 = "'" + gf_execsql("SELECT 职工编号 FROM 职工信息 WHERE 职工姓名='" + $("#技术部").val() + "'") + "',";
                var C25 = "'" + $("#技术签名时间").val() + "',";
                var C26 = "'" + $("#加工交期").val() + "',";
                var C27 = "'" + $("#加工评审结论").val() + "',";
                var C28 = "'" + gf_execsql("SELECT 职工编号 FROM 职工信息 WHERE 职工姓名='" + $("#机加工评审").val() + "'") + "',";
                var C29 = "'" + $("#机加工评审时间").val() + "',";
                var C30 = "'" + $("#模具").val() + "',";
                var C31 = "'" + $("#模具交期").val() + "',";
                var C32 = "'" + $("#生产数量").val() + "',";
                var C33 = "'" + $("#生产交期").val() + "',";
                var C34 = "'" + $("#生产部结论").val() + "',";
                var C35 = "'" + gf_execsql("SELECT 职工编号 FROM 职工信息 WHERE 职工姓名='" + $("#生产评审").val() + "'") + "',";
                var C36 = "'" + $("#生产评审时间").val() + "',";
                var C37 = "'" + $("#总经理结论").val() + "',";
                var C38 = "'" + gf_execsql("SELECT 职工编号 FROM 职工信息 WHERE 职工姓名='" + $("#确认签名").val() + "'") + "',";
                var C39 = "'" + $("#确认签名时间").val() + "'";

                $.ajax({
                    type: "GET",
                    url: "doAction.php",
                    data: {
                        act:'insertRS',
                        C1: C1,
                        C2: C2,
                        C3: C3,
                        C4: C4,
                        C5: C5,
                        C7: C7,
                        C8: C8,
                        C9: C9,
                        C10: C10,
                        C11: C11,
                        C12: C12,
                        C13: C13,
                        C14: C14,
                        C15: C15,
                        C16: C16,
                        C17: C17,
                        C18: C18,
                        C19: C19,
                        C20: C20,
                        C21: C21,
                        C23: C23,
                        C24: C24,
                        C25: C25,
                        C26: C26,
                        C27: C27,
                        C28: C28,
                        C29: C29,
                        C30: C30,
                        C31: C31,
                        C32: C32,
                        C33: C33,
                        C34: C34,
                        C35: C35,
                        C36: C36,
                        C37: C37,
                        C38: C38,
                        C39: C39
                    },
                    contentType: "application/json;charset=utf-8",
                    async: true,
                    success: function (data) {
                        Modal.alert({
                            msg: data,
                            title: '标题',
                            btnok: '确定',
                            btncl: '取消'
                        });
                        if (data.indexOf("保存成功") >= 0) {
                            $("#保存").addClass('disabled');
                            $("#ReviewBox input,select").attr("disabled", "disabled");
                            window.isconfirm = 1;
                        }
                    },
                    failure: function (data) {
                        Modal.alert({
                            msg: '请求失败！' + "\n",
                            title: '标题',
                            btnok: '确定',
                            btncl: '取消'
                        });
                    }
                });
            });

            $(document).on("click", "#刷新", function () {
                if (typeof(window.isconfirm) == "undefined" || !window.isconfirm) {
                    Modal.confirm({
                        msg: "当前数据未保存!" + "\n" + "确认刷新？"
                    })
                        .on(function (e) {
                            if (e)window.location.reload();
                            else return;
                        });
                } else {
                    window.location.reload();
                }
            });
        });
    </script>
<?php endif; ?>
</body>
</html>
