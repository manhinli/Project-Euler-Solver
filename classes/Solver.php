<?php

require_once(__DIR__."/DbConnection.php");

// All solvers should be named "SolverX" where `X` is the ID of the problem
// that the solver is solving for.

abstract class Solver
{
    protected $id;
    
    // Runs through all steps required for solving the problem for the input
    //  parameter $input
    public function solve($input) {
        $this->check_id_exists();
        
        // Time execution
        $timeStart = microtime(true);
        
        
        // Connect to DB
        $dbConn = new DbConnection();
        $dbHandle =& $dbConn->open();
        
        try {
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
            
        } catch (Exception $e) {
            $dbConn->close();
            throw $e;
        }
        
        $dbConn->close();

        
        $timeEnd = microtime(true);
        
        // Execution time for solution fetch/generation
        // Time resolution = seconds
        $execTime = round($timeEnd - $timeStart, 3);
        
        
        return array(   'problem_id' => $this->id,
                        'input' => $input,
                        'solution' => $solution,
                        'total_runs' => $totalRuns,
                        'exec_time' => $execTime    );
    }
    
    // Check that $id is defined
    // This is required in order to be able to look up the correct entries for
    //  the selected problem
    private function check_id_exists() {
        if (!isset($this->id)) {
            throw new Exception("Solver ID not set");
        }
    }
    
    // Determine if this problem-input pair had previously been run
    private function check_if_already_run($dbHandle, $input) {
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
    
    // Fetch previously cached solution from the database
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
    
    // Write a computed solution to the database
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
    
    // Increment the total number of runs a solution has had
    private function incr_solution_total_runs($dbHandle, $input) {
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
    
    // Get the number of runs a solution has had
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
    //
    // Return type is string, as it is saved to the database and returned to the
    //  user as such
    abstract protected function execute_solver($input);
}

?>
