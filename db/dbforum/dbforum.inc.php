<?php
require_once "../dbbase/conf.inc.php"
require_once "../dbbase/dbbase.inc.php";

class DBForum extends DBBase {
    public $instance;

    function __construct() {
        $config = DBConf::$forumconf;
        parent::__construct($config);
    }
}
?>
