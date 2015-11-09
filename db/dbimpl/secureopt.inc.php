<?php
require_once "dbhtw.inc.php";

class DBSecureOPT extends DBHelpTheWorld {
    public function __construct() {
        parent::__construct();
    }

    public function getSecureOPTId($opt) {
        if (!isset($opt) || empty($opt)) {
            $opt = '公开';
        }

        $sql = 'SELECT id FROM `secureopt_container` '.
            'WHERE optiondesc like \'%'.$opt.'%\' LIMIT 1';
        $ret = $this->runSQL($sql);
        return $ret[0]['id'];
    }

    public function getSecureOPT($id) {
        if (empty($id)) {
            return "公开";
        }

        $sql = 'SELECT optiondesc FROM secureopt_container '.
            'WHERE id=\''.$id.'\'';
        $ret = $this->runSQL($sql);
        return $ret[0]['optiondesc'];
    }
}
?>
