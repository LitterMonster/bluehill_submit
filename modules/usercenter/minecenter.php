<?php
$curdir = dirname(__FILE__)."/../..";
require_once "../../lib/allinone.inc.php";
require_once "../../interface/allinone.inc.php";
require_once "../../common/config.inc.php";
require_once "../../common/title_search.inc.html";
$params = LibMisc::getParams();
$_COOKIE['login_status'] = $params['login_status'];
$_COOKIE['username'] = $params['username'];
require_once "../../common/topnavbar_search.inc.html";
require_once "../../interface/allinone.inc.php";
require_once "../../db/allinone.inc.php";
require_once "minecenter.inc.html";
require_once "../../common/copyright.inc.html";
?>
