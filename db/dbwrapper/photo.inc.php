<?php
require_once "$curdir/db/dbimpl/photomgr.inc.php";

class WrapperDBPhoto {
    public function add($photopath) {
        if (empty($photopath)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $dbphotomgr = new DBPhotoMGR();
        $ret = $dbphotomgr->add($photopath);
        return $ret;
    }

    public function getPhotoURL($id) {
        if (empty($id)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $dbphotomgr = new DBPhotoMGR();
        $ret = $dbphotomgr->getPhotoURL($id);
        return $ret;
    }
}
?>
