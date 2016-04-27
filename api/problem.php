<?php

require_once(__DIR__."/../classes/ApiWrapper.php");
require_once(__DIR__."/../classes/Problems.php");

// Get the requested problem's ID
$reqProbId = intval($_GET["id"]);
    
try {
    // Fetch that particular problem
    $problemInfo = Problems::fetch($reqProbId);
    (new ApiWrapper($problemInfo))->respond_as_json();
    
} catch (Exception $e) {
    (new ErrorApiWrapper($e))->respond_as_json();
}

?>
