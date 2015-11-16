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

    public function addstaff(array $staff) {
        if (empty($staff['Name']) || empty($staff['LoginName']) 
            || empty($staff['Password']) || empty($staff['Telephone'])) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $employeeid = $staff['EmployeeID'];
        $name = $staff['Name'];
        $sex = $staff['Sex'];
        $password = $staff['Password'];
        $loginname = $staff['LoginName'];
        $email = $staff['Email'];
        $deptid = $staff['DeptID'];
        $telephone = $staff['Telephone'];
        $date = date('Y-m-d');

        $sql = "INSERT INTO tblEmployee (EmployeeID, Name, Sex, LoginName,
        Password, Email, DeptID, Telephone, OnboardDate) VALUES 
        ('', '".$name."', '".$sex."', '".$loginname."','".
        $password."', '".$email."', $deptid, '".$telephone."', $date)";


        $ret = $this->runSQL($sql);
        if (0 == sizeof($ret)) {
            return InterfaceError::ERR_DBIO;
        }

        return InterfaceError::ERR_OK;
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

    public function hrlogin(array $user) {
        if (empty($user['username']) ||
            empty($user['password'])) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $username = $user['username'];
        $password = $user['password'];

        $deptid = $this->getuserinfo($username)['DeptID'];
        
        if ($deptid != 1)
        {
            return InterfaceError::ERR_NOSUCHUSER;
        }

        $sql = "SELECT * FROM tblEmployee WHERE LoginName = '".$username.
            "' AND Password = '".$password."' AND DeptID = 1";
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
    /**
     * Return:
     *     all  tblLeave information when username is not null
     */

    public function getleaveinfo($username)
    {
        $employeeID = $this->getuserinfo($username)['EmployeeID'];

        $sql = "SELECT * FROM tblLeave WHERE EmployeeID = $employeeID LIMIT 1";
        $ret = $this->runSQL($sql);

        if (0 == sizeof($ret))
        {
            return InterfaceError::ERR_INVALIDPARAMS;
        }
        return $ret[0];
    }

    public function getremainhours($loginname)
    {
        $vacationremain = $this->getuserinfo($loginname)['VacationRemain'];
        return $vacationremain;
    }

    /*
     * Input: Employee's name
     * Output:Employee's used hours in the tblLeave, It is not the whole
     * used hours in the YearHoliday !
     * Date:2015-11-12 Author:Zhangtao
     */
    public function getusedhours($username)
    {
        if (empty($username))
        {
            return InterfaceError::ERR_INVALIDPARAMS;
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

    /**
     * Brife: get manager info 
     * Return:
     *      DeptName => ManagerName, it includes an array.
     */
    public function getmanagerinfo()
    {
        $sql = "SELECT b.DeptName, a.Name FROM tblEmployee a, tblDepartment b
            WHERE a.EmployeeID = b.ManagerID AND a.DeptID = b.DeptID";
        $ret = $this->runSQL($sql);
        if (empty($ret))
        {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $managerinfo = null;

        for($i = 0; $i < sizeof($ret); $i++)
        {
            $managerinfo[$ret[$i]['DeptName']] = $ret[$i]['Name'];
        }

        return $managerinfo;
    }

    /**
     * Brife:Judge the loginname is whether the manager
     * Return:
     *     true: InterfaceError::ERR_OK
     *     false: InterfaceError::ERR_INVALIDPARAMS
     */
    public function ismanager($loginname)
    {
        $managerinfo = $this->getmanagerinfo();

        $username = $this->getuserinfo($loginname)['Name'];
        foreach($managerinfo as $deptname => $managername)
        {
            if ($username == $managername)
                return InterfaceError::ERR_OK;
        }

        return InterfaceError::ERR_INVALIDPARAMS;
    }

    /**
     * Brife: get the staff whose manager is loginname 
     * Return:
     *     The Name array and not include the manager self
     */ 
    public function getmanagerstaff($loginname)
    {
        $deptid = $this->getuserinfo($loginname)['DeptID'];
        $username = $this->getusername($loginname);

        $sql = "SELECT Name FROM tblEmployee WHERE DeptID = $deptid 
            AND Name != '".$username."' ";
        $ret = $this->runSQL($sql);

        if (0 == sizeof($ret))
        {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        return $ret;
    }

    /**
     * Brife: Convert from username to loginname
     * Return:
     *     loginname
     */
    public function getloginname($username)
    {
        $sql = "SELECT LoginName FROM tblEmployee
            WHERE Name = '".$username."'LIMIT 1 ";
        $ret = $this->runSQL($sql);

        if (0 == sizeof($ret))
        {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        return $ret[0]['LoginName'];
    }

    public function getusername($loginname)
    {
        $sql = "SELECT Name FROM tblEmployee
        WHERE LoginName = '".$loginname."' LIMIT 1";
        $ret = $this->runSQL($sql);

        if (0 == sizeof($ret))
        {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        return $ret[0]['Name'];
    }

    /**
     * Brife: get employee's attendance information and ApproverName
     * Return:
     *     ApproverID and all tblAttendance data
     */
    public function getattendinfo($loginname)
    {
        $employeeID = $this->getuserinfo($loginname)['EmployeeID'];
        $sql = "SELECT c.Name, a.* FROM tblAttendance a, tblEmployee b,
            tblEmployee c WHERE a.EmployeeID = b.EmployeeID AND
            a.EmployeeID = $employeeID AND a.RecorderID = c.EmployeeID";
        $ret = $this->runSQL($sql);
        
        if (0 == sizeof($ret))
        {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        return $ret; 
    }

    public function getthismonthsalary($loginname)
    {
        $employeeID = $this->getuserinfo($loginname)['EmployeeID'];

        $year_month = date('Y-m');
        $sql = "SELECT * FROM tblSalary WHERE SalaryTime LIKE 
            '%".$year_month."%' AND EmployeeID = $employeeID LIMIT 1";
        $ret = $this->runSQL($sql);

        if(0 == sizeof($ret))
        {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        return $ret[0]; 
    }
   
    
    public function getallsalary($loginname)
    {
        $employeeID = $this->getuserinfo($loginname)['EmployeeID'];

        $sql = "SELECT * FROM tblSalary WHERE 
            EmployeeID = $employeeID";
        $ret = $this->runSQL($sql);

        if(0 == sizeof($ret))
        {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        return $ret; 
    }

    public function getdeptstaff($deptid)
    {
        if (empty($deptid))
        {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $sql = "SELECT * FROM tblEmployee WHERE DeptID = $deptid";
        $ret = $this->runSQL($sql);

        if (0 == sizeof($ret))
        {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        return $ret;
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
    public function getuserinfo($loginname) {
        if (empty($loginname)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $sql = 'SELECT * FROM tblEmployee  '.
            'where LoginName=\''.$loginname.'\' LIMIT 1';
        $ret = $this->runSQL($sql);
        if (0 == sizeof($ret)) {
           return InterfaceError::ERR_NOSUCHUSER; 
        }

        $userinfo = $ret[0];
        //$userinfo = $this->fillSecureInfo($userinfo);
        //$userinfo = $this->reorganizeUserinfo($userinfo);
        return $userinfo;
    }

    /**
     * Brife: get manager' deptname through deptid
     * Return:
     *     manager's Name , DeptName 
     * Date:2015-11-15
     */ 

    public function getdeptinfo($deptid)
    {
        if (empty($deptid))
        {
            return InterfaceError::ERR_INVALIDPARAMS;
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

    /**
     * Brife: get the employee's leave record
     * Return:
     *    ApproverName and all information in table tblLeave
     * Date: 2015-11-14
     */
    public function getstaffleaveinfo($loginname)
    {
        $deptid = $this->getuserinfo($loginname)['DeptID'];

        $sql = "SELECT c.Name 'ApproverName', a.* FROM tblLeave a,
            tblEmployee b, tblEmployee c WHERE a.EmployeeID = 
            b.EmployeeID AND b.LoginName = '".$loginname."' 
            AND c.EmployeeID = a.ApproverID LIMIT 1";
        $ret = $this->runSQL($sql);

        if (0 == sizeof($ret))
        {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        return $ret[0];
    }

    /**
     * Brife: get dept name through login
     * Return:
     *     deptname
     */ 
    public function getdeptname($loginname)
    {
        if (empty($loginname))
        {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $deptid = $this->getuserinfo($loginname)['DeptID'];

        $sql = "SELECT DeptName FROM tblDepartment WHERE
        DeptID = $deptid";

        $ret = $this->runSQL($sql);

        if (0 == sizeof($ret))
        {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        return $ret[0]['DeptName'];

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

    /**
     * Brief: update SelfIntro and password in info_search module
     * Return:
     *     the update state
     *     Success:InterfaceError::ERR_OK;
     *     Fail: InterfaceError::ERR_INVALIDPARAMS
     */ 
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
    }
    
    /**
     * Brief: update a staff's all information in info_manager module
     * Return:
     *     the update state
     *     Success:InterfaceError::ERR_OK;
     *     Fail: InterfaceError::ERR_INVALIDPARAMS
     */ 
    public function updatestaffbase(array $data)
    {
        if (empty($data)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $loginname = $data['LoginName'];
        $userinfo = $this->getuserinfo($loginname);
        $employeeid = $userinfo['EmployeeID'];
        $sex = $data['Sex'];
        $name = $data['Name'];
        $password = $data['Password'];
        $telephone = $data['Telephone'];
        $email = $data['Email'];
        $deptid = $data['DeptID'];
        $basicsalary = $data['BasicSalary'];
        $title = $data['Title'];
        $onboarddate = $data['OnboardDate'];
        $vacationremain = $data['VacationRemain'];
        $employeelevel = $data['EmployeeLevel'];
        $photoimage = $data['PhotoImage'];

        if (empty($loginname) || empty($name) || empty($password) || 
            empty($telephone)) {
            return InterfaceError::ERR_NULLKEYWORD;
        }

        $sql = "UPDATE tblEmployee SET Name = '".$name."', Sex = '".$sex."',
        LoginName = '".$loginname."', Password = '".$password."', Telephone = '".
        $telephone."', Email = '".$email."', DeptID = $deptid, BasicSalary ='".
        $basicsalary."', Title = '".$title."', OnboardDate = '".$onboarddate."',
        VacationRemain = '".$vacationremain."', EmployeeLevel = '".
        $employeelevel."', PhotoImage = '".$photoimage."' WHERE EmployeeID = ".
        $employeeid;


        $ret = $this->runSQL($sql);

        return InterfaceError::ERR_OK;

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

    /*
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
    */
}
?>
