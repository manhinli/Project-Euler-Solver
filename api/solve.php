<?php

require_once(__DIR__."/../classes/ApiWrapper.php");
require_once(__DIR__."/../classes/Solver.php");

try {
    // Only process POSTs
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Unsupported method");
    }

    // Get the requested problem's ID
    $reqProbId = intval($_POST["problem_id"]);

    if ($reqProbId < 1) {
        throw new Exception("Invalid problem ID");
    }

    // Dynamically generate the class
    $solver = SolverUtil::load_solver($reqProbId);

    if (!isset($_POST["input"])) {
        throw new Exception("No input received");    
    }

    $input = $_POST["input"];

    // Run the solver
    $output = $solver->solve(trim($input));
    (new ApiWrapper($output))->respond_as_json();
    
} catch (Exception $e) {
    (new ErrorApiWrapper($e))->respond_as_json();
}

?>
