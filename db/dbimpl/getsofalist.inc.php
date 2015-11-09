<?php
class DBHTWGetSofaList extends DBHTWHelpTheWorld {
    public function __construct() {

    }
    
    public function getSofaList() {
        
        $sql = "";
        $ret = $this->runSQL($sql);
        return $ret;
    }

}

?>
