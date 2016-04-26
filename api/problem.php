<?php

require_once(__DIR__."/../classes/Problems.php");

// Get the requested problem's ID
$reqProbId = intval($_GET["id"]);
    
// Return data as JSON
header("Content-Type: application/json; charset=utf-8");
echo json_encode(Problems::fetch($reqProbId), JSON_UNESCAPED_UNICODE);

?>
