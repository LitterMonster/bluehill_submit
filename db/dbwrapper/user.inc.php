<?php
require_once "$curdir/db/dbimpl/user.inc.php";

class WrapperDBUser {
    function encPassword($password) {
        return md5(md5($password).$salt);
    }

    public function add(array $user) {
        if (empty($user['password'])) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $user['password'] = $this->encPassword(
            $user['password']);

        $dbhtwuser = new DBHTWUser();
        $ret = $dbhtwuser->add($user);
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

    public function getuserinfo($username) {
        $dbhtwuser = new DBHTWUser();

        if (empty($username)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $ret = $dbhtwuser->getuserinfo($username);
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

    /*
     * Input: Employee's name
     * Output:Employee's used hours in the tblLeave, It is not the whole
     * used hours in the YearHoliday !
     * Date:2015-11-12 Author:Zhangtao
     */
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

    /**
     * Brife: get the staff under the control of manager
     * Return:
     *     The staff array
     */ 
    public function getmanagerstaff($loginname)
    {
        $dbhtwuser = new DBHTWUser();

        if (empty($loginname)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $ret = $dbhtwuser->getmanagerstaff($loginname);
        return $ret;
    }

    /**
     * Brife: get the employee's leave record
     * Return:
     *     An array contains the leave record
     */ 
    public function getstaffleaveinfo($loginname)
    {
        $dbhtwuser = new DBHTWUser();

        if (empty($loginname)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $ret = $dbhtwuser->getstaffleaveinfo($loginname);
        return $ret;
    }

    /**
     * Brife: Convert from username to loginname
     * Return:
     *     loginname
     */

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
        $ret = $dbhtwuser->updatelastaccess($username);
        return $ret;
    }
}
?>
