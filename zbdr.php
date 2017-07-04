<?php
require_once 'include.php';
checkUrl();
checkLogined();
checkPurview(isset($_SESSION['Q961']) ? $_SESSION['Q961'] : 0);

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
	$filter .= "AND (convert(char(7),CAST ( 月度质量记录.月份+'-01' AS datetime ),120) ='{$_REQUEST['yf']}')";
}
if (isset($_REQUEST['cq']) && $_REQUEST['cq']) {
	if ($_REQUEST['cq'] != 'null') {
		$filter .= " AND 厂区.厂区名称= '{$_REQUEST['cq']}'";
	} else {
		$filter .= " AND 月度质量记录.单位 IS NULL";
	}

}

$sql = "SELECT
  月度质量记录.序号 ,  月度质量记录.废品损失金额 ,  月度质量记录.主营业务收入 ,  月度质量记录.主营业务废品率 ,  月度质量记录.主营业务废品率目标值 ,
  月度质量记录.内废吨位 ,  月度质量记录.外废吨位 ,  月度质量记录.入库吨位 ,  月度质量记录.内废率目标 ,  月度质量记录.内废率 ,
  月度质量记录.外废率目标 ,  月度质量记录.外废率 ,  月度质量记录.综废率目标 ,  月度质量记录.综合废品率 ,  月度质量记录.吨废品损失 ,
  月度质量记录.索赔损失金额 ,  月度质量记录.吨索赔损失 ,  月度质量记录.主营业务索赔率目标值含废品买断 ,  月度质量记录.主营业务索赔率含废品买断 ,
  厂区.厂区名称 AS 单位,
  月度质量记录.月份 ,  月度质量记录.索赔损失金额纯三包 ,  月度质量记录.主营业务索赔率目标值纯三包 ,  月度质量记录.主营业务索赔率纯三包 ,
  CAST ( 月度质量记录.月份+'-01' AS datetime ) 年月
FROM
  月度质量记录
  LEFT OUTER JOIN 厂区 ON 厂区.厂区编号=月度质量记录.单位 WHERE 1=1
 {$filter}
ORDER BY 月度质量记录.月份 DESC,月度质量记录.单位 ";
$totalPage = ceil(getResultNum($sql) / $pageSize);
if ($page >= $totalPage) {
	$page = $totalPage;
}

$query = "SELECT TOP {$pageSize}  月度质量记录.序号 ,  月度质量记录.废品损失金额 ,  月度质量记录.主营业务收入 ,  月度质量记录.主营业务废品率 ,  月度质量记录.主营业务废品率目标值 ,
  月度质量记录.内废吨位 ,  月度质量记录.外废吨位 ,  月度质量记录.入库吨位 ,  月度质量记录.内废率目标 ,  月度质量记录.内废率 ,
  月度质量记录.外废率目标 ,  月度质量记录.外废率 ,  月度质量记录.综废率目标 ,  月度质量记录.综合废品率 ,  月度质量记录.吨废品损失 ,
  月度质量记录.索赔损失金额 ,  月度质量记录.吨索赔损失 ,  月度质量记录.主营业务索赔率目标值含废品买断 ,  月度质量记录.主营业务索赔率含废品买断 ,
  厂区.厂区名称 AS 单位,
  月度质量记录.月份 ,  月度质量记录.索赔损失金额纯三包 ,  月度质量记录.主营业务索赔率目标值纯三包 ,  月度质量记录.主营业务索赔率纯三包 ,
  CAST ( 月度质量记录.月份+'-01' AS datetime ) 年月
FROM
  月度质量记录
  LEFT OUTER JOIN 厂区 ON 厂区.厂区编号=月度质量记录.单位 WHERE 1=1
  {$filter} AND  月度质量记录.序号 NOT IN (
  SELECT TOP " .( (($page - 1) * $pageSize)>0?(($page - 1) * $pageSize):0) . " 月度质量记录.序号 FROM
  月度质量记录
  LEFT OUTER JOIN 厂区 ON 厂区.厂区编号=月度质量记录.单位 WHERE 1=1
  {$filter}  ORDER BY 月度质量记录.月份 DESC,月度质量记录.单位
  )  ORDER BY 月度质量记录.月份 DESC,月度质量记录.单位 ";

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
    <!--<link href="vendor/dataTables/css/dataTable.css" rel="stylesheet"/>-->
    <link href="vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="css/zysrfpljk.css">

    <script src="vendor/pace/pace.min.js"></script>
    <script src="vendor/jquery/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="jquery.liveeditor.min.js"></script>
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
                    <li class="active">质量指标记录</li>
                </ol>
                <h1 class="page-header">质量指标记录</h1>


                <?php if ($_SESSION['Q961'] == 2 || $_SESSION['Q961'] == 1): ?>
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
                            <form action="doUpload.php" method="post" enctype="multipart/form-data" id="form_u"
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
                            <a href="质量指标记录导入模板.xlsx" style="text-decoration: none;">模板文件下载</a>
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
                                <td><label for="厂区" style="float: right;">&nbsp;&nbsp;厂&nbsp;&nbsp;&nbsp;区：
                                        &nbsp;</label></td>
                                <td>
                                    <select name="cq" id="厂区" form="form">
                                        <option value=""></option>
                                        <?php
$sqlcq = "SELECT 厂区.厂区名称 FROM 月度质量记录 LEFT OUTER JOIN 厂区 ON 厂区.厂区编号=月度质量记录.单位 ORDER BY 厂区.厂区编号";
$cqs = array_column_unique(fetchAll($sqlcq), '厂区名称');
foreach ($cqs as $k => $v) {
	echo "<option value=\"" . (trim($v) ? trim($v) : 'null') . "\">" . (trim($v) ? trim($v) : 'null') . "</option>";
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
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed" id="dataTable"
                               style="background-color: white;width: 2500px;">
                            <thead style="color: #1a1a1a;">
                            <tr>
                                <th name="C0"><input id="checkAll" type="checkbox" /></th><th  >序号</th>
                                <th name="月份">月份</th>
                                <th name="单位">单位</th>
                                <th name="废品损失金额" style="background-color: #f5e79e;">废品损失<br>(万元)</th>
                                <th name="主营业务收入" style="background-color: #f5e79e;">主营业务收入<br>(万元)</th>
                                <th name="主营业务废品率目标值" style="background-color: #a9acb1;">主营业务<br>废品率<br>目标值</th>
                                <th name="主营业务废品率" style="background-color: #FF8000;">主营业务<br>废品率</th>
                                <th name="内废吨位" style="background-color: #727cb6">内废吨位</th>
                                <th name="外废吨位" style="background-color: #727cb6">外废吨位</th>
                                <th name="入库吨位" style="background-color: #727cb6">入库吨位</th>
                                <th name="内废率目标" style="background-color: #a9acb1;">内废率<br>目标</th>
                                <th name="内废率" style="background-color: #FF8000;">内废率</th>
                                <th name="外废率目标" style="background-color: #a9acb1;">外废率<br>目标</th>
                                <th name="外废率" style="background-color: #FF8000;">外废率</th>
                                <th name="综废率目标" style="background-color: #a9acb1;">综废率<br>目标</th>
                                <th name="综合废品率" style="background-color: #FF8000;">综合废品率</th>
                                <th name="索赔损失金额" style="background-color: #f5e79e">索赔损失<br>(万元)</th>
                                <th name="吨废品损失" style="background-color: #FF8000;">吨废品损失<br>(万元)</th>
                                <th name="吨索赔损失" style="background-color: #FF8000;">吨索赔损失<br>(万元)</th>
                                <th name="主营业务索赔率目标值含废品买断" style="background-color: #a9acb1;">主营业务<br>索赔率目标值<br>(含废品买断)
                                </th>
                                <th name="主营业务索赔率含废品买断" style="background-color: #FF8000;">主营业务<br>索赔率<br>(含废品买断)</th>
                                <th name="索赔损失金额" style="background-color: #f5e79e">索赔损失<br>(纯三包)</th>
                                <th name="主营业务索赔率目标值纯三包" style="background-color: #a9acb1;">主营业务<br>索赔率目标值<br>(纯三包)</th>
                                <th name="主营业务索赔率纯三包" style="background-color: #FF8000;">主营业务<br>索赔率<br>(纯三包)</th>
                            </tr>
                            </thead>

                            <tbody style="color: #1a1a1a;">
                            <?php $rowIndex = 0;
foreach (array_group_by($res, '月份') as $key => $val) {
	foreach ($val as $k => $v) {
		?>

                                    <tr row="<?php echo $rowIndex;
		$rowIndex += 1; ?>">
                                        <th><input type="checkbox" class="deletetr"></th>
                                        <th class="xh" ><?php echo $v['序号']; ?></th>
                                        <th class="yf"><?php echo $v['月份']; ?></th>
                                        <th class="dw"><?php echo trim($v['单位']); ?></th>
                                        <td><?php echo trim($v['废品损失金额']); ?></td>
                                        <td><?php echo trim($v['主营业务收入']); ?></td>
                                        <td style="background-color: #dbdbdb;"><?php echo $v['主营业务废品率目标值'] ? sprintf('%.2f', $v['主营业务废品率目标值'] * 100) . "%" : null; ?></td>
                                        <th <?php if ($v['主营业务废品率目标值'] && $v['主营业务废品率'] > $v['主营业务废品率目标值']) {
			echo "style='background-color:red;color:black;'";
		}?>><?php echo $v['主营业务废品率'] ? sprintf('%.2f', $v['主营业务废品率'] * 100) . "%" : null; ?></th>
                                        <td><?php echo $v['内废吨位']; ?></td>
                                        <td><?php echo $v['外废吨位']; ?></td>
                                        <td><?php echo $v['入库吨位']; ?></td>
                                        <td style="background-color: #dbdbdb;"><?php echo $v['内废率目标'] ? sprintf('%.2f', $v['内废率目标'] * 100) . "%" : null; ?></td>
                                        <th <?php if ($v['内废率目标'] && $v['内废率'] > $v['内废率目标']) {
			echo "style='background-color:red;color:black;'";
		}?>><?php echo $v['内废率'] ? sprintf('%.2f', $v['内废率'] * 100) . "%" : null; ?></th>
                                        <td style="background-color: #dbdbdb;"><?php echo $v['外废率目标'] ? sprintf('%.2f', $v['外废率目标'] * 100) . "%" : null; ?></td>
                                        <th <?php if ($v['外废率目标'] && $v['外废率'] > $v['外废率目标']) {
			echo "style='background-color:red;color:black;'";
		}?>><?php echo $v['外废率'] ? sprintf('%.2f', $v['外废率'] * 100) . "%" : null; ?></th>
                                        <td style="background-color: #dbdbdb;"><?php echo $v['综废率目标'] ? sprintf('%.2f', $v['综废率目标'] * 100) . "%" : null; ?></td>
                                        <th <?php if ($v['综废率目标'] && $v['综合废品率'] > $v['综废率目标']) {
			echo "style='background-color:red;color:black;'";
		}?>><?php echo $v['综合废品率'] ? sprintf('%.2f', $v['综合废品率'] * 100) . "%" : null; ?></th>
                                        <td><?php echo $v['索赔损失金额']; ?></td>
                                        <th style="background-color: #dbdbdb;"><?php echo $v['吨废品损失']; ?></th>
                                        <th style="background-color: #dbdbdb;"><?php echo $v['吨索赔损失']; ?></th>
                                        <td style="background-color: #dbdbdb;"><?php echo $v['主营业务索赔率目标值含废品买断'] ? sprintf('%.2f', $v['主营业务索赔率目标值含废品买断'] * 100) . "%" : null; ?></td>
                                        <th><?php echo $v['主营业务索赔率含废品买断'] ? sprintf('%.2f', $v['主营业务索赔率含废品买断'] * 100) . "%" : null; ?></th>
                                        <td><?php echo $v['索赔损失金额纯三包']; ?></td>
                                        <td style="background-color: #dbdbdb;"><?php echo $v['主营业务索赔率目标值纯三包'] ? sprintf('%.2f', $v['主营业务索赔率目标值纯三包'] * 100) . "%" : null; ?></td>
                                        <th <?php if ($v['主营业务索赔率目标值纯三包'] && $v['主营业务索赔率纯三包'] > $v['主营业务索赔率目标值纯三包']) {
			echo "style='background-color:red;color:black;'";
		}?>><?php echo $v['主营业务索赔率纯三包'] ? sprintf('%.2f', $v['主营业务索赔率纯三包'] * 100) . "%" : null; ?></th>
                                    </tr>

                                <?php }
}?>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <?php $where = "";
if (isset($_REQUEST['yf']) && $_REQUEST['yf']) {
	$where .= "&yf={$_REQUEST['yf']}";
}
if (isset($_REQUEST['cq']) && $_REQUEST['cq']) {
	$where .= "&cq={$_REQUEST['cq']}";
}
echo showPage2($page, $totalPage, $where);?>
                    </div>
                <?php endif;?>
                <?php if (!$res): ?>
                    <div><h5>未查询到满足条件的记录！</h5></div>
                <?php endif;?>

                <div id="ajaxResponses"></div>
            </div>
        </div>
        <a href="#" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i
                class="fa fa-angle-up"></i></a>
    </div>

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
                    var data = "row=" + row.attr("row") + "&序号=" + row.children('.xh').html()  + "&" + $.liveeditor.serialize($('td', row), headers);
                    $.ajax({
                        type: "POST",
                        url: "doAction.php?act=change",
                        data: data,
                        async: false,
                        success: function (data) {
                            if (data == 1) {
                                Modal.alert({msg: '修改成功!', title: '标题', btnok: '确定', btncl: '取消'});
                                $.liveeditor.reset($("#dataTable tbody td"));
                            } else {
                                //alert(data);
                                Modal.alert({msg: '修改失败!', title: '标题', btnok: '确定', btncl: '取消'});
                                //$("#ajaxResponses").html(data);
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

    <script type="text/javascript" src="js/alertrewrite.js"></script>
    <script src="vendor/jquery/jquery-migrate-1.1.0.min.js"></script>
    <script src="vendor/jquery-ui/ui/minified/jquery-ui.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--[if lt IE 9]>
    <script src="vendor/crossbrowserjs/html5shiv.js"></script>
    <script src="vendor/crossbrowserjs/respond.min.js"></script>
    <script src="vendor/crossbrowserjs/excanvas.min.js"></script>
    <![endif]-->
    <!--<script src="vendor/dataTables/js/jquery.dataTables.js"></script>-->
    <script src="vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script src="vendor/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
    <script src="vendor/js/apps.min.js"></script>

    <script>
        $(document).ready(function () {
            App.init();
        });
        <?php if (isset($_REQUEST['cq'])): ?>
        $("#厂区").val("<?php echo $_REQUEST['cq']; ?>");
        <?php endif;?>
        $("#zbdr").addClass("active");
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
    <script>
        $("#deleteButton").click(function () {
            $("input[class='deletetr']:checked").each(function () {
                n = $(this).parents("tr").index() + 1;
                $.ajax({
                    type: "GET",
                    url: "doAction.php",
                    data: {
                        act: 'delete',
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
