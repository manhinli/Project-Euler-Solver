<?php

// Only process POSTs
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die();
}

// Parse incoming data
$data = $_POST;

// Get the requested problem's ID
$reqProbId = intval($data["problemId"]);

// Dynamically generate the class (which should be named "SolverX" where X = ID)
$solverClass = "Solver" . $reqProbId;

include_once("../solvers/" . $solverClass . ".php");

$solver = new $solverClass();



$input = $data["input"];

// Run the solver
$output = $solver->solve(trim($input));


// Return data as JSON
header("Content-Type: application/json; charset=utf-8");
echo json_encode($output, JSON_UNESCAPED_UNICODE);

?>
