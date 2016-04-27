<?php

require_once(__DIR__."/DbConnection.php");

class Problems {
    public static function fetch($reqProbId) {
        $dbConn = new DbConnection();

        $dbHandle =& $dbConn->open();

        try {
            // Prepare statement
            $reqProbInfo_stmt = $dbHandle->prepare("SELECT * from problems WHERE id = :id LIMIT 1");
            $reqProbInfo_stmt->bindParam(':id', $reqProbId, PDO::PARAM_INT);
            
            // Fetch
            if (!$reqProbInfo_stmt->execute()) {
                throw new Exception("Could not fetch requested problem");
            }
            
            // Should only ever be one row at most
            $reqProbInfo = $reqProbInfo_stmt->fetch(PDO::FETCH_ASSOC);
            
            // If no information, then either it's not valid or we couldn't get it
            if (!$reqProbInfo) {
                throw new Exception("Could not fetch requested problem or it does not exist");
            }
            
            
        } catch (Exception $e) {
            $dbConn->close();
            throw $e;
        }
        
        $dbConn->close();
        
        return $reqProbInfo;
    }
    
    public static function fetch_all() {
        $dbConn = new DbConnection();

        $dbHandle =& $dbConn->open();

        try {
            // Only fetching the ID and title of each problem
            // All information fetched using ./problem.php?id=[id]
            $availProblems = $dbHandle
                                ->query("SELECT id, title from problems ORDER BY id ASC")
                                ->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $dbConn->close();
            throw $e;
        }
        
        $dbConn->close();

        return $availProblems;
    }
    
    
}

?>
