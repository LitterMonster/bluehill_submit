<?php
class FileUploader {
    private $path;
    private $type;
    private $rlimit = 2000000;
    private $randomrename = true;

    public function __construct($path, $type, $rlimit, $randomrename) {
        $this->path = $path;
        $this->type = $type;
        $this->rlimit = $rlimit;
        $this->randomrename = $randomrename;
    }

    function uploadFiles($file) {
        $name = $_FILES[$file]['name'];
        $tmpname = $_FILES[$file]['tmp_name'];
        $size = $_FILES[$file]['size'];
        $error = $_FILES[$file]['error'];

        return InterfaceError::ERR_UNSUPPORT;
    }

    function uploadFile($file) {
        $name = $_FILES[$file]['name'];
        $tmpname = $_FILES[$file]['tmp_name'];
        $size = $_FILES[$file]['size'];
        $error = $_FILES[$file]['error'];

        if ($size > $this->rlimit) {
            return InterfaceError::ERR_FILETOOLARGE;
        }

        $path = rtrim($this->path, '/').'/';
        $dest = $path.LibMisc::generateRandom()."-".$name;
        if (@move_uploaded_file($tmpname, $dest)) {
            $dest = str_replace("../", "", $dest);
            return $dest;
        } else {
            return InterfaceError::ERR_FILEIO;
        }
    }

    /**
     * Upload the file in given param, it may be an array
     * Return
     *      The stored location of uploaded file
     */
    public function upload($file) {
        $name = $_FILES[$file]['name'];

        if (is_array($name)) {
            return $this->uploadFiles($file);
        } else {
            return $this->uploadFile($file);
        }
    }
}
?>
