<?php
$start = microtime(true);
error_reporting(E_ALL);
ini_set("display_errors", 1);

$races = [
[57,291],
[72,1172],
[69,1176],
[92,2026]
];
$race_pt2 = [
[57726992,291117211762026]
];


function ways_to_win_pt1($x) {
    list($time,$record) = $x;
    $counter = 0;
    $win_streak = 0;
    for ($i = 0; $i < $time; $i++) {
        
        $distance = 0;
        $timeleft = $time - $i;
        $speed = $i;
        $distance = $speed*$timeleft;
        if ($distance > $record) {
            $counter++;
        }
    }
    return $counter;
}
function ways_to_win($x) {
    list($time,$record) = $x;
    $counter = 0;
    $win_streak = 0;
    
    for ($i = 0; $i < $time; $i++) {
        
        $distance = 0;
        $timeleft = $time - $i;
        $speed = $i;
        $distance = $speed*$timeleft;
        if ($distance > $record) {
            return $i;
        }
    }
    return false;
}
function ways_to_win_back($x) {
    list($time,$record) = $x;
    $counter = 0;
    $win_streak = 0;
    
    for ($i = $time; $i > 0; $i--) {
        $distance = 0;
        $timeleft = $time - $i;
        $speed = $i;
        $distance = $speed*$timeleft;
        
        if ($distance > $record) {
            return $i;
        }
    }
    return false;;
}

echo "<p>The answer for part 1 is: ".array_product((array_map('ways_to_win_pt1',$races)));
echo "<br>Time: ".microtime(true)-$start;


echo "<p>The answer for part2 is: ".array_product((array_map('ways_to_win_back',$race_pt2)))-array_product((array_map('ways_to_win',$race_pt2)))+1;
echo "<br>Time: ".microtime(true)-$start;