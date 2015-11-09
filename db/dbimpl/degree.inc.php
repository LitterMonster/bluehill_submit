<?php
require_once "dbhtw.inc.php";

class DBDegree extends DBHelpTheWorld {
    function __construct() {
        parent::__construct();
    }

    public function getDegreeId($degree) {
        if (empty($degree)) {
            return 1;
        }

        $sql = "SELECT id FROM degree_container ".
            "WHERE title='$degree' LIMIT 1";
        $ret = $this->runSQL($sql);
        return $ret[0]['id'];
    }

    public function getDegree($id) {
        if (empty($id)) {
            return "未设置";
        }

        $sql = "SELECT title FROM degree_container ".
            "WHERE id='$id' LIMIT 1";
        $ret = $this->runSQL($sql);
        return $ret[0]['title'];
    }
}
?>
