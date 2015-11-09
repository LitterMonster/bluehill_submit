<?php
require_once "fileuploader.inc.php";

class ImageUploader extends FileUploader {
    public function __construct() {
        parent::__construct("$../../upload/photo", 
            null, 20000000, true);
    }

    public function upload($file) {
        $ret = parent::upload($file);

        if (InterfaceError::isErrorCode($ret)) {
            return $ret;
        }

        // Here we should have a valid photo path
        $photowrapper = new WrapperDBPhoto();
        $ret = $photowrapper->add($ret);

        return $ret;
    }

    public function getPhotoURL($id) {
        if (empty($id)) {
            return InterfaceError::ERR_INVALIDPARAMS;
        }

        $photowrapper = new WrapperDBPhoto();
        return $photowrapper->getPhotoURL($id);
    }
}
?>
