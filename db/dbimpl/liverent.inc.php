<?php
include_once "estatebase.inc.php";
class DBHTWLiveRentBase extends DBHTWEstateBase {
    /**
     * Brief:
     *    add record to goodinfo_liverent_base
     * Parameters:
     *     user_id:$uid
     *     good information array:$good
     * Return:
     *    good's information array
     *
     * Date:2015-9-1     Revision:           Author:Zhangtao
     */
    public function add($uid, array $good) {
        if (empty($uid) || empty($good)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $good = parent::add($uid, $good);
        $area = $good['area'];
        $sql = "select id from cityarea_container where name = '$area'";
        $ret = $this->runSQL($sql);
        $area_id = $ret[0]['id'];

        if(empty($area_id)){
            return InterfaceError::ERR_NOSUCHAREAID;
        }

        $address_detail = $good['address_detail'];
        
        $sql = "insert into address_container(address_id,city_id, 
            address_detail) values ('null', '$area_id', '$address_detail')";
        $ret = $this->runSQL($sql);

        $sql = "select max(address_id) address_id from address_container";
        $ret = $this->runSQL($sql);
        
        $good['address_id'] = $ret[0]['address_id'];
        $good_id = $good['good_id'];
        $bathroom = (true == $good['bathroom']) ?'1':'0';
        $airconditioner = (true == $good['airconditioner']) ?'1':'0';
        $wash_machine = (true == $good['wash_machine']) ? '1':'0';
        $kitchen = (true == $good['kitchen']) ? '1':'0';
        $wifi = (true == $good['wifi']) ?'1':'0';
        // $nearbys_station_id = (true == $good['nearbys_station_id']) ?'1':'0';
        $capacity = $good['capacity'];
        $myfloor = $good['myfloor'];
        $totalfloor = $good['totalfloor'];
        $nearbys_id = $good['nearbys_id'];
        $address_id = $good['address_id'];
        $location_type_id = $good['location_type_id'];
        $bed_type_id = $good['bed_type_id'];
        $spacearea = $good['spacearea'];
        $saperated = (true == $good['saperated']) ?'1':'0';
        $residearea_type_id = $good['residearea_type_id'];

        $sql = "insert into goodinfo_liverent_base(good_id,
            address_id, bathroom, airconditioner, wash_machine,
            kitchen, wifi, capacity, location_type_id, bed_type_id,
            spacearea, saperated, residearea_type_id) values
            ('$good_id', '$address_id', '$bathroom', '$airconditioner',
            '$wash_machine', '$kitchen', '$wifi', '$capacity', 
            '$location_type_id', '$bed_type_id', '$spacearea',
            '$saperated', '$residearea_type_id')";
		$ret = $this->runSQL($sql);       

        $sql = "select max(good_id) good_id from goodinfo_base";
        $ret = $this->runSQL($sql);
        $good['good_id'] = $ret[0]['good_id'];
        return $good;
    }
    
    /**
     * Brief:
     *    run parents' search method
     * Parameters:
     *     good information array:$good
     * Return:
     *    No
     *
     * Date:2015-9-7     Revision:           Author:Zhangtao
     */

    public function search(array $good) {
        return  parent::search($good);
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

        LibMisc::appendAffectedVolumn($fields, $values, $updates,
            "bathroom", ($data['bathroom'] == true)?'1':'0');
        LibMisc::appendAffectedVolumn($fields, $values, $updates,
            "airconditioner", ($data['airconditioner'] == true)?'1':'0');
        LibMisc::appendAffectedVolumn($fields, $values, $updates,
            "wash_machine", ($data['wash_machine'] == true)?'1':'0');
        LibMisc::appendAffectedVolumn($fields, $values, $updates,
            "kitchen", ($data['kitchen'] == true)?'1':'0');
        LibMisc::appendAffectedVolumn($fields, $values, $updates,
            "wifi", ($data['wifi'] == true)?'1':'0');
        LibMisc::appendAffectedVolumn($fields, $values, $updates,
            "capacity", $data['capacity']);
        //LibMisc::appendAffectedVolumn($fields, $values, $updates,
        //  "address_id", $data['address_id']);
        LibMisc::appendAffectedVolumn($fields, $values, $updates,
            "location_type_id", $data['location_type_id']);
        LibMisc::appendAffectedVolumn($fields, $values, $updates,
            "bed_type_id", $data['bed_type_id']);
        LibMisc::appendAffectedVolumn($fields, $values, $updates,
            "spacearea", $data['spacearea']);
        LibMisc::appendAffectedVolumn($fields, $values, $updates,
            "saperated", ($data['saperated'] == true)?'1':'0');
        LibMisc::appendAffectedVolumn($fields, $values, $updates,
            "residearea_type_id", $data['residearea_type_id']);

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

        $sql = 'INSERT INTO goodinfo_liverent_base '.$fields.
            ' VALUES '.$values.' ON DUPLICATE KEY UPDATE '.$updates;
        $ret = $this->runSQL($sql);
    }

    public function deleteSofaData($good) {
        $good_id = $good['good_id'];

        $sql = "select address_id from goodinfo_liverent_base
            where good_id = $good_id limit 1";
        $ret = $this->runSQL($sql);
        $address_id = $ret[0]['address_id'];

        $sql = "delete from goodinfo_liverent_base where good_id = $good_id";
        $ret = $this->runSQL($sql);


        $sql = "delete from address_container where address_id = $address_id";
        $ret = $this->runSQL($sql);

        parent::deleteSofaData($good);
    }
    /* 
        public function remove(array $good) {
	        parent::remove($good);

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
