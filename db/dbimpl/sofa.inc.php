<?php
class DBHTWSofaClass extends DBHTWLiveRentBase {
    /**
     * Brief:
     *    add record to goodinfo_sale_base and goodinfo_sofa_base
     * Parameters:
     *     user_id:$uid
     *     good information array:$good
     * Return:
     *     The result of executing insert statement
     *
     * Date:2015-9-1     Revision:           Author:Zhangtao
     */
    public function add($uid, array $good) {
        if (empty($uid) || empty($good)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $good = parent::add($uid, $good);

        $good_id = $good['good_id'];
        $sql = "insert into goodinfo_sale_base(good_id) 
            values ('$good_id')";
        $ret = $this->runSQL($sql);

        $sql = "insert into goodinfo_sofa_info(good_id) 
            values ('$good_id')";
        $ret = $this->runSQL($sql);
        return $good;
    }

    /**
     * Brief:
     *     1.fliter the keyword
     *     2.get  address_id from province_container,city_container,
     *     cityarea_container and address_container
     *     3.get goodid from goodinfo_liverent_base by address_id
     * Parameters:
     *     good information array:$good
     * Return:
     *     No value
     *
     * Date:2015-9-7     Revision:           Author:Zhangtao
     */

    public function  search(array $good) {
        $keyword = trim($good['keyword']);
        $keyword = str_replace(" ","",$keyword);

        $province = mb_substr($keyword,0,2,'utf-8');
        $sql = "select address_id from province_container,
            city_container,cityarea_container,address_container
            where province_container.id = city_container.province_id
            and cityarea_container.city_id = city_container.id 
            and address_container.city_id = cityarea_container.id
            and province_container.name like '%$province%'";

        $ret = $this->runSQL($sql);

        if(empty($ret)) {
            $city = $province;
            $sql = "select address_id from province_container,
                city_container,cityarea_container,address_container
                where province_container.id = city_container.province_id
                and cityarea_container.city_id =  city_container.id
                and address_container.city_id = cityarea_container.id
                and city_container.name like '%$city%'";
            $ret = $this->runSQL($sql);

            if(empty($ret)) {
                return InterfaceError::ERR_DBIO;
            } else {
                $good['address_id'] = $ret;  
            }

        } else {
            $good['address_id'] = $ret;
        }

        $goodid = array();
        for ($i = 0; $i < sizeof($good['address_id']); $i++ ) {
            $addressid = $good['address_id'][$i]['address_id'];
            $sql = "select good_id from goodinfo_liverent_base 
                where address_id = '$addressid'";
            $ret = $this->runSQL($sql);
            for ($j = 0; $j < sizeof($ret); $j++) {
                $goodid[] = $ret[$j]['good_id'];
            }
        }

        $good['good_id'] = $goodid;

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

         $good_id = $data['good_id'];
         $sql = "select address_id from goodinfo_liverent_base 
             where good_id = '$good_id' limit 1";
         $ret = $this->runSQL($sql);
         $address_id = $ret[0]['address_id'];

         $area = $data['area'];
         $sql = "select id from cityarea_container
             where name = '$area' limit 1";
         $ret = $this->runSQL($sql);
         $cityarea_id = $ret[0]['id'];



        if (empty($data) || empty($data['good_id'])) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $fields = "(";
        $values = "(";
        $updates = "";

        $fields = $fields."address_id, ";
        $values = $values."'".$address_id."', ";

        LibMisc::appendAffectedVolumn($fields, 
            $values, $updates, "city_id", $cityarea_id);
        LibMisc::appendAffectedVolumn($fields, 
            $values, $updates, "address_detail", $data['address_detail']);

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

        $sql = 'INSERT INTO address_container '.$fields.
            ' VALUES '.$values.' ON DUPLICATE KEY UPDATE '.$updates;
        /*
        print "sofa.inc.php---->$sql";
        print "****data-->";
        print_r ($data);
        die;
        */
        $ret = $this->runSQL($sql);
    }

    public function deleteSofaData($good) {

        $good_id = $good['good_id'];
        $sql = "delete from goodinfo_sale_base where good_id = $good_id";
        $ret = $this->runSQL($sql);

        $sql = "delete from goodinfo_sofa_info where good_id = $good_id";
        $ret = $this->runSQL($sql);
        parent::deleteSofaData($good);
        return $ret;
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
