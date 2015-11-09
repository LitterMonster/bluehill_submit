<?php
require_once "$curdir/db/dbbase/conf.inc.php";
require_once "$curdir/db/dbbase/dbbase.inc.php";

class DBHelpTheWorld extends DBBase {
    public function __construct() {
        $config = DBConf::$htwconf;
        parent::__construct($config);
    }
}
?>
