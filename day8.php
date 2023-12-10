<?php
$start_time = microtime(true);
$input = array_map('trim',file('inputs/day8list.txt'));
$instructions = str_split(str_replace(['L','R'],[0,1],$input[0]));
unset($input[0],$input[1]);
$elements = [];
foreach ($input as $line) { 
    $line = explode(" = ",$line);
    $lr = explode(",",str_replace(['(',')',' '],['','',''],$line[1]));
    $elements[$line[0]] = $lr;
}

function find_next_element($element,$instruction) {
    global $elements;
    return $elements[$element][$instruction];
}
$current_element = "AAA";
$i = 0; 
$steps = 0;
while($current_element != "ZZZ") {
    $current_element = find_next_element($current_element,$instructions[$i]);
    $i = ($i == count($instructions)-1) ? 0 : $i+1;
    $steps++;
}
echo "<p>The answer for part 1 is: $steps";
echo "<p>".microtime(true) - $start_time; 

$start_list = [];
foreach($elements as $node => $paths) {
    if ($node[2] == "A") {
        $start_list[] = $node;
    }
} 
$current_elements = $start_list;
$steplists = [];
$current_element = $start_list[1];

$steplist = [];

foreach($start_list as $current_element) {
    $i = 0;
    $steps = 0;
    while (true) {
        $steps++;
        $current_element = find_next_element($current_element,$instructions[$i]);
        if ($current_element[2] == 'Z') {
        $steplist[] = $steps;
        break;
        }
        $i = ($i == count($instructions)-1) ? 0 : $i+1;
        
        if ($steps == 1000000) break;
    }
}

function is_prime($int) {
    for ($i = 2; $i <= $int-1; $i++) {
        if($int % $i == 0) {
            return false;
        }
    }
    return true;
}
function factorize($int) {
    $prime_factors = [];
    while (array_product($prime_factors) != $int) {
        for ($i = 2; $i <= $int-1; $i++) {  
            if ($int % $i == 0) {
                if(is_prime($i)) {
                    $prime_factors[] =  $i;
                }
            }
        } 
    }
    return $prime_factors;
}


$prime_factors = [];
foreach($steplist as $steps) {
    $prime_factors = array_merge($prime_factors, factorize($steps));
}
$part2 =  array_product(array_unique($prime_factors));
echo "<p>The answer for part 1 is: $part2";
echo "<p>".microtime(true) - $start_time; 