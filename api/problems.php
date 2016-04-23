<?php

include_once("../classes/dbConnection.php");


// Data = available Proj. Euler problems
$availProblems;


// Connect to DB and query for all available problems
try {
    
    $dbConn = new dbConnection();

    $dbHandle =& $dbConn->open();

    // Only fetching the ID and title of each problem
    // All information fetched using ./problem.php?id=[id]
    $availProblems = $dbHandle
                        ->query("SELECT id, title from problems ORDER BY id ASC")
                        ->fetchAll(PDO::FETCH_ASSOC);
    
    $dbConn->close();
    
} catch (PDOException $e) {
    
    print $e->getMessage();
    die();
    
}

    
// Return data as JSON
header("Content-Type: application/json; charset=utf-8");
echo json_encode($availProblems, JSON_UNESCAPED_UNICODE);

?>
