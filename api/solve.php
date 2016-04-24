<?php

// TODO: This will need to be changed to accept JSON coming in via. POST


// Get the requested problem's ID
$reqProbId = intval($_GET["id"]);


// Dynamically generate the class (which should be named "SolverX" where X = ID)
$solverClass = "Solver" . $reqProbId;

include_once("../solvers/" . $solverClass . ".php");

$solver = new $solverClass();


$input = "123"; // TODO: Input data required here

// Run the solver
$output = $solver->solve(trim($input));


// Return data as JSON
header("Content-Type: application/json; charset=utf-8");
echo json_encode($output, JSON_UNESCAPED_UNICODE);

?>
