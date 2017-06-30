<?php

/**
 *登录
 */
function login()
{
    $username = $_GET["username"];
    $username = addslashes($username);
    $password = $_GET["password"];

    $sql = "SELECT 用户登陆.登陆名,用户登陆.用户权限,用户登陆.用户组,职工信息.职工编号
FROM 用户登陆 left outer join 职工信息 on 职工信息.职工编号=用户登陆.对应工号
where 用户登陆.登陆名 = ? and 用户登陆.登陆密码= ? and 职工信息.是否离职='N'";

    $pdo = connect();
    $result = $pdo->prepare($sql);
    $result->bindParam(1, $username);
    $result->bindParam(2, $password);
    $result->execute();
    $res = $result->fetch(PDO::FETCH_ASSOC);
    $pdo = null;

    if ($res) {
        $_SESSION['username'] = str_replace(' ', '', $username);
        $_SESSION['purview'] = $res['用户权限'];
        $_SESSION['usergroup'] = trim($res['用户组']);
        $_SESSION['userid'] = trim($res['职工编号']);
        echo "1";
    } else {
        echo "0";
    }
}

/**
 * 签名认证
 * @param $zhigongname
 * @param $zhigongpassword
 */
function sign_log($zhigongname, $zhigongpassword)
{
    $sql = "SELECT top 1 职工姓名 FROM 职工信息 where 职工姓名 = ? and 认证密码= ? and 职工信息.是否离职='N'";
    $pdo = connect();
    $result = $pdo->prepare($sql);
    $result->bindParam(1, $zhigongname);
    $result->bindParam(2, $zhigongpassword);
    $result->execute();
    $res = $result->fetch(PDO::FETCH_ASSOC);
    $pdo = null;
    if ($res) {
        echo "1";
    } else {
        echo "0";
    }
}


/**
 *登出
 */
function logout()
{
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), "", time() - 1);
    }
    session_destroy();
    header("location:login.php");
}

/**
 *检查验证码
 */
function checkVerify()
{
    $valid = false;
    $message = '验证码不正确';
    $verify = $_GET["verify"];
    $verify1 = $_SESSION["verify"];
    if (strcasecmp($verify, $verify1) == 0) {
        $valid = true;
        $message = '';
    }

    echo json_encode(
        $valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $message)
    );
}


/**
 *
 */
function adduser()
{
    $arr = $_POST;
    if (insert("用户登陆", $arr)) {
        echo "保存成功！<a href='listUser.php'>返回用户列表</a>";
    }
}

/**
 * @return array
 */
function getAllUser()
{
    $sql = "SELECT   用户登陆.用户ID ,用户登陆.登陆名  ,  用户登陆.用户组 , 用户登陆.对应工号 ,  职工信息.职工姓名 , 部门.部门名称 ,  用户登陆.创建时间
FROM
  用户登陆
  LEFT OUTER JOIN 职工信息 ON 用户登陆.对应工号=职工信息.职工编号
  LEFT OUTER JOIN 部门 ON 部门.部门编号=职工信息.部门编号 ";
    $rows = fetchAll($sql);
    return $rows;
}

/**
 * @param $userid
 */
function editUser($userid)
{
    $arr = $_POST;
    //print_r( $arr);
    $table = "用户登陆";
    if (update($table, $arr, "用户ID={$userid}")) {
        echo "编辑成功！<a href='listUser.php'>返回用户列表</a>";
    }
}

/**
 * @param $userid
 */
function delUser($userid)
{
    if (delete("用户登陆", "用户ID={$userid}")) {
        echo "删除成功！<a href='listUser.php'>返回用户列表</a>";
    }
}


/**
 * 施工单跟踪-订单编号带细则号
 * @param $ddbh
 */
function getOrderXZ($ddbh)
{
    $sql = "SELECT DISTINCT 铸件单件.细则号,  铸件单件.工艺单铸件标识  FROM 铸件单件 WITH ( nolock )
INNER JOIN V_订单细则简略视图 WITH ( nolock ) ON V_订单细则简略视图.订单细则号 = 铸件单件.细则号
WHERE V_订单细则简略视图.订单编号 in ('{$ddbh}')";
    echoOption($sql, '细则号', '细则号', '工艺单铸件标识');
}

function getOrderXZ2($ddbh)
{
    $sql = "SELECT  V_订单细则简略视图.订单细则号 FROM V_订单细则简略视图
WHERE V_订单细则简略视图.订单编号 in ('{$ddbh}')";
    echoOption($sql, '订单细则号', '订单细则号');
}

/**
 * 施工单跟踪-细则号带单件标识
 * @param $ddxzh
 */
function getCastingBS($ddxzh)
{
    $sql = "SELECT 铸件单件.单件标识 FROM 铸件单件 WITH ( nolock ) 
INNER JOIN V_订单细则简略视图 WITH ( nolock ) ON V_订单细则简略视图.订单细则号 = 铸件单件.细则号
WHERE 铸件单件.细则号 in ('{$ddxzh}')";
    echoOption($sql, '单件标识', '单件标识');
}

/**
 * @param $djbs
 * @return array
 */
function trackSg($djbs)
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
WHERE 铸件单件.单件标识 = '{$djbs}'
ORDER BY 铸件单件作业过程.作业顺序 ";
    $rows = fetchAll($sql);
    return $rows;
}


function statistics($filter = null)
{
    $sql = "SELECT
  V_订单.订单编号 ,  V_订单.订货项数 ,  V_订单.订货日期 ,  V_订单.应收金额 ,  V_订单.开发票 ,
  V_订单.订单细则号 ,  V_订单.重量价格 ,  V_订单.订货数量 ,  V_订单.细则交货日期 ,  V_订单.细则重量 ,
  V_订单.特急件 ,  铸件清单.铸件名称 ,  V_订单.铸造 ,  V_订单.金工 ,  订单.客户 ,
 ( SELECT  职工姓名 FROM 职工信息  WHERE 职工编号=V_订单.业务员) AS 业务员 ,  订单.合同号 ,  铸件清单.铸件描述
FROM
  订单
  RIGHT OUTER JOIN V_订单 ON 订单.订单编号 = V_订单.订单编号
  LEFT OUTER JOIN 铸件清单 ON V_订单.铸件编号 = 铸件清单.铸件编号
  LEFT OUTER JOIN 客户 ON v_订单.客户号=客户.客户号
WHERE
  (
  (
    SELECT
      权限
    FROM
      系统角色
    WHERE
      系统角色='业务员'
      AND 职工号= (
      SELECT
        对应工号
      FROM
        用户登陆
      WHERE
        登陆名='huazhu'
    )
  ) LIKE '%' + rtrim ( 客户.客户 ) + '%'
    OR 'AP01' NOT IN ( '1400' )
    OR isnull (
    (
      SELECT
        权限
      FROM
        系统角色
      WHERE
        系统角色='业务员'
        AND 职工号= (
      
        SELECT
          对应工号
        FROM
          用户登陆
        WHERE
          登陆名='huazhu'  
      )
    ) ,
      ''
  ) = ''
) " . $filter . " ORDER BY V_订单.订单编号";
    $res = fetchAll($sql);
    return $res;
}


function insertRN($ddpsyb)
{
    try {
        $pdo = connect();
        $pdo->beginTransaction();

        if ($ddpsyb) {
            for ($xs = 0; $xs < count($ddpsyb); $xs++) {
                $ddpsyb[$xs] = str_replace("''", 'null', $ddpsyb[$xs]);
                $ddpsxz = explode(",", $ddpsyb[$xs]);

                $query = "IF EXISTS(SELECT * FROM 订单评审 WHERE 订单细则号= " . $ddpsxz[0] . " )
			BEGIN
			UPDATE 订单评审 SET 生产数量=" . $ddpsxz[1] . "  ,调出仓库=" . $ddpsxz[2] . "  ,调拨数量=" . $ddpsxz[3] . "  ,调入仓库=" . $ddpsxz[4] . "  ,加工交期=" . $ddpsxz[5] . " ,加工评审结论=" . $ddpsxz[6] . " ,机加工评审= (SELECT 职工编号 FROM 职工信息 WHERE 职工姓名 = " . trim($ddpsxz[7]) . " ),机加工评审时间=" . $ddpsxz[8] . " ,是否需要特殊评审=" . $ddpsxz[9] . " ,生产交期=" . $ddpsxz[10] . " ,生产部结论=" . $ddpsxz[11] . " ,生产评审=(SELECT 职工编号 FROM 职工信息 WHERE 职工姓名=" . trim($ddpsxz[12]) . " ),生产评审时间=" . $ddpsxz[13] . "  WHERE 订单细则号= " . $ddpsxz[0] . "
			END
			ELSE
			BEGIN
			INSERT INTO 订单评审(订单细则号,生产数量,调出仓库,调拨数量,调入仓库,加工交期,加工评审结论,机加工评审,机加工评审时间,是否需要特殊评审,生产交期,生产部结论,生产评审,生产评审时间) values (" . $ddpsxz[0] . "," . $ddpsxz[1] . "," . $ddpsxz[2] . "," . $ddpsxz[3] . "," . $ddpsxz[4] . "," . $ddpsxz[5] . "," . $ddpsxz[6] . ",(SELECT 职工编号 FROM 职工信息 WHERE 职工姓名=" . $ddpsxz[7] . ")," . $ddpsxz[8] . "," . $ddpsxz[9] . "," . $ddpsxz[10] . "," . $ddpsxz[11] . ",(SELECT 职工编号 FROM 职工信息 WHERE 职工姓名=" . $ddpsxz[12] . ")," . $ddpsxz[13] . ")
			END";
                //print_r($query);
                $pdo->exec($query);
            }
        }
        $pdo->commit();
        echo "保存成功!提交了" . $xs . "条记录。";

    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "数据保存时发生错误，错误报告：" . "\n";
        echo $e->getMessage() . "\n";
        die;
    }
}

function insertRS($C1, $C2, $C3, $C4, $C5, $C7, $C8, $C9, $C10, $C11, $C12, $C13, $C14, $C15, $C16, $C17, $C18, $C19, $C20, $C21, $C23, $C24, $C25, $C26, $C27, $C28, $C29, $C30, $C31, $C32, $C33, $C34, $C35, $C36, $C37, $C38, $C39)
{
    try {
        $query = "IF EXISTS(SELECT * FROM 订单评审 WHERE 订单细则号= " . $C1 . " )
    BEGIN
    UPDATE 订单评审 SET 传参=" . $C2 . " 调出仓库=" . $C3 . " 调拨数量=" . $C4 . " 调入仓库=" . $C5 . " 销售部结论=" . $C7 . " 业务部=" . $C8 . " 业务签名时间=" . $C9 . " 检具量具=" . $C10 . " 检验标准书=" . $C11 . " 历史品质记录=" . $C12 . " 质量部结论=" . $C13 . " 品管部=" . $C14 . " 品管签名时间=" . $C15 . " 供应部结论=" . $C16 . " PMC=" . $C17 . " PMC签名时间=" . $C18 . " 图纸=" . $C19 . " 工艺成熟=" . $C20 . " 工艺卡=" . $C21 . " 技术部结论=" . $C23 . " 技术部=" . $C24 . " 技术签名时间=" . $C25 . " 加工交期=" . $C26 . " 加工评审结论=" . $C27 . " 机加工评审=" . $C28 . "  机加工评审时间=" . $C29 . " 模具=" . $C30 . "模具交期=" . $C31 . " 生产数量=" . $C32 . " 生产交期=" . $C33 . " 生产部结论=" . $C34 . " 生产评审=" . $C35 . " 生产评审时间=" . $C36 . " 总经理结论=" . $C37 . " 确认签名=" . $C38 . " 确认签名时间=" . $C39 . " WHERE 订单细则号 = " . $C1 . "
    END
    ELSE
    BEGIN
    INSERT INTO 订单评审 (订单细则号,传参,调出仓库,调拨数量,调入仓库,销售部结论,业务部,业务签名时间,检具量具,检验标准书,历史品质记录,质量部结论,品管部,品管签名时间,供应部结论,PMC,PMC签名时间,图纸,工艺成熟,工艺卡,技术部结论,技术部,技术签名时间,加工交期,加工评审结论,机加工评审,机加工评审时间,模具,模具交期,生产数量,生产交期,生产部结论,生产评审,生产评审时间,总经理结论,确认签名,确认签名时间) VALUES (" . $C1 . "," . $C2 . $C3 . $C4 . $C5 . $C7 . $C8 . $C9 . $C10 . $C11 . $C12 . $C13 . $C14 . $C15 . $C16 . $C17 . $C18 . $C19 . $C20 . $C21 . $C23 . $C24 . $C25 . $C26 . $C27 . $C28 . $C29 . $C30 . $C31 . $C32 . $C33 . $C34 . $C35 . $C36 . $C37 . $C38 . $C39 . ")
    END";
        $query = str_replace("''", 'null', $query);
        $pdo = connect();
        $pdo->beginTransaction();
        $result = $pdo->prepare($query);
        $result->execute();
        $pdo->commit();
        echo "保存成功!";

    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "数据保存时发生错误，错误报告：" . "\n";
        echo $e->getMessage() . "\n";
        die;
    }
}