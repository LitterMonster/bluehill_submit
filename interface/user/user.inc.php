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
            $url = $rootdir."/modules/usercenter/minecenter.php?username="
                .$username."&login_status=".true;
            $result = "<script>url=\"$url\";".
                "window.location.href=url;".
                "</script>";

            return $result;
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
        $ret = $dbuser->login($user);

        return $this->gotoLoginSuccess($ret);
        //return $this->processLoginSuccess($ret, gotoSigninFail);
    }

    function processLoginSuccess($ret, $failfunc) {
        $error = new InterfaceError();

        if (InterfaceError::ERR_OK != $ret && 
            $error->isErrorCode($ret)) {
            return $this->$failfunc($ret);
        }

        return $this->gotoLoginSuccess($ret);
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
        if (!empty($ret))
        {
            $js = "<script language='javascript' type = 'text/javascript'
                >alert('修改完成！');</script>";
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
