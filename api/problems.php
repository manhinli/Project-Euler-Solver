<?php

require_once(__DIR__."/../classes/ApiWrapper.php");
require_once(__DIR__."/../classes/Problems.php");
    
try {
    // Fetch an array of ALL problems we have available
    $allProblems = Problems::fetch_all();
    (new ApiWrapper($allProblems))->respond_as_json();
    
} catch (Exception $e) {
    (new ErrorApiWrapper($e))->respond_as_json();
}

?>
