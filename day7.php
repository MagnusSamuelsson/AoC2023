<?php
$start = microtime(true);
$input = array_map('trim',file('inputs/day7list.txt'));
$cards = [];
$bids = [];
foreach($input as $row) {
    list($cards[],$bids[]) = explode(' ',$row);
}
function card_score_joker($card) {
    $card = array_count_values($card);
    if(isset($card['J'])) {
        $jokers = $card['J'];
        $card['J'] = 0;
        $maxkey = array_search(max($card),$card);
        $card[$maxkey] += $jokers;
    }
    sort($card);
    $card = array_filter($card);
    sort($card);
    switch (count($card)) {
        case 1:
            //Five of a kind
            return 6;
        case 2:
            //Four of a kind
            if ($card[0] == 4 || $card[1] == 4) {
               return 5;
            }
             //Fullhouse
            if ($card[0] == 3 || $card[1] == 3) {
                return 4;
            }
            break;
        case 3:
            //Three of a kind
            if ($card[0] == 3 || $card[1] == 3 || $card[2] == 3) {
                return 3;
            }
             //Two pair
            if ($card[0] == 2 || $card[1] == 2 || $card[2] == 2) {
                return 2;
            }
            break;
        case 4:
            //One pair
            return 1;
        case 5:
            //high value
            return -1;
    }    
}

function card_score($card) {
    $card = array_count_values($card);
    sort($card);
    switch (count($card)) {
        case 1:
            //Five of a kind
            return 6;
        case 2:
            //Four of a kind
            if ($card[0] == 4 || $card[1] == 4) {
               return 5;
            }
             //Fullhouse
            if ($card[0] == 3 || $card[1] == 3) {
                return 4;
            }
            break;
        case 3:
            //Three of a kind
            if ($card[0] == 3 || $card[1] == 3 || $card[2] == 3) {
                return 3; 
            }
             //Two pair
            if ($card[0] == 2 || $card[1] == 2 || $card[2] == 2) {
                return 2;
            }
            break;
        case 4:
            //One pair
            return 1;
        case 5:
            //high value
            return -1; 
    }    
}
function convert_card_joker($card) {
    $card_strength = ['A', 'K', 'Q', 'T', '9', '8', '7', '6', '5', '4', '3', '2','J'];
    return array_search($card,$card_strength);
}
function convert_card($card) {
    $card_strength = ['A', 'K', 'Q', 'T', '9', '8', '7', '6', '5', '4', '3', '2','J'];
    return array_search($card,$card_strength);
}

function compare_cards($c1,$c2) {
    $score = 0;
    $card1 = str_split($c1);
    $card2 = str_split($c2);
    
    $score_card1 = card_score($card1);
    $score_card2 = card_score($card2);
    if ($score_card1 != $score_card2) {
        return ($score_card1 < $score_card2) ? -1 : 1;
    }
    
    $card1_values = array_map('convert_card',$card1);
    $card2_values = array_map('convert_card',$card2);
    
    for ($i = 0; $i < 5; $i++) {
        if ($card1_values[$i] != $card2_values[$i]) {
            return ($card1_values[$i] > $card2_values[$i]) ? -1 : 1;
        }
    }
    
}
function compare_cards_joker($c1,$c2) {
    $score = 0;
    $card1 = str_split($c1);
    $card2 = str_split($c2);

    $score_card1 = card_score_joker($card1);
    $score_card2 = card_score_joker($card2);
    if ($score_card1 != $score_card2) {
        return ($score_card1 < $score_card2) ? -1 : 1;
    }
    
    $card1_values = array_map('convert_card_joker',$card1);
    $card2_values = array_map('convert_card_joker',$card2);
    for ($i = 0; $i < 5; $i++) {
        if ($card1_values[$i] != $card2_values[$i]) {
            return ($card1_values[$i] > $card2_values[$i]) ? -1 : 1;
        }
    }
    
}

uasort($cards,'compare_cards');
$i = 1;
$sum = 0;
foreach($cards as $k => $card) {
    $sum += $i*$bids[$k];
    $i++;
}
echo "<p>The answer for part 1 is: $sum";
echo "<br>Time: ".microtime(true)-$start;



uasort($cards,'compare_cards_joker');
$i = 1;
$sum = 0;
foreach($cards as $k => $card) {
    $sum += $i*$bids[$k];
    $i++;
}
echo "<p>The answer for part 2 is: $sum";
echo "<br>Time: ".microtime(true)-$start;
