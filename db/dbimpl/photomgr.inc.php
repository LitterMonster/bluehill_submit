<?php
require_once "dbhtw.inc.php";

class DBPhotoMGR extends DBHelpTheWorld {
    function __construct() {
        parent::__construct();
    } 

    public function add($photopath) {
        if (empty($photopath)) {
            return InterfaceError::ERR_INVALIDPATAMS;
        }

        $addtime = date('Y-m-d H:i:s', time());
        $photopath = str_replace("$", "", $photopath);

        $sql = "INSERT INTO `photopath_container` 
            (path, createtime) VALUES ('$photopath', '$addtime')";
        $ret = $this->runSQL($sql);

        if ($ret > 0) {
            $sql = "SELECT id FROM `photopath_container`
                 WHERE path='$photopath' LIMIT 1";
            $ret = $this->runSQL($sql);
        }

        return $ret[0]['id'];
    }

    public function getPhotoURL($id) {
        global $baseurl;

        if (empty($id)) {
            return InterfaceError::ERR_INVALIDPATAMS;
        }

        $sql = "SELECT path FROM `photopath_container` 
            WHERE id='$id' LIMIT 1";
        $ret = $this->runSQL($sql);
        return $baseurl."/".$ret[0]['path'];
    }
}
?>
