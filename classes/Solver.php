<?php

include_once("DbConnection.php");



// All solvers should be named "SolverX" where `X` is the ID of the problem
// that the solver is solving for.

abstract class Solver
{
    protected $id;
    
    public function solve($input) {
        // Time execution
        $timeStart = microtime(true);
        
        
        // Connect to DB
        $dbConn = new DbConnection();
        $dbHandle =& $dbConn->open();
        
        
        
        // TODO: THIS IS NOT THREAD SAFE!
        
        
        
        if ($this->check_if_already_run($dbHandle, $input)) {
            // If so, returned cached value from DB
            $solution = $this->get_solution_from_db($dbHandle, $input);
        } else {
            // Else execute the solver and write solution in
            $solution = $this->execute_solver($input);
            $this->write_solution_to_db($dbHandle, $input, $solution);
        }
        
        // Number of runs of *this* particular problem-input pair
        $totalRuns = $this->incr_solution_total_runs($dbHandle, $input);
        
        $dbConn->close();
        
        
        
        $timeEnd = microtime(true);
        
        // Execution time for solution fetch/generation
        // Time resolution = seconds
        $execTime = $timeEnd - $timeStart;
        
        
        return array(   'problemId' => $this->id,
                        'solution' => $solution,
                        'totalRuns' => $totalRuns,
                        'execTime' => $execTime     );
    }
    
    private function check_if_already_run($dbHandle, $input) {
        // Check that $id is defined
        // This is required in order to be able to look up the
        //  correct entries for the selected problem
        if (!isset($this->id)) {
            throw new Exception("Solver ID not set");
        }

        // Determine if this problem-input pair had previously been run
        // NOTE: PDO #rowCount() does not work well with MySQL, hence the use of #fetchColumn()
        $checkIfAlreadyRun_stmt = $dbHandle->prepare("SELECT COUNT(*) FROM solutions
                                                        WHERE problem_id = :id AND test_number = :input");
        $checkIfAlreadyRun_stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $checkIfAlreadyRun_stmt->bindParam(":input", $input);
        
        if (!$checkIfAlreadyRun_stmt->execute()) {
            throw new Exception("Could not execute already-run check");
        }
        
        // Has this problem-input pair already existed?
        return $checkIfAlreadyRun_stmt->fetchColumn() > 0;
    }
    
    private function get_solution_from_db($dbHandle, $input) {
        $prevSolution_stmt = $dbHandle->prepare("SELECT test_answer FROM solutions
                                                    WHERE problem_id = :id AND test_number = :input
                                                    LIMIT 1");
        $prevSolution_stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $prevSolution_stmt->bindParam(":input", $input);
        
        if (!$prevSolution_stmt->execute()) {
            throw new Exception("Could not fetch previous solution");
        }
        
        // Get the previously generated solution (there should only be 1 row)
        return $prevSolution_stmt->fetchColumn();
    }
    
    private function write_solution_to_db($dbHandle, $input, $solution) {
        $writeSolution_stmt = $dbHandle->prepare("INSERT INTO solutions(problem_id, test_number, test_answer)
                                                    VALUES(:id, :input, :solution)");
        $writeSolution_stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $writeSolution_stmt->bindParam(":input", $input);
        $writeSolution_stmt->bindParam(":solution", $solution);
        
        if (!$writeSolution_stmt->execute()) {
            throw new Exception("Could not store solution");
        }
    }
    
    private function incr_solution_total_runs($dbHandle, $input) {
        
        // TODO: Consider stored procedure on DB? Or one full transaction with get_solution_total_runs()?        
        
        $totalRunIncr_stmt = $dbHandle->prepare("UPDATE solutions
                                                    SET total_runs = total_runs + 1
                                                    WHERE problem_id = :id AND test_number = :input");
        $totalRunIncr_stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $totalRunIncr_stmt->bindParam(":input", $input);
        
        if (!$totalRunIncr_stmt->execute()) {
            throw new Exception("Could not increment total runs on solution");
        }
        
        return $this->get_solution_total_runs($dbHandle, $input);
    }
    
    private function get_solution_total_runs($dbHandle, $input) {
        $totalRuns_stmt = $dbHandle->prepare("SELECT total_runs FROM solutions
                                                WHERE problem_id = :id AND test_number = :input");
        $totalRuns_stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $totalRuns_stmt->bindParam(":input", $input);
        
        if (!$totalRuns_stmt->execute()) {
            throw new Exception("Could not fetch total runs on solution");
        }
        
        return $totalRuns_stmt->fetchColumn();
    }
    
    
    // To be implemented by the solver class
    abstract protected function execute_solver($input);
}

?>
