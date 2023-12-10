<?php
$start = microtime(true);
$input = array_map('trim',file('inputs/day3list.txt'));
$input2 = $input;

//Create a symbol map
$symbolmap = [];
$symbols = [];
foreach ($input as $y => $row) {
    for ($x = 0; $x < strlen($row); $x++){
        $char = (int)$row[$x];
        if ($char != $row[$x] && $row[$x] != '.') {
            $symbolmap[$y][$x] = $row[$x];
            array_push($symbols,$row[$x]);
        }
    }
}
$symbols = array_unique($symbols);

//Find all numbers and position
$numbers_list = [];
$numbermap = [];
foreach ($input as $y => $row) {
    $row = str_replace($symbols,'.',$row);
    while ($row != str_replace('..','.',$row)) {
        $row = str_replace('..','.',$row);
    }
    $row = trim($row,'.');
    $numbers = explode('.',$row);
    if  (strlen($numbers[0]) > 0) {
        
        foreach ($numbers as $n) {
            $number = [
                'number' => $n,
                'x' => strpos($input[$y],$n),
                'y' => $y
            
            ];
            $number_id = array_push($numbers_list,$number)-1;
            for ($i = 0; $i < strlen($n); $i++) {
                $input[$y][$number['x']+$i] = '.';
                $numbermap[$y][$number['x']+$i] = $number_id;
            }
            
        }
    }
}
function symbol_adjacent($y,$x) {
    global $symbolmap;
    if (isset($symbolmap[$y-1][$x-1])) return true;
    if (isset($symbolmap[$y-1][$x])) return true;
    if (isset($symbolmap[$y-1][$x+1])) return true;
    if (isset($symbolmap[$y][$x+1])) return true;
    if (isset($symbolmap[$y+1][$x+1])) return true;
    if (isset($symbolmap[$y+1][$x])) return true;
    if (isset($symbolmap[$y+1][$x-1])) return true;
    if (isset($symbolmap[$y][$x-1])) return true;
    return false;
}

function number_position($numbers) {
    $nr_length = strlen($numbers['number']);
    for ($i = 0; $i < $nr_length; $i++) {
        if  (symbol_adjacent($numbers['y'],$numbers['x']+$i)) {
            return $numbers['number'];
        }
    }
    return 0;
}

echo "<p>The answer for part 1 is: ".array_sum(array_map('number_position',$numbers_list));
echo "<br>Time: ".microtime(true)-$start;

//PART 2

function gear_adjacent_ratios($y,$x) {
    global $numbermap;
    $nr_ids = [];
    if (isset($numbermap[$y-1][$x-1])) array_push($nr_ids,$numbermap[$y-1][$x-1]);
    if (isset($numbermap[$y-1][$x])) array_push($nr_ids,$numbermap[$y-1][$x]);
    if (isset($numbermap[$y-1][$x+1])) array_push($nr_ids,$numbermap[$y-1][$x+1]);
    if (isset($numbermap[$y][$x+1])) array_push($nr_ids,$numbermap[$y][$x+1]);
    if (isset($numbermap[$y+1][$x+1])) array_push($nr_ids,$numbermap[$y+1][$x+1]);
    if (isset($numbermap[$y+1][$x])) array_push($nr_ids,$numbermap[$y+1][$x]);
    if (isset($numbermap[$y+1][$x-1])) array_push($nr_ids,$numbermap[$y+1][$x-1]);
    if (isset($numbermap[$y][$x-1])) array_push($nr_ids,$numbermap[$y][$x-1]);
    return array_unique($nr_ids);
}
function gear_filter($symbol) {
    return array_filter($symbol, function($s) {
        if ($s == '*') {
            return true;
        } else {
            return false;
        }
    });
}
function find_gears($gearmap,$y) {
    global $numbers_list;
    $row_value = 0;
    foreach ($gearmap as $x => $gear) {
        $ratios = gear_adjacent_ratios($y,$x);
        if (count($ratios) === 2) {
            $ratios = array_values($ratios);
            $row_value = $row_value+($numbers_list[$ratios[0]]['number']*$numbers_list[$ratios[1]]['number']);
        }
        
    }
    return $row_value;
}

$gearmap = array_filter(array_map('gear_filter',$symbolmap),function($x) {return ($x == null) ? false : true;});
echo "<p>The answer for part 2 is: ".array_sum(array_map('find_gears', $gearmap,array_keys($gearmap)));
echo "<br>Time: ".microtime(true)-$start;