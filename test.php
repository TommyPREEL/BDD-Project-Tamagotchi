<?php
$stats_impact = [
    "hungry" => 30,
    "thirsty" => 10,
    "sleep" => 5,
    "boredom" => 5
];

$level = 5;

print_r($stats_impact);

$tab2 = [];
foreach($stats_impact as $stat => $value)
{
    $value += $level-1;
    $tab2[$stat] = $value;
}
print_r($stats_impact);
print_r($tab2);
