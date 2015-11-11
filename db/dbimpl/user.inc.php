<?php
require_once "secureopt.inc.php";
require_once "photomgr.inc.php";
require_once "gendertag.inc.php";
require_once "profession.inc.php";
require_once "degree.inc.php";

class DBHTWUser extends DBHelpTheWorld {
    public function __construct() {
        parent::__construct();
    }

    /**
     * Brief: Check if the user exists in DB
     * Return:
     *      true      Exists
     *      false     Not exists
     */
    public function checkuser($username) {
        if (empty($username)) {
            return false;
        }

        $sql = "SELECT * FROM `userinfo_base` ". 
            "WHERE username='$username' LIMIT 1";
        $ret = $this->runSQL($sql);

        if (empty($ret)) {
            return false;
        } else {
            return true;
        }
    }

    public function add(array $user) {
        if (empty($user['username']) ||
            empty($user['password'])) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $username = $user['username'];
        $password = $user['password'];
        $mobile = $user['mobile'];

        if ($this->checkuser($username)) {
            return InterfaceError::ERR_USERALREADYEXIST;
        }

        if (!empty($mobile) && $this->checkmobile($mobile)) {
           return InterfaceError::ERR_MOBILEALREADYEXIST; 
        }

        $opt = new DBSecureOPT();
        $secureopt_id = $opt->getSecureOPTId($user['secureopt']);

        $sql = 'INSERT INTO `userinfo_base` (username, '.
            'password, secureopt_id, jointime) VALUES '.
            '(\''.$username.'\', \''.$password.'\', \''.
            $secureopt_id.'\', \''.time().'\')';
        $ret = $this->runSQL($sql);
        if (0 == $ret) {
            return InterfaceError::ERR_DBIO;
        }

        $this->updatelastaccess($username);
        $userinfo = $this->getinfo($username, $username);
        return $userinfo;
    }

    public function login(array $user) {
        if (empty($user['username']) ||
            empty($user['password'])) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $username = $user['username'];
        $password = $user['password'];

        $sql = 'SELECT LoginName, Password FROM `tblEmployee` '.
            'WHERE LoginName=\''.$username.'\' and '.
            'Password=\''.$password.'\' LIMIT 1';
        $ret = $this->runSQL($sql);
        if (0 == sizeof($ret)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        } else {
            return InterfaceError::ERR_OK;
        }

        //$this->updatelastaccess($username);
        //$userinfo = $this->getinfo($username, $username);
        //return $ret;
    }

    public function getleaveinfo($username)
    {
        $employeeID = $this->getuserinfo($username)['EmployeeID'];

        $sql = "SELECT * FROM tblLeave WHERE EmployeeID = $employeeID";
        $ret = $this->runSQL($sql);

        if (0 == sizeof($ret))
        {
            return InterfaceError::ERR_INVALIDPARAMS;
        }
        return $ret;
    }

    public function getusedhours($username)
    {
        if (empty($username))
        {
            return InterfaceError::ERR_OK;
        }

        $leaveinfo = $this->getleaveinfo($username);

        $counthours = 0;
        for ($i = 0; $i < sizeof($leaveinfo); $i++)
        {
            if ($leaveinfo[$i]['Status'] != "已否决" &&
            $leaveinfo[$i]['Status'] != "已取消")
            {
                $counthours += $leaveinfo[$i]['Hours'];
            }
        }

        return $counthours;
    }

    private function reorganizeSecureInfo($secureinfo) {
        if (empty($secureinfo)) {
            return $secureinfo;
        }

        // TODO: Fill the secure info data area

        return $secureinfo;
    }

    private function reorganizeUserinfo($userinfo) {
        if (empty($userinfo)) {
            return $userinfo;
        }

        if (empty($userinfo['secureopt_id'])) {
            $userinfo['secureopt'] = "公开";
        } else {
            $secureopt = new DBSecureOPT();
            $secureopt_id = $userinfo['secureopt_id'];
            $secureopt = $secureopt->getSecureOPT($secureopt_id);
            $userinfo['secureopt'] = $secureopt;
        }
        unset($userinfo['secureopt_id']);

        if (!empty($userinfo['avatar'])) {
            $photomgr = new DBPhotoMGR();
            $ret = $photomgr->getPhotoURL($userinfo['avatar']);
        } else {
            $ret = null;
        }
        $userinfo['avatar'] = $ret;

        $userinfo['lastaccess'] = strtotime($userinfo['lastaccess']);

        if (empty($userinfo['gender_tag_id'])) {
            $userinfo['gendertag'] = "未设置";
        } else {
            $gendertag_id = $userinfo['gender_tag_id'];
            $gendertag = new DBGenderTag();
            $gendertag = $gendertag->getGenderTag($gendertag_id);
            $userinfo['gendertag'] = $gendertag;
        }
        unset($userinfo['gender_tag_id']);

        if (empty($userinfo['profession_id'])) {
            $userinfo['profession'] = "未设置";
        } else {
            $profession = new DBProfession();
            $profession = $profession->getProfession(
                $userinfo['profession_id']);
            $userinfo['profession'] = $profession;
        }
        unset($userinfo['profession_id']);

        if (empty($userinfo['degree_id'])) {
            $userinfo['degree'] = "未设置";
        } else {
            $degree = new DBDegree();
            $degree = $degree->getDegree($userinfo['degree_id']);
            $userinfo['degree'] = $degree;
        }
        unset($userinfo['degree_id']);

        if (empty($userinfo['reside_city_id'])) {
            $userinfo['residecity'] = "未设置";
        } else {

        }
        unset($userinfo['reside_city_id']);

        if (empty($userinfo['hometown_city_id'])) {
            $userinfo['hometown'] = "未设置";
        } else {

        }
        unset($userinfo['hometown_city_id']);

        return $userinfo;
    }

    /**
     * Verify Status Value
     *      0  Pass
     *      1  Verifing
     *      2  Not applied
     *      4  Fail
     */
    private function checkVerifyStatus($userinfo) {
        if (empty($userinfo['verified'])) {
            $userinfo['verified'] = false;
        }

        if (empty($userinfo['verifystatus'])) {
            $userinfo['verifystatus'] = 2;
        }

        unset($userinfo['idcardno']);
        unset($userinfo['idcardphoto']);

        return $userinfo;
    }

    private function initSecureInfo($pattern) {
        $result['mobile'] = $pattern;
        $result['qqno'] = $pattern;
        $result['wechat'] = $pattern;
        $result['email'] = $pattern;
        $result['mobile'] = $pattern;
        $result['reside_address'] = $pattern;
        $result['hometown_address'] = $pattern;
        $result['birthday'] = $pattern;
        
        $result['primary_school'] = $pattern;
        $result['junior_school'] = $pattern;
        $result['senior_school'] = $pattern;
        $result['colledge'] = $pattern;
        $result['university'] = $pattern;
        $result['master_school'] = $pattern;
        $result['doctor_school'] = $pattern;

        return $result;
    }

    private function fillSecureInfo($userinfo) {
        $user_id = $userinfo['user_id'];
        $secureopt = $userinfo['secureopt_id'];
        $sql = 'SELECT optiondesc FROM secureopt_container '.
            'WHERE id=\''.$secureopt.'\'';
        $ret = $this->runSQL($sql);
        $secureopt = $ret['optiondesc'];

        if (empty($secureopt) || $secureopt == '公开' ||
            (($secureopt == '仅向好友公开') &&
            $this->isFriend($requestuser, $requesteduser))) {
            $sql = 'SELECT * FROM userinfo_secure '.
                'NATURAL LEFT OUTER JOIN userinfo_education '.
                'WHERE user_id=\''.$user_id.'\'';
            $result = $this->runSQL($sql);
            $userinfo = $this->checkVerifyStatus($userinfo, $result[0]);
            $result = $this->reorganizeSecureInfo($result[0]);
        } else {
            $result = $this->initSecureInfo("保密");
        }

        if (empty($result)) {
            $result = $this->initSecureInfo("未设置");
        }

        $userinfo['secure'] = $result;
        return $userinfo;
    }

    /**
     *  Brief: Get the user info of given username
     *  Parameters:
     *      requestuser   Guy who need the info
     *      requesteduser Target user
     *  When to use:
     *      After login, the user information will be returned
     *      When another guy want to look the profile of another guy
     */
    public function getuserinfo($username) {
        if (empty($username)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $sql = 'SELECT * FROM tblEmployee  '.
            'where LoginName=\''.$username.'\' LIMIT 1';
        $ret = $this->runSQL($sql);
        if (0 == sizeof($ret)) {
           return InterfaceError::ERR_NOSUCHUSER; 
        }

        $userinfo = $ret[0];
        //$userinfo = $this->fillSecureInfo($userinfo);
        //$userinfo = $this->reorganizeUserinfo($userinfo);
        return $userinfo;
    }

    public function getdeptinfo($deptid)
    {
        if (empty($deptid))
        {
            echo "部门编号为空!";
            die;
        }

        $sql = 'SELECT a.Name, b.DeptName from tblEmployee as a, tblDepartment'.
            ' as b where a.EmployeeID = b.ManagerID and a.DeptID = '.$deptid;
        $ret = $this->runSQL($sql);

        if (0 == sizeof($ret)) {
           return InterfaceError::ERR_NOSUCHUSER; 
        }

        $managername = $ret[0];
        return $managername;
    }

    public function getsecureinfo($requestuser, $requesteduser) {
        $ret = $this->getinfo($requestuser, $requesteduser);

        if (InterfaceError::isErrorCode($ret)) {
            return $ret;
        }

        return $ret['secure'];
    }

    public function isFriend($user, $friend) {
        return true;
    }
    public function getUid($username) {
        if(empty($username)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $sql = "select user_id from userinfo_base where 
            username = '$username' limit 1";
        $ret = $this->runSQL($sql);
        return $ret[0]['user_id'];
    }

    public function getname($userid) {
        if (empty($userid)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $sql = 'SELECT name FROM userinfo_extend '.
            'WHERE user_id=\''.$userid.'\' LIMIT 1';
        $ret = $this->runSQL($sql);
        return $ret[0]['name'];
    }

    public function getbaseinfo($username) {
        if (empty($username)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $sql = 'SELECT * FROM userinfo_base '.
            'WHERE username=\''.$username.'\' LIMIT 1';
        $ret = $this->runSQL($sql);
        return $ret[0];
    }

    public function getgenderid($userid) {
        if (empty($userid)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $sql = 'SELECT gender_tag_id FROM '.
            'userinfo_extend WHERE user_id='.
            '\''.$userid.'\' LIMIT 1';
        $ret = $this->runSQL($sql);

        if (empty($ret)) {
            return $ret;
        }

        $sql = 'SELECT gender_id FROM gender_tag_container '.
            'WHERE id=\''.$ret[0]['gender_tag_id'].'\' LIMIT 1';
        $ret = $this->runSQL($sql);

        return $ret[0]['gender_id'];
    }

    public function getgendertags($userid) {
        if (empty($userid)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $ret = $this->getgenderid($userid);
        if (empty($ret)) {
            $sql = 'SELECT gendertag FROM gender_tag_container';
        } else {
            $sql = 'SELECT gendertag FROM gender_tag_container '.
                'WHERE gender_id=\''.$ret.'\'';
        }

        $ret = $this->runSQL($sql);
        return $ret;
    }

    function getgendertagid($tag) {
        if (empty($tag)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }    

        $sql = 'SELECT id FROM gender_tag_container '.
            'WHERE gendertag=\''.$tag.'\'';
        $ret = $this->runSQL($sql);
        return $ret[0]['id'];
    }

    public function updateuserdata(array $data) {
        if (empty($data)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $userinfo = $this->getuserinfo($data['username'], $data['username']);
        $employeeID = $userinfo['EmployeeID'];

        if (empty($data['password']))
        {
            $sql = "update tblEmployee set SelfIntro = '".$data['introduction'].
                "' where EmployeeID = $employeeID ";
            $ret = $this->runSQL($sql);

            return InterfaceError::ERR_OK;
        }
        else
        {
            $sql = "update tblEmployee set Password = '".$data['password'].
                "' where EmployeeID = $employeeID ";
            $ret = $this->runSQL($sql);

            return InterfaceError::ERR_OK;
        }
        return InterfaceError::INVALIDPARAMS;
       /* 
        $baseinfo = $this->getbaseinfo($data['username']);
        if (empty($baseinfo)) {
            return InterfaceError::ERR_PERM;
        }
        
        $fields = "(";
        $values = "(";
        $updates = "";

        $fields = $fields."user_id, ";
        $values = $values."'".$baseinfo['user_id']."', ";

        LibMisc::appendAffectedVolumn($fields, 
            $values, $updates, "name", $data['name']);
        LibMisc::appendAffectedVolumn($fields, 
            $values, $updates, "nickname", $data['nickname']);
        LibMisc::appendAffectedVolumn($fields, 
            $values, $updates, "introduction", $data['introduction']);
        LibMisc::appendAffectedVolumn($fields, 
            $values, $updates, "avatar", $data['avatar']);

        if (!empty($data['gendertag'])) {
            $id = $this->getgendertagid($data['gendertag']);
        }
        LibMisc::appendAffectedVolumn($fields, 
            $values, $updates, "gender_tag_id", $id);

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

        $sql = 'INSERT INTO userinfo_extend '.$fields.
            ' VALUES '.$values.' ON DUPLICATE KEY UPDATE '.$updates;
        $ret = $this->runSQL($sql);

        if (!empty($data['dateofbirth'])) {
            $dateofbirth = $data['dateofbirth'];
            $dateofbirth = str_replace("年", "-", $dateofbirth);
            $dateofbirth = str_replace("月", "-", $dateofbirth);
            $dateofbirth = str_replace("日", "", $dateofbirth);
            $dateofbirth = date('Y-m-d', strtotime($dateofbirth));
        }

        $fields = "(";
        $values = "(";
        $updates = "";

        $fields = $fields."user_id, ";
        $values = $values."'".$baseinfo['user_id']."', ";

        LibMisc::appendAffectedVolumn($fields, 
            $values, $updates, "dateofbirth", $dateofbirth);
        LibMisc::appendAffectedVolumn($fields, 
            $values, $updates, "mobile", $data['mobile']);
        LibMisc::appendAffectedVolumn($fields, 
            $values, $updates, "qqno", $data['qqno']);
        LibMisc::appendAffectedVolumn($fields, 
            $values, $updates, "wechat", $data['wechat']);
        LibMisc::appendAffectedVolumn($fields, 
            $values, $updates, "email", $data['email']);

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

        $sql = 'INSERT INTO userinfo_secure '.$fields.
            ' VALUES '.$values.' ON DUPLICATE KEY UPDATE '.$updates;
        $ret = $this->runSQL($sql);

        return InterfaceError::ERR_OK;
        */
    }

    /**
     * Brief: Check if the mobile is already registered
     * Parameter
     *      mobile    NO. of the mobile
     *
     * Return
     *      true      If is registered
     *      false     If is available
     */
    public function checkmobile($mobile) {
        if (empty($mobile)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $sql = "SELECT mobile FROM userinfo_secure ".
            "WHERE mobile='$mobile' LIMIT 1";
        $ret = $this->runSQL($sql);

        if (empty($ret)) {
            return false;
        } else {
            return true;
        }
    }    

    public function updatelastaccess($username) {
        if (empty($username)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $userinfo = $this->getuserinfo($username, $username);
        $accesstime = date("Y-m-d H:i:s", time());
        $userid = $userinfo['user_id'];
        $sql = "INSERT INTO userinfo_extend (user_id, lastaccess) ".
            "VALUES ('$userid', '$accesstime') ".
            "ON DUPLICATE KEY UPDATE lastaccess='$accesstime'";
        $ret = $this->runSQL($sql);
        return array("lastaccess"=>$accesstime);
    }
}
?>
