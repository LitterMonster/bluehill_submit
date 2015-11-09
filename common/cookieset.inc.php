<?php
require_once "lib/allinone.inc.php";
require_once "interface/allinone.inc.php";

$params = LibMisc::getParams();
$logout = $params['logout'];
$deadline = time() + 3600;

if ($logout) {
    $deadline = time() - 3600;
}

if (!empty($params['username'])) {
    $username = $params['username'];
} else {
    $username = $_COOKIE['username'];
}

if (!empty($params['login_status'])) {
    $login_status = $params['login_status'];
} else {
    $login_status = $_COOKIE['login_status'];
}

setcookie("username", $username, $deadline);
setcookie("login_status", $login_status, $deadline);
?>
