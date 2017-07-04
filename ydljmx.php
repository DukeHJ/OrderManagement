<?php
require_once 'include.php';
checkUrl();
checkLogined();
checkPurview(isset($_SESSION['Q958']) ? $_SESSION['Q958'] : 0);

require_once 'vendor/PHPExcel/Classes/PHPExcel.php';
require_once 'vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';
require_once 'vendor/PHPExcel/Classes/PHPExcel/Reader/Excel5.php';
$pageSize = 15;

$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
if ($page < 1 || $page == null || !is_numeric($page)) {
	$page = 1;
}

$filter = "";
if (isset($_REQUEST['yf']) && $_REQUEST['yf']) {
	$filter .= "AND (convert(char(7),CAST (   月度零件废品明细.月度+'-01' AS datetime ),120) ='{$_REQUEST['yf']}')";
}
if (isset($_REQUEST['cq']) && $_REQUEST['cq']) {
	$filter .= " AND   厂区.厂区名称='{$_REQUEST['cq']}' ";
}

$sql = "SELECT
  月度零件废品明细.零件图号 ,  月度零件废品明细.铸件编号 ,  月度零件废品明细.铸件名称 ,  月度零件废品明细.产品重要度 ,  月度零件废品明细.铸件种类 ,
  月度零件废品明细.总成分类 ,  月度零件废品明细.产品系列 ,  月度零件废品明细.整车分类 ,  月度零件废品明细.废品原因 ,  月度零件废品明细.废品影响因素 ,
  月度零件废品明细.用户 ,  ( SELECT 厂区名称 FROM 厂区 WHERE 厂区编号=月度零件废品明细.生产单位) 生产单位 ,  月度零件废品明细.重量 ,  月度零件废品明细.入库件数 ,  月度零件废品明细.内废件数 ,
  月度零件废品明细.外废件数 ,  月度零件废品明细.总废品件数 ,  月度零件废品明细.入库吨位 ,  月度零件废品明细.内废吨位 ,  月度零件废品明细.外废吨位 ,
  月度零件废品明细.总废品吨位 ,  月度零件废品明细.制表人 ,  月度零件废品明细.内废率 ,  月度零件废品明细.外废率 ,  月度零件废品明细.综合废品率 ,
  月度零件废品明细.月度 ,  月度零件废品明细.传参 ,  月度零件废品明细.制表时间 ,  月度零件废品明细.审核人 ,  月度零件废品明细.审核时间 ,
  月度零件废品明细.序号 ,  月度零件废品明细.内废主要原因 ,  月度零件废品明细.外废主要原因 ,  月度零件废品明细.备注
FROM
  月度零件废品明细
  LEFT OUTER JOIN 厂区 ON 厂区.厂区编号=月度零件废品明细.生产单位  WHERE 1=1
  {$filter}  ORDER BY 月度零件废品明细.月度 DESC,厂区.厂区编号";
$totalPage = ceil(getResultNum($sql) / $pageSize);
if ($page >= $totalPage) {
	$page = $totalPage;
}

$query = "SELECT TOP {$pageSize}  月度零件废品明细.零件图号 ,  月度零件废品明细.铸件编号 ,  月度零件废品明细.铸件名称 ,  月度零件废品明细.产品重要度 ,  月度零件废品明细.铸件种类 ,
  月度零件废品明细.总成分类 ,  月度零件废品明细.产品系列 ,  月度零件废品明细.整车分类 ,  月度零件废品明细.废品原因 ,  月度零件废品明细.废品影响因素 ,
  月度零件废品明细.用户 ,  ( SELECT 厂区名称 FROM 厂区 WHERE 厂区编号=月度零件废品明细.生产单位) 生产单位 ,  月度零件废品明细.重量 ,  月度零件废品明细.入库件数 ,  月度零件废品明细.内废件数 ,
  月度零件废品明细.外废件数 ,  月度零件废品明细.总废品件数 ,  月度零件废品明细.入库吨位 ,  月度零件废品明细.内废吨位 ,  月度零件废品明细.外废吨位 ,
  月度零件废品明细.总废品吨位 ,  月度零件废品明细.制表人 ,  月度零件废品明细.内废率 ,  月度零件废品明细.外废率 ,  月度零件废品明细.综合废品率 ,
  月度零件废品明细.月度 ,  月度零件废品明细.传参 ,  月度零件废品明细.制表时间 ,  月度零件废品明细.审核人 ,  月度零件废品明细.审核时间 ,
  月度零件废品明细.序号 ,  月度零件废品明细.内废主要原因 ,  月度零件废品明细.外废主要原因 ,  月度零件废品明细.备注
FROM
  月度零件废品明细
  LEFT OUTER JOIN 厂区 ON 厂区.厂区编号=月度零件废品明细.生产单位 WHERE 1=1
  {$filter} AND  月度零件废品明细.月度+月度零件废品明细.生产单位+月度零件废品明细.零件图号 NOT IN (
  SELECT TOP " . ( (($page - 1) * $pageSize)>0?(($page - 1) * $pageSize):0) . " 月度零件废品明细.月度+月度零件废品明细.生产单位+月度零件废品明细.零件图号 FROM
  月度零件废品明细
  LEFT OUTER JOIN 厂区 ON 厂区.厂区编号=月度零件废品明细.生产单位 WHERE 1=1
  {$filter}  ORDER BY 月度零件废品明细.月度 DESC,厂区.厂区编号
  )  ORDER BY 月度零件废品明细.月度 DESC,厂区.厂区编号 ";
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
    <title>华铸ERP系统质量报表</title>
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
    <link rel="stylesheet" type="text/css" href="css/zysrfpljk.css">


    <script src="vendor/pace/pace.min.js"></script>
    <script src="vendor/jquery/jquery-1.9.1.min.js"></script>

</head>
<body>
<?php include_once 'template/pageloader.php';?>

<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
    <?php include_once 'template/header.php';?>
    <?php include_once 'template/sidebar.php';?>

    <div id="content" class="content">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb pull-right">
                    <li><a href="#">首页</a></li>
                    <li><a href="#">质量报表</a></li>
                    <li class="active">月度零件明细</li>
                </ol>
                <h1 class="page-header">月度零件明细</h1>


                <?php if ($_SESSION['Q958'] == 2 || $_SESSION['Q958'] == 1): ?>
                    <div>
                        <button type="button" class="btn-inverse btn btn-sm" id="deleteButton">删除</button>
                        ||
                        <!-- <button type="button" class="btn-inverse btn btn-sm" id="addButton">添加</button> -->
                        <button type="button" class="btn-inverse btn btn-sm" id="saveButton">保存</button>
                        ||
                        <button type="button" class="btn-inverse btn btn-sm" id="reloadButton">刷新</button>
                        ||
                        <button type="button" class="btn-inverse btn btn-sm" onclick="$('#file_u').toggle();">导入Excel
                        </button>

                        <div id="file_u"
                             style="padding: 10px;border-radius: 4px;width:250px;display: none;">
                            <form action="doUpload2.php" method="post" enctype="multipart/form-data" id="form_u"
                                  style="background-color: white;padding: 2px">
                                <table>
                                    <tr>
                                        <td><input type="file" name="_f"></td>
                                        <td>
                                            <button type="submit" id="f_u" class="btn btn-sm btn-white "
                                                    aria-label="Left Align">
                                            <span class="glyphicon glyphicon glyphicon-upload"
                                                  aria-hidden="true"></span>
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                            <a href="月度零件明细导入模板.xlsx" style="text-decoration: none;">模板文件下载</a>
                        </div>
                    </div>
                <?php endif;?>


                <div class="schBox">
                    <form action="<?php print $_SERVER['PHP_SELF']?>" id="form">
                        <table>
                            <tr>
                                <td><label for="月份" style="float: right;">&nbsp;&nbsp;月&nbsp;&nbsp;&nbsp;份：
                                        &nbsp;</label></td>
                                <td>
                                    <input type="datetime" id="月份" name="yf"
                                        <?php if (isset($_REQUEST['yf'])) {
	echo "value=\"" . $_REQUEST['yf'] . "\"";
} /*else {
	                                            echo "value=\"" . date('Y-m', time()) . "\"";
*/?>
                                    >
                                </td>
                                <td><label for="厂区" style="float: right;">生产单位：
                                        &nbsp;</label></td>
                                <td>
                                    <select name="cq" id="厂区" form="form">
                                        <option value=""></option>
                                        <?php
$sqlcq = "SELECT 厂区.厂区名称  FROM 月度零件废品明细 LEFT OUTER JOIN 厂区 ON 厂区.厂区编号=月度零件废品明细.生产单位 ORDER BY 厂区.厂区编号";
$cqs = array_column_unique(fetchAll($sqlcq), '厂区名称');
foreach ($cqs as $k => $v) {
	echo "<option value=\"" . trim($v) . "\">" . trim($v) . "</option>";
}
?>
                                    </select>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-sm btn-inverse "
                                            aria-label="Left Align">
                                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-inverse"
                                            aria-label="Left Align"
                                            onClick="$('#月份').val('');$('#厂区').val('');">
                                        <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

                <?php if ($res): ?>
                    <div class="table-responsive"   >
                        <table class="table table-bordered table-condensed text-center" id="dataTable"
                               style="background-color: white;color: #1a1a1a;">
                            <thead>
                            <tr>
                                <th name="C0"><input id="checkAll" type="checkbox" /></th><th style="display: none;">序号</th>
                                <th name="月度" style="background-color: #f4ca67">月度</th>
                                <th name="生产单位" style="background-color: #f4ca67">生产单位</th>
                                <th name="零件图号" style="background-color:#5ed2d2">零件号</th>
                                <th name="铸件名称" style="background-color:#5ed2d2">零件名称</th>
                                <th name="重量" style="background-color:#5ed2d2">单重(Kg)</th>
                                <th name="入库件数" style="background-color: #f4ca67">入库数<br>(件)</th>
                                <th name="内废件数" style="background-color: #f4ca67">内废数<br>(件)</th>
                                <th name="外废件数" style="background-color: #f4ca67">外废数<br>(件)</th>
                                <th name="总废品件数" style="background-color: #f4ca67">总废品数<br>(件)</th>
                                <th name="入库吨位" style="background-color: #79d294">入库重<br>(吨)</th>
                                <th name="内废吨位" style="background-color: #79d294">内废重<br>(吨)</th>
                                <th name="外废吨位" style="background-color: #79d294">外废重<br>(吨)</th>
                                <th name="总废品吨位" style="background-color: #79d294">总废品重<br>(吨)</th>
                                <th name="内废率" style="background-color: #f4ca67">内废率</th>
                                <th name="外废率" style="background-color: #f4ca67">外废率</th>
                                <th name="综合废品率" style="background-color: #f4ca67">综废率</th>
                                <th name="内废主要原因" style="background-color:#5ed2d2">主要内废原因</th>
                                <th name="外废主要原因" style="background-color:#5ed2d2">主要外废原因</th>
                                <th name="备注" style="background-color:#5ed2d2">备注</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $rowIndex = 0;
foreach (array_group_by($res, '月度') as $key => $val) {
	foreach ($val as $k => $v) {
		?>

                                    <tr row="<?php echo $rowIndex;
		$rowIndex += 1; ?>">
                                        <th><input type="checkbox" class="deletetr"></th><th class="xh" style="display: none;"><?php echo $v['序号']; ?></th>
                                        <th><?php echo $v['月度']; ?></th>
                                        <th><?php echo trim($v['生产单位']); ?></th>
                                        <td style="background-color:#5ed2d2"><?php echo trim($v['零件图号']); ?></td>
                                        <td style="background-color:#5ed2d2"><?php echo trim($v['铸件名称']); ?></td>
                                        <td style="background-color:#5ed2d2"><?php echo $v['重量'] ? sprintf('%.2f', $v['重量']) : null; ?></td>
                                        <td><?php echo $v['入库件数'] ? sprintf('%d', $v['入库件数']) : null; ?></td>
                                        <td><?php echo $v['内废件数'] ? sprintf('%d', $v['内废件数']) : null; ?></td>
                                        <td><?php echo $v['外废件数'] ? sprintf('%d', $v['外废件数']) : null; ?></td>
                                        <td><?php echo $v['总废品件数'] ? sprintf('%d', $v['总废品件数']) : null; ?></td>
                                        <td style="background-color: #79d294"><?php echo $v['入库吨位'] ? sprintf('%.2f', $v['入库吨位']) : null; ?></td>
                                        <td style="background-color: #79d294"><?php echo $v['内废吨位'] ? sprintf('%.2f', $v['内废吨位']) : null; ?></td>
                                        <td style="background-color: #79d294"><?php echo $v['外废吨位'] ? sprintf('%.2f', $v['外废吨位']) : null; ?></td>
                                        <td style="background-color: #79d294"><?php echo $v['总废品吨位'] ? sprintf('%.2f', $v['总废品吨位']) : null; ?></td>
                                        <td><?php echo $v['内废率'] ? sprintf('%.2f', $v['内废率'] * 100) . "%" : null; ?></td>
                                        <td><?php echo $v['外废率'] ? sprintf('%.2f', $v['外废率'] * 100) . "%" : null; ?></td>
                                        <td><?php echo $v['综合废品率'] ? sprintf('%.2f', $v['综合废品率'] * 100) . "%" : null; ?></td>
                                        <td style="text-align: left!important;background-color: #5ed2d2"><?php echo trim($v['内废主要原因']); ?></td>
                                        <td style="text-align: left!important;background-color:#5ed2d2"><?php echo trim($v['外废主要原因']); ?></td>
                                        <td style="background-color:#5ed2d2"><?php echo trim($v['备注']); ?></td>
                                    </tr>

                                <?php }
}?>
                           </tbody>
                        </table>

                    </div>
                    <div><?php $where = "";
if (isset($_REQUEST['yf']) && $_REQUEST['yf']) {
	$where .= "&yf={$_REQUEST['yf']}";
}
if (isset($_REQUEST['cq']) && $_REQUEST['cq']) {
	$where .= "&cq={$_REQUEST['cq']}";
}
echo showPage2($page, $totalPage, $where);?></div>
                <?php endif;?>
                <?php if (!$res): ?>
                    <div><h5>未查询到满足条件的记录！</h5></div>
                <?php endif;?>
            </div>
        </div>
    </div>
    <a href="#" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i
            class="fa fa-angle-up"></i></a>
</div>
<script type="text/javascript" src="jquery.liveeditor.min.js"></script>
<script src="vendor/jquery/jquery-migrate-1.1.0.min.js"></script>
<script src="vendor/jquery-ui/ui/minified/jquery-ui.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--[if lt IE 9]>
<script src="vendor/crossbrowserjs/html5shiv.js"></script>
<script src="vendor/crossbrowserjs/respond.min.js"></script>
<script src="vendor/crossbrowserjs/excanvas.min.js"></script>
<![endif]-->
<script src="vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script src="vendor/slimscroll/jquery.slimscroll.min.js"></script>
<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="vendor/js/apps.min.js"></script>
<script src="js/alertrewrite.js"></script>
<script src="js/common.js"></script>
<script>
    $(document).ready(function () {
        App.init();
    });
    <?php if (isset($_REQUEST['cq'])): ?>
    $("#厂区").val("<?php echo $_REQUEST['cq']; ?>");
    <?php endif;?>
    $("#ydljmx").addClass("active");
</script>
<script>
    $(document).ready(function () {
        $("#search").click(function () {
            $.ajax({
                type: "GET",
                url: "doAction.php?act=ydljmx&year=" + encodeURI($("#year").val()) + "&changqu=" + encodeURI($("#changqu").val()),
                dataType: "html",
                async: false,
                success: function (data) {
                    $("#searchResult").html(data);
                },
                error: function (jqXHR) {
                    alert("发生错误:" + jqXHR.status);
                }
            });
        });
    });
    $(document).ready(function () {
        $("#clear").click(function () {
            $("#changqu").val('');
        });
    });

</script>
<script>
    $(document).ready(function () {
        $('#月份').datetimepicker({
            language: 'ch',
            format: 'yyyy-mm',
            autoclose: true,
            startView: 'year',
            minView: 'year',
            maxView: 'decade'
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#dataTable tbody td").liveeditor({
            editingCss: 'editing',

            // Scroll to focused editor
            onEditorFocused: function () {
                var $window = $(window);
                var $body = $('html, body');
                var elem = $(this);
                var elemTop = elem.offset().top;
                var elemLeft = elem.offset().left;
                var windowWidth = $window.width();
                var windowHeight = $window.height();
                var docViewTop = $window.scrollTop();
                var docViewLeft = $window.scrollLeft();
                var scrollVertical = (elemTop + elem.height() > docViewTop + windowHeight) || (elemTop < docViewTop);
                var scrollHorizontal = (elemLeft + elem.width() > docViewLeft + windowWidth) || (elemLeft < docViewLeft);
                if (scrollVertical && scrollHorizontal) {
                    //Scroll diagonally
                    $body.stop()
                        .animate({
                            scrollTop: (elemTop - windowHeight / 2) + 'px',
                            scrollLeft: (elemLeft - windowWidth / 2) + 'px'
                        }, 'fast');
                } else if (scrollVertical) {
                    //Scroll vertically
                    $body.stop()
                        .animate({
                            scrollTop: (elemTop - windowHeight / 2) + 'px'
                        }, 'fast');
                } else {
                    //Scroll horizontally
                    $body.stop()
                        .animate({
                            scrollLeft: (elemLeft - windowWidth / 2) + 'px'
                        }, 'fast');
                }
            },

            //Track changes on row level
            onChanged: function () {
                var row = $(this).closest('tr');
                if ($('.liveeditor-changed', row).length > 0)
                    row.addClass('changed');
                else
                    row.removeClass('changed');
            }
        });

        //Save changes
        $('#saveButton').click(function () {
            $.liveeditor.closeEditor($("#dataTable tbody td"));
            var headers = $('#dataTable thead tr th');
            $('#dataTable tbody tr.changed').each(function () {
                var row = $(this);
                var data = "row=" + row.attr("row") + "&序号=" + row.children('.xh').html() + "&" + $.liveeditor.serialize($('td', row), headers);
                $.ajax({
                    type: "POST",
                    url: "doAction.php?act=change2",
                    async: false,
                    data: data,
                    success: function (data) {
                        if (data == 1) {
                            Modal.alert({msg: '修改成功!', title: '标题', btnok: '确定', btncl: '取消'});
                            $.liveeditor.reset($("#dataTable tbody td"));
                        } else {
                            Modal.alert({msg: '修改失败!', title: '标题', btnok: '确定', btncl: '取消'});
                        }
                    },
                    error: function () {
                        console.log("Failed to save changes");
                    }
                });
            });
        });
    });

</script>
<script>
    $("#deleteButton").click(function () {
        $("input[class='deletetr']:checked").each(function () {
            n = $(this).parents("tr").index() + 1;
            $.ajax({
                type: "GET",
                url: "doAction.php",
                data: {
                    act: 'delete_ydljmx',
                    xh: $("table#dataTable").find("tr:eq(" + n + ")").find(".xh").html()
                },
                contentType: "application/json;charset=utf-8",
                async: false,
                success: function (data) {
                    if (data == 1) {
                        Modal.alert({msg: '删除成功!', title: '标题', btnok: '确定', btncl: '取消'});
                    } else {
                        Modal.alert({msg: '删除失败!', title: '标题', btnok: '确定', btncl: '取消'});
                    }
                },
                failure: function (data) {
                    alert("请求失败！" + "\n");
                }
            });
            $("table#dataTable").find("tr:eq(" + n + ")").remove();
        });
    });
</script>
<script>
    $("#reloadButton").click(function () {
        window.location.reload();
    });
</script>

<script>
 $(function() {
           $("#checkAll").click(function() {
                $("input[class='deletetr']").attr("checked",this.checked);
            });
            var $subBox = $("input[class='deletetr']");
            $subBox.click(function(){
                $("#checkAll").attr("checked",$subBox.length == $("input[class='deletetr']:checked").length ? true : false);
            });
        });
        </script>
</body>
</html>
