<?php

require_once(__DIR__."/../classes/ApiWrapper.php");
require_once(__DIR__."/../classes/SolverUtil.php");

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

    // Check that we have input
    if (!isset($_POST["input"])) {
        throw new Exception("No input received");    
    }

    $input = $_POST["input"];

    // Run the solver
    $solver = SolverUtil::load_solver($reqProbId);
    $output = $solver->solve(trim($input));
    (new ApiWrapper($output))->respond_as_json();
    
} catch (Exception $e) {
    (new ErrorApiWrapper($e))->respond_as_json();
}

?>
