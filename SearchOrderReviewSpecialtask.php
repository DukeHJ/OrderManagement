<?php
try
{
	 
	$query = "SELECT 订单细则.订单细则号 ,V_订单细则简略视图.图号 ,V_订单细则简略视图.材质 ,V_订单细则简略视图.铸件名称 ,V_订单细则简略视图.订货数量 ,(SELECT CONVERT(date, V_订单细则简略视图.细则交货日期, 23) ) AS 细则交货日期 ,订单细则.合同要求 ,V_订单细则简略视图.客户简称 ,(SELECT CONVERT(date, V_订单细则简略视图.订货日期 , 23) )AS 订货日期 ,V_订单细则简略视图.合同号 ,订单细则.新品 ,订单细则.铸件编号 ,V_订单细则简略视图.规格 ,V_订单细则简略视图.型号 , 铸件清单.参考重量,CAST ( 0 AS BIT ) AS 传参 ,V.库存 ,订单细则.特急件 ,订单细则.金工 ,订单细则.铸造 ,铸件清单.铸件描述 ,订单细则.生产方式
    FROM 订单细则 with (nolock)
    LEFT OUTER JOIN V_订单细则简略视图 with (nolock) ON 订单细则.订单细则号=V_订单细则简略视图.订单细则号
    LEFT OUTER JOIN 订单 with (nolock) ON 订单细则.订单编号=订单.订单编号
    LEFT OUTER JOIN 订单评审 with (nolock) ON 订单评审.订单细则号 = 订单细则.订单细则号
    LEFT OUTER JOIN 铸件清单 with (nolock) ON 订单细则.铸件编号 = 铸件清单.铸件编号
    LEFT OUTER JOIN ( SELECT 仓库 , 铸件编号 , SUM ( 当前库存 ) AS 库存 FROM V_铸件库存明细2_仓库汇总 with (nolock) WHERE ( 仓库 IN ( '04' ) ) GROUP BY 仓库 ,铸件编号 HAVING SUM ( 当前库存 ) <>0
) V ON V.铸件编号=铸件清单.铸件编号
    WHERE
  (
  (
    订单细则.新品=1
    AND V_订单细则简略视图.投产 IN ( '0' , '1' )
    AND 订单细则.订单细则号 NOT IN (SELECT 订单细则号 FROM 订单评审 with (nolock))
  )
    OR ( 订单评审.是否需要特殊评审=1 AND V_订单细则简略视图.投产 IN ( '0' , '1' ) )
)
  AND 订单评审.传参 IS NULL
  ORDER BY 订单细则号";
	
	$res = fetchAll($query);

	foreach ($res as $val) {
		if ($val['铸造']) {$val['铸造'] = "<input  type='checkbox' checked='checked' onclick='return false';>";} else { $val['铸造'] = "<input  type='checkbox' onclick='return false';>";}
		if ($val['金工']) {$val['金工'] = "<input  type='checkbox' checked='checked' onclick='return false';>";} else { $val['金工'] = "<input  type='checkbox' onclick='return false';>";}
		if ($val['新品']) {$val['新品'] = "<input  type='checkbox' checked='checked' onclick='return false';>";} else { $val['新品'] = "<input  type='checkbox' onclick='return false';>";}
		if ($val['特急件'] == '是') {$val['特急件'] = "<input  type='checkbox' checked='checked' onclick='return false';>";} else { $val['特急件'] = "<input  type='checkbox' onclick='return false';>";}

		if ($val['参考重量']) {
			$val['参考重量'] = sprintf("%.2f", $val['参考重量']);
		}

		echo "<tr>";
		echo "<td class='trzz'>" . $val['铸造'] . "</td>";
		echo "<td class='trjg'>" . $val['金工'] . "</td>";
		echo "<td class='trxp'>" . $val['新品'] . "</td>";
		echo "<td class='trtj'>" . $val['特急件'] . "</td>";
		echo "<td class='trhth'>" . $val['合同号'] . "</td>";
		echo "<td class='trkhjc'>" . $val['客户简称'] . "</td>";
		echo "<td class='trhtyq' style=\"text-align: left;\">" . $val['合同要求'] . "</td>";
		echo "<td class='trhtyq'>" . $val['生产方式'] . "</td>";
		echo "<td class='trdhrq'>" . $val['订货日期'] . "</td>";
		echo "<td class='trjhrq  identity'>" . $val['细则交货日期'] . "</td>";
		echo "<td class='trdhsl identity'>" . $val['订货数量'] . "</td>";
		echo "<td class='trkc'>" . $val['库存'] . "</td>";
		echo "<td class='trzjmc'>" . $val['铸件名称'] . "</td>";
		echo "<td class='trcz'>" . $val['材质'] . "</td>";
		echo "<td class='trzjms' style=\"text-align: left;\">" . $val['铸件描述'] . "</td>";
		echo "<td class='trckzl'>" . $val['参考重量'] . "</td>";
		echo "<td class='trth'>" . $val['规格'] . "</td>";
		echo "<td class='trth'>" . $val['型号'] . "</td>";
		echo "<td class='trth'>" . $val['图号'] . "</td>";
		echo "<td class='trzjbh'>" . $val['铸件编号'] . "</td>";
		echo "<td class='trddxzh'>" . $val['订单细则号'] . "</td>";
		echo "<td class='trcc'>" . $val['传参'] . "</td>";
		echo "</tr>";

	}

} catch (PDOException $e) {
	echo $e->getMessage() . "<br>";
	die;
}

