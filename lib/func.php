<?php
function order_statistics_query($month = null, $client = null, $contract = null)
{
    $filter = '';
    if ($month) {
        $filter .= " AND CONVERT ( CHAR ( 7 ) , V_订单细则简略视图.订货日期 , 120 )='{$month}' ";
    }
    if ($client) {
        $filter .= " AND V_订单细则简略视图.客户='{$client}'";
    }
    if ($contract) {
        $filter .= " AND 职工信息.职工姓名='{$contract}'";
    }
    $sql = "SELECT
   职工信息.职工姓名 AS 业务员 ,
 V_订单细则简略视图.订货日期 ,
  V_订单细则简略视图.订单编号,
 V_订单细则简略视图.订单细则号,
V_订单细则简略视图.客户,
V_订单细则简略视图.铸件名称,
    CONVERT ( CHAR ( 7 ) , V_订单细则简略视图.订货日期 , 120 ) AS 月份 ,
   SUM(V_订单细则简略视图.订货数量) AS 订货数量 ,
   SUM(V_订单细则简略视图.订货数量*V_订单细则简略视图.细则重量)   AS 订货吨位 ,
  SUM(订单细则.细则金额) AS 订货金额 
FROM
  V_订单细则简略视图  with(nolock) 
  LEFT OUTER JOIN 订单细则 with(nolock)  ON 订单细则.订单细则号=V_订单细则简略视图.订单细则号
LEFT OUTER JOIN 订单 with(nolock)  ON 订单.订单编号=V_订单细则简略视图.订单编号
LEFT OUTER JOIN 职工信息 ON 职工信息.职工编号=订单.业务员
WHERE DATEDIFF(MM,  V_订单细则简略视图.订货日期,getdate())<16   {$filter}
GROUP BY  职工信息.职工姓名,
   CONVERT ( CHAR ( 7 ) , V_订单细则简略视图.订货日期 , 120 ) ,
 V_订单细则简略视图.订货日期 ,
 V_订单细则简略视图.订单编号,
V_订单细则简略视图.订单细则号,
V_订单细则简略视图.客户,
V_订单细则简略视图.铸件名称
ORDER BY  V_订单细则简略视图.订货日期";

    $res = fetchAll($sql);
    $by1 = '业务员';
    $by2 = '客户';
    if (!$contract && $client) {
        $by1 = '客户';
        $by2 = '业务员';
    }

    if ($res) {
        $resg = array_group_by($res, '月份');
        foreach ($resg as $key => $val) {
            echo "<div><h5>{$key}</h5>";
            foreach (array_group_by($val, $by1) as $k1 => $v1) {
                echo "<div><h5>" . trim($v1[0][$by1]) . "</h5> ";
                foreach (array_group_by($v1, $by2) as $k => $v) {
                    echo "<div><h5>{$v[0][$by2]}</h5>";
                    foreach (array_group_by($v, '订单编号') as $k2 => $v2) {
                        echo "<div class='v'><h5>{$v2[0]['订单编号']}" . date('Y-m-d', strtotime($v2[0]['订货日期'])) . "<span class='glyphicon glyphicon-plus' aria-hidden='true' onclick=\"$(this).parents('.v').children('.table-responsive').toggle();if($(this).hasClass('glyphicon-plus'))" . '{' . "$(this).removeClass('glyphicon-plus');$(this).addClass('glyphicon-minus');}else if($(this).hasClass('glyphicon-minus')){(this).removeClass('glyphicon-minus');$(this).addClass('glyphicon-plus');}\"></span></h5><div class='table-responsive display-none'><table class='table table-bordered table-condensed text-center'><thead><tr><td>订单细则号</td><td>铸件名称</td><td>数量</td><td>吨位</td><td>金额</td></tr></thead><tbody>";
                        foreach ($v2 as $k3 => $v3) {
                            echo "<tr><td>{$v3['订单细则号']}</td><td>{$v3['铸件名称']}</td><td>" . number_format($v3['订货数量']) . "</td><td>" . number_format($v3['订货吨位']) . "</td><td>" . number_format($v3['订货金额']) . "</td></tr>";
                        }
                        echo "</tbody></table></div></div>";
                    }
                    echo "</div>";
                }
                echo "<hr></div>";
            }
            echo "<hr></div>";
        }
    } else {
        echo "<h5>未查询到符合条件的记录！</h5>";
    }

}


/**
 *跟踪单件过程
 *
 *
 * 权限++++++++++++++++
 *
 * @param $ddxzh
 */
function track_single_pro($ddxzh)
{
    $sql = "SELECT 铸件单件.单件标识 , 铸件单件.细则号 , 铸件单件.化验单号 , 铸件单件.处置单号 , 铸件单件.终止 , 铸件单件.终止说明 ,
  铸件单件.工艺单铸件标识 , 铸件单件.属性 , 铸件单件.性质 , 铸件单件.最后作业顺序 , 铸件单件.等待作业顺序 , 铸件单件.等待 ,
  V_订单细则简略视图.客户 , V_订单细则简略视图.类别 ,  V_订单细则简略视图.铸件名称 ,  V_订单细则简略视图.材质 ,
  V_订单细则简略视图.投产 , V_订单细则简略视图.业务员 , V_订单细则简略视图.细则交货日期 , V_订单细则简略视图.订货日期 ,
  V_订单细则简略视图.交货工期 , V_订单细则简略视图.参考重量 , 铸件单件作业过程.序号 , 铸件单件作业过程.作业顺序 , 铸件单件作业过程.作业工序 ,
  铸件单件作业过程.作业描述 , 铸件单件作业过程.编号 , 铸件单件作业过程.时间 , 铸件单件作业过程.验收时间 , 铸件单件作业过程.计划耗时 ,
  铸件单件作业过程.实际耗时 , V_订单细则简略视图.订单编号 , 工序.计划验收 , V_订单细则简略视图.订货数量 , V_订单细则简略视图.客户类别 ,
  铸件单件.造型批次号 , V_订单细则炉号开产.开产日期 ,  铸件单件.造型蜡型编号,  V_订单细则炉号开产.开产日期 
FROM   
  V_铸件单件_all 铸件单件 with (nolock)
  INNER JOIN V_铸件单件作业过程_all 铸件单件作业过程 with (nolock) ON 铸件单件作业过程.单件标识 = 铸件单件.单件标识 
  INNER JOIN V_订单细则简略视图 ON V_订单细则简略视图.订单细则号 = 铸件单件.细则号 
  LEFT OUTER JOIN 工序 ON 工序.工序 = 铸件单件作业过程.作业工序 
  LEFT OUTER JOIN V_订单细则炉号开产 ON 铸件单件.细则号 = V_订单细则炉号开产.订单细则号 AND 铸件单件.造型批次号 = V_订单细则炉号开产.炉号
WHERE 铸件单件.细则号 = '{$ddxzh}'
";
    $res = fetchAll($sql);
    if ($res) {
        echo "<div class='div'>铸件标识：{$res[0]['工艺单铸件标识']}<br>";
        echo "{$res[0]['铸件名称']}&nbsp;&nbsp;&nbsp;{$res[0]['材质']}（{$res[0]['类别']}）&nbsp;&nbsp;&nbsp;净重：" . sprintf("%.2f", $res[0]['参考重量']) . "<br>";
        echo "<span class='red'>订货：{$res[0]['订货数量']}&nbsp;&nbsp;&nbsp;</span>";
        echo "<span class='red'>交货期：{$res[0]['交货工期']}&nbsp;&nbsp;&nbsp;</span>";
        echo "<span class='red'>超期：" . diffBetweenTwoDays(get2Dm($res, '验收时间', 'max') ? date("Y-m-d", strtotime(get2Dm($res, '验收时间', 'max'))) : date("Y-m-d", strtotime($res[0]['订货日期'])), date("Y-m-d", strtotime($res[0]['细则交货日期']))) . "</span><br>";
        echo "</div>";


        foreach (array_group_by($res, '单件标识') as $key => $val) {
            $tmp[$key] = $val[0]['等待作业顺序'];
        }
        $arr = array_count_values($tmp);
        ksort($arr);
        echo "<div  id='statistics'  ><table class='table table-bordered text-center table-condensed '><tr><td>作业顺序</td><td>作业工序</td><td>等待</td><td>数量</td></tr>";
        foreach ($arr as $key => $val) {
            foreach (array_group_by($res, '单件标识') as $k => $v) {
                foreach ($v as $k1 => $v1) {
                    if (($v1['作业顺序'] == $key) && ($v1['作业顺序'] == $v[0]['等待作业顺序'])) {
                        $d = $v1['作业工序'];
                        $e = $v1['等待'];
                    }
                }
            }
            echo "<tr><td>{$key}</td><td>{$d}</td><td>{$e}</td><td>{$val}</td></tr>";
        }
        echo "</table></div>";


        echo "<a class='a1'  href='javascript:void(0)'  onclick='$(\"#statistics\").css(\"display\",\"none\");$(\"#info\").css(\"display\",\"block\");$(\".a1\").css(\"display\",\"none\");$(\".a2\").css(\"display\",\"block\");'>详细信息</a>";
        echo "<a class='a2'  href='javascript:void(0)' style='display: none;' onclick=' $(\"#statistics\").css(\"display\",\"block\");$(\"#info\").css(\"display\",\"none\");$(\".a2\").css(\"display\",\"none\");$(\".a1\").css(\"display\",\"block\");'>返回</a>";


        echo "<div id='info' style='height:360px;overflow-y: scroll;display: none;'>";
        foreach (array_group_by($res, '单件标识') as $key => $val) {
            $a = 0;
            $b = 0;
            $c = "";
            foreach ($val as $v) {
                $a += $v['计划耗时'];
                $b += $v['实际耗时'];
                if ($v['作业顺序'] == $val[0]['等待作业顺序']) {
                    $c .= $v['作业顺序'] . $v['作业工序'] . $v['等待'];
                }
            }


            echo "<div class='div1'><h6>{$key}&nbsp;&nbsp;&nbsp;<strong class='red'>等待：{$c}</strong>&nbsp;&nbsp;&nbsp;";
            echo "<span   class=\"glyphicon glyphicon-plus\" aria-hidden=\"true\"
                                      onclick=\"$(this).parents('.div1').children('.div2').toggle();if($(this).hasClass('glyphicon-plus'))" . '{' . "$(this).removeClass('glyphicon-plus');$(this) . addClass('glyphicon-minus');" . '}' . "else if($(this).hasClass('glyphicon-minus'))" . '{' . "$(this) . removeClass('glyphicon-minus');$(this) . addClass('glyphicon-plus');" . '}' . "\"
                                ></span></h6>";
            echo "<div class='table-responsive div2 display-none'><table class='table  table-bordered table-condensed text-center'>";
            echo "<tr><td>";
            echo "<span  class=\"glyphicon glyphicon-plus \" aria-hidden=\"true\"
                                      onclick=\"$(this).parents('.div1').children('.div3').toggle();if($(this).hasClass('glyphicon-plus'))" . '{' . "$(this).removeClass('glyphicon-plus');$(this) . addClass('glyphicon-minus');" . '}' . "else if($(this).hasClass('glyphicon-minus'))" . '{' . "$(this) . removeClass('glyphicon-minus');$(this) . addClass('glyphicon-plus');" . '}' . "\"
                                ></span>";
            echo "&nbsp;&nbsp;&nbsp;<span style='color: #0e90d2;'>造型批次号</span></td><td>终止</td><td>属性</td><td>性质</td><td>顺序</td><td>待序</td><td><span class=\"red\">计划h</span></td><td><span class=\"red\">实际h</span></td><td><span class=\"red\">超时h</span></td><td>开产日期</td><td>施工单号</td></tr>";
            echo "<tr " . ($val[0]['终止'] == 'Y' ? "style='background-color:red;color:black; '" : null) . "><td style='color: #0e90d2;'>{$val[0]['造型批次号']}</td><td>{$val[0]['终止']}</td><td>{$val[0]['属性']}</td><td>{$val[0]['性质']}</td><td>{$val[0]['最后作业顺序']}</td><td>{$val[0]['等待作业顺序']}</td><td  style='color: red;'>{$a}</td><td style='color: red;'>{$b}</td><td style='color: red;'>" . ($b - $a) . "</td><td>" . ($val[0]['开产日期'] ? date("Y-m-d", strtotime($val[0]['开产日期'])) : '(null)') . "</td><td>{$val[0]['造型蜡型编号']}</td></tr>";
            echo "</table></div>";

            echo "<div class='table-responsive div3 display-none '><table class='table table-bordered table-condensed text-center' >";
            echo "<tr><td>作业</td><td>编号</td><td>时间</td><td>验收时间</td><td>计划h</td><td>实际h</td><td>超时h</td></tr>";
            foreach ($val as $row) {
                echo "<tr><td>{$row['作业顺序']}&nbsp;{$row['作业工序']}</td><td>{$row['编号']}</td><td>" . ($row['时间'] ? date("Y-m-d", strtotime($row['时间'])) : null) . "</td><td>" . ($row['验收时间'] ? date("Y-m-d", strtotime($row['验收时间'])) : null) . "</td><td>" . ($row['计划耗时'] ? sprintf("%d", $row['计划耗时']) : null) . "</td><td>" . ($row['实际耗时'] ? sprintf("%d", $row['实际耗时']) : null) . "</td><td>" . ($row['实际耗时'] ? ($row['实际耗时'] - $row['计划耗时']) : null) . "</td></tr>";
            }
            echo "</table></div>";
            echo "</div>";


        }

        echo "</div>";
    } else {
        echo "<div style='font-size: 1.2rem;padding: 1rem ;'><h5>没有记录！</h5></div>";
    }
}

/**
 * 跟踪细则一览
 * @param $ddxzh
 */
function track_xz_overview($ddxzh)
{
    $sql = "SELECT   V_订单细则_跟踪一览.订单细则号, V_订单细则_跟踪一览.时间, V_订单细则_跟踪一览.数量, V_订单细则_跟踪一览.事由
FROM      V_订单细则_跟踪一览 

WHERE V_订单细则_跟踪一览.订单细则号 ='{$ddxzh}'
 ORDER BY V_订单细则_跟踪一览.时间
";
    $res = fetchAll($sql);
    if ($res) {
        echo "<div class='div'><table class=\"table table-bordered table-condensed text-center\"><thead><tr><td>订单细则号</td><td>时间</td><td>数量</td><td>事由</td></tr></thead><tbody>";
        foreach ($res as $row) {
            echo "<tr><td>" . trim($row['订单细则号']) . "</td><td>" . ($row['时间'] ? date("Y-m-d", strtotime($row['时间'])) : null) . "</td><td>{$row['数量']}</td><td>{$row['事由']}</td></tr>";
        }
        echo "</tbody></table></div>";
    } else {
        echo "<div style='font-size: 1.2rem;padding: 1rem ;'><h5>没有记录！</h5></div>";
    }
}

/**
 * 跟踪细则进度比
 * @param $ddxzh
 */
function track_xz_pro_r($ddbh)
{
    $sql = "SELECT (SELECT  职工姓名 FROM 职工信息 WHERE 职工编号=V_dw_业务员业绩.业务员) 业务员 , V_dw_业务员业绩.客户 ,
  V_dw_业务员业绩.订单编号 ,  V_dw_业务员业绩.订单细则号 ,
  V_dw_业务员业绩.铸件名称 , V_dw_业务员业绩.材质 ,  V_dw_业务员业绩.类别 ,  V_dw_业务员业绩.铸件编号 ,
  V_dw_业务员业绩.订货数量 , V_dw_业务员业绩.订货日期 ,
  V_dw_业务员业绩.造型数 ,  V_dw_业务员业绩.发货数 , V_dw_业务员业绩.细则交货日期 , V_dw_业务员业绩.净工艺重量 ,
  V_dw_业务员业绩.完成 , V_dw_业务员业绩.超期 , V_dw_业务员业绩.最后交货日期
FROM
  V_dw_业务员业绩 
WHERE V_dw_业务员业绩.订单编号 ='{$ddbh}'
 ORDER BY V_dw_业务员业绩.订单细则号
";
    $res = fetchAll($sql);
    if ($res) {
        $a = 0;
        $b = 0;
        $c = 0;
        /* $d = 0;$e = 0;$f = 0;$g = 0;$k = 0;*/
        foreach ($res as $row) {
            $a += $row['订货数量'];
            $b += $row['造型数'];
            $c += $row['发货数'];
            /*$d += $row['订货数量'] * $row['净工艺重量'];$e += $row['造型数'] * $row['净工艺重量'];$f += $row['发货数'] * $row['净工艺重量'];$g += ($row['订货数量'] - $row['造型数']) * $row['净工艺重量'];$k += ($row['订货数量'] - $row['发货数']) * $row['净工艺重量'];*/
        }
        echo "<div class='div'>";
        echo "<h5>{$res[0]['订单编号']}&nbsp;&nbsp;&nbsp;&nbsp;<small>{$res[0]['客户']}&nbsp;&nbsp;&nbsp;&nbsp;{$res[0]['业务员']}</small></h5>";
        echo "<span class='red'>订货数：{$a}&nbsp;&nbsp;&nbsp;蜡型数：{$b}&nbsp;&nbsp;&nbsp;发货数：{$c}&nbsp;&nbsp;&nbsp;发货进度：" . (sprintf("%01.2f", $c / $a * 100) . '%') . "</span>";
        echo "<div class='table-responsive'><table class='table table-bordered table-condensed text-center'>";
        echo "<tr><td>订单细则号</td><td>铸件名称</td><td>订货数</td><td>蜡型数</td><td>发货数</td><td class='red'>发货进度</td><td>完成</td><td>超期</td></tr>";
        //<td>订货重</td><td>蜡型重</td><td>发货重</td><td>未蜡型重</td><td>未发货重</td>
        //<td>".($rows['净工艺重量'] * $rows['订货数量'])."</td><td>".( $rows['净工艺重量'] * $rows['造型数'])."</td><td>".($rows['净工艺重量'] * $rows['发货数'])."</td><td>".($rows['净工艺重量'] * ($rows['订货数量'] - $rows['造型数']))."</td><td>".($rows['净工艺重量'] * ($rows['订货数量'] - $rows['发货数']))."</td>
        foreach ($res as $rows) {
            echo "<tr><td>{$rows['订单细则号']}</td><td>{$rows['铸件名称']}</td><td>{$rows['订货数量']}</td><td>{$rows['造型数']}</td><td>{$rows['发货数']}</td><td class='red'>" . (sprintf("%01.2f", $rows['发货数'] / $rows['订货数量'] * 100) . '%') . "</td><td class='red'>" . ($rows['完成'] ? '是' : '否') . "</td><td class='red'>{$rows['超期']}</td></tr>";
        }
        echo "</table></div>";
        echo "</div>";
    } else {
        echo "<div style='font-size: 1.2rem;padding: 1rem ;'><h5>没有记录！</h5></div>";
    }
}


function track_xz_pro($ddbh = null)
{
    if ($ddbh) {
        $filter = " WHERE V_订单细则简略视图.订单编号 ='{$ddbh}'";
    }
    $sql = "SELECT
  V_订单细则简略视图.订单细则号,  V_订单细则简略视图.订货数量,  V_订单细则简略视图.订货日期,  V计划投产.投产数量,  V计划投产.投产时间,
  V发货生产.生产发货数量,  V发货.发货数量,  V发货.发货时间,
  CASE WHEN V发货.发货数量>=V_订单细则简略视图.订货数量 THEN 1 ELSE 0 END AS 完成,
  计划生产.蜡型合格,
  计划生产.蜡型废品,  计划生产.蜡型时间,  计划生产.面层合格,  计划生产.面层废品,  计划生产.面层时间,
  计划生产.脱蜡合格,  计划生产.脱蜡废品,  计划生产.脱蜡时间,  计划生产.熔炼浇注合格,  计划生产.熔炼浇注废品,
  计划生产.熔炼浇注时间,  计划生产.碎壳合格,  计划生产.碎壳废品,  计划生产.碎壳时间,  计划生产.初检合格,
  计划生产.初检废品,  计划生产.初检时间,  计划生产.热处理合格,  计划生产.热处理废品,  计划生产.热处理时间,
  计划生产.终检合格,  计划生产.终检废品,  计划生产.终检时间,  计划生产.入库检验合格,  计划生产.入库检验废品,
  计划生产.入库检验时间,  计划生产.铸件成品合格,  计划生产.铸件成品废品,  计划生产.铸件成品时间,  计划生产.加工成品合格,
  计划生产.加工成品废品,  计划生产.加工成品时间,  计划生产.加工合格,  计划生产.加工废品,  计划生产.加工时间,
  V_订单细则简略视图.铸件名称,  V_订单细则简略视图.材质,  V_订单细则简略视图.订单编号,  V_订单细则简略视图.合同号,  V_订单细则简略视图.细则交货日期,
  CASE WHEN CONVERT ( CHAR ( 10 ) , V发货.发货时间 , 120 ) > CONVERT ( CHAR ( 10 ) , V_订单细则简略视图.细则交货日期 , 120 ) THEN '拖期' WHEN CONVERT ( CHAR ( 10 ) , getdate ( ) , 120 ) > CONVERT ( CHAR ( 10 ) , V_订单细则简略视图.细则交货日期 , 120 ) THEN '拖期' WHEN V发货.发货数量>= V_订单细则简略视图.订货数量 AND CONVERT ( CHAR ( 10 ) , V发货.发货时间 , 120 ) <= CONVERT ( CHAR ( 10 ) , V_订单细则简略视图.细则交货日期 , 120 ) THEN '按期' ELSE '待定' END AS 交货状态,
  V_订单细则简略视图.细则重量 AS 细则重量,
  V_订单细则简略视图.订货数量* V_订单细则简略视图.细则重量 AS 订货重量,
  V_订单细则简略视图.订货数量-isnull ( V发货.发货数量 , 0 ) AS 欠数,
  ( V_订单细则简略视图.订货数量-isnull ( V发货.发货数量 , 0 ) ) *V_订单细则简略视图.细则重量 AS 欠货重量,
  DATEADD ( DAY , V铸件作业路线.蜡型时间 , V计划投产.投产时间 ) AS 蜡型计划完成时间,
  DATEADD ( DAY , V铸件作业路线.制壳时间 , V计划投产.投产时间 ) AS 制壳计划完成时间,
  DATEADD ( DAY , V铸件作业路线.熔炼时间 , V计划投产.投产时间 ) AS 熔炼计划完成时间,
  DATEADD ( DAY , V铸件作业路线.入库检验时间 , V计划投产.投产时间 ) AS 后整理计划完成时间,
  DATEADD ( DAY , V铸件作业路线.加工成品时间 , V计划投产.投产时间 ) AS 加工计划完成时间,
  V细则号等待.单件数 AS 单件数,
  V细则号等待.废品数 AS 废品数,
  V细则号等待.蜡型等待数 AS 蜡型等待数,
  V细则号等待.面层等待数 AS 面层等待数,
  V_订单细则简略视图.图号 AS 图号,
  V_订单细则简略视图.客户代号 AS 客户代号,
  V_订单细则简略视图.内部图纸编号 AS 内部图纸编号
FROM
  (
  SELECT
    订单细则号,
    SUM ( CASE WHEN V生产.工序='蜡型' THEN V生产.合格数 ELSE NULL END ) 蜡型合格,
    SUM ( CASE WHEN V生产.工序='蜡型' THEN V生产.废品数 ELSE NULL END ) 蜡型废品,
    MAX ( CASE WHEN V生产.工序='蜡型' THEN V生产.时间 ELSE NULL END ) 蜡型时间,
    SUM ( CASE WHEN V生产.工序='面层' THEN V生产.合格数 ELSE NULL END ) 面层合格,
    SUM ( CASE WHEN V生产.工序='面层' THEN V生产.废品数 ELSE NULL END ) 面层废品,
    MAX ( CASE WHEN V生产.工序='面层' THEN V生产.时间 ELSE NULL END ) 面层时间,
    SUM ( CASE WHEN V生产.工序='脱蜡' THEN V生产.合格数 ELSE NULL END ) 脱蜡合格,
    SUM ( CASE WHEN V生产.工序='脱蜡' THEN V生产.废品数 ELSE NULL END ) 脱蜡废品,
    MAX ( CASE WHEN V生产.工序='脱蜡' THEN V生产.时间 ELSE NULL END ) 脱蜡时间,
    SUM ( CASE WHEN V生产.工序='熔炼浇注' THEN V生产.合格数 ELSE NULL END ) 熔炼浇注合格,
    SUM ( CASE WHEN V生产.工序='熔炼浇注' THEN V生产.废品数 ELSE NULL END ) 熔炼浇注废品,
    MAX ( CASE WHEN V生产.工序='熔炼浇注' THEN V生产.时间 ELSE NULL END ) 熔炼浇注时间,
    SUM ( CASE WHEN V生产.工序='碎壳' THEN V生产.合格数 ELSE NULL END ) 碎壳合格,
    SUM ( CASE WHEN V生产.工序='碎壳' THEN V生产.废品数 ELSE NULL END ) 碎壳废品,
    MAX ( CASE WHEN V生产.工序='碎壳' THEN V生产.时间 ELSE NULL END ) 碎壳时间,
    SUM ( CASE WHEN V生产.工序='初检' THEN V生产.合格数 ELSE NULL END ) 初检合格,
    SUM ( CASE WHEN V生产.工序='初检' THEN V生产.废品数 ELSE NULL END ) 初检废品,
    MAX ( CASE WHEN V生产.工序='初检' THEN V生产.时间 ELSE NULL END ) 初检时间,
    SUM ( CASE WHEN V生产.工序='热处理' THEN V生产.合格数 ELSE NULL END ) 热处理合格,
    SUM ( CASE WHEN V生产.工序='热处理' THEN V生产.废品数 ELSE NULL END ) 热处理废品,
    MAX ( CASE WHEN V生产.工序='热处理' THEN V生产.时间 ELSE NULL END ) 热处理时间,
    SUM ( CASE WHEN V生产.工序='终检' THEN V生产.合格数 ELSE NULL END ) 终检合格,
    SUM ( CASE WHEN V生产.工序='终检' THEN V生产.废品数 ELSE NULL END ) 终检废品,
    MAX ( CASE WHEN V生产.工序='终检' THEN V生产.时间 ELSE NULL END ) 终检时间,
    SUM ( CASE WHEN V生产.工序='入库检验' THEN V生产.合格数 ELSE NULL END ) 入库检验合格,
    SUM ( CASE WHEN V生产.工序='入库检验' THEN V生产.废品数 ELSE NULL END ) 入库检验废品,
    MAX ( CASE WHEN V生产.工序='入库检验' THEN V生产.时间 ELSE NULL END ) 入库检验时间,
    SUM ( CASE WHEN V生产.工序='铸件成品' THEN V生产.合格数 ELSE NULL END ) 铸件成品合格,
    SUM ( CASE WHEN V生产.工序='铸件成品' THEN V生产.废品数 ELSE NULL END ) 铸件成品废品,
    MAX ( CASE WHEN V生产.工序='铸件成品' THEN V生产.时间 ELSE NULL END ) 铸件成品时间,
    SUM ( CASE WHEN V生产.工序='加工成品' THEN V生产.合格数 ELSE NULL END ) 加工成品合格,
    SUM ( CASE WHEN V生产.工序='加工成品' THEN V生产.废品数 ELSE NULL END ) 加工成品废品,
    MAX ( CASE WHEN V生产.工序='加工成品' THEN V生产.时间 ELSE NULL END ) 加工成品时间,
    SUM ( CASE WHEN V生产.工序='加工' THEN V生产.合格数 ELSE NULL END ) 加工合格,
    SUM ( CASE WHEN V生产.工序='加工' THEN V生产.废品数 ELSE NULL END ) 加工废品,
    MAX ( CASE WHEN V生产.工序='加工' THEN V生产.时间 ELSE NULL END ) 加工时间
  FROM
    (
    SELECT
      订单细则号,  工序,
      SUM ( isnull ( 合格数 , 0 ) +isnull ( 回用数 , 0 ) ) AS 合格数,
      SUM ( isnull ( 料废数 , 0 ) +isnull ( 工废数 , 0 ) ) AS 废品数,
      MAX ( 制表日期 ) AS 时间
    FROM
      计划生产 WITH ( nolock )
    GROUP  BY
       订单细则号 ,
       工序
  ) V生产
  GROUP  BY
     订单细则号
) 计划生产
  RIGHT OUTER JOIN V_订单细则简略视图 ON V_订单细则简略视图.订单细则号=计划生产.订单细则号
  LEFT OUTER JOIN (

  SELECT
    细则号 AS 订单细则号,
    SUM ( 投产数量 ) AS 投产数量,
    MAX ( 投产时间 ) AS 投产时间
  FROM
    计划投产 WITH ( nolock )
  GROUP  BY
     细则号
) V计划投产 ON V计划投产.订单细则号=V_订单细则简略视图.订单细则号
  LEFT OUTER JOIN (
  SELECT
    生产细则号 AS 订单细则号,
    SUM ( 发货数量 ) AS 生产发货数量
  FROM
    发货记录 WITH ( nolock )
  GROUP  BY
     生产细则号
) V发货生产 ON V发货生产.订单细则号=V_订单细则简略视图.订单细则号
  LEFT OUTER JOIN (
  SELECT
    发货记录.订单细则号,
    SUM ( 发货记录.发货数量 ) AS 发货数量,
    MAX ( 发货记录主表.发货日期 ) AS 发货时间
  FROM
    发货记录 WITH ( nolock )
    LEFT OUTER JOIN 发货记录主表 WITH ( nolock ) ON 发货记录.发运编号=发货记录主表.发运编号
  GROUP  BY
     发货记录.订单细则号
) V发货 ON V发货.订单细则号=V_订单细则简略视图.订单细则号
  LEFT OUTER JOIN (
  SELECT
    细则号,
    SUM ( CASE WHEN 作业工序='蜡型' THEN 计划总耗时/24.0 ELSE NULL END ) AS 蜡型时间,
    SUM ( CASE WHEN 作业工序='脱蜡' THEN 计划总耗时/24.0 ELSE NULL END ) AS 制壳时间,
    SUM ( CASE WHEN 作业工序='熔炼浇注' THEN 计划总耗时/24.0 ELSE NULL END ) AS 熔炼时间,
    SUM ( CASE WHEN 作业工序='入库检验' THEN 计划总耗时/24.0 ELSE NULL END ) AS 入库检验时间,
    SUM ( CASE WHEN 作业工序='加工成品' THEN 计划总耗时/24.0 ELSE NULL END ) AS 加工成品时间
  FROM
    (
    SELECT
      铸件作业路线1.细则号,  铸件作业路线1.作业顺序,  铸件作业路线1.计划耗时,
      SUM ( 铸件作业路线2.计划耗时 ) AS 计划总耗时,
      铸件作业路线1.作业工序
    FROM
      铸件作业路线 AS 铸件作业路线1 WITH ( nolock )
      INNER JOIN 铸件作业路线 AS 铸件作业路线2 WITH ( nolock ) ON 铸件作业路线1.细则号 = 铸件作业路线2.细则号 AND 铸件作业路线1.作业顺序 >= 铸件作业路线2.作业顺序
    GROUP  BY
       铸件作业路线1.细则号 ,
       铸件作业路线1.作业顺序 ,
       铸件作业路线1.作业工序 ,
       铸件作业路线1.计划耗时
  ) V
  GROUP  BY
     细则号
) V铸件作业路线 ON V铸件作业路线.细则号=V_订单细则简略视图.订单细则号
  LEFT OUTER JOIN (
  SELECT
    细则号,
    SUM ( 1 ) AS 单件数,
    SUM ( CASE WHEN 终止='Y' THEN 1 ELSE NULL END ) AS 废品数,
    SUM ( CASE WHEN 终止='N' AND 等待作业='蜡型' THEN 1 ELSE NULL END ) AS 蜡型等待数,
    SUM ( CASE WHEN 终止='N' AND 等待作业='面层' THEN 1 ELSE NULL END ) AS 面层等待数,
    SUM ( CASE WHEN 终止='N' AND 等待作业='背层' THEN 1 ELSE NULL END ) AS 背层等待数,
    SUM ( CASE WHEN 终止='N' AND 等待作业='脱蜡' THEN 1 ELSE NULL END ) AS 脱蜡等待数,
    SUM ( CASE WHEN 终止='N' AND 等待作业='熔炼浇注' THEN 1 ELSE NULL END ) AS 熔炼等待数,
    SUM ( CASE WHEN 终止='N' AND 等待作业='初检' THEN 1 ELSE NULL END ) AS 初检等待数,
    SUM ( CASE WHEN 终止='N' AND 等待作业 IN ( '碎壳' , '切割' , '磨浇口' , '抛丸' , '焊补' , '打磨' , '热处理' , '酸洗' , '整形' ) THEN 1 ELSE NULL END ) AS 后整理等待数,
    SUM ( CASE WHEN 终止='N' AND 等待作业='终检' THEN 1 ELSE NULL END ) AS 终检等待数,
    SUM ( CASE WHEN 终止='N' AND 等待作业='入库检验' THEN 1 ELSE NULL END ) AS 入库检验等待数,
    SUM ( CASE WHEN 终止='N' AND 等待作业='铸件成品' THEN 1 ELSE NULL END ) AS 铸件成品等待数,
    SUM ( CASE WHEN 终止='N' AND 等待作业='加工' THEN 1 ELSE NULL END ) AS 加工成品等待数
  FROM
    铸件单件 WITH ( nolock )
  GROUP  BY
     细则号
) V细则号等待 ON V细则号等待.细则号= V_订单细则简略视图.订单细则号 {$filter}";
    $res = fetchAll($sql);
    if ($res) {
        echo "<div class='table-responsive' style='font-size: 1.1rem;'>";
        echo "<table class='table table-bordered table-condensed text-center'><thead style='background-color: #1a1a1a;color: white;'>";
        echo "<tr><td>细则号</td><td>订货数</td><td>订货日期</td><td>投产数</td><td>细则重</td><td>投产时间</td><td>生产发货数</td><td>发货数</td><td>发货时间</td><td>交货日期</td><td>欠数</td><td>完成</td><td>交货状态</td><td>单件数</td><td>废品数</td><td>蜡型等待数</td><td>蜡型计划完成时间</td><td>蜡型合格</td><td>蜡型废品</td><td>蜡型时间</td><td>制壳计划完成时间</td><td>熔炼计划完成时间</td><td>铸件名称</td><td>材质</td><td>订单编号</td></tr>";
        echo "</thead><tbody>";
        foreach ($res as $row) {
            echo "<tr>";
            echo "<td>{$row['订单细则号']}</td><td>{$row['订货数量']}</td><td>" . ($row['订货日期'] ? date('Y-m-d', strtotime($row['订货日期'])) : null) . "</td><td>{$row['投产数量']}</td><td>{$row['细则重量']}</td><td>" . ($row['投产时间'] ? date('Y-m-d', strtotime($row['投产时间'])) : null) . "</td><td>{$row['生产发货数量']}</td><td>{$row['发货数量']}</td><td>" . ($row['发货时间'] ? date('Y-m-d', strtotime($row['发货时间'])) : null) . "</td><td>" . ($row['细则交货日期'] ? date('Y-m-d', strtotime($row['细则交货日期'])) : null) . "</td><td>{$row['欠数']}</td>";
            echo "<td>" . ($row['完成'] ? "<input type='checkbox' checked='checked' onclick='return false;'>" : "<input type='checkbox'  onclick='return false;'>") . "</td>";
            echo "<td>{$row['交货状态']}</td><td>{$row['单件数']}</td><td>{$row['废品数']}</td><td>{$row['蜡型等待数']}</td><td>" . ($row['蜡型计划完成时间'] ? date('Y-m-d', strtotime($row['蜡型计划完成时间'])) : null) . "</td><td>{$row['蜡型合格']}</td><td>{$row['蜡型废品']}</td><td>{$row['蜡型时间']}</td><td>" . ($row['制壳计划完成时间'] ? date('Y-m-d', strtotime($row['制壳计划完成时间'])) : null) . "</td><td>" . ($row['熔炼计划完成时间'] ? date('Y-m-d', strtotime($row['熔炼计划完成时间'])) : null) . "</td><td>{$row['铸件名称']}</td><td>{$row['材质']}</td><td>{$row['订单编号']}</td>";
            echo "</tr>";
        }
        echo "</tbody></table></div>";
    } else {
        echo "<div style='font-size: 1.2rem;padding: 1rem ;'><h5>没有记录！</h5></div>";
    }
}


function insert_order($ddzbtj, $ddxzs, $ddxztj = null, $ddfys, $ddfytj = null)
{
    try {
        $ddbh = $ddzbtj[0];
        $mydatazb = "'" . $ddbh . "'";
        for ($i = 1; $i < count($ddzbtj); $i++) {
            $mydatazb = $mydatazb . "," . "'" . $ddzbtj[$i] . "'";
        }
        $pdo = connect();
        $pdo->beginTransaction();

        $queryzb = "INSERT INTO 订单( 订单编号,内部合同号,合同号,订单来源,运费承担,客户,交易币种,订货日期,下单日期,汇率,业务员,跟单员,下单人,订单处置,订单描述,备注,客户产品要求,公司承诺,法律法规,合同链接,登记员,登记时间,备件订单,校核员,校核时间,订货项数,应收金额,订货费用,附加费用) VALUES (" . $mydatazb . ") ";
        //print_r($queryzb);
        $resultzb = $pdo->prepare($queryzb);
        $resultzb->execute();
        $xzs = 0;
        if ($ddxzs) {
            for (; $xzs < count($ddxztj); $xzs++) {
                $ddxztj[$xzs] = str_replace("''", 'null', $ddxztj[$xzs]);
                $queryxz = "insert into 订单细则(订单编号,订单细则号,客户行号,铸造,金工,新品,特急件,处置,订单形式,铸件编号,原生产车间,生产方式,订货数量,发货重量形式,细则重量,发货价格形式,重量价格,单件价格,细则金额,加工件价,细则总价,细则交货日期,客户标识,合同要求,要求PT探伤数量,要求RT探伤数量,探伤要求等级,包装箱每箱件数,包装箱规格,备注,发货结束) values ('" . $ddbh . "'," . $ddxztj[$xzs] . ") ";

                //print_r($queryxz);
                $pdo->exec($queryxz);
            }
        }
        $fjs = 0;
        if ($ddfys) {
            for (; $fjs < count($ddfytj); $fjs++) {
                $ddfytj[$fjs] = str_replace("''", 'null', $ddfytj[$fjs]);
                $queryfy = "insert into 订单附加费用(订单编号,费用名,金额,备注) values ('" . $ddbh . "'," . $ddfytj[$fjs] . ") ";
                //print_r($queryfy);
                $pdo->exec($queryfy);
            }
        }
        echo "保存成功!";
        if ($xzs) {
            echo "提交了" . $xzs . "条订单细则.";
        }
        if ($fjs) {
            echo "提交了" . $fjs . "条附件项.";
        }
        $pdo->commit();

    } catch
    (PDOException $e) {
        $pdo->rollBack();
        echo "数据保存时发生错误，错误报告：" . "\n";
        echo $e->getMessage() . "\n";
        die;
    }
}