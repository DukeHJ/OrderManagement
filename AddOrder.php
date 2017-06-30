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
    <link href="vendor/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/add-order.css">

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
            <li class="active">订单录入</li>
        </ol>
        <h1 class="page-header">订单录入</h1>

        <div class="btn-group">
            <button type="button" class="btn btn-success" id="savezb">提交</button>
            <button type="button" class="btn btn-success " id="renewzb">重新开单</button>
        </div>

        <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#dingdanzhubiao" data-toggle="tab">订单主表</a></li>
            <li><a href="#dingdanxize" data-toggle="tab">订单细则</a></li>
            <li><a href="#fujiafeiyong" data-toggle="tab">附加费用</a></li>
        </ul>

        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active " id="dingdanzhubiao">
                <div class="table-responsive">
                    <table id="ddzhubiao" class="table  table-bordered" style="width:1000px;">
                        <tr>
                            <td><span class="identity">订单编号:</span></td>
                            <td><input class="form-control identity right" type="text" id="订单编号" maxlength="10"></td>
                            <td>内部合同号:</td>
                            <td><input type="text" class="form-control right" id="内部合同号" maxlength="25"></td>
                            <td>签订合同号:</td>
                            <td><input type="text" class="form-control right" id="签订合同号" maxlength="25"></td>
                            <td>订单来源:</td>
                            <td><select id="订单来源" class="form-control right">
                                    <option value=""></option>
                                    <option value="电话记录">电话记录</option>
                                    <option value="附合同订单">附合同订单</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>运费承担:</td>
                            <td><select id="运费承担" class="form-control right">
                                    <option value=""></option>
                                    <option value="我方">我方承担运费</option>
                                    <option value="客户">客户承担运费</option>
                                </select></td>
                            <td>客户:</td>
                            <td><select id="客户" class="form-control right">
                                    <option value=''></option>
                                    <?php $sqlkh = "SELECT 客户.客户,  客户.客户类别 FROM 客户 where 客户.关闭业务 is null or 客户.关闭业务=0";
                                    $kh = fetchAll($sqlkh);
                                    foreach ($kh as $key => $val) {
                                        echo "<option value='" . $val['客户'] . "'>" . $val['客户类别'] . '&nbsp;&nbsp;&nbsp;' . $val['客户'] . "</option>";
                                    }
                                    ?>

                                </select></td>
                            <td>交易币种:</td>
                            <td><select id="交易币种" class="form-control right">
                                    <option value="人民币">人民币</option>
                                    <option value="美元">美元</option>
                                </select></td>
                            <td>汇率:</td>
                            <td><input class="form-control right readonly" type="number" step="0.01" id="汇率"></td>
                        </tr>
                        <tr>
                            <td>订货日期:</td>
                            <td><input type="datetime" class="form-control right" id="订货日期"
                                       onClick="laydate({istime: true, format: 'YYYY-MM-DD'})"></td>
                            <td>下单日期:</td>
                            <td><input type="datetime" class="form-control right" id="下单日期"
                                       onClick="laydate({istime: true, format: 'YYYY-MM-DD'})"></td>
                            <td>下单人:</td>
                            <td><input type="text" class="form-control right" id="下单人" maxlength="10"></td>
                        </tr>
                        <tr>
                            <td>订货项数:</td>
                            <td><input class="form-control right readonly" type="number" id="订货项数" disabled="disabled">
                            </td>
                            <td>订货费用:</td>
                            <td><input class="form-control right readonly" type="number" id="订货费用" disabled="disabled">
                            </td>
                            <td>附加费用:</td>
                            <td><input class="form-control right readonly" type="number" id="附加费用" disabled="disabled">
                            </td>
                            <td>应收金额:</td>
                            <td><input class="form-control right readonly" type="number" id="应收金额" disabled="disabled">
                            </td>
                        </tr>
                        <tr>
                            <td>接单员:</td>
                            <td><select class="form-control right" id="接单员">
                                    <option value=''></option>
                                    <?php $sqljdy = "SELECT 系统角色.职工号 , 职工信息.职工姓名 ,  部门.部门名称 FROM 系统角色
 LEFT OUTER JOIN 职工信息  ON 系统角色.职工号 = 职工信息.职工编号 
 LEFT OUTER JOIN 部门 ON 部门.部门编号 = 职工信息.部门编号 
 WHERE 系统角色.系统角色='接单员'";
                                    $jdy = fetchAll($sqljdy);
                                    foreach ($jdy as $key => $val) {
                                        echo "<option value='" . $val['职工号'] . "'>" . $val['职工姓名'] . "</option>";
                                    }
                                    ?>
                                </select></td>
                            <td>跟单员:</td>
                            <td><select class="form-control right" id="跟单员">
                                    <option value=''></option>
                                    <?php $sqlgdy = "SELECT 系统角色.职工号 , 职工信息.职工姓名 ,  部门.部门名称 FROM 系统角色
 LEFT OUTER JOIN 职工信息  ON 系统角色.职工号 = 职工信息.职工编号 
 LEFT OUTER JOIN 部门 ON 部门.部门编号 = 职工信息.部门编号 
 WHERE 系统角色.系统角色='跟单员'";
                                    $gdy = fetchAll($sqlgdy);
                                    foreach ($gdy as $key => $val) {
                                        echo "<option value='" . $val['职工号'] . "'>" . $val['职工姓名'] . "</option>";
                                    }
                                    ?>

                                </select></td>
                            <td rowspan="2">订单描述:</td>
                            <td colspan="3" rowspan="2" class="right"><textarea id="订单描述" class="form-control"
                                                                                rows="3"></textarea></td>
                        </tr>
                        <tr>
                            <td>订单处置:</td>
                            <td><select class="right" id="订单处置">
                                    <option value="0">待签-可先做工艺</option>
                                    <option value="1" selected="selected">投产-允许生产</option>
                                    <option value="2">暂停</option>
                                    <option value="3">作废</option>
                                    <option value="4">询价-不做工艺</option>
                                </select></td>
                            <td>合同链接</td>
                            <td><input class="right" type="file" name="file" id="合同链接"></td>
                        </tr>
                        <tr>
                            <td style="color: #F2D60C;">客户产品要求:</td>
                            <td colspan="3" class="right"><textarea id="客户产品要求" class="form-control"
                                                                    rows="3"></textarea></td>
                            <td>公司承诺:</td>
                            <td colspan="3"><textarea id="公司承诺" class="form-control" rows="3"></textarea></td>
                        </tr>
                        <tr>
                            <td>法律法规:</td>
                            <td colspan="3" class="right"><textarea id="法律法规" class="form-control" rows="3"></textarea>
                            </td>
                            <td>备注:</td>
                            <td colspan="3" class="right"><textarea id="备注" class="form-control" rows="3"></textarea>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="table-responsive">
                    <table id="" class="table table-condensed table-bordered">
                        <tr>
                            <td>登记员</td>
                            <td><input id="登记员" class="right2 form-control" type="text" readonly="readonly"></td>
                            <td><input id="登记时间" class="right form-control" type="datetime" readonly="readonly"></td>
                            <td>备件订单</td>
                            <td><select id="备件订单" class="form-control" style="width:60px">
                                    <option value="0"></option>
                                    <option value="1">是</option>
                                </select></td>
                            <td>校核员</td>
                            <td><input id="校核员" class="right2 form-control" type="text" readonly="readonly"></td>
                            <td><input id="校核时间" class="right form-control" type="datetime" readonly="readonly"></td>
                            <td><input type="text" id="校核" class="right2 form-control"
                                       style="background-color:white;color:red;border:0px;font-size: 20px"
                                       readonly="readonly"></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade in " id="dingdanxize">
                <div class="btn-group">
                    <button type="button" class="btn btn-success" id="addxz">添加细则</button>
                    <button type="button" class="btn btn-success" id="deletexz">删除细则</button>
                </div>
                <div class="table-responsive">
                    <table id="ddxize" class="table table-hover table-bordered" style="width:3300px;">
                        <thead>
                        <tr>
                            <td class="xh">#</td>
                            <td>序号</td>
                            <td class="identity">订单细则号</td>
                            <td>客户行号</td>
                            <td class="identity">铸造</td>
                            <td class="identity">加工</td>
                            <td>新品</td>
                            <td>特急</td>
                            <td class="identity">状态</td>
                            <td>订单形式</td>
                            <td>材质</td>
                            <td>铸件编号</td>
                            <td>铸件名称</td>
                            <td>零件图号</td>
                            <td>铸件描述</td>
                            <td>原生产车间</td>
                            <td>生产方式</td>
                            <td>毛坯图号</td>
                            <td>毛坯图号版本</td>
                            <td>加工图号</td>
                            <td>加工图号版本</td>
                            <td>订货数量</td>
                            <td>重量形式</td>
                            <td>铸件参考重量</td>
                            <td>订单单量</td>
                            <td>订单总重</td>
                            <td>价格形式</td>
                            <td>铸件参考单价</td>
                            <td>重量单价</td>
                            <td>单价件价</td>
                            <td>铸件金额</td>
                            <td>加工件价</td>
                            <td>加工金额</td>
                            <td>细则总价</td>
                            <td>交货日期</td>
                            <td>商标</td>
                            <td>合同要求(质检/报告等)</td>
                            <td>要求PT探伤数量</td>
                            <td>要求RT探伤数量</td>
                            <td>探伤要求等级</td>
                            <td>包装箱每箱件数</td>
                            <td>包装箱规格</td>
                            <td>备注</td>
                            <td>发货结束</td>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade in" id="fujiafeiyong">
                <div class="btn-group">
                    <button type="button" class="btn btn-success " id="addfyxz">添加细则</button>
                    <button type="button" class="btn btn-success " id="deletefyxz">删除细则</button>
                </div>
                <div class="table-responsive">
                    <table id="ddfjfy" class="table table-hover table-bordered" style="width:650px;">
                        <tr>
                            <td style="width:40px">#</td>
                            <td style="width:40px">序&nbsp;号</td>
                            <td>订单编号</td>
                            <td>费用名</td>
                            <td>金额</td>
                            <td>备注</td>
                        </tr>
                    </table>
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

<script type="text/javascript" src="vendor/AjaxFileUpload/jquery.ajaxfileupload.js"></script>
<script type="text/javascript" src="vendor/bootstrap-select/dist/js/bootstrap-select.js"></script>


<script type="text/javascript" src="js/myfunction.js"></script>
<script type="text/javascript" src="js/localtime.js"></script>
<script type="text/javascript" src="vendor/laydate/laydate.js"></script>


<script>
    $(document).ready(function () {
        App.init();
    });
    $("#订单管理,#订单录入").addClass("active");
</script>

<script type="text/javascript">
    $(document).ready(function () {
        var user = "<?php echo $_SESSION['username']; ?>";
        var mytoday = yyyy + "-" + mm + "-" + dd;
        var yy = mytoday.substring(2, 4);
        var thisdate = yy + mm;
        $("#订货日期").val(mytoday);
        $("#汇率").val('1.00');
        $("#锁定").val('0');
        var ddzdy = gf_pyzm(user).substring(0, 2);
        var ddcount = Number(gf_execsql("select count(*) from 订单 where left(订单编号,6)='" + ddzdy + thisdate + "'")) + 1;
        var ddlsh = formatDigits(ddcount, 3);
        $("#订单编号").val(ddzdy + thisdate + ddlsh);
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        var xuhao = 1;
        var fyxuhao = 1;
        $("#savezb").click(function () {
            var notnull = "订单编号,签订合同号,客户,跟单员";
            if (!cons_notnull(notnull)) return;

            var dinghuofy = 0;
            var fujiafy = 0;
            var yingshouje = 0;

            if (!CheckBH($("#订单编号").val()) && isNull($("#订单编号").val())) {
                Modal.alert({msg: '订单编号只能由数字和英文字母组成!', title: '标题', btnok: '确定', btncl: '取消'});
                $("#订单编号").val('');
                return;
            }

            var ddxzh = $("input[name='ddxzh[]']"), khhh = $("input[name='khhh[]']"), zz = $("input[name='zz[]']"), jg = $("input[name='jg[]']"), xp = $("input[name='xp[]']"), tj = $("input[name='tj[]']"), zt = $("select[name='zt[]']"), ddxs = $("select[name='ddxs[]']"), zjbh = $("select[name='zjbh[]']"), ysccj = $("select[name='ysccj[]']"), scfs = $("select[name='scfs[]']"), dhsl = $("input[name='dhsl[]']"), zlxs = $("select[name='zlxs[]']"), dddl = $("input[name='dddl[]']"), jgxs = $("select[name='jgxs[]']"), ddzldj = $("input[name='ddzldj[]']"), dddjjj = $("input[name='dddjjj[]']"), zjje = $("input[name='zjje[]']"), jgjj = $("input[name='jgjj[]']"), xzzj = $("input[name='xzzj[]']"), jhrq = $("input[name='jhrq[]']"), sb = $("input[name='sb[]']"), yqptsl = $("input[name='yqptsl[]']"), yqrtsl = $("input[name='yqrtsl[]']"), tsyqdj = $("input[name='tsyqdj[]']"), bzxjs = $("input[name='bzxjs[]']"), bzxgg = $("input[name='bzxgg[]']"), bz = $("input[name='bz[]']"), fhjs = $("input[name='fhjs[]']"), htyqz = $("input[name='htyqz[]']");

            var fyddbh = $("input[name='fyddbh[]']"), fyffy = $("select[name='fyffy[]']"), fyje = $("input[name='fyje[]']"), fybz = $("input[name='fybz[]']");

            var Nformxz = new Array;
            var Nformfy = new Array;
            var tjz = new Array;
            for (var i = 0, j = 0; i < ddxzh.length; i++) {
                if (!isNull(ddxzh[i].value)) {
                    Modal.alert({msg: '订单细则号不能为空！', title: '标题', btnok: '确定', btncl: '取消'});
                    return;
                }
                if (!CheckBH(ddxzh[i].value) && isNull(ddxzh[i].value)) {
                    Modal.alert({msg: '订单细则号只能由数字和英文字母组成!', title: '标题', btnok: '确定', btncl: '取消'});
                    ddxzh[i].value = '';
                    return;
                }
                if (!isNull(zjbh[i].value)) {
                    Modal.alert({msg: '铸件编号不能为空！', title: '标题', btnok: '确定', btncl: '取消'});
                    return;
                }
                if (!isNull(ysccj[i].value)) {
                    Modal.alert({msg: '原生产车间不能为空！', title: '标题', btnok: '确定', btncl: '取消'});
                    return;
                }
                if (!isNull(scfs[i].value)) {
                    Modal.alert({msg: '生产方式不能为空！', title: '标题', btnok: '确定', btncl: '取消'});
                    return;
                }
                if (!isNull(dhsl[i].value)) {
                    Modal.alert({msg: '订货数量不能为空！', title: '标题', btnok: '确定', btncl: '取消'});
                    return;
                }
                if (!isNull(jhrq[i].value)) {
                    Modal.alert({msg: '细则交货日期不能为空！', title: '标题', btnok: '确定', btncl: '取消'});
                    return;
                }
                if (!isNull(htyqz[i].value)) {
                    Modal.alert({msg: '合同要求不能为空！', title: '标题', btnok: '确定', btncl: '取消'});
                    return;
                }

                if (!isNull(tj[i].value)) {
                    tjz[i] = '否';
                }
                if (isNull(tj[i].value)) {
                    tjz[i] = '是';
                }
                Nformxz[j] = "'" + ddxzh[i].value + "','" + khhh[i].value + "','" + zz[i].value + "','" + jg[i].value + "','" + xp[i].value + "','" + tjz[i] + "','" + zt[i].value + "','" + ddxs[i].value + "','" + zjbh[i].value + "','" + ysccj[i].value + "','" + scfs[i].value + "','" + dhsl[i].value + "','" + zlxs[i].value + "','" + dddl[i].value + "','" + jgxs[i].value + "','" + ddzldj[i].value + "','" + dddjjj[i].value + "','" + zjje[i].value + "','" + jgjj[i].value + "','" + xzzj[i].value + "','" + jhrq[i].value + "','" + sb[i].value + "','" + htyqz[i].value + "','" + yqptsl[i].value + "','" + yqrtsl[i].value + "','" + tsyqdj[i].value + "','" + bzxjs[i].value + "','" + bzxgg[i].value + "','" + bz[i].value + "','" + fhjs[i].value + "'";
                dinghuofy += Number(xzzj[i].value);
                j++;
            }
            for (var k = 0, l = 0; k < fyddbh.length; k++) {
                if (!isNull(fyddbh[k].value)) {
                    continue;
                }
                if (!isNull(fyje[k].value)) {
                    Modal.alert({msg: '费用金额不能为空！', title: '标题', btnok: '确定', btncl: '取消'});
                    return;
                }
                Nformfy[l] = "'" + fyffy[k].value + "','" + fyje[k].value + "','" + fybz[k].value + "'";
                fujiafy += Number(fyje[k].value);
                l++;
            }
            yingshouje = Number(fujiafy) + Number(dinghuofy);

            $("#订货项数").val(j);
            $("#订货费用").val(dinghuofy.toFixed(2));
            $("#附加费用").val(fujiafy.toFixed(2));
            $("#应收金额").val(yingshouje.toFixed(2));

            var htlj = $(".合同链接").text();
            htlj = htlj.substring(0, htlj.lastIndexOf(' '));
            var ddzbtj = $("#订单编号").val() + ',' + $("#内部合同号").val() + ',' + $("#签订合同号").val() + ',' + $("#订单来源").val() + ',' + $("#运费承担").val() + ',' + $("#客户").val() + ',' + $("#交易币种").val() + ',' + $("#订货日期").val() + ',' + $("#下单日期").val() + ',' + $("#汇率").val() + ',' + $("#接单员").val() + ',' + $("#跟单员").val() + ',' + $("#下单人").val() + ',' + $("#订单处置").val() + ',' + $("#订单描述").val() + ',' + $("#备注").val() + ',' + $("#客户产品要求").val() + ',' + $("#公司承诺").val() + ',' + $("#法律法规").val() + ',' + htlj + ',' + gf_execsql("SELECT 职工编号 FROM 职工信息 WHERE 职工姓名='" + $("#登记员").val() + "'") + ',' + $("#登记时间").val() + ',' + $("#备件订单").val() + ',' + gf_execsql("SELECT 职工编号 FROM 职工信息 WHERE 职工姓名='" + $("#校核员").val() + "'") + ',' + $("#校核时间").val() + ',' + $("#订货项数").val() + ',' + $("#订货费用").val() + ',' + $("#附加费用").val() + ',' + $("#应收金额").val();

            Modal.confirm({
                msg: "订单提交后不能修改或删除" + "\n" + "确定提交？"
            })
                .on(function (e) {
                    if (e) {
                        $.ajax({
                            type: "GET",
                            url: "doAction.php",
                            data: {
                                act: 'insert_order',
                                ddzbtj: ddzbtj,
                                Nformxz: Nformxz,
                                Nformfy: Nformfy,
                                ddxzs: j,
                                ddfys: l
                            },
                            contentType: "application/json;charset=utf-8",
                            async: true,
                            success: function (data) {
                                Modal.alert({msg: data, title: '标题', btnok: '确定', btncl: '取消'});
                                if (data.indexOf("保存成功") >= 0) {
                                    $("#savezb,#addxz,#addfyxz,#deletexz,#deletefyxz").addClass('disabled');
                                    window.isconfirm = 1;
                                }
                            },
                            failure: function (data) {
                                Modal.alert({msg: '请求失败！' + "\n", title: '标题', btnok: '确定', btncl: '取消'});
                            }
                        });
                    } else {
                        return;
                    }
                });
        });

        $("#renewzb").click(function () {
            if (typeof(window.isconfirm) == "undefined" || !window.isconfirm) {
                Modal.confirm({msg: "当前数据未保存!" + "\n" + "确认刷新？"})
                    .on(function (e) {
                        if (e)window.location.reload();
                        else return;
                    });
            } else {
                window.location.reload();
            }
        });

        $("#addxz").click(function () {
            var chejian = gf_execsql2("SELECT 部门.部门编号 ,  部门.部门名称 ,  部门.备注 ,  部门.厂区 ,  部门.车间 , 部门.车间生产方式 ,  部门.车间代号 FROM 部门 WHERE 部门.车间='1'", '部门编号', '部门名称');
            var caizhi = gf_execsql2("SELECT 材质.材质 ,  材质.执行标准 ,  材质.钢种类别 ,  材质.国别标准 ,  材质.牌号类别 , 材质.材质别名 ,  材质.材质简称 ,  材质.材质代号 FROM 材质 ORDER BY 材质", '材质', '材质', '钢种类别', '牌号类别');
            var C1 = '<tr><td><input class="xh" type="checkbox"  name="deletecheckbox"></td><td>' + xuhao + '</td>';
            var C2 = '<td><input class="ddxzh" type="text" name="ddxzh[]" maxlength="13" placeholder="' + $("#订单编号").val() + 'xxxx' + '"></td>';
            var C3 = '<td><input class="khhh" type="text" name="khhh[]" maxlength="13"></td>';
            var C4 = '<td><input class="zz" type="checkbox"  checked="checked" name="zz[]" value="1" onclick="this.value=(this.value==0)?1:0" ></td>';
            var C5 = '<td><input class="jg" type="checkbox" name="jg[]" value="0" onclick="this.value=(this.value==0)?1:0"></td>';
            var C6 = '<td><input class="xp" type="checkbox" name="xp[]" value="0" onclick="this.value=(this.value==0)?1:0"></td>';
            var C7 = '<td><input class="tj" type="checkbox" name="tj[]" value="0" onclick="this.value=(this.value==0)?1:0"></td>';
            var C8 = '<td><select class="zt" name="zt[]" style="color:red;"><option value="0">代签</option><option value="1"  selected="selected">投产</option><option value="2">暂停</option><option value="3">作废</option></select></td>';
            var C9 = '<td><select class="ddxs" name="ddxs[]"><option value="来模">来模</option><option value="图纸"  selected="selected">图纸</option></select></td>';
            var C10 = '<td><select class="cz"  name="cz[]"><option></option>' + caizhi + '</select></td>';
            var C11 = '<td><select class="zjbh"  name="zjbh[]"><option></option></select></td>';
            var C12 = '<td><input class="zjmc readonly" type="text" name="zjmc[]" readonly="readonly"></td>';
            var C13 = '<td><input class="ljth readonly" type="text" name="ljth[]" readonly="readonly"></td>';
            var C14 = '<td><input class="zjms readonly" type="text" name="zjms[]" readonly="readonly"></td>';
            var C15 = '<td><select class="ysccj" name="ysccj[]"><option value=""></option>' + chejian + ' </select></td>';
            var C16 = '<td><select class="scfs" name="scfs[]"><option value=""></option><option value="低温蜡">低温蜡</option><option value="中温蜡">中温蜡</option><option value="砂铸">砂铸</option><option value="加工">加工</option><option value="外协">外协</option></select></td>';
            var C17 = '<td><input class="mpth readonly" type="text" name="mpth[]" readonly="readonly"></td>';
            var C18 = '<td><input class="mpthbb readonly" type="text" name="mpthbb" readonly="readonly"></td>';
            var C19 = '<td><input class="jgth readonly" type="text" name="jgth[]" readonly="readonly"></td>';
            var C20 = '<td><input class="jgthbb readonly" type="text" name="jgthbb[]" readonly="readonly"></td>';
            var C21 = '<td><input class="dhsl" type="number" name="dhsl[]"></td>';
            var C22 = '<td><select class="zlxs" name="zlxs[]"><option value="工艺重量">工艺重量</option><option value="订货重量" selected="selected">订货重量</option><option value="实磅重量">实磅重量</option></select></td>';
            var C23 = '<td><input class="zjckzl readonly" type="number" name="zjckzl[]" readonly="readonly"></td>';
            var C24 = '<td><input class="dddl" type="number" name="dddl[]" step="0.01"></td>';
            var C25 = '<td><input class="ddzz  readonly" type="number" name="ddzz[]"  readonly="readonly"></td>';
            var C26 = '<td><select class="jgxs" name="jgxs[]"><option value=""></option><option value="单价">公斤价</option><option value="件价">件价</option></select></td>';
            var C27 = '<td><input class="zjckdj readonly" type="number" name="zjckdj[]" readonly="readonly"></td>';
            var C28 = '<td><input class="ddzldj" type="number" name="ddzldj[]" step="0.01"  maxlength="13" readonly="readonly"></td>';
            var C29 = ' <td><input class="dddjjj " type="number" name="dddjjj[]"  step="0.01"  maxlength="13"readonly="readonly"></td>';
            var C30 = '<td><input class="zjje readonly" type="number" name="zjje[]" step="0.01" readonly="readonly"></td>';
            var C31 = '<td><input class="jgjj" type="number" name="jgjj[]" step="0.01" maxlength="13" readonly="readonly"></td>';
            var C32 = '<td><input class="jgje readonly" type="number" name="jgje[]" step="0.01" readonly="readonly"></td>';
            var C33 = '<td><input class="xzzj  readonly" type="number" name="xzzj[]" step="0.01" readonly="readonly"></td>';
            var C34 = '<td><input class="jhrq"  name="jhrq[]" type="datetime" onClick="laydate({istime: true})"></td>';
            var C35 = '<td><input class="sb" type="text" name="sb[]"></td>';
            var C36 = '<td><select class="htyq selectpicker" name="htyq[]" multiple="multiple" size="3"><option value="首件评定">首件评定</option><option value="力学性能">力学性能</option><option value="金相">金相</option><option value="VT">VT</option><option value="尺寸">尺寸</option><option value="RT">RT</option><option value="PT">PT</option><option value="MT">MT</option><option value="UT">UT</option><option value="CMTR">CMTR</option><option value="3.1证书">3.1证书</option><option value="动力平衡">动力平衡</option><option value="水压">水压</option><option value="气压">气压</option><option value="热处理">热处理</option><option value="静平衡">静平衡</option><option value="固溶化">固溶化</option><option value="着色">着色</option><option value="无特殊要求">无特殊要求</option></select><input class="htyqz" name="htyqz[]" type="text" style="display:none;"></td>';
            var C37 = '<td><input class="yqptsl" type="text" name="yqptsl[]" onkeyup= "if(!  /^[0-9]*[1-9][0-9]*$/.test(this.value)){Modal.alert({msg: &apos;要求PT探伤数量必须为正整数！&apos;,title: &apos;标题&apos;,btnok: &apos;确定&apos;,btncl:&apos;取消&apos;});this.value=null;}"></td>';
            var C38 = '<td><input class="yqrtsl" type="text" name="yqrtsl[]" onkeyup= "if(!  /^[0-9]*[1-9][0-9]*$/.test(this.value)){Modal.alert({msg: &apos;要求RT探伤数量必须为正整数！&apos;,title: &apos;标题&apos;,btnok: &apos;确定&apos;,btncl:&apos;取消&apos;});this.value=null;}"></td>';
            var C39 = '<td><input class="tsyqdj" type="text" name="tsyqdj[]"></td>';
            //var C40='<td><input class="tsjssc" type="file" name="tsjssc[]"></td>';
            //var C41='<td><input class="zztzlj" type="file" name="zztzlj[]"></td>';
            //var C42='<td><input class="jgtzlj" type="file" name="jgtzlj[]"></td>';
            var C43 = '<td><input class="bzxjs" type="text" name="bzxjs[]" onkeyup= "if(!  /^[0-9]*[1-9][0-9]*$/.test(this.value)){Modal.alert({msg: &apos;包装箱每箱件数必须为正整数！&apos;,title: &apos;标题&apos;,btnok: &apos;确定&apos;,btncl:&apos;取消&apos;});this.value=null;}"></td>';
            var C44 = '<td><input class="bzxgg" type="text" name="bzxgg[]"></td>';
            var C45 = '<td><input class="bz" type="text" name="bz[]"></td>';
            var C46 = '<td><input class="yfhs readonly" type="number" name="yfhs[]"  readonly="readonly"></td>';
            var C47 = '<td><input class="fhjs" type="checkbox" name="fhjs[]" value="0" onclick="this.value=(this.value==0)?1:0"></td></tr>';
            var jshtml = C1 + C2 + C3 + C4 + C5 + C6 + C7 + C8 + C9 + C10 + C11 + C12 + C13 + C14 + C15 + C16 + C17 + C18 + C19 + C20 + C21 + C22 + C23 + C24 + C25 + C26 + C27 + C28 + C29 + C30 + C31 + C32 + C33 + C34 + C35 + C36 + C37 + C38 + C39 + C43 + C44 + C45 + C47;
            $('#ddxize').append(jshtml);
            xuhao++;
            $('.selectpicker').selectpicker({
                dropupAuto: false,
                size: 4
            });
        });
        $("#addfyxz").click(function () {
            var dmmc = gf_execsql2("SELECT 序号 , 代码 ,  代码名称 ,  代码简称 ,  分类类别 , 示意图 ,  标准 ,  系统分类信息.类别编码 ,  系统分类信息.说明 ,  系统分类信息.所属领域 FROM 系统分类信息 WHERE 系统分类信息.分类类别='订单附加费用'", '代码名称', '代码名称');
            var jshtml = '<tr><td><input type="checkbox" class="xh" name="deletefycheckbox"></td><td class="fyxh">' + fyxuhao + '</td><td><input class="fyddbh readonly" type="text" name="fyddbh[]" readonly="readonly"></td><td><select class="fyffy" name="fyffy[]">' + dmmc + '</select></td><td><input class="fyje" type="number" name="fyje[]"></td><td><input class="fybz" type="text" name="fybz[]"></td></tr>';
            $('#ddfjfy').append(jshtml);
            fyxuhao++;
            var fyddbh = $("#订单编号").val();
            $(".fyddbh").val(fyddbh);
        });

        $("#deletexz").click(function () {
            $("input[name='deletecheckbox']:checked").each(function () {
                n = $(this).parents("tr").index() + 1;
                $("table#ddxize").find("tr:eq(" + n + ")").remove();
            });
        });
        $("#deletefyxz").click(function () {
            $("input[name='deletefycheckbox']:checked").each(function () {
                n = $(this).parents("tr").index();
                $("table#ddfjfy").find("tr:eq(" + n + ")").remove();
            });
        });

        $("#客户").change(function () {
            var jybz = gf_execsql("select 交易币种 from 客户 where 客户='" + $(this).val() + "'");
            $("#交易币种").val(jybz);
        });

        $(document).on("change", ".cz", function () {
            var dqh = $(this).parents('tr');
            dqh.find(".zjmc").val('');
            dqh.find(".zjms").val('');
            dqh.find(".mpth").val('');
            dqh.find(".mpthbb").val('');
            dqh.find(".jgth").val('');
            dqh.find(".jgthbb").val('');
            dqh.find(".zjckzl").val('');
            dqh.find(".zjckdj").val('');
            var caizhi = $(this).val();
            var zjbh = "<option value=''></option>" + gf_execsql2("SELECT 铸件清单.铸件编号 ,  铸件清单.铸件名称 ,  铸件清单.材质 ,  铸件清单.类别 ,  铸件清单.参考重量 , 铸件清单.常用模具 ,  铸件清单.校核人 ,  铸件清单.图号 ,  铸件清单.生产方式 ,  铸件清单.类型 , 铸件清单.图纸版本 ,  铸件清单.铸件描述 ,  铸件清单.客户描述 ,  铸件清单.客户物料号 ,  铸件清单.客户 ,铸件清单.毛坯图号 ,  铸件清单.毛坯图号版本 ,  铸件清单.加工图号版本 ,  铸件清单.加工图号 ,  铸件清单.零件图号 FROM 铸件清单 LEFT OUTER JOIN 客户 ON 客户.客户=铸件清单.客户 WHERE 材质='" + $(this).val() + "' ORDER BY 铸件编号", '铸件编号', '铸件编号', '铸件名称');
            dqh.find(".zjbh option").remove();
            dqh.find(".zjbh").append(zjbh);
        });

        $(document).on("change", ".zjbh", function () {
            var dqh = $(this).parents('tr');
            var zjbh = $(this).val();
            var zjmc = gf_execsql("select 铸件名称 from 铸件清单 where 铸件编号='" + $(this).val() + "' ");
            var ljth = gf_execsql("select 图号 from 铸件清单 where 铸件编号='" + $(this).val() + "' ");
            var zjms = gf_execsql("select 铸件描述 from 铸件清单 where 铸件编号='" + $(this).val() + "' ");
            var mpth = gf_execsql("select 毛坯图号 from 铸件清单 where 铸件编号='" + $(this).val() + "' ");
            var mpthbb = gf_execsql("select 毛坯图号版本 from 铸件清单 where 铸件编号='" + $(this).val() + "' ");
            var jgth = gf_execsql("select 加工图号 from 铸件清单 where 铸件编号='" + $(this).val() + "' ");
            var jgthbb = gf_execsql("select 加工图号版本 from 铸件清单 where 铸件编号='" + $(this).val() + "' ");
            var zjckzl = gf_execsql("select 参考重量 from 铸件清单 where 铸件编号='" + $(this).val() + "' ");
            var zjckdj = gf_execsql("select 参考价格 from 铸件清单 where 铸件编号='" + $(this).val() + "' ");
            dqh.find(".zjmc").val(zjmc);
            dqh.find(".zjms").val(zjms);
            dqh.find(".mpth").val(mpth);
            dqh.find(".mpthbb").val(mpthbb);
            dqh.find(".jgth").val(jgth);
            dqh.find(".jgthbb").val(jgthbb);
            dqh.find(".zjckzl").val(zjckzl);
            dqh.find(".zjckdj").val(zjckdj);
        });

        $(document).on("change", ".ysccj", function () {
            var dqh = $(this).parents('tr');
            var scfs = gf_execsql("select 车间生产方式 from 部门 where 部门编号='" + $(this).val() + "' ");
            dqh.find(".scfs").val(scfs);
        });

        $(document).on("change", ".selectpicker", function () {
            var dqh = $(this).parents('tr');
            var htyqs = $(this).val();
            dqh.find(".htyqz").val(htyqs);
        });

        $(document).on("change", "#汇率", function () {
            var huilv = parseFloat($(this).val()).toFixed(2);
            if (huilv > 0) {
                $(this).val(huilv);
            } else {
                Modal.alert({msg: '汇率必须为正值！', title: '标题', btnok: '确定', btncl: '取消'});
                $(this).val('');
            }
        });

        $(document).on("change", ".fyje", function () {
            var fyje = parseFloat($(this).val()).toFixed(2);
            if (fyje > 0) {
                $(this).val(fyje);
            } else {
                Modal.alert({msg: '所填附加费用必须为正值！', title: '标题', btnok: '确定', btncl: '取消'});
                $(this).val('');
            }
        });

        $(document).on("change", ".jgjj", function () {
            var dqh = $(this).parents('tr');
            var jgjj = $(this).val();
            if (jgjj >= 0) {
                jgjj = parseFloat(jgjj);
                jgjj = jgjj.toFixed(2);
                $(this).val(jgjj);
                var dhsl = dqh.find(".dhsl").val();
                var jgje = (dhsl * jgjj).toFixed(2);
                dqh.find(".jgje").val(jgje);
                var zjje = dqh.find(".zjje").val();
                var xzzj = (Number(jgje) + Number(zjje)).toFixed(2);
                dqh.find(".xzzj").val(xzzj);
            } else {
                Modal.alert({msg: '加工件价不能为负值！', title: '标题', btnok: '确定', btncl: '取消'});
                $(this).val('');
                dqh.find(".jgje").val('');
                dqh.find(".xzzj").val('');
            }
        });

        $(document).on("change", ".dhsl", function () {
            var dqh1 = $(this).parents('tr');
            var dhsl1 = $(this).val();
            if (dhsl1 > 0 && dhsl1 % 1 === 0) {
                dhsl1 = parseInt(dhsl1);
                $(this).val(dhsl1);
                var dddl1 = dqh1.find(".dddl").val();
                var ddzz1 = (dhsl1 * dddl1).toFixed(2);
                dqh1.find(".ddzz").val(ddzz1);
            } else {
                Modal.alert({msg: '订货数量必须为正整数！', title: '标题', btnok: '确定', btncl: '取消'});
                $(this).val('');
                dqh1.find(".ddzz").val('');
                dqh1.find(".zjje").val('');
                dqh1.find(".jgje").val('');
                dqh1.find(".xzzj").val('');
            }
        });
        $(document).on("change", ".dddl", function () {
            var dqh1 = $(this).parents('tr');
            var dddl1 = $(this).val();
            if (dddl1 >= 0) {
                dddl1 = parseFloat(dddl1);
                dddl1 = dddl1.toFixed(2);
                $(this).val(dddl1);
                var dhsl1 = dqh1.find(".dhsl").val();
                var ddzz1 = (dhsl1 * dddl1).toFixed(2);
                dqh1.find(".ddzz").val(ddzz1);
            } else {
                Modal.alert({msg: '订单单量不能为负值！', title: '标题', btnok: '确定', btncl: '取消'});
                $(this).val('');
                dqh1.find(".ddzz").val('');
            }
        });

        $(document).on("change", ".jgxs", function () {
            var dqh = $(this).parents('tr');
            var jgxs = $(this).val();
            if (jgxs == '单价') {
                dqh.find(".jgjj").removeAttr("readonly");
                dqh.find(".ddzldj").removeAttr("readonly");
                dqh.find(".ddzldj").val('');
                dqh.find(".ddzldj").css({"background-color": "white"});
                dqh.find(".zjje").val('');
                dqh.find(".xzzj").val('');
                dqh.find(".dddjjj").val('');
                dqh.find(".dddjjj").attr("readonly", "readonly");
                dqh.find(".dddjjj").css({"background-color": "#e7e7e7"});

                $(document).on("change", ".dhsl", function () {
                    var dqhh = $(this).parents('tr');
                    var dhsl = $(this).val();
                    if (dhsl > 0 && dhsl % 1 === 0) {
                        dhsl = parseInt(dhsl);
                        $(this).val(dhsl);
                        var dddl = dqhh.find(".dddl").val();
                        var ddzz = (dhsl * dddl).toFixed(2);

                        var ddzldj = dqh.find(".ddzldj").val();
                        var zjje = (ddzz * ddzldj).toFixed(2);
                        dqhh.find(".zjje").val(zjje);

                        var jgjj = dqhh.find(".jgjj").val();
                        var jgje = (dhsl * jgjj).toFixed(2);
                        dqhh.find(".jgje").val(jgje);

                        var xzzj = (Number(jgje) + Number(zjje)).toFixed(2);
                        dqhh.find(".xzzj").val(xzzj);
                    }
                });

                $(document).on("change", ".dddl", function () {
                    var dqhh = $(this).parents('tr');
                    var dddl = $(this).val();
                    if (dddl >= 0) {
                        dddl = parseFloat(dddl);
                        dddl = dddl.toFixed(2);
                        $(this).val(dddl);
                        var dhsl = dqhh.find(".dhsl").val();
                        var ddzz = (dhsl * dddl).toFixed(2);
                        var ddzldj = dqhh.find(".ddzldj").val();
                        var zjje = (ddzz * ddzldj).toFixed(2);
                        dqhh.find(".zjje").val(zjje);
                        var jgjj = dqhh.find(".jgjj").val();
                        var jgje = (dhsl * jgjj).toFixed(2);
                        var xzzj = (Number(jgje) + Number(zjje)).toFixed(2);
                        dqhh.find(".xzzj").val(xzzj);
                    } else {
                        dqhh.find(".zjje").val('');
                        dqhh.find(".xzzj").val('');
                    }
                });

                $(document).on("change", ".ddzldj", function () {
                    var dqh = $(this).parents('tr');
                    var ddzldj = $(this).val();
                    if (ddzldj >= 0) {
                        ddzldj = parseFloat(ddzldj);
                        ddzldj = ddzldj.toFixed(2);
                        $(this).val(ddzldj);
                        var dhsl = dqh.find(".dhsl").val();
                        var dddl = dqh.find(".dddl").val();
                        var zjje = (dhsl * dddl * ddzldj).toFixed(2);
                        dqh.find(".zjje").val(zjje);
                        var jgje = dqh.find(".jgje").val();
                        var xzzj = (Number(jgje) + Number(zjje)).toFixed(2);
                        dqh.find(".xzzj").val(xzzj);
                    } else {
                        Modal.alert({
                            msg: '订单重量单价不能为负值！', title: '标题', btnok: '确定', btncl: '取消'
                        });
                        $(this).val('');
                        dqh.find(".xzzj").val('');
                        dqh.find(".zjje").val('');
                    }
                });
            }

            if (jgxs == '件价') {
                dqh.find(".ddzldj").attr("readonly", "readonly");
                dqh.find(".ddzldj").val('');
                dqh.find(".ddzldj").css({"background-color": "#e7e7e7"});
                dqh.find(".dddjjj").removeAttr("readonly");
                dqh.find(".dddjjj").val('');
                dqh.find(".dddjjj").css({"background-color": "white"});
                dqh.find(".jgjj").removeAttr("readonly");
                dqh.find(".zjje").val('');
                dqh.find(".xzzj").val('');

                $(document).on("change", ".dddjjj", function () {
                    var dqh = $(this).parents('tr');
                    var dddjjj = $(this).val();
                    if (dddjjj >= 0) {
                        dddjjj = parseFloat(dddjjj);
                        dddjjj = dddjjj.toFixed(2);
                        $(this).val(dddjjj);
                        var dddl = dqh.find(".dddl").val();
                        var ddzldj = dddjjj / dddl;
                        ddzldj = ddzldj.toFixed(2);
                        dqh.find(".ddzldj").val(ddzldj);
                        var dhsl = dqh.find(".dhsl").val();
                        var zjje = (dddjjj * dhsl).toFixed(2);
                        dqh.find(".zjje").val(zjje);
                        var jgje = dqh.find(".jgje").val();
                        var xzzj = (Number(jgje) + Number(zjje)).toFixed(2);
                        dqh.find(".xzzj").val(xzzj);
                    } else {
                        Modal.alert({msg: '订单单价件价不能为负值！', title: '标题', btnok: '确定', btncl: '取消'});
                        $(this).val('');
                        dqh.find(".ddzldj").val('');
                        dqh.find(".zjje").val('');
                        dqh.find(".xzzj").val('');
                    }
                });

                $(document).on("change", ".dddl", function () {
                    var ddqh = $(this).parents('tr');
                    var dddl = $(this).val();
                    if (dddl >= 0) {
                        dddl = parseFloat(dddl);
                        dddl = dddl.toFixed(2);
                        $(this).val(dddl);
                        var dhsl = ddqh.find(".dhsl").val();
                        var dddjjj = ddqh.find(".dddjjj").val();
                        var ddzldj = (dddjjj / dddl).toFixed(2);
                        ddqh.find(".ddzldj").val(ddzldj);
                    } else {
                        ddqh.find(".ddzldj").val('');
                    }
                });

                $(document).on("change", ".dhsl", function () {
                    var ddqh = $(this).parents('tr');
                    var dhsl = $(this).val();
                    if (dhsl > 0 && dhsl % 1 === 0) {
                        dhsl = parseInt(dhsl);
                        $(this).val(dhsl);
                        var dddl = ddqh.find(".dddl").val();
                        var ddzz = (dhsl * dddl).toFixed(2);
                        ddqh.find(".ddzz").val(ddzz);

                        var dddjjj = ddqh.find(".dddjjj").val();
                        var zjje = (dddjjj * dhsl).toFixed(2);
                        ddqh.find(".zjje").val(zjje);

                        var jgjj = ddqh.find(".jgjj").val();
                        var jgje = (dhsl * jgjj).toFixed(2);
                        ddqh.find(".jgje").val(jgje);

                        var xzzj = (Number(jgje) + Number(zjje)).toFixed(2);
                        ddqh.find(".xzzj").val(xzzj);
                    }
                });
            }
        });

        var interval;

        function applyAjaxFileUpload(element) {
            $(element).AjaxFileUpload({
                action: "uploads/upload.php",
                onChange: function (filename) {
                    var $span = $("<span />")
                        .attr("class", $(this).attr("id"))
                        .text("Uploading")
                        .insertAfter($(this));
                    $(this).remove();
                    interval = window.setInterval(function () {
                        var text = $span.text();
                        if (text.length < 13) {
                            $span.text(text + ".");
                        } else {
                            $span.text("Uploading");
                        }
                    }, 200);
                },
                onComplete: function (filename, response) {
                    window.clearInterval(interval);
                    var $span = $("span." + $(this).attr("id")).text("uploads/" + filename + " "),
                        $fileInput = $("<input />")
                            .attr({
                                type: "file",
                                name: $(this).attr("name"),
                                id: $(this).attr("id")
                            });
                    if (typeof(response.error) === "string") {
                        $span.replaceWith($fileInput);
                        applyAjaxFileUpload($fileInput);
                        alert(response.error);
                        return;
                    }
                    $("<a id='abc' />").attr("href", "#")
                        .text("x")
                        .bind("click", function (e) {
                            $span.replaceWith($fileInput);
                            applyAjaxFileUpload($fileInput);
                        })
                        .appendTo($span);
                }
            });
        }

        applyAjaxFileUpload("#合同链接");
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
        $("#登记员").click(function () {
            if (!$("#登记员").val()) {
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
                                $("#登记员").val(dqmodal.find("#职工姓名").val());
                                $("#登记时间").val(now);
                                $("#签订合同号").attr("disabled", true);
                                $("#运费承担").attr("disabled", true);
                                $("#客户").attr("disabled", true);
                                $("#订货日期").removeAttr("onclick");
                                $("#订货日期").attr("disabled", true);
                                $("#订单描述").attr("disabled", true);
                                $("#订单处置").attr("disabled", true);
                                $("#接单员").attr("disabled", true);
                                $("#备注").attr("disabled", true);
                                $("#合同链接").attr("disabled", true);
                                $("#abc").text('');
                            }
                        },
                        error: function (jqXHR) {
                            Modal.alert({msg: '发生错误:' + jqXHR.status, title: '标题', btnok: '确定', btncl: '取消'});
                        }
                    });
                });
            } else {
                Modal.alert({
                    msg: '<form class="form-horizontal"><div class="form-group"><label for="职工姓名" class="col-md-4 control-lable">职工姓名</label><div class="col-md-8"><input type="text" class="form-control" id="职工姓名" name="职工姓名" disabled="disabled" value="' + $("#登记员").val() + '"></div></div><div class="form-group"><label for="认证密码" class="col-md-4 control-lable">认证密码</label><div class="col-md-8"><input type="password" class="form-control" id="认证密码" name="认证密码"></div></div></form>',
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
                                Modal.alert({
                                    msg: '登录名或密码错误！', title: '标题', btnok: '确定', btncl: '取消'
                                });
                                return;
                            }
                            if (data == 1) {
                                $("#登记员").val('');
                                $("#登记时间").val('');
                                $("#签订合同号").removeAttr("disabled");
                                $("#运费承担").removeAttr("disabled");
                                $("#客户").removeAttr("disabled");
                                $("#订货日期").attr("onclick", "laydate({istime: true, format: 'YYYY-MM-DD'})");
                                $("#订货日期").removeAttr("disabled");
                                $("#订单描述").removeAttr("disabled");
                                $("#订单处置").removeAttr("disabled");
                                $("#接单员").removeAttr("disabled");
                                $("#备注").removeAttr("disabled");
                                $("#合同链接").removeAttr("disabled");
                                $("#abc").text('x');
                            }
                        },
                        error: function (jqXHR) {
                            Modal.alert({
                                msg: '发生错误:' + jqXHR.status, title: '标题', btnok: '确定', btncl: '取消'
                            });
                        }
                    });
                });
            }
        });

        $("#校核员").click(function () {
            if (!$("#校核员").val()) {
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
                                $("#校核员").val(dqmodal.find("#职工姓名").val());
                                $("#校核时间").val(now);
                                $("#锁定").val('1');
                                $("#校核").val('校核');
                            }
                        },
                        error: function (jqXHR) {
                            Modal.alert({msg: '发生错误:' + jqXHR.status, title: '标题', btnok: '确定', btncl: '取消'});
                        }
                    });
                });
            } else {
                Modal.alert({
                    msg: '<form class="form-horizontal"><div class="form-group"><label for="职工姓名" class="col-md-4 control-lable">职工姓名</label><div class="col-md-8"><input type="text" class="form-control" id="职工姓名" name="职工姓名" disabled="disabled" value="' + $("#校核员").val() + '"></div></div><div class="form-group"><label for="认证密码" class="col-md-4 control-lable">认证密码</label><div class="col-md-8"><input type="password" class="form-control" id="认证密码" name="认证密码"></div></div></form>',
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
                                $("#校核员").val('');
                                $("#校核时间").val('');
                                $("#锁定").val('0');
                                $("#校核").val('');
                            }
                        },
                        error: function (jqXHR) {
                            Modal.alert({
                                msg: '发生错误:' + jqXHR.status, title: '标题', btnok: '确定', btncl: '取消'
                            });
                        }
                    });
                });
            }
        });
    });
</script>

</body>
</html>
