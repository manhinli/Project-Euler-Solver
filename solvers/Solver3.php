<?php

include_once(__DIR__."/../classes/Solver.php");

// Project Euler
// Problem #3
//
// Largest prime factor
//
// To find the largest prime factor, we go over all prime factors that
//  exist of the provided number; during which we simply take the one that is
//  largest.

class Solver3 extends Solver {
    protected $id = 3;      // <--- This must match problem ID
    
    protected function execute_solver($input) {
        $input = intval($input);
        
        // We can only process positive integers
        if ($input < 1) {
            throw new Exception("Input not positive integer");
        }

        // 1 is not prime, so we can't really do much with 1 as an input
        if ($input === 1) {
            throw new Exception("Number '1' cannot be operated on - no prime factors exist");
        }
        
        
        
        // Find prime factors by dividing through
        $largestPrimeFactor = 2;
        
        // This is the divisor being trialled
        $fact = 2;
        
        // The number is progressively divided down in the loop below
        $num = $input;
        
        // Go over all prime factors
        // Factors here are prime because we exhaust division by smaller
        //  factors until we can divide no longer
        
        // Note that we don't need to go beyond sqrt(num) - should be obvious
        //  considering what factors are...
        while ($fact * $fact <= $num) {
            if ($num % $fact === 0) {           // Check that $fact is indeed a factor
                if ($fact > $largestPrimeFactor) {
                    $largestPrimeFactor = $fact;
                }
        
                $num = $num / $fact;            // Divide through, repeat
                continue;
            }
            
            // Try next divisor
            // This is basically naive, but is fast enough going through all
            //  combinations before hitting the next prime 
            ++$fact;
        }
        
        // $num holds the remaining factor, which may be larger than what
        // we have at the moment
        if ($num > $largestPrimeFactor) {
            $largestPrimeFactor = $num;
        }
        
        
        // We return the string with the value contained within
        return strval($largestPrimeFactor);
    }
}


?>
