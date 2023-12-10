<?php
$start_time = microtime(true);
$input = array_map('trim',file('inputs/day5list.txt'));
$seeds = $input[0];
$seeds = explode(' ',str_replace('seeds: ','',$seeds));
$input[0] = '';
$input = array_filter($input);
$i = 0;
$maps = [];
$tables = [];
$mapvar = "";
 
foreach ($input as $row) {
    if (str_contains($row,'map:')) {
        $mapvar = str_replace([' map:','-'],['','_'],$row);
        $$mapvar = [];
        array_push($maps,$mapvar);
    } else {
        $values = explode(' ',$row);
        $values = array_map('intval',$values);
        array_push($$mapvar,$values);
    }
}

function s_to_l($m,$x) {
    global $$m;
    foreach ($$m as $map) {
        if (($x > $map[1]) && ($x <= $map[1]+$map[2])) {
            return $x-$map[1]+$map[0];
        }
    }
    return $x;
}
function seed_to_location($seed) {
    global $maps;
    foreach($maps as $map) {
        $seed = s_to_l($map,$seed);
    }
    return $seed;
}
$location2 = array_map('seed_to_location',$seeds);
echo "<p>The answer for part 1 is: ".min($location2);
echo "<p>".microtime(true) - $start_time; 
function even($number){ 
    if($number % 2 == 0){ 
        return true;  
    } 
    else{ 
        return false;  
    } 
} 

$seedpairs = [];
for ($i = 0; $i < count($seeds); $i+=2) {
    array_push($seedpairs,(int)$seeds[$i]);
    array_push($seedpairs,(int)$seeds[$i+1]+$seeds[$i]);
}


$range = $seedpairs;
sort($range);
function x_to_y($x_to_y,$range) {
    $low_in = false;
    $high_in = false;
    $low = $x_to_y[1];
    $high = $x_to_y[2]+$x_to_y[1];
    $subtract = $x_to_y[1]-$x_to_y[0];
    $range[] = $high;
    $range[] = $low;
    sort($range);
    $lowkey = array_search($low,$range);
    $highkey = count($range)-array_search($high,array_reverse($range))-1;
    $lowkey_even = even($lowkey);
    $highkey_even = even($highkey);
    $new_range = [];
    while(true) {
        if (!$lowkey_even && $highkey-1 == $lowkey) {
            $new_range[] = $low-$subtract;
            $new_range[] = $high-$subtract;

            $range[$lowkey]--;
            $range[$highkey];
            break;
        }
        if (!$lowkey_even && $highkey-1 == $lowkey) {
            break;
        }

        if ($lowkey_even && $highkey-1 == $lowkey) {
            unset($range[$lowkey]);
            unset($range[$highkey]);
            break;
        }

        if ($lowkey_even && $highkey-1 != $lowkey) {            
            if ($highkey-$lowkey > 3) {
                for ($i = $lowkey+1; $i < $highkey-1; $i+=2) {
                    $new_range[] = $range[$i]-$subtract;
                    $new_range[] = $range[$i+1]-$subtract;
                    unset($range[$i]);
                    unset($range[$i+1]);
                }
            } else {
                if ($highkey_even) {
                    $range[] = $range[$highkey]+1;
                }
                $new_range[] = $range[$lowkey+1]-$subtract;
                $new_range[] = $range[$lowkey+2]-$subtract;
                unset($range[$lowkey+1]);
                unset($range[$lowkey+2]);
                    
            }
                unset($range[$lowkey]);
                unset($range[$highkey]);
                break;
        }


        if (!$lowkey_even && $highkey-1 != $lowkey ) {
            $new_range[] = $low-$subtract;
            
            for ($i = $lowkey+1; $i < $highkey; $i++) {
                $new_range[] = $range[$i]-$subtract;
                unset($range[$i]);
            }
            unset($range[$lowkey]);
            $range[] = $low-1;
            if ($highkey_even) {
                $new_range[] = $range[$highkey]-$subtract;
                $range[] = $range[$highkey]+1;
            }
            unset($range[$highkey]);
            break;
        }
        echo "<p>Possible fail....";
        break;
    }   
    
    sort($range);
    if(!even(count($range))) {
        echo "Fuck";
    }
    if(!even(count($new_range))) {
        echo "Fuck";
    }
    
    return [$range,$new_range];
}
$new_range =[];
foreach($maps as $map) {
    $nr = [];
    $new_range = [];
    foreach($$map as $key => $x_to_y) {
        list($range, $nr) = x_to_y($x_to_y,$range);
        $new_range = array_merge($nr,$new_range);
    }
    $range = array_merge($range,$new_range);
}
sort($range); 
$part2 = min($range);
echo "<p>The answer for part 2 is: $part2";
echo "<p>".microtime(true) - $start_time; 