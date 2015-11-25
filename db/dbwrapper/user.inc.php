<?php
require_once "$curdir/db/dbimpl/user.inc.php";

class WrapperDBUser {
    function encPassword($password) {
        return md5(md5($password).$salt);
    }

    public function addstaff(array $staff) {
        if (empty($staff['Name']) || empty($staff['LoginName']) 
            || empty($staff['Password']) || empty($staff['Telephone'])) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        // $user['password'] = $this->encPassword(
        //    $user['password']);

        $dbhtwuser = new DBHTWUser();
        $ret = $dbhtwuser->addstaff($staff);
        return $ret;
    }

    public function login(array $user) {
        $dbhtwuser = new DBHTWUser();

        if (empty($user['password'])) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        //$user['password'] = $this->encPassword(
        //    $user['password']);

        $ret = $dbhtwuser->login($user);
        return $ret;
    }

    public function hrlogin(array $user)
    {
        $dbhtwuser = new DBHTWUser();

        if (empty($user['password'])) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        //$user['password'] = $this->encPassword(
        //    $user['password']);

        $ret = $dbhtwuser->hrlogin($user);
        return $ret;
    }

    public function getuserinfo($loginname) {
        $dbhtwuser = new DBHTWUser();

        if (empty($loginname)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $ret = $dbhtwuser->getuserinfo($loginname);
        return $ret;
    }

    public function getdeptinfo($deptid)
    {
        $dbhtwuser = new DBHTWUser();

        if (empty($deptid))
        {
            echo "部门编号为空！";
            die;
        }
        $ret = $dbhtwuser->getdeptinfo($deptid);
        return $ret;
    }
    
    public function getdeptname($loginname)
    {
        $dbhtwuser = new DBHTWUser();

        if (empty($loginname))
        {
            return InterfaceError::ERR_INVALIDPARAMS;
        }
        $ret = $dbhtwuser->getdeptname($loginname);
        return $ret;
    }

    public function getusedhours($loginname)
    {
        $dbhtwuser = new DBHTWUser();

        if (empty($loginname)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $ret = $dbhtwuser->getusedhours($loginname);
        return $ret;
    }

    public function getremainhours($loginname)
    {
        $dbhtwuser = new DBHTWUser();

        if (empty($loginname)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $ret = $dbhtwuser->getremainhours($loginname);
        return $ret;
    }

    public function ismanager($loginname)
    {
        $dbhtwuser = new DBHTWUser();

        if (empty($loginname)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $ret = $dbhtwuser->ismanager($loginname);
        return $ret;

    }

    public function getmanagerstaff($loginname)
    {
        $dbhtwuser = new DBHTWUser();

        if (empty($loginname)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $ret = $dbhtwuser->getmanagerstaff($loginname);
        return $ret;
    }

    public function getstaffleaveinfo($loginname)
    {
        $dbhtwuser = new DBHTWUser();

        if (empty($loginname)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $ret = $dbhtwuser->getstaffleaveinfo($loginname);
        return $ret;
    }

    public function getloginname($username)
    {
        $dbhtwuser = new DBHTWUser();

        if (empty($username)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $ret = $dbhtwuser->getloginname($username);
        return $ret;
    }

    public function getusername($loginname)
    {
        $dbhtwuser = new DBHTWUser();

        if (empty($loginname)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $ret = $dbhtwuser->getusername($loginname);
        return $ret;
    }

    public function getattendinfo($loginname)
    {
        $dbhtwuser = new DBHTWUser();

        if (empty($loginname)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $ret = $dbhtwuser->getattendinfo($loginname);
        return $ret;
    }

    public function getthismonthsalary($loginname)
    {
        $dbhtwuser = new DBHTWUser();

        if (empty($loginname)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $ret = $dbhtwuser->getthismonthsalary($loginname);
        return $ret;
    }

    public function getallsalary($loginname)
    {
        $dbhtwuser = new DBHTWUser();

        if (empty($loginname)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $ret = $dbhtwuser->getallsalary($loginname);
        return $ret;
    }
    
    public function getdeptstaff($deptid)
    {
        if (empty($deptid))
        {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $dbhtwuser = new DBHTWUser();

        $ret = $dbhtwuser->getdeptstaff($deptid);
        return $ret;
    }

    public function deletestaff($params)
    {
        $employeeid = $params['EmployeeID'];
        if (empty($employeeid))
        {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $dbhtwuser = new DBHTWUser();
        $ret = $dbhtwuser->deletestaff($params);
        return $ret;
    }

    public function searchstaff($params)
    {
        if (is_array($params))
        {
            $keyword = trim($params['keyword']);
            if (empty($keyword))
            {
                return InterfaceError::ERR_INVALIDPARAMS;
            }
        }
        $dbhtwuser = new DBHTWUser();
        $ret = $dbhtwuser->searchstaff($params);
        return $ret;
    }

    public function getsecureinfo($requestuser, $requesteduser) {
        $dbhtwuser = new DBHTWUser();

        if (empty($requestuser) || empty($requesteduser)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $ret = $dbhtwuser->getsecureinfo($requestuser, $requesteduser);
        return $ret;
    }

    public function getname($userid) {
        if (empty($userid)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $dbhtwuser = new DBHTWUser();
        $ret = $dbhtwuser->getname($userid);
        return $ret;
    }
    
    public function getUid($username) {
        if(empty($username)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }
        
        $dbhtwuser = new DBHTWUser();
        $ret = $dbhtwuser->getUid($username);
        return $ret;
    }

    public function getbaseinfo($username) {
        if (empty($username)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $dbhtwuser = new DBHTWUser();
        $ret = $dbhtwuser->getbaseinfo($username);
        return $ret;
    }

    public function getgendertags($userid) {
        if (empty($userid)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $dbhtwuser = new DBHTWUser();
        $ret = $dbhtwuser->getgendertags($userid);
        return $ret;
    }

    public function updateuserdata(array $data) {
        if (empty($data)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        } 

        $dbhtwuser = new DBHTWUser();
        $ret = $dbhtwuser->updateuserdata($data);
        return $ret;
    }

    public function updatestaffbase(array $data) {
        if (empty($data)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        } 

        $dbhtwuser = new DBHTWUser();
        $ret = $dbhtwuser->updatestaffbase($data);
        return $ret;
    }

    public function checkmobile($mobile) {
        if (empty($mobile)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $dbhtwuser = new DBHTWUser();
        $ret = $dbhtwuser->checkmobile($mobile);
        return $ret;
    }

    public function updatelastaccess($username) {
        if (empty($username)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $dbhtwuser = new DBHTWUser();
        //$ret = $dbhtwuser->updatelastaccess($username);
        //return $ret;
    }
}
?>
