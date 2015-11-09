<?php
require_once "dbhtw.inc.php";

class DBProfession extends DBHelpTheWorld {
    function __construct() {
        parent::__construct();
    }

    public function getProfessionId($profession) {
        if (empty($profession)) {
            return 1;
        }

        $sql = "SELECT id FROM profession_container ".
            "WHERE title='$profession' LIMIT 1";
        $ret = $this->runSQL($sql);
        return $ret[0]['id'];
    }

    public function getProfession($id) {
        if (empty($id)) {
            return "未设置";
        }

        $sql = "SELECT title FROM profession_container ".
            "WHERE id='$id' LIMIT 1";
        $ret = $this->runSQL($sql);
        return $ret[0]['title'];
    }
}
?>
