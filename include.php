<?php
session_start();
$purview=isset($_SESSION['purview'])?$_SESSION['purview']:array();
define('G_GLOBAL_PATH', dirname(__FILE__));
define('G_INCLUDE_PATH', G_GLOBAL_PATH . '/lib');
//set_include_path(".".PATH_SEPARATOR.ROOT."/lib". PATH_SEPARATOR.ROOT."/core". PATH_SEPARATOR.get_include_path());

require_once G_INCLUDE_PATH . '/pdo.func.php';
require_once G_INCLUDE_PATH . '/image.func.php';
require_once G_INCLUDE_PATH . '/common.func.php';
require_once G_INCLUDE_PATH . '/page.func.php';
require_once G_INCLUDE_PATH . '/string.func.php';
require_once G_INCLUDE_PATH . '/upload.func.php';
require_once G_INCLUDE_PATH . '/func.inc.php';
require_once G_INCLUDE_PATH . '/func.php';

require_once G_GLOBAL_PATH . '/configs.php';
