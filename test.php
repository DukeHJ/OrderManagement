<?php
include 'include.php';
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
WHERE 铸件单件.细则号 = 'HU1601004001'
ORDER BY 铸件单件作业过程.作业顺序 ";
$res=fetchAll($sql);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php var_dump($res);?>
</body>
</html>