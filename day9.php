<?php
$start_time = microtime(true);
$input = array_map('trim',file('inputs/day9list.txt'));
$oasis = array_map('explode_input',$input);
function explode_input($x) {
    return array_map('intval',explode(' ', $x));
}

function next_step($step) {
    $next_step = [];
    for($i = 0; $i < count($step)-1; $i++) {
        $next_step[] = $step[$i+1]-$step[$i];
    }   
    if(max($next_step) == 0 && min($next_step) == 0) {
        $c = 0;
    } else {
        $c = 1;
    }
    return [$next_step,$c]; 
    
}
function predict_value_in_history($oasis) {
    $next_step = $oasis;
    $oasis = [$oasis];
    $c = 1;
    while($c > 0) {
        list($next_step,$c) = next_step($next_step);
        $oasis[] = $next_step;
    }
    return $oasis;
}

function oasis_extrapolate($oasis) {
    $max_per_line = [];
    for($i = count($oasis)-2; $i >= 0; $i--) {
        $oasis[$i][] = $oasis[$i][count($oasis[$i])-1]+$oasis[$i+1][count($oasis[$i+1])-1];
    }
    return $oasis;
}
function oasis_extrapolate_backwards($oasis) {
    $max_per_line = [];
    for($i = count($oasis)-2; $i >= 0; $i--) {
        array_unshift($oasis[$i],$oasis[$i][0]-$oasis[$i+1][0]);
    }
    return $oasis;
}

$oasis_sequenced  = array_map('predict_value_in_history',$oasis);
$oasis_extrapolated = array_map('oasis_extrapolate',$oasis_sequenced);

function sum_oasis($oasis) {
    return $oasis[0][count($oasis[0])-1];
}

function sum_oasis_2($oasis) {
    return $oasis[0][0];
}

echo "<p>The answer for part 1 is: ".array_sum(array_map('sum_oasis',$oasis_extrapolated));
echo "<p>".microtime(true) - $start_time; 

$oasis_extrapolated_backwards = array_map('oasis_extrapolate_backwards',$oasis_sequenced);
echo "<p>The answer for part 1 is: ".array_sum(array_map('sum_oasis_2',$oasis_extrapolated_backwards));
echo "<p>".microtime(true) - $start_time;