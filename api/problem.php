<?php

include_once("../classes/dbConnection.php");


// Get the requested problem's ID
$reqProbId = intval($_GET["id"]);


// Data = requested problem's information
$reqProbInfo;


// Connect to DB and query for the given ID's problem
try {
    
    $dbConn = new dbConnection();

    $dbHandle =& $dbConn->open();

    // Prepare statement
    $reqProbInfo_stmt = $dbHandle->prepare("SELECT * from problems WHERE id = :id LIMIT 1");
    $reqProbInfo_stmt->bindParam(':id', $reqProbId);
    
    // Fetch
    if ($reqProbInfo_stmt->execute()) {
        // Should only ever be one row at most
        $reqProbInfo = $reqProbInfo_stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    $dbConn->close();
    
} catch (PDOException $e) {
    
    print $e->getMessage();
    die();
    
}

    
// Return data as JSON
header("Content-Type: application/json; charset=utf-8");
echo json_encode($reqProbInfo, JSON_UNESCAPED_UNICODE);

?>
