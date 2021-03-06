<?php

class SolverUtil {
    // Function to create a new instance of a solver class for the requested
    //  problem ID by fetching it from the solvers/ directory
    public static function load_solver($reqProbId) {
        // Naming of classes should be "SolverX" where `X` is the problem ID
        $solverClass = "Solver" . $reqProbId;
        $filePath = __DIR__."/../solvers/" . $solverClass . ".php";

        if (!file_exists($filePath)) {
            throw new Exception("Unable to locate solver");
        }
        
        require_once($filePath);
        
        return new $solverClass();
    }
}

?>
