<?php
echo "<h1>Advent Of Code 2023</h1>";

for( $iiiiiii = 2; $iiiiiii <= 9; $iiiiiii++ ) {
    echo "<h2>Day $iiiiiii</h2>";
    include "day$iiiiiii.php";
    $vars = array_keys(get_defined_vars());
    foreach($vars as $var) {
        if($var != 'iiiiiii') {
            unset(${"$var"});
        }
    }
}