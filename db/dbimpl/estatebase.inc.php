<?php
class  DBHTWEstateBase extends DBHTWGoodBase {
    /**
     * Brief:
     *    add record to goodinfo_estate_base
     * Parameters:
     *     user_id:$uid
     *     good information array:$good
     * Return:
     *     good's information array
     *
     * Date:2015-9-1     Revision:           Author:Zhangtao
     */
    public function add($uid, array $good) {
        if (empty($uid) || empty($good)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $good = parent::add($uid, $good);

        $good_id = $good['good_id'];
        $provider_ownership_id = $good['provider_ownership_id'];
        //$booked_slot_id = $good['booked_slot_id'];
        //$booked_history_id = $good['booked_history_id'];
        //$available_slot_id = $good['available_slot_id'];

        $sql = "insert into goodinfo_estate_base
            (good_id, provider_ownership_id) values
            ('$good_id', '$provider_ownership_id')";
        $ret = $this->runSQL($sql);

        $sql = "select max(good_id) good_id from goodinfo_base";
        $ret = $this->runSQL($sql);

        $good['good_id'] = $ret[0]['good_id'];

        return $good;

    }

    /**
     * Brief:
     *    run parents's search method
     * Parameters:
     *     good information array:$good
     * Return:
     *     No value
     *
     * Date:2015-9-7     Revision:           Author:Zhangtao
     */

    public function search(array $good) {
        return parent::search($good);
    }

    public function getSofaInfoByuid($userid) {
        return parent::getSofaInfoByuid($userid);
    }

    public function getSofaInfoBygoodid($goodid) {
        return parent::getSofaInfoBygoodid($goodid);
    }

    public function getSofaInfoIdBygoodid($goodid) {
        return parent::getSofaInfoIdBygoodid($goodid);
    }

    public function updateSofaData($data) {
        parent::updateSofaData($data);

        if (empty($data) || empty($data['good_id'])) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $fields = "(";
        $values = "(";
        $updates = "";

        $fields = $fields."good_id, ";
        $values = $values."'".$data['good_id']."', ";

        LibMisc::appendAffectedVolumn($fields, 
            $values, $updates, "provider_ownership_id",
            $data['provider_ownership_id']);

        $fields = trim($fields);
        $values = trim($values);
        $updates = trim($updates);

        if (',' == $fields{strlen($fields) - 1}) {
            $fields = substr($fields, 0, strlen($fields) - 1);
            $values = substr($values, 0, strlen($values) - 1);
            $updates = substr($updates, 0, strlen($updates) - 1);
        }

        $fields = $fields.")";
        $values = $values.")";

        $sql = 'INSERT INTO goodinfo_estate_base '.$fields.
            ' VALUES '.$values.' ON DUPLICATE KEY UPDATE '.$updates;
        $ret = $this->runSQL($sql);
    }

    public function deleteSofaData($good) {
        $good_id = $good['good_id'];
        $sql = "delete from goodinfo_estate_base where good_id = $good_id";
        $ret = $this->runSQL($sql);
        parent::deleteSofaData($good);
    }
    /*
    public function remove(array $good) {
        parent::remove($good)
            dbhtwestatebase = new DBHTWEstateBase
        $sql = "";
        $ret = $this->runSQL($sql);
        return $ret;
    }

    public function modify(array $good) {
        parent::modify($good);
        $arg = $good[];
        
        $sql = "";
        $ret = $this->runSQL($sql);
        return $ret;

    }
    */
}

?>
