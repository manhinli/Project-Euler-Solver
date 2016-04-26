<?php

require_once(__DIR__."/../classes/ApiWrapper.php");

// Only process POSTs
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die();
}

// Parse incoming data
$data = $_POST;

// Get the requested problem's ID
$reqProbId = intval($data["problem_id"]);

// Dynamically generate the class (which should be named "SolverX" where X = ID)
$solverClass = "Solver" . $reqProbId;

require_once(__DIR__."/../solvers/" . $solverClass . ".php");

$solver = new $solverClass();



$input = $data["input"];

// Run the solver
try {
    $output = $solver->solve(trim($input));
    (new ApiWrapper($output))->respond_as_json();
    
} catch (Exception $e) {
    (new ErrorApiWrapper($e))->respond_as_json();
}

?>
