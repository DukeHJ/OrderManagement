<?php
/*
 *连接数据库
 */
/**
 * @return PDO
 */
function connect() {
	$host = DB_HOST;
	$dbname = DB_DBNAME;
	$dbms = DB_TYPE;
	$user = DB_USER;
	$pwd = DB_PWD;
	$dsn = "$dbms:server=$host;Database=$dbname";
	try {
		$pdo = new PDO($dsn, $user, $pwd);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $pdo;
	} catch (PDOException $e) {
		die("数据库连接失败Error: " . $e->getMessage());
	}
}

/**
 * @param $table
 * @param $array
 * @return int
 */
function insert($table, $array) {
	$pdo = connect();
	try {
		$pdo->beginTransaction();
		$keys = join(",", array_keys($array));
		$vals = "'" . join("','", array_values($array)) . "'";
		$sql = "insert into {$table}($keys) values ({$vals})";
		$result = $pdo->prepare($sql);
		$result->execute();
		$pdo->commit();
        $pdo = null;
		return $result->rowCount();
	} catch (PDOException $e) {
		$pdo->rollBack();
		die("Error: " . $e->getMessage());
	}
}

/**
 * @param $table
 * @param $array
 * @param null $where
 * @return int
 */
function update($table, $array, $where = null) {
	$pdo = connect();
	$str = "";
	foreach ($array as $key => $val) {
		if ($val == null) {
			$sep = "";
		} else {
			$sep = ",";
		}
		$str .= $key . "='" . $val . "'" . $sep;
	}
	$str = rtrim($str, ",");
	$sql = "update {$table} set {$str} " . ($where == null ? null : " where " . $where);
	try {
		$pdo->beginTransaction();
		$result = $pdo->prepare($sql);
		$result->execute();
		$pdo->commit();
        $pdo = null;
		return $result->rowCount();
	} catch (PDOException $e) {
		$pdo->rollBack();
		die("Error: " . $e->getMessage());
	}
}

/**
 * @param $table
 * @param null $where
 * @return int
 */
function delete($table, $where = null) {
	$pdo = connect();
	$where = $where == null ? null : " where " . $where;
	$sql = "delete from {$table} {$where}";
	try {
		$result = $pdo->prepare($sql);
		$result->execute();
        $pdo = null;
		return $result->rowCount();
	} catch (PDOException $e) {
		$pdo->rollBack();
		die("Error: " . $e->getMessage());
	}
}

/**
 * @param $sql
 * @return mixed
 */
function fetchOne($sql) {
	$pdo = connect();
	$result = $pdo->prepare($sql);
	$result->execute();
	$res = $result->fetch(PDO::FETCH_ASSOC);
	$pdo = null;
    //return transCoding($res);//php7
    return $res;//php5
}

/**
 * @param $sql
 * @return array
 */
function fetchAll($sql) {
	$pdo = connect();
	$result = $pdo->prepare($sql);
	$result->execute();
	$res = $result->fetchAll(PDO::FETCH_ASSOC);
    $pdo = null;
    //return transCoding($res);//php7
    return $res;//php5
}

/**
 * php7数组中文key值转码
 * @param $rows
 * @return array
 */
function transCoding($rows) {
    $tmp=array();
	foreach ($rows as $key => $val){
        if(is_array($val)){
            $tmp[$key]=transCoding($val);
        }else{
            $k2=iconv("gbk//ignore", "utf-8", $key);
            $tmp[$k2]=  $val;
        }
    }
	return $tmp;
}

/**
 * @param $sql
 * @return mixed
 */
function fetchColumn($sql) {
	$pdo = connect();
	$result = $pdo->prepare($sql);
	$result->execute();
	$res = $result->fetchColumn(0);
	$pdo = null;
	return str_replace(' ', '', $res);
}

/**
 * @param $sql
 * @return int
 */
function getResultNum($sql) {
	$pdo = connect();
	$result = $pdo->prepare($sql);
	$result->execute();
	$res = $result->fetchAll(PDO::FETCH_ASSOC);
    $pdo = null;
	return count($res);
}

/**
 * @param $sql
 * @param $V
 * @param $T1
 * @param null $T2
 */
function echoOption($sql, $V, $T1, $T2 = null) {
	$stp = "&nbsp;";
	$res = fetchAll($sql);
	if (count($res) > 0) {
		echo "<option value=''></option>";
		foreach ($res as $k => $v) {
			echo '<option value="' . trim($v[$V]) . '">' . trim($v[$T1]) . ($T2 == null ? null : $stp . $stp . $v[$T2]) . '</option>';
		}
	} else {
		echo "0";
	}
}
