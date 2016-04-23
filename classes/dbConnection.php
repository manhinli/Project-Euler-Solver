<?php

class dbConnection {
    // Configuration for connections to the DB
    private static $host = "localhost";
    private static $dbname = "uq498819";
    
    private static $username = "user";
    private static $password = "password";
    
    
    private $handle;
 
    
    public function &getHandle() {
        return $this->handle;
    }
    
    public function &open() {
        $this->handle = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$dbname, self::$username, self::$password);
        return $this->getHandle();
    }
    
    public function close() {
        $this->handle = null;
    }
}

?>