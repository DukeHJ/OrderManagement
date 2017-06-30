<?php
require 'include.php';
$pdo = connect();
$query = $_GET["sql"];
$lmcc1 = $_GET["lmc1"];
$lmcc2 = $_GET["lmc2"];
$lmcc3 = $_GET["lmc3"];
$lzcc = $_GET["lzc"];

$result = $pdo->prepare($query);
$result->execute();
$res = $result->fetchall(PDO::FETCH_ASSOC);
if (count($res) > 0) {
    for ($i = 0; $i < count($res); $i++) {
        if ($lmcc2) {
            if ($lmcc3) {
                echo '<option value="' . trim($res[$i][$lzcc]) . '">' . trim($res[$i][$lmcc1]) . '&nbsp;&nbsp;&nbsp;' . trim($res[$i][$lmcc2]) . '&nbsp;&nbsp;&nbsp;' . $res[$i][$lmcc3] . '</option>';
            } else {
                echo '<option value="' . trim($res[$i][$lzcc]) . '">' . trim($res[$i][$lmcc1]) . '&nbsp;&nbsp;&nbsp;' . trim($res[$i][$lmcc2]) . '</option>';
            }
        } else {
            echo '<option value="' . trim($res[$i][$lzcc]) . '">' . trim($res[$i][$lmcc1]) . '</option>';
        }
    }
} else {
    echo "";
}

