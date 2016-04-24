<?php

class DbConnection {
    // Configuration for connections to the DB
    private static $host = "localhost";
    private static $dbname = "uq498819";
    
    private static $username = "user";
    private static $password = "password";
    
    private static $pdoOptions = 
        array(
            // Prepared statement emulation causes integers to become strings
            // Switching this off uses native MySQL prep. stmts.
            // https://bugs.php.net/bug.php?id=44639
            PDO::ATTR_EMULATE_PREPARES => false
        );
    
    private $handle;
 
    
    public function &getHandle() {
        return $this->handle;
    }
    
    public function &open() {
        $this->handle = new PDO(
            "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=utf8",
            self::$username,
            self::$password,
            self::$pdoOptions);
            
        return $this->getHandle();
    }
    
    public function close() {
        $this->handle = null;
    }
}

?>
