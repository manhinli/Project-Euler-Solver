<?php

require_once(__DIR__."/DbConnection.php");

class Problems {
    public static function fetch($reqProbId) {
        $dbConn = new DbConnection();

        $dbHandle =& $dbConn->open();

        // Prepare statement
        $reqProbInfo_stmt = $dbHandle->prepare("SELECT * from problems WHERE id = :id LIMIT 1");
        $reqProbInfo_stmt->bindParam(':id', $reqProbId, PDO::PARAM_INT);
        
        // Fetch
        $reqProbInfo;
        
        if ($reqProbInfo_stmt->execute()) {
            // Should only ever be one row at most
            $reqProbInfo = $reqProbInfo_stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        $dbConn->close();
        
        return $reqProbInfo;
    }
    
    public static function fetchAll() {
        $dbConn = new DbConnection();

        $dbHandle =& $dbConn->open();

        // Only fetching the ID and title of each problem
        // All information fetched using ./problem.php?id=[id]
        $availProblems = $dbHandle
                            ->query("SELECT id, title from problems ORDER BY id ASC")
                            ->fetchAll(PDO::FETCH_ASSOC);
        
        $dbConn->close();
        
        return $availProblems;
    }
    
    
}

?>
