<?php
class DBHTWOrderSofa extends DBHTWHelpTheWorld {
    public function __construct() {


    }

    public function order($uid,array $orderinfo){
        $good_id = $orderinfo['goodid'];
        $beginning = $orderinfo['beginning'];
        $duration = $orderinfo['duration'];
        $capacity = $orderinfo['capacity'];
        $information = $orderinfo['information'];

        $sql = "";
        $ret = $this->runSQL($sql);
        return $ret;
    }

}

?>
