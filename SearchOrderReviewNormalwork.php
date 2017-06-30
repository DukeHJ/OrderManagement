<?php
try {

    $query = "SELECT
  订单评审.订单细则号 ,  订单评审.图纸 ,  订单评审.模具 ,  订单评审.样品 ,  订单评审.检验标准书 ,
  订单评审.检具量具 ,  订单评审.历史品质记录 ,  订单评审.工艺成熟 ,  订单评审.工装夹具 ,  订单评审.工艺卡 ,
  订单评审.整形模 ,  (SELECT CONVERT(date, 订单评审.生产交期, 23) )AS 生产交期 ,  V_订单细则简略视图.铸件名称 ,  V_订单细则简略视图.订货数量 ,  V_订单细则简略视图.材质 ,
 (SELECT CONVERT(date, V_订单细则简略视图.细则交货日期, 23) )AS 细则交货日期 ,  V_订单细则简略视图.加工图号 , V_订单细则简略视图.加工图号版本 ,  (SELECT 职工姓名 FROM 职工信息 WHERE 职工编号 = 订单评审.业务部) AS 业务部  ,   (SELECT 职工姓名 FROM 职工信息 WHERE 职工编号 = 订单评审.品管部) AS 品管部   ,  (SELECT 职工姓名 FROM 职工信息 WHERE 职工编号 = 订单评审.技术部) AS 技术部  ,
  (SELECT CONVERT(date, 订单评审.业务签名时间 , 23) )AS 业务签名时间 ,  (SELECT CONVERT(date, 订单评审.业务签名时间 , 23) )AS 业务签名时间 , (SELECT CONVERT(date, 订单评审.品管签名时间 , 23) )AS 品管签名时间 ,  (SELECT CONVERT(date, 订单评审.技术签名时间 , 23) )AS 技术签名时间 ,  订单评审.PMC ,  (SELECT CONVERT(date, 订单评审.PMC签名时间 , 23) )AS PMC签名时间 ,  (SELECT CONVERT(date, V_订单细则简略视图.订货日期 , 23) )AS 订货日期,  V_订单细则简略视图.合同号 ,  V_订单细则简略视图.新品 ,  (SELECT 职工姓名 FROM 职工信息 WHERE 职工编号 = 订单评审.生产评审) AS 生产评审,  (SELECT CONVERT(date, 订单评审.生产评审时间 , 23) )AS 生产评审时间 ,
  订单细则.图纸链接 ,   (SELECT CONVERT(date, 订单.下单日期 , 23) )AS 下单日期 ,  V_订单细则简略视图.产品编号 ,
  铸件清单.生产方式 ,  订单评审.生产数量 ,   Convert(decimal(18,2),铸件清单.参考重量) AS 参考重量 ,  订单细则.合同要求 ,  V_订单细则简略视图.客户简称 ,
  铸件清单.常用模具 ,  订单细则.铸件编号 ,  V_订单细则简略视图.细则备注 ,  订单评审.调拨数量 ,   (SELECT 仓库名称 FROM 仓库 WHERE 仓库编号= 订单评审.调出仓库) AS 调出仓库 ,  (SELECT 仓库名称 FROM 仓库 WHERE 仓库编号 = 订单评审.调入仓库) AS 调入仓库 ,
  V.库存 AS 库存 ,
  V_订单细则简略视图.金工 ,   (SELECT 职工姓名 FROM 职工信息 WHERE 职工编号 = 订单评审.确认签名) AS 确认签名  ,  (SELECT CONVERT(date, 订单评审.确认签名时间 , 23) )AS 确认签名时间 ,  订单评审.生产部结论 ,  订单评审.销售部结论 ,
  订单评审.质量部结论 ,  订单评审.总经理结论 ,  订单评审.供应部结论 ,  订单评审.技术部结论 ,  订单评审.是否需要特殊评审 ,
   (SELECT 职工姓名 FROM 职工信息 WHERE 职工编号 = 订单评审.机加工评审) AS 机加工评审   ,  (SELECT CONVERT(date, 订单评审.机加工评审时间 , 23) )AS 机加工评审时间 ,  订单评审.加工评审结论 , (SELECT CONVERT(date, 订单评审.加工交期 , 23) )AS 加工交期 ,  订单细则.特急件 ,
  订单细则.铸造 ,  铸件清单.铸件描述, 订单评审.调出仓库 AS 调出仓库_ , 订单评审.调入仓库 AS 调入仓库_
FROM
  订单评审
  LEFT OUTER JOIN V_订单细则简略视图 ON 订单评审.订单细则号=V_订单细则简略视图.订单细则号
  LEFT OUTER JOIN 订单细则 ON 订单细则.订单细则号=订单评审.订单细则号
  LEFT OUTER JOIN 部门 ON 订单细则.投产部门=部门.部门编号
  LEFT OUTER JOIN 订单 ON 订单.订单编号=订单细则.订单编号
  LEFT OUTER JOIN 铸件清单 ON 订单细则.铸件编号=铸件清单.铸件编号
  LEFT OUTER JOIN (

  SELECT
    仓库 ,  铸件编号 ,
    SUM ( 当前库存 ) AS 库存
  FROM
    V_铸件库存明细2_仓库汇总
  WHERE
    ( 仓库 IN ( '04' ) )
  GROUP BY
    仓库 ,
    铸件编号
  HAVING
    SUM ( 当前库存 ) <>0

) V ON V.铸件编号=铸件清单.铸件编号

WHERE V_订单细则简略视图.新品=0 AND V_订单细则简略视图.投产 IN ('0','1')";

    $res = fetchAll($query);

    foreach ($res as $val) {
        if ($val['铸造']) {
            $val['铸造'] = "<input  type='checkbox' class='colck' checked='checked' value='1'  onclick='return false'>";
        } else {
            $val['铸造'] = "<input  class='colck' type='checkbox' onclick='return false' value='0'>";
        }
        if ($val['金工']) {
            $val['金工'] = "<input  class='colck' type='checkbox' checked='checked' value='1' onclick='return false'>";
        } else {
            $val['金工'] = "<input  class='colck' type='checkbox' onclick='return false' value='0'>";
        }
        if ($val['新品']) {
            $val['新品'] = "<input  class='colck' type='checkbox' checked='checked' value='1' onclick='return false'>";
        } else {
            $val['新品'] = "<input  class='colck' type='checkbox' onclick='return false' value='0'>";
        }
        if ($val['特急件'] == '是') {
            $val['特急件'] = "<input  class='colck' type='checkbox' checked='checked' value='1' onclick='return false'>";
        } else {
            $val['特急件'] = "<input  class='colck' type='checkbox' onclick='return false' value='0'>";
        }

        if ($val['图纸']) {
            $val['图纸'] = "<input  class='colck' type='checkbox' checked='checked' value='1' onclick='return false'>";
        } else {
            $val['图纸'] = "<input  class='colck' type='checkbox' onclick='return false' value='0'>";
        }
        if ($val['工艺成熟']) {
            $val['工艺成熟'] = "<input  class='colck' type='checkbox' checked='checked' value='1' onclick='return false'>";
        } else {
            $val['工艺成熟'] = "<input  class='colck' type='checkbox' onclick='return false' value='0'>";
        }
        if ($val['工艺卡']) {
            $val['工艺卡'] = "<input  class='colck' type='checkbox' checked='checked' value='1' onclick='return false'>";
        } else {
            $val['工艺卡'] = "<input  class='colck' type='checkbox' onclick='return false' value='0'>";
        }
        if ($val['模具']) {
            $val['模具'] = "<input  class='colck' type='checkbox' checked='checked' value='1' onclick='return false'>";
        } else {
            $val['模具'] = "<input  class='colck' type='checkbox' onclick='return false' value='0'>";
        }
        if ($val['检具量具']) {
            $val['检具量具'] = "<input  class='colck' type='checkbox' checked='checked' value='1' onclick='return false'>";
        } else {
            $val['检具量具'] = "<input  class='colck' type='checkbox' onclick='return false' value='0'>";
        }
        if ($val['检验标准书']) {
            $val['检验标准书'] = "<input  class='colck' type='checkbox' checked='checked' value='1' onclick='return false' >";
        } else {
            $val['检验标准书'] = "<input  class='colck' type='checkbox' onclick='return false'  value='0'>";
        }
        if ($val['是否需要特殊评审']) {
            $val['是否需要特殊评审'] = "<input  class='colck tsps' name='tsps[]' type='checkbox' checked='checked' value='1' onclick=\"this.value=(this.value==0)?1:0\" >";
        } else {
            $val['是否需要特殊评审'] = "<input  class='colck tsps' name='tsps[]' type='checkbox'  value='0' onclick=\"this.value=(this.value==0)?1:0\" >";
        }

        echo "<tr>";
        echo "<td class='trzz'>" . $val['铸造'] . "</td>";
        echo "<td class='trjg'>" . $val['金工'] . "</td>";
        echo "<td class='trxp'>" . $val['新品'] . "</td>";
        echo "<td class='trtj'>" . $val['特急件'] . "</td>";
        echo "<td class='trkhjc'>" . $val['客户简称'] . "</td>";
        echo "<td class='trdhrq'>" . $val['订货日期'] . "</td>";
        echo "<td class='trhth'>" . $val['合同号'] . "</td>";
        echo "<td class='trhtyq' style=\"text-align: left;\">" . $val['合同要求'] . "</td>";
        echo "<td class='trddxzh'>" . $val['订单细则号'] . "</td>";
        echo "<td class='trzjbh'>" . $val['铸件编号'] . "</td>";
        echo "<td class='trzjmc'>" . $val['铸件名称'] . "</td>";
        echo "<td class='trzjms' style=\"text-align: left;\">" . $val['铸件描述'] . "</td>";
        echo "<td class='trcz'>" . $val['材质'] . "</td>";
        echo "<td class='trckzl'>" . $val['参考重量'] . "</td>";
        echo "<td class='trjgth'>" . $val['加工图号'] . "</td>";
        echo "<td class='trjgthbb'>" . $val['加工图号版本'] . "</td>";
        echo "<td class='trjhrq'>" . $val['细则交货日期'] . "</td>";
        echo "<td class='trdhsl'>" . $val['订货数量'] . "</td>";

        if ($val['生产数量']) {
            echo "<td class='trscsl'><input type='text' class='scsl col1' name='scsl[]' value='" . trim($val['生产数量']) . "' onkeyup= \"if(!  /(^[1-9]+\d*$)|(^0$)/.test(this.value)){Modal.alert({msg: &apos;生产数量必须为非负整数！&apos;,title: &apos;标题&apos;,btnok: &apos;确定&apos;,btncl:&apos;取消&apos;});this.value=null;}\"></td>";
        } else {
            echo "<td class='trscsl'><input type='text' class='scsl col1' name='scsl[]' onkeyup= \"if(!  /(^[1-9]+\d*$)|(^0$)/.test(this.value)){Modal.alert({msg: &apos;生产数量必须为非负整数！&apos;,title: &apos;标题&apos;,btnok: &apos;确定&apos;,btncl:&apos;取消&apos;});this.value=null;}\"></td>";
        }

        echo "<td class='trkc'>" . trim($val['库存']) . "</td>";

        echo "<td class='trdcck'><select class='dcck col2' name='dcck[]'></select></td>";

        if ($val['调拨数量']) {
            echo "<td class='trdbsl'><input type='text' class='dbsl col1' name='dbsl[]' value='" . trim($val['调拨数量']) . "' onkeyup= \"if(!  /(^[1-9]+\d*$)|(^0$)/.test(this.value)){Modal.alert({msg: &apos;调拨数量必须为非负整数！&apos;,title: &apos;标题&apos;,btnok: &apos;确定&apos;,btncl:&apos;取消&apos;});this.value=null;}\"></td>";
        } else {
            echo "<td class='trdbsl'><input type='text' class='dbsl col1' name='dbsl[]' onkeyup= \"if(!  /(^[1-9]+\d*$)|(^0$)/.test(this.value)){Modal.alert({msg: &apos;调拨数量必须为非负整数！&apos;,title: &apos;标题&apos;,btnok: &apos;确定&apos;,btncl:&apos;取消&apos;});this.value=null;}\"></td>";
        }

        echo "<td class='trdrck'><select class='drck col2' name='drck[]'></select></td>";

        if ($val['加工交期']) {
            echo "<td class='trjgjq'><input type='datetime' class='jgjq col2' name='jgjq[]' value='" . trim($val['加工交期']) . "' onClick=\"laydate({istime: true})\"></td>";
        } else {
            echo "<td class='trjgjq'><input type='datetime' class='jgjq col2' name='jgjq[]' onClick=\"laydate({istime: true})\"></td>";
        }

        if ($val['加工评审结论']) {
            echo "<td class='trjgpsjl'><input type='text' class='jgpsjl' name='jgpsjl[]' value='" . trim($val['加工评审结论']) . "'></td>";
        } else {
            echo "<td class='trjgpsjl'><input type='text' class='jgpsjl' name='jgpsjl[]'></td>";
        }

        if ($val['机加工评审']) {
            echo "<td class='trjjgps'><input type='text' class='jjgps col1' name='jjgps[]' value='" . trim($val['机加工评审']) . "' readonly=\"readonly\"></td>";
        } else {
            echo "<td class='trjjgps'><input type='text' class='jjgps col1' name='jjgps[]' readonly=\"readonly\"></td>";
        }

        if ($val['机加工评审时间']) {
            echo "<td class='trjjgpssj'><input type='datetime' class='jjgpssj col2' name='jjgpssj[]' value='" . trim($val['机加工评审时间']) . "' readonly=\"readonly\"></td>";
        } else {
            echo "<td class='trjjgpssj'><input type='datetime' class='jjgpssj col2' name='jjgpssj[]' readonly=\"readonly\"></td>";
        }
        echo "<td class='trtsps'>" . $val['是否需要特殊评审'] . "</td>";

        if ($val['生产交期']) {
            echo "<td class='trzzjq'><input type='datetime' class='zzjq col2' name='zzjq[]' value='" . trim($val['生产交期']) . "' onClick=\"laydate({istime: true})\"></td>";
        } else {
            echo "<td class='trzzjq'><input type='datetime' class='zzjq col2' name='zzjq[]' onClick=\"laydate({istime: true})\"></td>";
        }

        if ($val['生产部结论']) {
            echo "<td class='trscbjl'><input type='text' class='scbjl' name='scbjl[]' value='" . trim($val['生产部结论']) . "'></td>";
        } else {
            echo "<td class='trscbjl'><input type='text' class='scbjl' name='scbjl[]'></td>";
        }

        if ($val['生产评审']) {
            echo "<td class='trscps'><input type='text' class='scps col1' name='scps[]' value='" . trim($val['生产评审']) . "' readonly=\"readonly\"></td>";
        } else {
            echo "<td class='trscps'><input type='text' class='scps col1' name='scps[]' readonly=\"readonly\"></td>";
        }

        if ($val['生产评审时间']) {
            echo "<td class='trscpssj'><input type='datetime' class='scpssj col2' name='scpssj[]' value='" . trim($val['生产评审时间']) . "' readonly=\"readonly\"></td>";
        } else {
            echo "<td class='trscpssj'><input type='datetime' class='scpssj col2' name='scpssj[]' readonly=\"readonly\"></td>";
        }

        echo "<td class='trywb displaynone '>" . trim($val['业务部']) . "</td>";
        echo "<td class='trdcck_ displaynone'>" . trim($val['调出仓库_']) . "</td>";
        echo "<td class='trdrck_ displaynone'>" . trim($val['调入仓库_']) . "</td>";
        echo "</tr>";

    }

} catch (PDOException $e) {
    echo $e->getMessage() . "<br>";
    die;
}



