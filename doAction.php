<?php
require 'include.php';
$act = $_REQUEST['act'];
if ($act == 'logout') {
    logout();
} elseif ($act == 'login') {
    login();
} elseif ($act == "checkVerify") {
    checkVerify();
} elseif ($act == "adduser") {
    adduser();
} elseif ($act == "edituser") {
    $userid = $_REQUEST['userid'];
    editUser($userid);
} elseif ($act == "deluser") {
    $userid = $_REQUEST['userid'];
    delUser($userid);
} elseif ($act == "getxzh") {
    $ddbh = $_REQUEST['ddbh'];
    getOrderXZ($ddbh);
} elseif ($act == "getxzh2") {
    $ddbh = $_REQUEST['ddbh'];
    getOrderXZ2($ddbh);
} elseif ($act == "getdjbs") {
    $ddxzh = $_REQUEST['ddxzh'];
    getCastingBS($ddxzh);
}

if ($act == "order_statistics_query") {
    $month = $_REQUEST["month"];
    $client = $_REQUEST["client"];
    $contract = $_REQUEST["contract"];
    order_statistics_query($month, $client, $contract);
}

if ($act == "order_info_query.php") {
    $date1 = $_POST['date1'];
    $date2 = $_POST['date2'];
    $date3 = $_POST['date3'];
    $date4 = $_POST['date4'];
    $client = $_POST["client"];
    $contract = $_POST["contract"];
    order_info_query($date1, $date2, $date3, $date4, $client, $contract);
}

if ($act == "track_single_pro") {
    $ddxzh = $_GET['ddxzh'];
    track_single_pro($ddxzh);
}
if ($act == "track_xz_overview") {
    $ddxzh = $_GET['ddxzh'];
    track_xz_overview($ddxzh);
}
if ($act == "track_xz_pro_r") {
    $ddbh = $_GET['ddbh'];
    track_xz_pro_r($ddbh);
}
if ($act == "track_xz_pro") {
    $ddbh = $_GET['ddbh'];
    track_xz_pro($ddbh);
}

if ($act == "insert_order") {
    $ddzbtj = explode(",", $_GET["ddzbtj"]);
    $ddxzs = $_GET["ddxzs"];
    if ($ddxzs) {
        $ddxztj = $_GET["Nformxz"];
    } else {
        $ddxztj = null;
    }
    $ddfys = $_GET["ddfys"];
    if ($ddfys) {
        $ddfytj = $_GET["Nformfy"];
    } else {
        $ddfytj = null;
    }
    insert_order($ddzbtj, $ddxzs, $ddxztj, $ddfys, $ddfytj);
}


if ($act == "sign_log") {
    $zhigongname = trim($_GET["zhigongname"]);
    $zhigongpassword = md5(trim($_GET["zhigongpassword"]));
    sign_log($zhigongname, $zhigongpassword);
}

if ($act == "insertRN") {
    $ddpsyb = $_GET["Nform"];
    insertRN($ddpsyb);
}


if ($act == "insertRS") {
    $C1 = $_GET['C1'];
    $C2 = $_GET['C2'];
    $C3 = $_GET['C3'];
    $C4 = $_GET['C4'];
    $C5 = $_GET['C5'];
    $C7 = $_GET['C7'];
    $C8 = $_GET['C8'];
    $C9 = $_GET['C9'];
    $C10 = $_GET['C10'];
    $C11 = $_GET['C11'];
    $C12 = $_GET['C12'];
    $C13 = $_GET['C13'];
    $C14 = $_GET['C14'];
    $C15 = $_GET['C15'];
    $C16 = $_GET['C16'];
    $C17 = $_GET['C17'];
    $C18 = $_GET['C18'];
    $C19 = $_GET['C19'];
    $C20 = $_GET['C20'];
    $C21 = $_GET['C21'];
    $C23 = $_GET['C23'];
    $C24 = $_GET['C24'];
    $C25 = $_GET['C25'];
    $C26 = $_GET['C26'];
    $C27 = $_GET['C27'];
    $C28 = $_GET['C28'];
    $C29 = $_GET['C29'];
    $C30 = $_GET['C30'];
    $C31 = $_GET['C31'];
    $C32 = $_GET['C32'];
    $C33 = $_GET['C33'];
    $C34 = $_GET['C34'];
    $C35 = $_GET['C35'];
    $C36 = $_GET['C36'];
    $C37 = $_GET['C37'];
    $C38 = $_GET['C38'];
    $C39 = $_GET['C39'];
    insertRS($C1, $C2, $C3, $C4, $C5, $C7, $C8, $C9, $C10, $C11, $C12, $C13, $C14, $C15, $C16, $C17, $C18, $C19, $C20, $C21, $C23, $C24, $C25, $C26, $C27, $C28, $C29, $C30, $C31, $C32, $C33, $C34, $C35, $C36, $C37, $C38, $C39);
}


