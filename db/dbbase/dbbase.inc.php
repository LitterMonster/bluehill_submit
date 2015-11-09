<?php
class DBBase {
    static $pdoInstance;

    public function __construct(array $config) {
        $dsn = "mysql:host={$config['hostname']}; ".
            "port={$config['hostport']}; ".
            "dbname={$config['database']}; ".
            "charset=utf8";
        $user = $config['username'];
        $password = $config['password'];

        $options = array(
            PDO::ATTR_PERSISTENT=>true,
            PDO::ATTR_ERRMODE=>PDO::ERRMODE_SILENT);

        try {
            if (is_null(self::$pdoInstance)) {
                self::$pdoInstance = new PDO($dsn, 
                    $user, $password, $options);
            }
        } catch (PDOException $e) {
            
        }
    } 

	private function cleanup($bind) {
		if (!is_array($bind)) {
			if (!empty($bind))
				$bind = array($bind);
			else
				$bind = array();
		}
		return $bind;
	}

	public function runSQL($sql, $bind = "") {
		$sql = trim($sql);
		$bind = $this->cleanup($bind);
		
		try {
			$pdostmt = self::$pdoInstance->prepare($sql);
            $ret = $pdostmt->execute($bind);
            if (false !== $ret) {
                if (preg_match("/^(".implode("|", 
                    array("select", "describe", "pragma", 
                    "SELECT", "DESCRIBE", "PRAGMA")). 
                    ") /i", $sql)) {
                    return $pdostmt->fetchAll(PDO::FETCH_ASSOC);
                } else if (preg_match("/^(". 
                    implode("|", array("delete", "insert", "update", 
                    "DELETE", "INSERT", "UPDATE")). 
                    ") /i", $sql)) {
                    $count = $pdostmt->rowCount();
                    return  $count;
                } else {
                    return $pdostmt->fetchAll(PDO::FETCH_ASSOC);
                }
            } 
        } catch (PDOException $e) {
			return false;
		}
	}
}
?>
