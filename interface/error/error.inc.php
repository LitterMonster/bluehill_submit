<?php

class InterfaceError {
    const ERR_NOSUCHMETHOD = '-1';
    const ERR_NOSUCHINTF = '-2';
    const ERR_INVALIDPARAMS = '-3';
    const ERR_DBIO = '-4';
    const ERR_NOSUCHUSER = '-5';
    const ERR_PERM = '-6';
    const ERR_FILETOOLARGE = '-7';
    const ERR_FILEIO = '-8';
    const ERR_UNSUPPORT = '-9';
    const ERR_USERALREADYEXIST = '-10';
    const ERR_MOBILEALREADYEXIST = '-11';
    const ERR_NOSUCHAREAID = '-12';
    const ERR_NULLKEYWORD = '-13';

    const ERR_OK = '200';

    static $errparams = array(
            self::ERR_NOSUCHMETHOD=>"nosuchmethod",
            self::ERR_NOSUCHINTF=>"nosuchintf",
            self::ERR_INVALIDPARAMS=>"invalid",
            self::ERR_DBIO=>"dabaseio",
            self::ERR_NOSUCHUSER=>"nosuchuser",
            self::ERR_PERM=>"permission",
            self::ERR_FILETOOLARGE=>"filetoolarge",
            self::ERR_FILEIO=>"fileio",
            self::ERR_UNSUPPORT=>"unsupport",
            self::ERR_USERALREADYEXIST=>"useralreadyexist",
            self::ERR_MOBILEALREADYEXIST=>"mobilealreadyexist",
            self::ERR_NOSUCHAREAID=>"nosuchareaid",
            self::ERR_NULLKEYWORD=>"nullkeyword",

            self::ERR_OK=>"OK");

    static public function isErrorCode($code) {
        if (!is_int($code) && !is_string($code)) {
            return false;
        }

        return array_key_exists($code, self::$errparams);
    }

    static public function getErrorMessage($code) {
        return self::$errparams[$code];
    }

    function print_error($code, $msg, $result) {
        if (null == $result) {
            $result = array("result"=>$result);
        }
        $ret = array("code"=>$code, 
            "msg"=>$msg, "data"=>$result);

        return $ret;
    }

    public function errorAction($code, $data) {
        $errlist = array(
            self::ERR_NOSUCHMETHOD=>"无效的方法",
            self::ERR_NOSUCHINTF=>"无效的接口",
            self::ERR_INVALIDPARAMS=>"无效的参数",
            self::ERR_DBIO=>"数据库操作错误",
            self::ERR_NOSUCHUSER=>"用户不存在",
            self::ERR_PERM=>"操作不被允许",
            self::ERR_FILETOOLARGE=>"文件太大",
            self::ERR_FILEIO=>"文件传输错误",
            self::ERR_UNSUPPORT=>"不支持的操作",
            self::ERR_USERALREADYEXIST=>"用户已经存在",
            self::ERR_MOBILEALREADYEXIST=>"手机号已经被注册",
            self::ERR_NOSUCHAREAID=>"无效的地区Id",
            self::ERR_NULLKEYWORD=>"空的关键字",

            self::ERR_OK=>"OK");
        return $this->print_error($code, 
            $errlist[$code], $data);
    }
}

?>
