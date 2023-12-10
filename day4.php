<?php
$start = microtime(true);
$input = array_map('trim',file('inputs/day4list.txt'));

function match_cards($scratchcards) {
    $cards = explode('|',$scratchcards);
    $matching_numbers = count(array_filter(array_intersect(explode(' ',$cards[0]),explode(' ',$cards[1]))));
    $points = 1;
    for ($i = 1; $i < $matching_numbers; $i++) {
        $points = $points+$points;
    }
    return ($matching_numbers > 0) ? $points : 0;
}

$game = array_map('match_cards',$input);
echo "<p>The answer for part 1 is: ".array_sum($game);
echo "<br>Time: ".microtime(true)-$start;

$card_multiplier = [];
function match_cards_v2($scratchcards) {
    global $card_multiplier;
    $cards = explode('|',$scratchcards);
    $gamenr = (int)preg_replace('/\D/', '', explode(':',$cards[0])[0]);
    if (isset($card_multiplier[$gamenr])) {
        $card_multiplier[$gamenr] += 1;
    } else {
        $card_multiplier[$gamenr] = 1;
    }
    $matching_numbers = count(array_filter(array_intersect(explode(' ',$cards[0]),explode(' ',$cards[1]))));
    
    for ($i = 1; $i < $matching_numbers+1; $i++) {
        if  (!isset($card_multiplier[$gamenr+$i])) {
            $card_multiplier[$gamenr+$i] = $card_multiplier[$gamenr];
            
        } else {
            $card_multiplier[$gamenr+$i] += $card_multiplier[$gamenr];
        }
    }
    return $scratchcards;
}

array_map('match_cards_v2',$input);
echo "<p>The answer for part 2 is: ".array_sum($card_multiplier);
echo "<br>Time: ".microtime(true)-$start;