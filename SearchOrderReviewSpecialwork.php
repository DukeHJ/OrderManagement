<?php
try
{
 
	$query = "SELECT 订单评审.订单细则号 ,  订单评审.图纸 ,  订单评审.模具 ,  订单评审.样品 ,  订单评审.检验标准书 , 订单评审.检具量具 ,  订单评审.历史品质记录 ,  订单评审.工艺成熟 ,  订单评审.工装夹具 ,  订单评审.工艺卡 , 订单评审.整形模 ,  (SELECT CONVERT(date, 订单评审.生产交期, 23) )AS 生产交期,  V_订单细则简略视图.铸件名称 ,  V_订单细则简略视图.订货数量 ,  V_订单细则简略视图.材质 ,(SELECT CONVERT(date, V_订单细则简略视图.细则交货日期, 23) )AS 细则交货日期 ,  V_订单细则简略视图.图号 ,  (SELECT 职工姓名 FROM 职工信息 WHERE 职工编号 = 订单评审.业务部) AS 业务部  ,   (SELECT 职工姓名 FROM 职工信息 WHERE 职工编号 = 订单评审.品管部) AS 品管部   ,  (SELECT 职工姓名 FROM 职工信息 WHERE 职工编号 = 订单评审.技术部) AS 技术部   , (SELECT CONVERT(date, 订单评审.业务签名时间 , 23) )AS 业务签名时间 , (SELECT CONVERT(date, 订单评审.品管签名时间 , 23) )AS 品管签名时间, (SELECT CONVERT(date, 订单评审.技术签名时间 , 23) )AS 技术签名时间,   (SELECT 职工姓名 FROM 职工信息 WHERE 职工编号 = 订单评审.PMC) AS PMC   ,  (SELECT CONVERT(date, 订单评审.PMC签名时间 , 23) )AS PMC签名时间 , (SELECT CONVERT(date, V_订单细则简略视图.订货日期 , 23) )AS 订货日期,  V_订单细则简略视图.合同号 ,  V_订单细则简略视图.新品 ,  (SELECT 职工姓名 FROM 职工信息 WHERE 职工编号 = 订单评审.生产评审) AS 生产评审,  (SELECT CONVERT(date, 订单评审.生产评审时间 , 23) )AS 生产评审时间, 订单细则.图纸链接 ,  (SELECT CONVERT(date, 订单.下单日期 , 23) )AS 下单日期,  V_订单细则简略视图.规格 ,  V_订单细则简略视图.型号 ,  V_订单细则简略视图.产品编号 , 铸件清单.生产方式 ,  订单评审.生产数量 ,  Convert(decimal(18,2),铸件清单.参考重量) AS 参考重量 ,  订单细则.合同要求 ,  V_订单细则简略视图.客户简称 ,  铸件清单.常用模具 ,  订单细则.铸件编号 ,  V_订单细则简略视图.细则备注 ,  订单评审.调拨数量 ,  (SELECT 仓库名称 FROM 仓库 WHERE 仓库编号= 订单评审.调出仓库) AS 调出仓库 ,  (SELECT 仓库名称 FROM 仓库 WHERE 仓库编号 = 订单评审.调入仓库) AS 调入仓库 ,  V.库存 AS 库存 ,  V_订单细则简略视图.金工 ,   (SELECT 职工姓名 FROM 职工信息 WHERE 职工编号 = 订单评审.确认签名) AS 确认签名  ,  (SELECT CONVERT(date, 订单评审.确认签名时间 , 23) )AS 确认签名时间,  订单评审.生产部结论 ,  订单评审.销售部结论 ,  订单评审.质量部结论 ,  订单评审.总经理结论 ,  订单评审.供应部结论 ,  订单评审.技术部结论 ,  (SELECT CONVERT(date, 订单评审.模具交期 , 23) )AS 模具交期,(SELECT CONVERT(date, 订单评审.加工交期 , 23) )AS 加工交期 ,  订单评审.加工评审结论 ,  (SELECT 职工姓名 FROM 职工信息 WHERE 职工编号 = 订单评审.机加工评审) AS 机加工评审   ,  (SELECT CONVERT(date, 订单评审.机加工评审时间 , 23) )AS 机加工评审时间 ,  订单细则.特急件 ,  订单细则.铸造 ,  铸件清单.铸件描述 ,  rtrim ( CONVERT ( CHAR ( 10 ) , getdate ( ) , 112 ) ) +right ( ( CAST ( 序号 AS CHAR ( 20 ) ) +10000 ) , 4 ) AS 序号 ,  订单评审.是否需要特殊评审 ,  订单评审.传参
    FROM
  订单评审 WITH ( NOLOCK )
  LEFT OUTER JOIN V_订单细则简略视图 WITH ( NOLOCK ) ON 订单评审.订单细则号=V_订单细则简略视图.订单细则号
  LEFT OUTER JOIN 订单细则 WITH ( NOLOCK ) ON 订单细则.订单细则号=订单评审.订单细则号
  LEFT OUTER JOIN 部门 WITH ( NOLOCK ) ON 订单细则.投产部门=部门.部门编号
  LEFT OUTER JOIN 订单 WITH ( NOLOCK ) ON 订单.订单编号=订单细则.订单编号
  LEFT OUTER JOIN 铸件清单 WITH ( NOLOCK ) ON 订单细则.铸件编号=铸件清单.铸件编号
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
  ORDER BY 订单细则号";
	 
	$res = fetchAll($query);

	foreach ($res as $val) {
		if ($val['铸造']) {$val['铸造'] = "<input  type='checkbox' checked='checked' value='1'  onclick='return false'>";} else { $val['铸造'] = "<input  type='checkbox' onclick='return false' value='0'>";}
		if ($val['金工']) {$val['金工'] = "<input  type='checkbox' checked='checked' value='1' onclick='return false'>";} else { $val['金工'] = "<input  type='checkbox' onclick='return false' value='0'>";}
		if ($val['新品']) {$val['新品'] = "<input  type='checkbox' checked='checked' value='1' onclick='return false'>";} else { $val['新品'] = "<input  type='checkbox' onclick='return false' value='0'>";}
		if ($val['特急件'] == '是') {$val['特急件'] = "<input  type='checkbox' checked='checked' value='1' onclick='return false'>";} else { $val['特急件'] = "<input  type='checkbox' onclick='return false' value='0'>";}

		if ($val['图纸']) {$val['图纸'] = "<input  type='checkbox' checked='checked' value='1' onclick='return false'>";} else { $val['图纸'] = "<input  type='checkbox' onclick='return false' value='0'>";}
		if ($val['工艺成熟']) {$val['工艺成熟'] = "<input  type='checkbox' checked='checked' value='1' onclick='return false'>";} else { $val['工艺成熟'] = "<input  type='checkbox' onclick='return false' value='0'>";}
		if ($val['工艺卡']) {$val['工艺卡'] = "<input  type='checkbox' checked='checked' value='1' onclick='return false'>";} else { $val['工艺卡'] = "<input  type='checkbox' onclick='return false' value='0'>";}
		if ($val['模具']) {$val['模具'] = "<input  type='checkbox' checked='checked' value='1' onclick='return false'>";} else { $val['模具'] = "<input  type='checkbox' onclick='return false' value='0'>";}
		if ($val['检具量具']) {$val['检具量具'] = "<input  type='checkbox' checked='checked' value='1' onclick='return false'>";} else { $val['检具量具'] = "<input  type='checkbox' onclick='return false' value='0'>";}
		if ($val['检验标准书']) {$val['检验标准书'] = "<input  type='checkbox' checked='checked' value='1' onclick='return false' >";} else { $val['检验标准书'] = "<input  type='checkbox' onclick='return false'  value='0'>";}

		echo "<tr>";
		echo "<td class='trcc'>" . $val['传参'] . "</td>";
		echo "<td class='trzz'>" . $val['铸造'] . "</td>";
		echo "<td class='trjg'>" . $val['金工'] . "</td>";
		echo "<td class='trxp'>" . $val['新品'] . "</td>";
		echo "<td class='trtj'>" . $val['特急件'] . "</td>";
		echo "<td class='trxh'>" . $val['序号'] . "</td>";
		echo "<td class='trkhjc'>" . $val['客户简称'] . "</td>";
		echo "<td class='trdhrq'>" . $val['订货日期'] . "</td>";
		echo "<td class='trhth'>" . $val['合同号'] . "</td>";
		echo "<td class='trhtyq' style=\"text-align: left;\">" . $val['合同要求'] . "</td>";
		echo "<td class='trddxzh'>" . $val['订单细则号'] . "</td>";
		echo "<td class='trzjbh'>" . $val['铸件编号'] . "</td>";
		echo "<td class='trzjmc' style=\"text-align: left;\">" . $val['铸件名称'] . "</td>";
		echo "<td class='trzjms'>" . $val['铸件描述'] . "</td>";
		echo "<td class='trcz'>" . $val['材质'] . "</td>";
		echo "<td class='trckzl'>" . $val['参考重量'] . "</td>";
		echo "<td class='trth'>" . $val['图号'] . "</td>";
		echo "<td class='trjhrq'>" . $val['细则交货日期'] . "</td>";
		echo "<td class='trdhsl'>" . $val['订货数量'] . "</td>";
		echo "<td class='trkc'>" . $val['库存'] . "</td>";
		echo "<td class='trdcck'>" . $val['调出仓库'] . "</td>";
		echo "<td class='trdbsl'>" . $val['调拨数量'] . "</td>";
		echo "<td class='trdrck'>" . $val['调入仓库'] . "</td>";
		echo "<td class='trxsbjl'>" . $val['销售部结论'] . "</td>";
		echo "<td class='trxsb'>" . $val['业务部'] . "</td>";
		echo "<td class='trxsbqmsj'>" . $val['业务签名时间'] . "</td>";
		echo "<td class='trjcnl'>" . $val['检具量具'] . "</td>";
		echo "<td class='trjybzs'>" . $val['检验标准书'] . "</td>";
		echo "<td class='trlspzjl'>" . $val['历史品质记录'] . "</td>";
		echo "<td class='trzlbjl'>" . $val['质量部结论'] . "</td>";
		echo "<td class='trzlb'>" . $val['品管部'] . "</td>";
		echo "<td class='trzlbqmsj'>" . $val['品管签名时间'] . "</td>";
		echo "<td class='trgybjl'>" . $val['供应部结论'] . "</td>";
		echo "<td class='trgyb'>" . $val['PMC'] . "</td>";
		echo "<td class='trgybqmsj'>" . $val['PMC签名时间'] . "</td>";
		echo "<td class='trtz'>" . $val['图纸'] . "</td>";
		echo "<td class='trgycs'>" . $val['工艺成熟'] . "</td>";
		echo "<td class='trgyk'>" . $val['工艺卡'] . "</td>";
		echo "<td class='trjsbjl'>" . $val['技术部结论'] . "</td>";
		echo "<td class='trjsb'>" . $val['技术部'] . "</td>";
		echo "<td class='trjsbqmsj'>" . $val['技术签名时间'] . "</td>";
		echo "<td class='trjgjq'>" . $val['加工交期'] . "</td>";
		echo "<td class='trjgpsjl'>" . $val['加工评审结论'] . "</td>";
		echo "<td class='trjjgps'>" . $val['机加工评审'] . "</td>";
		echo "<td class='trjjgpssj'>" . $val['机加工评审时间'] . "</td>";
		echo "<td class='trmj'>" . $val['模具'] . "</td>";
		echo "<td class='trmjjq'>" . $val['模具交期'] . "</td>";
		echo "<td class='trscsl'>" . $val['生产数量'] . "</td>";
		echo "<td class='trscjq'>" . $val['生产交期'] . "</td>";
		echo "<td class='trscbjl'>" . $val['生产部结论'] . "</td>";
		echo "<td class='trscps'>" . $val['生产评审'] . "</td>";
		echo "<td class='trscpssj'>" . $val['生产评审时间'] . "</td>";
		echo "<td class='trzjljl'>" . $val['总经理结论'] . "</td>";
		echo "<td class='trqrqm'>" . $val['确认签名'] . "</td>";
		echo "<td class='trqrqmsj'>" . $val['确认签名时间'] . "</td>";
		echo "</tr>";

	}

} catch (PDOException $e) {
	echo $e->getMessage() . "<br>";
	die;
}

