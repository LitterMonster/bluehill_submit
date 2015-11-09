<?php
require_once "dbhtw.inc.php";

class DBGenderTag extends DBHelpTheWorld {
    public function __construct() {
        parent::__construct();
    }

    public function getGenderTagId($gendertag) {
        if (empty($gendertag)) {
            return 1;
        }

        $sql = "SELECT id FROM gender_tag_container ".
            "WHERE gendertag='$gendertag' LIMIT 1";
        $ret = $this->runSQL($sql);
        return $ret[0]['id'];
    }

    public function getGenderTag($id) {
        if (empty($id)) {
            return "未知";
        }

        $sql = "SELECT gendertag FROM gender_tag_container ".
            "WHERE id='$id' LIMIT 1";
        $ret = $this->runSQL($sql);
        return $ret[0]['gendertag'];
    }
}
?>
