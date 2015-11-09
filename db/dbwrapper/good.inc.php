<?php
require_once "$curdir/db/dbimpl/goodbase.inc.php";
require_once "$curdir/db/dbimpl/estatebase.inc.php";
require_once "$curdir/db/dbimpl/liverent.inc.php";
require_once "$curdir/db/dbimpl/sofa.inc.php";
require_once "$curdir/db/dbbase/dbbase.inc.php";
class WrapperDBGood {
    /**
     * Brief:
     *     release sofa
     * Parameters:
     *     username:$username
     *     good information array:$good
     * Return:
     *     The result of executing add method
     *
     * Date:2015-9-1     Revision:           Author:Zhangtao
     */
    public function releaseSofa($username, array $good) {
        if (empty($username) || empty($good)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        } 

        $dbhtwuser = new WrapperDBUser();
        $uid = $dbhtwuser->getUid($username);

        $dbhtwsofaclass = new DBHTWSofaClass();
        $ret = $dbhtwsofaclass->add($uid,$good);
        return $ret;
    }

    /**
     * Brief:
     *     search sofa
     * Parameters:
     *     good information array:$good
     * Return:
     *     The result of executing search method
     *
     * Date:2015-9-7     Revision:           Author:Zhangtao
     */

    public function searchSofa(array $good) {
        global $rootdir;
        $keyword = trim($good['keyword']);
        if (empty($keyword)) {
            print "<script language='javascript' type = 'text/javascript'
                >alert('关键字不能为空!');</script>";
            $url = $rootdir."/modules/goodcenter/goodcenter.php".
                "?fail=".InterfaceError::getErrorMessage(
                    InterfaceError::ERR_INVALIDPARAMS);
            print "<script language='javascript' type = 'text/javascript'>
                window.location.href = '$url';</script>";
        }

        $dbhtwsofaclass = new DBHTWSofaClass();
        $ret = $dbhtwsofaclass->search($good);
        return $ret;
    }

    public function getSofaInfoByuid($userid) {
        if (empty($userid)) {
            print "<script language='javascript' type = 'text/javascript'
                >alert('用户Id为空,请先登陆!');</script>";
            $url = $rootdir."/modules/usercenter/signin.php".
                "?fail=".InterfaceError::getErrorMessage(
                    InterfaceError::ERR_INVALIDPARAMS);
            print "<script language='javascript' type = 'text/javascript'>
                window.location.href = '$url';</script>";
        }
        $dbhtwsofaclass = new DBHTWSofaClass();
        $ret = $dbhtwsofaclass->getSofaInfoByuid($userid);
        return $ret;
    }

    public function getSofaInfoBygoodid($goodid) {
        if (empty($goodid)) {
            print "<script language='javascript' type = 'text/javascript'
                >alert('沙发Id为空,请先发布沙发!');</script>";
            $url = $rootdir."/modules/goodcenter/goodcenter.php".
                "?fail=".InterfaceError::getErrorMessage(
                    InterfaceError::ERR_INVALIDPARAMS);
            print "<script language='javascript' type = 'text/javascript'>
                window.location.href = '$url';</script>";
        }
        $dbhtwsofaclass = new DBHTWSofaClass();
        $ret = $dbhtwsofaclass->getSofaInfoBygoodid($goodid);
        return $ret;
    }

    public function updateSofaData($data) {
        $dbhtwsofaclass = new DBHTWSofaClass();
        $ret = $dbhtwsofaclass->updateSofaData($data);
        return $ret;
    }

    public function deleteSofaData($data) {
        $dbhtwsofaclass = new DBHTWSofaClass();
        $ret = $dbhtwsofaclass->deleteSofaData($data);
        return $ret;
    }
}
?>
