<?php

include_once(__DIR__."/../classes/Solver.php");

// Project Euler
// Problem #5
//
// Smallest multiple
//
// For some n where we are trying to find the smallest multiple of {1, ..., n}
//  we can simply run through all numbers which are a multiple of n and check
//  if {2, ..., n-1} are a valid factor of it.
// The smallest number which satisifies this is the result.

class Solver5 extends Solver {
    protected $id = 5;      // <--- This must match problem ID
    
    protected function execute_solver($input) {
        // $input is `n` as described in the blurb up top
        $input = intval($input);
        
        // We can only process positive integers
        if ($input < 1) {
            throw new Exception("Input not positive integer");
        }

        // We can't really do much with 1 as an input
        if ($input === 1) {
            throw new Exception("Number '1' cannot be operated on - number must be greater than 1");
        }
        
        
        
        // Solver starts here
        
        // Start off with n
        $candidate = $input;
        
        while (true) {
            for ($div = $input - 1; $div > 1; --$div) {
                if ($candidate % $div !== 0) {
                    // Try next candidate - increment by n
                    $candidate += $input;
                    continue 2;     // This jumps out to the WHILE loop
                }
            }
            
            // If we reached here, we have found the smallest multiple as we
            //  have exhausted all the factors {2, ..., n-1}.
            
            // We return the string with the value contained within
            return strval($candidate);
        }
    }
}


?>
