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
    <link rel="stylesheet" type="text/css" href="css/order-review-normal.css">

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
            <li class="active">订单评审(一般)</li>
        </ol>
        <h1 class="page-header">订单评审
            <small>(一般)</small>
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
                                       style="width: 3200px;">
                                    <thead>
                                    <tr>
                                        <td>铸造</td>
                                        <td>加工</td>
                                        <td>新品</td>
                                        <td>特急</td>
                                        <td>客户简称</td>
                                        <td class="col1">订货日期</td>
                                        <td>合同号</td>
                                        <td>合同要求</td>
                                        <td>订单细则号</td>
                                        <td>铸件编号</td>
                                        <td class="col4">产品名称</td>
                                        <td class="col3">铸件描述</td>
                                        <td>材质</td>
                                        <td>参考重量</td>
                                        <td class="col2">加工图号</td>
                                        <td class="col4">加工图号版本</td>
                                        <td class="col1">交货日期</td>
                                        <td class="col4">订货数量</td>
                                        <td class="col1" style="background-color: #CA347D;">生产数量</td>
                                        <td class="col4" style="background-color: #3AC4A6;">备件库库存</td>
                                        <td style="background-color: #3AC4A6;">调出仓库</td>
                                        <td class="col1" style="background-color: #3AC4A6;">调拨数量</td>
                                        <td style="background-color: #3AC4A6;">调入仓库</td>
                                        <td class="col1" style="background-color: #0F82EF;">加工交期</td>
                                        <td style="background-color: #0F82EF;">加工评审结论</td>
                                        <td style="background-color: #0F82EF;">机加工评审</td>
                                        <td class="col1" style="background-color: #0F82EF;">机加工评审时间</td>
                                        <td class="col4" style="background-color: #9F4FAF;">特殊评审</td>
                                        <td class="col1" style="background-color: #9F4FAF;">铸造交期</td>
                                        <td style="background-color: #9F4FAF;">生产部结论</td>
                                        <td style="background-color: #9F4FAF;">生产评审</td>
                                        <td class="col1" style="background-color: #9F4FAF;">生产评审时间</td>
                                        <td class="displaynone">业务部</td>
                                        <td class="displaynone"></td>
                                        <td class="displaynone"></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php include 'SearchOrderReviewNormalwork.php'; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (1): ?>
                    <div class="tab-pane fade in " id="workzone">
                        <div id="ReviewBox" class="row">
                            <div class="col-md-12 ui-sorttable">
                                <div class="btn-group">
                                    <button type="button" id="save" class="btn btn-sm btn-inverse">保存</button>
                                    <button type="button" id="delete" class="btn btn-sm btn-inverse">删除</button>
                                    <button type="button" id="reload" class="btn btn-sm btn-inverse">刷新</button>
                                </div>
                                <div class="table-responsive">
                                    <table id="data-table3"
                                           class="table table-striped table-bordered table-condensed text-center"
                                           style="width: 3250px;">
                                        <thead>
                                        <tr>
                                            <td class="col4">#</td>
                                            <td class="col4">铸造</td>
                                            <td class="col4">加工</td>
                                            <td class="col4">新品</td>
                                            <td class="col4">特急</td>
                                            <td class="col2">客户简称</td>
                                            <td class="col1">订货日期</td>
                                            <td class="col1">合同号</td>
                                            <td class="col3">合同要求</td>
                                            <td class="col1">订单细则号</td>
                                            <td class="col1">铸件编号</td>
                                            <td class="col1">产品名称</td>
                                            <td class="col3">铸件描述</td>
                                            <td class="col1">材质</td>
                                            <td class="col4">参考重量</td>
                                            <td class="col2">加工图号</td>
                                            <td class="col1">加工图号版本</td>
                                            <td class="col1">交货日期</td>
                                            <td class="col1">订货数量</td>
                                            <td class="col1" style="background-color: #CA347D;">生产数量</td>
                                            <td class="col1" style="background-color: #3AC4A6;">备件库库存</td>
                                            <td class="col2" style="background-color: #3AC4A6;">调出仓库</td>
                                            <td class="col1" style="background-color: #3AC4A6;">调拨数量</td>
                                            <td class="col2" style="background-color: #3AC4A6;">调入仓库</td>
                                            <td class="col1" style="background-color: #0F82EF;">加工交期</td>
                                            <td class="col3" style="background-color: #0F82EF;">加工评审结论</td>
                                            <td class="col1" style="background-color: #0F82EF;">机加工评审</td>
                                            <td class="col1" style="background-color: #0F82EF;">机加工评审时间</td>
                                            <td class="col1" style="background-color: #9F4FAF;">特殊评审</td>
                                            <td class="col1" style="background-color: #9F4FAF;">铸造交期</td>
                                            <td class="col3" style="background-color: #9F4FAF;">生产部结论</td>
                                            <td class="col1" style="background-color: #9F4FAF;">生产评审</td>
                                            <td class="col1" style="background-color: #9F4FAF;">生产评审时间</td>
                                            <td style="display: none;"></td>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endif; ?>

                <div class="tab-pane fade in " id="tasklist">
                    <div class="row">
                        <div class="col-md-12 ui-sorttable">
                            <div class="table-responsive">
                                <table id="data-table2" class="table table-striped table-bordered  text-center"
                                       style="width: 1850px;">
                                    <thead>
                                    <tr>
                                        <td>铸造</td>
                                        <td>加工</td>
                                        <td>新品</td>
                                        <td>特急</td>
                                        <td class="col2">合同号</td>
                                        <td class="col1">客户简称</td>
                                        <td class="col1">订货日期</td>
                                        <td>生产方式</td>
                                        <td class="col1">交货日期</td>
                                        <td>合同要求</td>
                                        <td class="col4">业务员</td>
                                        <td>铸件名称</td>
                                        <td>铸件描述</td>
                                        <td>材质</td>
                                        <td>参考重量</td>
                                        <td>加工图号</td>
                                        <td>加工图号版本</td>
                                        <td>订货数量</td>
                                        <td>库存</td>
                                        <td>订单细则号</td>
                                        <td>铸件编号</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php include 'SearchOrderReviewNormaltask.php'; ?>
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

<script type="text/javascript" src="js/myfunction.js"></script>
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
    $("#订单管理,#订单评审一般").addClass("active");
</script>

<?php if (1): ?>
    <script>
        var ck = "<option value=''></option>" + gf_execsql2("SELECT 仓库编号 ,  仓库名称 ,  存放物料类别 FROM 仓库", '仓库编号', '仓库名称', '存放物料类别');
        $(".dcck").append(ck);
        $(".drck").append(ck);
        $("#data-table tbody tr").each(function () {
            $(this).find(".dcck").val($(this).find(".trdcck_").html());
            $(this).find(".drck").val($(this).find(".trdrck_").html());
        });
        $("#data-table tbody input,#data-table tbody select").attr("disabled", "disabled");
    </script>

    <script>
        var timeout;
        $("#data-table tbody tr").bind('touchstart mousedown', function () {
            var thistr = $(this);
            timeout = setTimeout(function () {
                thistr.find("input,select").removeAttr("disabled");
                if (thistr.find(".trywb").html()) {
                    thistr.find(".scsl").attr("disabled", "disabled");
                    thistr.find(".dcck").attr("disabled", "disabled");
                    thistr.find(".dbsl").attr("disabled", "disabled");
                    thistr.find(".drck").attr("disabled", "disabled");
                }
                if (thistr.find(".jjgps").val()) {
                    thistr.find(".jgjq").attr("disabled", "disabled");
                    thistr.find(".jgpsjl").attr("disabled", "disabled");
                }
                if (thistr.find(".scps").val()) {
                    thistr.find(".tsps").attr("disabled", "disabled");
                    thistr.find(".zzjq").attr("disabled", "disabled");
                    thistr.find(".scbjl").attr("disabled", "disabled");
                }

                var C1 = '<tr><td><input class="colck" type="checkbox"  name="deletecheckbox"></td><td>' + thistr.find(".trzz").html() + '</td><td>' + thistr.find(".trjg").html() + '</td><td>' + thistr.find(".trxp").html() + '</td><td>' + thistr.find(".trtj").html() + '</td><td>' + thistr.find(".trkhjc").html() + '</td><td class="col2">' + thistr.find(".trdhrq").html() + '</td><td>' + thistr.find(".trhth").html() + '</td><td>' + thistr.find(".trhtyq").html() + '</td><td>' + thistr.find(".trddxzh").html() + '</td><td>' + thistr.find(".trzjbh").html() + '</td><td>' + thistr.find(".trzjmc").html() + '</td><td>' + thistr.find(".trzjms").html() + '</td><td>' + thistr.find(".trcz").html() + '</td><td>' + thistr.find(".trckzl").html() + '</td><td>' + thistr.find(".trjgth").html() + '</td><td>' + thistr.find(".trjgthbb").html() + '</td><td class="col2">' + thistr.find(".trjhrq").html() + '</td><td>' + thistr.find(".trdhsl").html() + '</td>';

                var C2 = '<td>' + thistr.find(".trscsl").html() + '</td><td>' + thistr.find(".trkc").html() + '</td><td>' + thistr.find(".trdcck").html() + '</td><td>' + thistr.find(".trdbsl").html() + '</td><td>' + thistr.find(".trdrck").html() + '</td><td>' + thistr.find(".trjgjq").html() + '</td><td>' + thistr.find(".trjgpsjl").html() + '</td><td>' + thistr.find(".trjjgps").html() + '</td><td>' + thistr.find(".trjjgpssj").html() + '</td><td>' + thistr.find(".trtsps").html() + '</td><td>' + thistr.find(".trzzjq").html() + '</td><td>' + thistr.find(".trscbjl").html() + '</td><td>' + thistr.find(".trscps").html() + '</td><td>' + thistr.find(".trscpssj").html() + '</td>';
                var C3 = '<td class="displaynone"><input type="text" class="ddxzh" name="ddxzh[]" readonly="readonly" value="' + thistr.find(".trddxzh").html() + '"></td><td class="trdcck_ displaynone">' + thistr.find(".trdcck_").html() + '</td><td class="trdrck_ displaynone">' + thistr.find(".trdrck_").html() + '</td></tr>';

                $("#data-table3 tbody").append(C1 + C2 + C3);
                $("#data-table3 tbody tr").each(function () {
                    $(this).find(".dcck").val($(this).find(".trdcck_").html());
                    $(this).find(".drck").val($(this).find(".trdrck_").html());
                });
                $('#Reviewtabs1 a[href="#workzone"]').tab('show');
                thistr.remove();
            }, 1000);

        });
        $("#data-table tbody tr").bind('touchend mouseup mouseout', function () {
            clearTimeout(timeout);
        });
    </script>

    <script>
        var timeout2;
        $("#data-table2 tbody tr").bind('touchstart mousedown', function () {
            //$("#data-table2 tbody tr").mousedown(function() {
            var thistr = $(this);
            timeout2 = setTimeout(function () {
                var C1 = '<tr><td><input class="colck" type="checkbox"  name="deletecheckbox"></td><td>' + thistr.find(".trzz").html() + '</td><td>' + thistr.find(".trjg").html() + '</td><td>' + thistr.find(".trxp").html() + '</td><td>' + thistr.find(".trtj").html() + '</td><td>' + thistr.find(".trkhjc").html() + '</td><td class="col2">' + thistr.find(".trdhrq").html() + '</td><td>' + thistr.find(".trhth").html() + '</td><td>' + thistr.find(".trhtyq").html() + '</td><td>' + thistr.find(".trddxzh").html() + '</td><td>' + thistr.find(".trzjbh").html() + '</td><td>' + thistr.find(".trzjmc").html() + '</td><td>' + thistr.find(".trzjms").html() + '</td><td>' + thistr.find(".trcz").html() + '</td><td>' + thistr.find(".trckzl").html() + '</td><td>' + thistr.find(".trjgth").html() + '</td><td>' + thistr.find(".trjgthbb").html() + '</td><td class="col2">' + thistr.find(".trjhrq").html() + '</td><td>' + thistr.find(".trdhsl").html() + '</td>';
                var C2 = '<td><input type="text" class="scsl col1" name="scsl[]" onkeyup= "if(!  /(^[1-9]+\d*$)|(^0$)/.test(this.value)){Modal.alert({msg: &apos;生产数量必须为非负整数！&apos;,title: &apos;标题&apos;,btnok: &apos;确定&apos;,btncl:&apos;取消&apos;});this.value=null;}"></td><td>' + thistr.find(".trkc").html() + '</td>';
                var ck = "<option value=''></option>" + gf_execsql2("SELECT 仓库编号 ,  仓库名称 ,  存放物料类别 FROM 仓库", '仓库编号', '仓库名称', '存放物料类别');
                var C4 = '<td><select class="dcck col2"  name="dcck[]"><option></option>' + ck + '</select></td>';
                var C5 = '<td><input type="text" class="dbsl col1" name="dbsl[]" onkeyup= "if(!  /(^[1-9]+\d*$)|(^0$)/.test(this.value)){Modal.alert({msg: &apos;调拨数量必须为非负整数！&apos;,title: &apos;标题&apos;,btnok: &apos;确定&apos;,btncl:&apos;取消&apos;});this.value=null;}"></td>';
                var C6 = '<td><select class="drck col2"  name="drck[]"><option></option>' + ck + '</select></td>';
                var C7 = '<td><input type="datetime" class="jgjq col2" name="jgjq[]" onClick="laydate({istime: true})"></td>';
                var C8 = '<td><input type="text" class="jgpsjl" name="jgpsjl[]"></td>';
                var C9 = '<td><input type="text" class="jjgps col1" name="jjgps[]" readonly="readonly"></td>';
                var C10 = '<td><input type="datetime" class="jjgpssj col2" name="jjgpssj[]" readonly="readonly"></td>';
                var C11 = '<td><input type="checkbox" class="tsps colck" name="tsps[]" value="0" onclick="this.value=(this.value==0)?1:0"></td>';
                var C12 = '<td><input type="datetime" class="zzjq col2" name="zzjq[]" onClick="laydate({istime: true})"></td>';
                var C13 = '<td><input type="text" class="scbjl" name="scbjl[]"></td>';
                var C14 = '<td><input type="text" class="scps col1" name="scps[]" readonly="readonly"></td>';
                var C15 = '<td><input type="datetime" class="scpssj col2" name="scpssj[]" readonly="readonly"></td><td class="displaynone"><input type="text" class="ddxzh" name="ddxzh[]" readonly="readonly" value="' + thistr.find(".trddxzh").html() + '"></td></tr>';

                $("#data-table3 tbody").append(C1 + C2 + C4 + C5 + C6 + C7 + C8 + C9 + C10 + C11 + C12 + C13 + C14 + C15);
                $('#Reviewtabs1 a[href="#workzone"]').tab('show');
                thistr.remove();
            }, 1000);
        });
        $("#data-table2 tbody tr").bind('touchend mouseup mouseout', function () {
            clearTimeout(timeout2);
        });
    </script>

    <script>
        $(document).ready(function () {
            $(document).on("click", "#save", function () {
                var wztable = $(this).parents(".ui-sorttable");
                var ddxzh = wztable.find("input[name='ddxzh[]']"), scsl = wztable.find("input[name='scsl[]']"), dcck = wztable.find("select[name='dcck[]']"), dbsl = wztable.find("input[name='dbsl[]']"), drck = wztable.find("select[name='drck[]']"), jgjq = wztable.find("input[name='jgjq[]']"), jgpsjl = wztable.find("input[name='jgpsjl[]']"), jjgps = wztable.find("input[name='jjgps[]']"), jjgpssj = wztable.find("input[name='jjgpssj[]']"), tsps = wztable.find("input[name='tsps[]']"), zzjq = wztable.find("input[name='zzjq[]']"), scbjl = wztable.find("input[name='scbjl[]']"), scps = wztable.find("input[name='scps[]']"), scpssj = wztable.find("input[name='scpssj[]']");
                var Nform = new Array;
                for (var i = 0, j = 0; i < ddxzh.length; i++) {
                    if (!isNull(ddxzh[i].value)) {
                        continue;
                    }
                    Nform[j] = "'" + ddxzh[i].value + "','" + scsl[i].value + "','" + dcck[i].value + "','" + dbsl[i].value + "','" + drck[i].value + "','" + jgjq[i].value + "','" + jgpsjl[i].value + "','" + jjgps[i].value + "','" + jjgpssj[i].value + "','" + tsps[i].value + "','" + zzjq[i].value + "','" + scbjl[i].value + "','" + scps[i].value + "','" + scpssj[i].value + "'";
                    j++;
                }

                $.ajax({
                    type: "GET",
                    url: "doAction.php",
                    data: {act: 'insertRN', Nform: Nform},
                    contentType: "application/json;charset=utf-8",
                    async: true,
                    success: function (data) {
                        Modal.alert({msg: data, title: '标题', btnok: '确定', btncl: '取消'});
                        if (data.indexOf("保存成功") >= 0) {
                            $("#save,#delete").addClass('disabled');
                            window.isconfirm = 1;
                        }
                    },
                    failure: function (data) {
                        Modal.alert({msg: '请求失败！' + "\n", title: '标题', btnok: '确定', btncl: '取消'});
                    }
                });
            });


            $(document).on("click", "#reload", function () {
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
            $(document).on("click", "#delete", function () {
                $("input[name='deletecheckbox']:checked").each(function () {
                    n = $(this).parents("tr").index() + 1;
                    $("table#data-table3").find("tr:eq(" + n + ")").remove();
                });
            });

        });
    </script>

    <script>
        $(document).ready(function () {
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
            $(document).on("click", ".jjgps", function () {
                var dqtr = $(this).parents("tr");
                if (!dqtr.find(".jjgps").val()) {
                    Modal.alert({
                        msg: '<form class="form-horizontal"><div class="form-group"><label for="职工姓名" class="col-md-4 control-lable">职工姓名</label><div class="col-md-8"><input type="text" class="form-control" id="职工姓名" name="职工姓名"></div></div><div class="form-group"><label for="认证密码" class="col-md-4 control-lable">认证密码</label><div class="col-md-8"><input type="password" class="form-control" id="认证密码" name="认证密码"></div></div></form>',
                        title: '数字签名',
                        btnok: '确定',
                        btncl: '取消'
                    });
                    $(".ok").click(function () {
                        var dqmodal = $(this).parents(".modal-content");
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
                                    Modal.alert({msg: data, title: '标题', btnok: '确定', btncl: '取消'});
                                }
                                if (data == 0) {
                                    Modal.alert({msg: '登录名或密码错误！', title: '标题', btnok: '确定', btncl: '取消'});
                                    return;
                                }
                                if (data == 1) {
                                    dqtr.find(".jjgps").val(dqmodal.find("#职工姓名").val());
                                    dqtr.find(".jjgpssj").val(now);
                                    dqtr.find('.jgjq, .jgpsjl').attr("disabled", "disabled");
                                }
                            },
                            error: function (jqXHR) {
                                Modal.alert({msg: '发生错误:' + jqXHR.status, title: '标题', btnok: '确定', btncl: '取消'
                                });
                            }
                        });
                    });
                } else {
                    Modal.alert({
                        msg: '<form class="form-horizontal"><div class="form-group"><label for="职工姓名" class="col-md-4 control-lable">职工姓名</label><div class="col-md-8"><input type="text" class="form-control" id="职工姓名" name="职工姓名" disabled="disabled" value="' + $(this).val() + '"></div></div><div class="form-group"><label for="认证密码" class="col-md-4 control-lable">认证密码</label><div class="col-md-8"><input type="password" class="form-control" id="认证密码" name="认证密码"></div></div></form>',
                        title: '反签名',
                        btnok: '确定',
                        btncl: '取消'
                    });
                    $(".ok").click(function () {
                        var dqmodal = $(this).parents(".modal-content");
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
                                    Modal.alert({msg: data, title: '标题', btnok: '确定', btncl: '取消'});
                                }
                                if (data == 0) {
                                    Modal.alert({msg: '登录名或密码错误！', title: '标题', btnok: '确定', btncl: '取消'});
                                    return;
                                }
                                if (data == 1) {
                                    dqtr.find(".jjgps").val('');
                                    dqtr.find(".jjgpssj").val('');
                                    dqtr.find('.jgjq, .jgpsjl').removeAttr("disabled");
                                }
                            },
                            error: function (jqXHR) {
                                Modal.alert({msg: '发生错误:' + jqXHR.status, title: '标题', btnok: '确定', btncl: '取消'});
                            }
                        });
                    });
                }
            });
            $(document).on("click", ".scps", function () {
                var dqtr = $(this).parents("tr");
                if (!dqtr.find(".scps").val()) {
                    Modal.alert({
                        msg: '<form class="form-horizontal"><div class="form-group"><label for="职工姓名" class="col-md-4 control-lable">职工姓名</label><div class="col-md-8"><input type="text" class="form-control" id="职工姓名" name="职工姓名"></div></div><div class="form-group"><label for="认证密码" class="col-md-4 control-lable">认证密码</label><div class="col-md-8"><input type="password" class="form-control" id="认证密码" name="认证密码"></div></div></form>',
                        title: '数字签名',
                        btnok: '确定',
                        btncl: '取消'
                    });
                    $(".ok").click(function () {
                        var dqmodal = $(this).parents(".modal-content");
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
                                    Modal.alert({msg: data, title: '标题', btnok: '确定', btncl: '取消'});
                                }
                                if (data == 0) {
                                    Modal.alert({msg: '登录名或密码错误！', title: '标题', btnok: '确定', btncl: '取消'});
                                    return;
                                }
                                if (data == 1) {
                                    dqtr.find(".scps").val(dqmodal.find("#职工姓名").val());
                                    dqtr.find(".scpssj").val(now);
                                    dqtr.find('.scbjl, .zzjq, .tsps').attr("disabled", "disabled");
                                }
                            },
                            error: function (jqXHR) {
                                Modal.alert({msg: '发生错误:' + jqXHR.status, title: '标题', btnok: '确定', btncl: '取消'});
                            }
                        });
                    });
                } else {
                    Modal.alert({
                        msg: '<form class="form-horizontal"><div class="form-group"><label for="职工姓名" class="col-md-4 control-lable">职工姓名</label><div class="col-md-8"><input type="text" class="form-control" id="职工姓名" name="职工姓名" disabled="disabled" value="' + $(this).val() + '"></div></div><div class="form-group"><label for="认证密码" class="col-md-4 control-lable">认证密码</label><div class="col-md-8"><input type="password" class="form-control" id="认证密码" name="认证密码"></div></div></form>',
                        title: '反签名',
                        btnok: '确定',
                        btncl: '取消'
                    });
                    $(".ok").click(function () {
                        var dqmodal = $(this).parents(".modal-content");
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
                                    Modal.alert({msg: data, title: '标题', btnok: '确定', btncl: '取消'});
                                }
                                if (data == 0) {
                                    Modal.alert({msg: '登录名或密码错误！', title: '标题', btnok: '确定', btncl: '取消'});
                                    return;
                                }
                                if (data == 1) {
                                    dqtr.find(".scps").val('');
                                    dqtr.find(".scpssj").val('');
                                    dqtr.find('.scbjl, .zzjq, .tsps').removeAttr("disabled");
                                }
                            },
                            error: function (jqXHR) {
                                Modal.alert({msg: '发生错误:' + jqXHR.status, title: '标题', btnok: '确定', btncl: '取消'});
                            }
                        });
                    });
                }
            });
        });
    </script>
<?php endif; ?>
</body>
</html>
