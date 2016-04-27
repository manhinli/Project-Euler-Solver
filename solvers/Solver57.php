<?php

// NOTE: BC Math must be enabled for this to work!

require_once(__DIR__."/../classes/Solver.php");

// Project Euler
// Problem #57
//
// Square root convergents
//
// This solver runs through n number of iterations down the list of rational
//  fractions described in the problem. The pattern is pretty easy to get:
//
//  a_n+1   a_n + 2*b_n
//  ----- = -----------
//  b_n+1    a_n + b_n
//
// Note that due to the large numbers being used, BC Math is used, and hence the
//  numbers here are actually strings.
//
// The side-effect of using integers as strings means that comparing their
//  length is actually stupidly easy - just compare string lengths!

class Solver57 extends Solver {
    protected $id = 57;      // <--- This must match problem ID
    
    protected function execute_solver($input) {
        // $input is `n` as described in the blurb up top
        $input_asInt = intval($input);
        
        // Check str->int transform didn't screw up (e.g. clipping)
        if (strval($input_asInt) !== strval($input)) {
            throw new Exception("Input not a valid integer or could not be safely handled");
        }
        
        $input = $input_asInt;
        
        // We can only process positive integers
        if ($input < 1) {
            throw new Exception("Input not positive integer");
        }


        // Solver starts here
        
        // The answer is the count of rational fraction expansions that have
        // a longer numerator than denominator
        $count = 0;
        
        // Base case (before first iteration)
        $num = '1';
        $denom = '1';
        
        
        // Note that we start at 1 because we already "ran" the first iteration
        // by supplying the numerator and denominator above
        for ($i = 0; $i < $input; ++$i) {
            
            // We can get away with using the same variables instead of creating
            // new placeholders by using a little algebra
            $num = bcadd($num, bcmul($denom, "2"));
            $denom = bcsub($num, $denom);
            
            if (strlen($num) > strlen($denom)) {
                ++$count;
            }
        }
        
        return strval($count);
        
    }
}


?>
