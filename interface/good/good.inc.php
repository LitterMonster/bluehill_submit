<?php
class InterfaceGood {
     /**
     * Brief:
     *    release sofa action
     * Parameters:
     *     NULL
     * Return:
     *    result of executing releaseSofa method
     *
     * Date:2015-9-1     Revision:           Author:Zhangtao
     */
   public function releaseAction() {
        $params = LibMisc::getParams();
        $params['good_id'] = "";
        $params['class_id'] = 1;
        $params['price_currency_id'] = 1;
        $params['photos_id'] = 1;
        $params['price_unit_id'] = 1;
        $username = $params['username'];
        $frommobile = $params['frommobile']; 

        if (empty($username) || empty($params['title'])) {
            if (0 == $frommobile) {
                return $this->gotoReleaseFail(
                    InterfaceError::ERR_INVALIDPARAMS);
            } else {
                $error = new InterfaceError();
                return $error->errorAction(
                    InterfaceError::ERR_INVALIDPARAMS,
                    $params);
            }
        } 

        $dbgood = new WrapperDBGood();
        $ret = $dbgood->releaseSofa($username,$params);
        return $this->gotoReleaseSuccess($ret);
    }

    public function searchAction() {
        $params = LibMisc::getParams();
        $dbgood = new WrapperDBGood();
        $keyword = $params['keyword'];
        $frommobile = $params['frommobile'];

        if (empty($keyword)) {
            if (0 == $frommobile) {
                return $this->gotoSearchFail(
                    InterfaceError::ERR_INVALIDPARAMS);
            } else {
                $error = new InterfaceError();
                return $error->errorAction(
                    InterfaceError::ERR_INVALIDPARAMS,
                    $params);
            }
        }
        $ret = $dbgood->searchSofa($params);
    }

    public function deleteAction() {
        $params = LibMisc::getParams();
        $dbgood = new WrapperDBGood();
        $ret = $dbgood->deleteSofaData($params);
        return $ret;
    }

    public function updateAction() {
        $params = LibMisc::getParams();
        $dbgood = new WrapperDBGood();
        $ret = $dbgood->updateSofaData($params);
        print "<script language='javascript' type = 'text/javascript'>
            alert('沙发更新成功!');</script>";
        $url = "../../modules/goodcenter/goodcenter.php";
        print "<script language='javascript' type = 'text/javascript'>
            window.location.href = '$url';</script>";
    }

    public function gotoSearchFail($result) {
        global $rootdir;
        $params = LibMisc::getParams();
        $frommobile = $params['frommobile'];

        if (0 == $frommobile) {
            $url = $rootdir."/modules/goodcenter/goodcenter.php".
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

            return $error->errorAction($code, $params);
        }
    }

    function gotoReleaseFail($result) {
        global $rootdir;
        $params = LibMisc::getParams();
        $frommobile = $params['frommobile'];

        if (0 == $frommobile) {
            if (empty($params['username'])) {
                print "<script language='javascript' type = 'text/javascript'
                    >alert('用户名为空,请先登陆!');</script>";
                $url = $rootdir."/modules/usercenter/signin.php".
                   "?fail=".InterfaceError::getErrorMessage(
                       InterfaceError::ERR_INVALIDPARAMS);
                $result = "<script>url=\"$url\";".
                   "window.location.href=url;".
                   "</script>";
            } else if (empty($params['title'])) {
                print "<script language='javascript' type = 'text/javascript'>
                    alert('沙发标题不能为空!');</script>";
                $url = $rootdir."/modules/goodcenter/goodcenter.php".
                    "?fail=".InterfaceError::getErrorMessage(
                        InterfaceError::ERR_INVALIDPARAMS);
                $result = "<script>url=\"$url\";".
                    "window.location.href=url;".
                    "</script>";
            }
            return $result;
        } else {
            $error = new InterfaceError();
            $code = InterfaceError::ERR_INVALIDPARAMS;
            if ($error->isErrorCode($result)) {
               $code = $result;
            }

            return $error->errorAction($code, $params);
        }
    }

    public function gotoReleaseSuccess($result){

        global $rootdir;
        $params = LibMisc::getParams();
        $frommobile = $params['frommobile'];
        if (0 == $frommobile) {
           print "<script >alert('沙发发布成功!');</script>";
           $url = "$rootdir/modules/goodcenter/goodcenter.php";
           $result = "<script >window.location.href = '$url';</script>";
            return $result;
        } else {
            $error = new InterfaceError();
            return $error->errorAction(InterfaceError::ERR_OK, $result);
        }
    }

    /*
    public function orderAction() {

    }

    public function getSofaInfoAction() {

    }*/
}
?>
