<?php
class InterfaceUser {
    function gotoSigninFail($result) {
        global $rootdir;
        $params = LibMisc::getParams();
        $frommobile = $params['frommobile'];

        if (0 == $frommobile) {
            $url = $rootdir."/modules/usercenter/signin.php".
                "?fail=".InterfaceError::getErrorMessage(
                    InterfaceError::ERR_INVALIDPARAMS);
            $result = "<script>url=\"$url\";".
                "window.location.href=url;".
                "</script>";

            return $result;
        } else {
            $error = new InterfaceError();
            $code = InterfaceError::ERR_INVALIDPARAMS;
            if ($error->isErrorCode($result)) {
                $code = $result;
            }

            return $error->errorAction(
                $code, $params);
        }
    }

    function gotoLoginSuccess($result) {
        global $rootdir;
        $params = LibMisc::getParams();
        $frommobile = $params['frommobile'];
        $username = $params['username'];

        if (0 == $frommobile) {
            if ($result == InterfaceError::ERR_OK)
            {
            $url = $rootdir."/modules/usercenter/minecenter.php?username="
                .$username."&login_status=".true;
            $result = "<script>url=\"$url\";".
                "window.location.href=url;".
                "</script>";

            return $result;
            } else {
                $js = "<script language='javascript' type = 'text/javascript'
                    >alert('用户名或密码错误！');</script>";
                $url = $rootdir."/info_search.php";
                $result = $js."<script>url=\"$url\";".
                    "window.location.href=url;".
                    "</script>";

                return $result;
                
            }
        } else {
            $error = new InterfaceError();
            return $error->errorAction(
                InterfaceError::ERR_OK, $result);
        }
    }

    public function signoutAction() {
        global $rootdir;
        $url = $rootdir."/index.php?logout=".true;
        $result = "<script>url=\"$url\";".
            "window.location.href=url;".
            "</script>";

        return $result;
    }

    public function signinAction() {
        $params = LibMisc::getParams();
        $frommobile = $params['frommobile'];
        $username = $params['username'];
        $password = $params['password'];

        if (empty($username) || empty($password)) {
            if (0 == $frommobile) {
                return $this->gotoSigninFail(
                    InterfaceError::ERR_INVALIDPARAMS);
            } else {
                $error = new InterfaceError();
                return $error->errorAction(
                    InterfaceError::ERR_INVALIDPARAMS,
                    $params);
            }
        }

        $dbuser = new WrapperDBUser();
        $user = array("username"=>$username,
            "password"=>$password);
        $ret = $dbuser->login($user);

        return $this->gotoLoginSuccess($ret);
        //return $this->processLoginSuccess($ret, gotoSigninFail);
    }

    public function hrsigninAction() {
        $params = LibMisc::getParams();
        $frommobile = $params['frommobile'];
        $username = $params['username'];
        $password = $params['password'];
        //echo "username:".$username."====password:".$password;
        //die;

        if (empty($username) || empty($password)) {
            if (0 == $frommobile) {
                return $this->gotoSigninFail(
                    InterfaceError::ERR_INVALIDPARAMS);
            } else {
                $error = new InterfaceError();
                return $error->errorAction(
                    InterfaceError::ERR_INVALIDPARAMS,
                    $params);
            }
        }

        $dbuser = new WrapperDBUser();
        $user = array("username"=>$username,
            "password"=>$password);
        $ret = $dbuser->hrlogin($user);

        return $this->gotohrLoginSuccess($ret);
        //return $this->processLoginSuccess($ret, gotoSigninFail);
    }

    public function addstaffAction()
    {
        $params = LibMisc::getParams();
        $params['EmployeeID'] = "";

        if (empty($params['Name']) || empty($params['LoginName']) 
            || empty($params['Password']) || empty($params['Telephone']))
        {
                return $this->gotoAddFail(InterfaceError::ERR_INVALIDPARAMS);
        }

        $dbuser = new WrapperDBUser();
        $ret = $dbuser->addstaff($params);
        return $this->gotoAddstaffSuccess($ret);
    }

    private function gotoAddstaffSuccess($result)
    {
        global $rootdir;
        $params = LibMisc::getParams();
        $username = $params['username'];
        if ($result == InterfaceError::ERR_OK)
        {
           print "<script >alert('新员工添加成功!');</script>";
           $url = "$rootdir/modules/hrcenter/minecenter.php?username=".
$username."&login_status=1";
           $result = "<script >window.location.href = '$url';</script>";
           return $result;
        } else if ($result == InterfaceError::ERR_DBIO){
           print "<script >alert('新员工添加失败!');</script>";
           $url = "$rootdir/modules/hrcenter/minecenter.php?username=".
$username."&login_status=1";
           $result = "<script >window.location.href = '$url';</script>";
           return $result;
        } else if ($result == InterfaceError::ERR_INVALIDPARAMS) {
           print "<script >alert('重要属性为空!');</script>";
           $url = "$rootdir/modules/hrcenter/minecenter.php?username=".
$username."&login_status=1";
           $result = "<script >window.location.href = '$url';</script>";
           return $result;
        }
    }

    private function gotoAddFail($result)
    {
        global $rootdir;
        $params = LibMisc::getParams();
        $username = $params['username'];
        
        if (empty($params['Name']))
        {
           print "<script >alert('真实姓名不能为空!');</script>";
           $url = "$rootdir/modules/hrcenter/minecenter.php?username=".
$username."&login_status=1";
           $result = "<script >window.location.href = '$url';</script>";
           return $result;
        } else if (empty($params['LoginName'])){
           print "<script >alert('登陆名不能为空!');</script>";
           $url = "$rootdir/modules/hrcenter/minecenter.php?username=".
$username."&login_status=1";
           $result = "<script >window.location.href = '$url';</script>";
           return $result;
        } else if (empty($params['Password'])){
           print "<script >alert('登陆密码不能为空!');</script>";
           $url = "$rootdir/modules/hrcenter/minecenter.php?username=".
$username."&login_status=1";
           $result = "<script >window.location.href = '$url';</script>";
           return $result;
        }  else if (empty($params['Telephone'])){
           print "<script >alert('电话号码不能为空!');</script>";
           $url = "$rootdir/modules/hrcenter/minecenter.php?username=".
$username."&login_status=1";
           $result = "<script >window.location.href = '$url';</script>";
           return $result;
        } 

    }

    function gotohrLoginSuccess($result) {
        global $rootdir;
        $params = LibMisc::getParams();
        $frommobile = $params['frommobile'];
        $username = $params['username'];

        if (0 == $frommobile) {
            if ($result == InterfaceError::ERR_OK)
            {
            $url = $rootdir."/modules/hrcenter/minecenter.php?username="
                .$username."&login_status=".true;
            $result = "<script>url=\"$url\";".
                "window.location.href=url;".
                "</script>";

            return $result;
            } 
            else if ($result == InterfaceError::ERR_NOSUCHUSER)
            {
                $js = "<script language='javascript' type = 'text/javascript'
                    >alert('您不是人事部员工,禁止登陆！');</script>";
                $url = $rootdir."/info_manager.php";
                $result = $js."<script>url=\"$url\";".
                    "window.location.href=url;".
                    "</script>";

                return $result;
                
            } else {
                $js = "<script language='javascript' type = 'text/javascript'
                    >alert('用户名或密码错误！');</script>";
                $url = $rootdir."/info_manager.php";
                $result = $js."<script>url=\"$url\";".
                    "window.location.href=url;".
                    "</script>";

                return $result;
                
            }
        } else {
            $error = new InterfaceError();
            return $error->errorAction(
                InterfaceError::ERR_OK, $result);
        }
    }

    public function deletestaffAction()
    {
        $params = LibMisc::getParams();
        $employeeid = $params['EmployeeID'];
        $username = $params['username'];

        if (empty($employeeid) || empty($username))
        {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $dbuser = new WrapperDBUser();
        $ret = $dbuser->deletestaff($params);

        return $this->gotoDeletestaffSuccess($ret);
    }

    public function gotoDeletestaffSuccess($ret)
    {
        global $rootdir;
        $params = LibMisc::getParams();
        $username = $params['username'];
        $deptid = $params['DeptID']; 
        if ($ret == InterfaceError::ERR_OK)
        {
            print "<script language='javascript' type = 'text/javascript'>
                alert('删除成功!');</script>";
            $url = "../../modules/hrcenter/importdept.php?username=".
                    "$username"."&deptid=$deptid&login_status=".true;
            return "<script language='javascript' type = 'text/javascript'>
                window.location.href = '$url';</script>";
        } else if ($ret == InterfaceError::ERR_INVALIDPARAMS){
            $js = "<script language='javascript' type = 'text/javascript'
                >alert('删除失败！');</script>";
            $url = $rootdir."/modules/hrcenter/importdept.php?username=".
                "$username"."&deptid=$deptid&login_status=".true;
            $result = $js."<script>url=\"$url\";".
                "window.location.href=url;".
                "</script>";

            return $result;
        }
    }

    function processLoginSuccess($ret, $failfunc) {
        $error = new InterfaceError();

        if (InterfaceError::ERR_OK != $ret && 
            $error->isErrorCode($ret)) {
            return $this->$failfunc($ret);
        }

        return $this->gotoLoginSuccess($ret);
    }

    public function updatestaffbaseAction()
    {
        $params = LibMisc::getParams();
        $username = $params['username'];
        if (!empty($_COOKIE['username']) &&
            $username != $_COOKIE['username']) {
            $error = new InterfaceError();
            return $error->errorAction(
                InterfaceError::ERR_PERM, $params);            
        }

        $staffdata = array(
            "username"=>$username,
            "Name"=>$params['Name'],
            "Sex"=>$params['Sex'],
            "LoginName"=>$params['LoginName'],
            "Password"=>$params['Password'],
            "Telephone"=>$params['Telephone'],
            "Email"=>$params['Email'],
            "DeptID"=>$params['DeptID'],
            "BasicSalary"=>$params['BasicSalary'],
            "Title"=>$params['Title'],
            "OnboardDate"=>$params['OnboardDate'],
            "VacationRemain"=>$params['VacationRemain'],
            "EmployeeLevel"=>$params['EmployeeLevel'],
            "PhotoImage"=>$params['PhotoImage'],);
        $dbuser = new WrapperDBUser();
        $ret = $dbuser->updatestaffbase($staffdata);
        return $this->gotoUpdatestaffbase($ret);
    }

    public function gotoUpdatestaffbase($ret)
    {
        global $rootdir;
        $params = LibMisc::getParams();
        $username = $params['username'];
        $loginname = $params['LoginName'];
        $deptid = $params['DeptID'];
        if ($ret == InterfaceError::ERR_OK)
        {
            $js = "<script language='javascript' type = 'text/javascript'
                >alert('修改成功！');</script>";
            $url = $rootdir."/modules/hrcenter/importdept.php?username=".
                "$username"."&deptid=$deptid&login_status=".true;
            $result = $js."<script>url=\"$url\";".
                "window.location.href=url;".
                "</script>";

            return $result;
        } else if ($ret == InterfaceError::ERR_NULLKEYWORD){
            $js = "<script language='javascript' type = 'text/javascript'
                >alert('关键属性不能为空！');</script>";
            $url = $rootdir."/modules/hrcenter/importdept.php?username=".
                "$username"."&deptid=$deptid&login_status=".true;
            $result = $js."<script>url=\"$url\";".
                "window.location.href=url;".
                "</script>";

            return $result;
        } else if ($ret == InterfaceError::ERR_INVALIDPARAMS){
            $js = "<script language='javascript' type = 'text/javascript'
                >alert('修改失败！');</script>";
            $url = $rootdir."/modules/hrcenter/importdept.php?username=".
                "$username"."&deptid=$deptid&login_status=".true;
            $result = $js."<script>url=\"$url\";".
                "window.location.href=url;".
                "</script>";

            return $result;
        }

        //$error = new InterfaceError();
        //return $error->errorAction($ret, null);
    }


    public function updatebaseinfoAction() {
        global $rootdir;
        $params = LibMisc::getParams();
        $username = $params['username'];
        if (!empty($_COOKIE['username']) &&
            $username != $_COOKIE['username']) {
            $error = new InterfaceError();
            return $error->errorAction(
                InterfaceError::ERR_PERM, $params);            
        }
    
        $userdata = array(
            "username"=>$params['username'],
            "password"=>$params['password'],
            "introduction"=>$params['introduction']); 
        $dbuser = new WrapperDBUser();
        $ret = $dbuser->updateuserdata($userdata);
        return $this->gotoUpdatebaseinfo($ret);
    }

    public function gotoUpdatebaseinfo($ret)
    {
        global $rootdir;
        $params = LibMisc::getParams();
        $username = $params['username'];
        if ($ret == InterfaceError::ERR_OK)
        {
            $js = "<script language='javascript' type = 'text/javascript'
                >alert('修改成功！');</script>";
            $url = $rootdir."/modules/usercenter/minecenter.php?username="
                .$username."&login_status=".true;
            $result = $js."<script>url=\"$url\";".
                "window.location.href=url;".
                "</script>";

            return $result;
        } else {
            $js = "<script language='javascript' type = 'text/javascript'
                >alert('修改失败');</script>";
            $url = $rootdir."/modules/usercenter/minecenter.php?username="
                .$username."&login_status=".true;
            $result = $js."<script>url=\"$url\";".
                "window.location.href=url;".
                "</script>";

            return $result;

        }
        //$error = new InterfaceError();
        //return $error->errorAction($ret, null);
    }

    public function updateavatarAction() {
        $params = LibMisc::getParams();
        $username = $params['username'];

        if (empty($username) || empty($_FILES['avatar'])) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $imageuploader = new ImageUploader();
        $ret = $imageuploader->upload('avatar');

        if (InterfaceError::ERR_OK != $ret &&
            InterfaceError::isErrorCode($ret)) {
            return $error->errorAction($ret, $params);
        }

        $userdata = array(
            "avatar"=>$ret,
            "username"=>$username);
        $dbuser = new WrapperDBUser();
        $ret = $dbuser->updateuserdata($userdata);
        $error = new InterfaceError();
        return $error->errorAction($ret, null);
    }

    public function getprofileAction() {
        $params = LibMisc::getParams();
        $requser = $params['requser'];
        $targetuser = $params['targetuser'];

        if (empty($requser) || empty($targetuser)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $dbuser = new WrapperDBUser();
        $userinfo = $dbuser->getinfo($requser, $targetuser);
        echo json_encode($userinfo); die;
    }

    public function nearbyuserAction() {

    }

    public function friendlistAction() {

    }

    public function roammedcityuserAction() {

    }

    public function checkmobileAction() {
        $params = LibMisc::getParams();
        $mobile = $params['mobile'];
        $error = new InterfaceError();

        if (empty($mobile)) {
            return $error->errorAction(
                InterfaceError::ERR_INVALIDPARAMS,
                $params);
        }

        $dbuser = new WrapperDBUser();
        $ret = $dbuser->checkmobile($mobile);

        if (InterfaceError::isErrorCode($ret)) {
            return $error->errorAction($ret, $params);
        } else {
            return $error->errorAction(
                InterfaceError::ERR_OK, 
                array("isMobileStatus"=>$ret));
        }
    }
}
?>
