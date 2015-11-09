<?php
class DBHTWSearchSofa extends DBHTWHelpTheWorld {
    public function __construct() {

    }

    public function search(array $searchCondition) {
        $duration = $searchCondition['duration'];
        $beginning = $searchCondition['beginning'];
        $duration = $searchCondirion['duration'];
        $bedtype_id =  $searchCondition['bedtypeid'];
        $location_type_id = $searchCondition['locationtypeid'];
        $residearea_type_id = $searchCondition['resideareatypeid'];
        $nearby_id = $searchCondition['nearbyid'];
        $ownership_id = $searchCondition['ownershipid'];
        $capacity = $searchCondition['capacity'];
        $ownersex = $searchCondition['ownersex'];
        $ownerage = $searchCondition['ownerage'];
        $information = $searchCondition['information'];
        $covenientinfo = $searchCondition['convenientinfo'];

        $prereq_education = $searchCondition['prereqeducation'];
        $prereq_favorite_scenery = $searchCondition['prereqfavoritescenery'];
        $prereq_havegones = $searchCondition['prereqhavegones'];
        $prereq_prociders_id = $searchCondition['prereqprovidersid'];
        $prereq_readdings = $searchCondition['prereqreaddings'];

        $sql = "";
        $ret = $this->runSQL($sql);
        return $ret;
    }


}



?>
