<?php
include_once "dbhtw.inc.php";
class DBHTWGoodBase extends DBHelpTheWorld {
     /**
     * Brief:
     *    add record to goodinfo_base
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

        $good_id = $good['good_id'];
        $class_id = $good['class_id'];
        //  $price = $good['price'];
        $price_unit_id = $good['price_unit_id'];
        $price_currency_id = $good['price_currency_id'];
        $provider_id = $uid;
        //  $discount = $good['discount'];
        $photos_id = $good['photos_id'];
        $title = $good['title'];
        $comment = $good['comment'];

        $sql = "insert into goodinfo_base 
            (good_id, class_id, price_unit_id, price_currency_id,
            provider_id, photos_id, title, comment)
            values 
            ('$good_id', '$class_id', '$price_unit_id', 
            '$price_currency_id', '$provider_id', '$photos_id',
            '$title', '$comment')";
        $ret = $this->runSQL($sql);
        $sql = "select max(good_id) good_id from goodinfo_base";
        $ret = $this->runSQL($sql);
        $good['good_id'] = $ret[0]['good_id'];

        return $good;
    }

    /**
     * Brief:
     *     search sofa from database
     * Parameters:
     *     good information array:$good
     * Return:
     *     available sofa and numbers
     *
     * Date:2015-9-7     Revision:           Author:Zhangtao
     */
    public function search(array $good) {
        $basefacility = array();
        if(!empty($good['provider_ownership_id'])) {
            $basefacility['provider_ownership_id'] 
                = $good['provider_ownership_id'];
        }
        if(!empty($good['bed_type_id'])) {
            $basefacility['bed_type_id'] = $good['bed_type_id'];
        }
        if(!empty($good['capacity'])) {
            $basefacility['capacity'] = $good['capacity'];
        }
        if(!empty($good['residearea_type_id'])) {
            $basefacility['residearea_type_id'] 
                = $good['residearea_type_id'];
        }
        if(!empty($good['location_type_id'])) {
            $basefacility['location_type_id'] 
                = $good['location_type_id'];
        }
        if(!empty($good['bathroom'])) {
            $basefacility['bathroom'] = 1;
        }
        if(!empty($good['airconditioner'])) {
            $basefacility['airconditioner'] = 1;
        }
        if(!empty($good['wash_machine'])) {
            $basefacility['wash_machine'] = 1;
        }
        if(!empty($good['kitchen'])) {
            $basefacility['kitchen'] = 1;
        }
        if(!empty($good['wifi'])) {
            $basefacility['wifi'] = 1;
        }
        if(!empty($good['saperated'])) {
            $basefacility['saperated'] = 1;
        }

        $fathergood = array();
        $length = 0;
        for ($i = 0; $i < sizeof($good['good_id']); $i++) {
            $goodid = $good['good_id'][$i];

            $sql1 = "select provider_id ,title,comment from goodinfo_base 
                where good_id = '$goodid'";
            $ret1 = $this->runSQL($sql1)[0];

            $sql2 = "select provider_ownership_id from goodinfo_estate_base 
                where good_id = '$goodid'";
            $ret2 = $this->runSQL($sql2)[0];

            $sql3 = " select * from goodinfo_liverent_base as a natural join 
                address_container as b where a.address_id = b.address_id 
                and good_id = '$goodid'";
            $ret3 = $this->runSQL($sql3)[0];

            $tempfacility = array();
            $tempfacility['provider_ownership_id'] 
                = $ret2['provider_ownership_id'];
            $tempfacility['bed_type_id'] = $ret3['bed_type_id'];
            $tempfacility['capacity'] = $ret3['capacity'];
            $tempfacility['residearea_type_id'] = $ret3['residearea_type_id'];
            $tempfacility['location_type_id'] = $ret3['location_type_id'];
            $tempfacility['bathroom'] = $ret3['bathroom'];
            $tempfacility['airconditioner'] = $ret3['airconditioner'];
            $tempfacility['wash_machine'] = $ret3['wash_machine'];
            $tempfacility['kitchen'] = $ret3['kitchen'];
            $tempfacility['wifi'] = $ret3['wifi'];
            $tempfacility['saperated'] = $ret3['saperated'];
            $tempfacility['spacearea'] = $ret3['spacearea'];

            $state = true;
            foreach($basefacility as $key => $value) {
                if($basefacility["$key"] == $tempfacility["$key"]) {
                    $state = true;
                } else {
                    $state = false;
                    break;
                }
            }

            $songood = array();
            if ($state == true) {
                $songood['good_id'] = $goodid;

                $temp = $ret1['provider_id'];
                $sql = "select username from userinfo_base 
                    where user_id = '$temp'";
                $ret = $this->runSQL($sql)[0];


                //print "<td>"; print $ret1['provider_id']; print "</td>";

                $songood['username'] = $ret['username'];

                $temp = $ret2['provider_ownership_id'];
                $sql = "select typename from ownership_container 
                    where id = '$temp'";
                $ret = $this->runSQL($sql)[0];
                
                $songood['provider_ownership_id'] = $ret['typename'];
                $songood['title'] = $ret1['title']; 
                $songood['comment'] = $ret1['comment'];
                $songood['address_detail'] = $ret3['address_detail'];
                $songood['bathroom'] = ($ret3['bathroom']==1)?"是":"否";
                $songood['airconditioner'] 
                    = ($ret3['airconditioner']==1)?"是":"否";
                $songood['wash_machine'] 
                    = ($ret3['wash_machine']==1)?"是":"否";
                $songood['kitchen'] = ($ret3['kitchen']==1)?"是":"否";
                $songood['wifi'] = ($ret3['wifi']==1)?"是":"否";
                $songood['capacity'] = $ret3['capacity'];
                $songood['address_id'] = $ret3['address_id'];
                
                $temp = $ret3['location_type_id'];
                $sql = "select typename  from locationtype_container 
                    where id = '$temp'";
                $ret = $this->runSQL($sql)[0];
                
                $songood['location_type_id'] = $ret['typename'];

                $temp = $ret3['bed_type_id'];
                $sql = "select typename  from bedtype_container 
                    where id = '$temp'";
                $ret = $this->runSQL($sql)[0];

                $songood['bed_type_id'] = $ret['typename'];
                
                $songood['spacearea'] = (empty($ret['spacearea']))
                    ?"0":"{$ret['spacearea']}";

                $songood['saperated'] = ($ret3['saperated']==1)?"是":"否";

                $temp = $ret3['residearea_type_id'];
                $sql = "select typename  from residearea_type_container 
                    where id = '$temp'";
                $ret = $this->runSQL($sql)[0];

                $songood['residearea_type_id'] = $ret['typename'];

                $fathergood[$length++] = $songood;
            }
        }
        return $fathergood;
    }

    public function getSofaInfoByuid($userid) {
        $sql = "select good_id from goodinfo_base 
            where provider_id = '$userid'";
        $goodidret = $this->runSQL($sql);
        $fathergood = array();
        $length = 0;
        for ($i = 0; $i < sizeof($goodidret); $i++) {
            $goodid = $goodidret[$i]['good_id'];
            $songood = $this->getSofaInfoBygoodid($goodid);
            $fathergood[$length++] = $songood;
        }
        return $fathergood;
    }

    public function getSofaInfoBygoodid($goodid) {
        $songood = array();

        $sql1 = "select provider_id ,title,comment from goodinfo_base 
            where good_id = '$goodid'";
        $ret1 = $this->runSQL($sql1)[0];

        $sql2 = "select provider_ownership_id from goodinfo_estate_base 
            where good_id = '$goodid'";
        $ret2 = $this->runSQL($sql2)[0];

        $sql3 = " select * from goodinfo_liverent_base as a natural join 
            address_container as b 
            where a.address_id = b.address_id and good_id = '$goodid'";
        $ret3 = $this->runSQL($sql3)[0];

        $songood['good_id'] = $goodid;

        $temp = $ret1['provider_id'];
        $sql = "select username from userinfo_base where user_id = '$temp'";
        $ret = $this->runSQL($sql)[0];
        $songood['username'] = $ret['username'];

        $temp = $ret2['provider_ownership_id'];
        $sql = "select typename from ownership_container where id = '$temp'";
        $ret = $this->runSQL($sql)[0];

        $songood['provider_ownership_id'] = $ret['typename'];
        $songood['title'] = $ret1['title']; 
        $songood['comment'] = $ret1['comment'];
        $songood['address_detail'] = $ret3['address_detail'];
        $songood['bathroom'] = ($ret3['bathroom']==1)?"是":"否";
        $songood['airconditioner'] = ($ret3['airconditioner']==1)?"是":"否";
        $songood['wash_machine'] = ($ret3['wash_machine']==1)?"是":"否";
        $songood['kitchen'] = ($ret3['kitchen']==1)?"是":"否";
        $songood['wifi'] = ($ret3['wifi']==1)?"是":"否";
        $songood['capacity'] = $ret3['capacity'];
        $songood['address_id'] = $ret3['address_id'];

        $temp = $ret3['location_type_id'];
        $sql = "select typename  from locationtype_container 
            where id = '$temp'";
        $ret = $this->runSQL($sql)[0];
        $songood['location_type_id'] = $ret['typename'];

        $temp = $ret3['bed_type_id'];
        $sql = "select typename  from bedtype_container where id = '$temp'";
        $ret = $this->runSQL($sql)[0];
        $songood['bed_type_id'] = $ret['typename'];

        $songood['spacearea'] = (empty($ret3['spacearea']))
            ?"0":"{$ret3['spacearea']}";
        $songood['saperated'] = ($ret3['saperated']==1)?"是":"否";

        $temp = $ret3['residearea_type_id'];
        $sql = "select typename  from residearea_type_container 
            where id = '$temp'";
        $ret = $this->runSQL($sql)[0];

        $songood['residearea_type_id'] = $ret['typename'];
        return $songood;
    }

    public function getSofaInfoIdBygoodid($goodid) {
        $songood = array();

        $sql1 = "select provider_id ,title,comment from goodinfo_base 
            where good_id = '$goodid'";
        $ret1 = $this->runSQL($sql1)[0];

        $sql2 = "select provider_ownership_id from goodinfo_estate_base 
            where good_id = '$goodid'";
        $ret2 = $this->runSQL($sql2)[0];

        $sql3 = " select * from goodinfo_liverent_base as a natural join 
            address_container as b 
            where a.address_id = b.address_id and good_id = '$goodid'";
        $ret3 = $this->runSQL($sql3)[0];

        $songood['good_id'] = $goodid;
        $songood['provider_id'] = $ret1['provider_id'];
        $songood['provider_ownership_id'] = $ret2['provider_ownership_id'];
        $songood['title'] = $ret1['title']; 
        $songood['comment'] = $ret1['comment'];
        $songood['address_detail'] = $ret3['address_detail'];
        $songood['bathroom'] = $ret3['bathroom'];
        $songood['airconditioner'] = $ret3['airconditioner'];
        $songood['wash_machine'] = $ret3['wash_machine'];
        $songood['kitchen'] = $ret3['kitchen'];
        $songood['wifi'] = $ret3['wifi'];
        $songood['capacity'] = $ret3['capacity'];
        $songood['address_id'] = $ret3['address_id'];
        $songood['location_type_id'] = $ret3['location_type_id'];
        $songood['bed_type_id'] = $ret3['bed_type_id'];
        $songood['spacearea'] = (empty($ret3['spacearea']))
            ?"0":"{$ret3['spacearea']}";
        $songood['saperated'] = $ret3['saperated'];
        $songood['residearea_type_id'] = $ret3['residearea_type_id'];
        return $songood;
    }

    public function updateSofaData($data) {
        
        if (empty($data) || empty($data['good_id'])) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $fields = "(";
        $values = "(";
        $updates = "";

        $fields = $fields."good_id, ";
        $values = $values."'".$data['good_id']."', ";

        LibMisc::appendAffectedVolumn($fields, 
            $values, $updates, "title", $data['title']);
        LibMisc::appendAffectedVolumn($fields, 
            $values, $updates, "comment", $data['comment']);

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

        $sql = 'INSERT INTO goodinfo_base '.$fields.
            ' VALUES '.$values.' ON DUPLICATE KEY UPDATE '.$updates;
        $ret = $this->runSQL($sql);
 
    }

    public function deleteSofaData($good) {
        $good_id = $good['good_id'];
        $sql = "delete from goodinfo_base where good_id = $good_id";
        $ret = $this->runSQL($sql);
        print "<script language='javascript' type = 'text/javascript'>
            alert('沙发删除成功!');</script>";
        $url = "../../modules/goodcenter/goodcenter.php";
        print "<script language='javascript' type = 'text/javascript'>
            window.location.href = '$url';</script>";
    }
    /*
    public function remove(array $good) {
        $sql = "";
        $ret = $this->runSQL($sql);
        return $ret;

    }

    public function modify(array $good) {
        $sql = "";
        $ret = $this->runSQL($sql);
        return $ret;
    } 


     */
}
?>
