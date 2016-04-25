<?php

include_once(__DIR__."/../classes/Problems.php");
    
// Return data as JSON
header("Content-Type: application/json; charset=utf-8");
echo json_encode(Problems::fetchAll(), JSON_UNESCAPED_UNICODE);

?>
