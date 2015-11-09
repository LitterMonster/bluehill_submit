<?php
class LibMisc {
    static public function getParams() {
 		$data = array_merge($_POST, $_GET);
 		return $data;
    }

    static public function generateRandom() {
        return date('YmdHis').'-'.rand(1000, 9999);
    }

    static public function appendAffectedVolumn(&$fields, 
        &$values, &$updates, $volname, $volvalue) {

        //if (empty($volvalue)) {
        //    return;
        //}

        $fields = $fields.$volname.", ";
        $values = $values."'".$volvalue."', ";
        if($volvalue == '0') {
            $updates = $updates.$volname."='0', ";
        } else {
            $updates = $updates.$volname."='".$volvalue."', ";
        }
    }
}
?>
