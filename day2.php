<?php
$input = file('inputs/day2list.txt');
foreach ($input as $key => $game) {
    $game = substr($game,strpos($game,':')+2);
    $game = explode(';',$game);
    foreach($game as $i => $draw) {
        $draw = explode(',',$draw);
        foreach($draw as $cubes) {
          $cubes = trim($cubes);
          $cube = explode(' ',$cubes);
          $fixed_input[$key+1][$i][$cube[1]] = intval($cube[0]);
        }
    }
}
function sum($carry, $item)
{
    $carry += $item;
    return $carry;
}


//PART 1
function is_possible($game) {
    $possible = true;
    foreach($game as $gameid => $draw) {
        foreach($draw as $color => $nr_of_cubes) {
            if($color == 'red' && $nr_of_cubes > 12) {
                $possible = false;
            }
            if($color == 'green' && $nr_of_cubes > 13) {
                $possible = false;
            }
            if($color == 'blue' && $nr_of_cubes > 14) {
                $possible = false;
            }
        }
    }
    if($possible) {
        return true;
    } else {
        return false;
    }
}

$possible_games = array_filter($fixed_input, 'is_possible');
$sum = array_reduce(array_keys($possible_games),'sum');
echo "<p>The answer to part 1 is: $sum";

//PART 2

function calc_power($game) {
    $red = 0;
    $green = 0;
    $blue = 0;
    foreach($game as $gameid => $draw) {
        foreach($draw as $color => $nr_of_cubes) {
            if($color == 'red' && $nr_of_cubes > $red) {
                $red = $nr_of_cubes;
            }
            if($color == 'green' && $nr_of_cubes >  $green) {
                $green = $nr_of_cubes;
            }
            if($color == 'blue' && $nr_of_cubes > $blue) {
                 $blue = $nr_of_cubes;
            }
        }
    }
    return $red*$blue*$green;
}

$power = array_map('calc_power',$fixed_input);
$sum = array_reduce($power,'sum');
echo "<p> The answer for part 2 is: $sum";