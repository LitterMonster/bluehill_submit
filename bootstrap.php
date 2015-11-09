<?php
header("Content-type: text/html; charset=utf8");
$curdir = dirname(__FILE__);

require_once "common/config.inc.php";
require_once "lib/allinone.inc.php";
require_once "interface/allinone.inc.php";
require_once "db/allinone.inc.php";
require_once "lib/utils.inc.php";


$uri = $_SERVER['REQUEST_URI'];
$uri = explode('?', $uri);

$path = $uri[0];
$path = trim($path, '/');
$path = explode('/', $path);

$interface = $path[$pathPrefixIgnore + 1];
if (!empty($interface)) {
    $interface = 'Interface'.Ucfirst($interface);
} else {
    $interface = 'InterfaceError';
}

$action = $path[$pathPrefixIgnore + 2];
if (!empty($action)) {
    $action = $action.'Action';
} else {
    $action = 'errorAction';
}

if (!class_exists($interface)) {
    $error = new InterfaceError();
    echo json_encode($error->errorAction(
        InterfaceError::ERR_NOSUCHINTF, null));
    exit;
}

$instance = new $interface;
if (!method_exists($instance, $action)) {
    $error = new InterfaceError();
    echo json_encode($error->errorAction(
        InterfaceError::ERR_NOSUCHMETHOD, null));
    exit;
}

$params = LibMisc::getParams();
$frommobile = $params['frommobile'];
$result = $instance->$action();

if (1 == $frommobile) {
    echo json_encode($result);
} else {
    echo $result;
}

$username = $params['username'];
if (!empty($username)) {
    $wrapperdbuser = new WrapperDBUser();
    $wrapperdbuser->updatelastaccess($username);
}

exit;
?>
