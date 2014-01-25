<?php

$rules = [
    0 => ['c' => 1, 'f' => 7, 'r' => 9],
    1 => ['l' => 2],
    2 => ['o' => 3],
    3 => ['s' => 4],
    4 => ['e' => 5],
    5 => ['s' => 6],
    6 => [' ' => 11],
    7 => ['i' => 8],
    8 => ['x' => 4],
    9 => ['e' => 10],
    10 => ['f' => 5],
    11 => ['#' => 12],
    12 => ['0' => 12, '1' => 12, '2' => 12,
           '3' => 12, '4' => 12, '5' => 12,
           '6' => 12, '7' => 12, '8' => 12,
           '9' => 12, 'EOF' => 13],
];

$state = 0;
$accept_states = [13];

$input = 'fixes #1234';

$tokens = array_merge(
    str_split($input),
    ['EOF']
);

foreach ($tokens as $token) {
    if (!isset($rules[$state][$token])) {
        $token = var_export($token, true);
        throw new \RuntimeException("No rule found for state $state, token $token");
    }

    $state = $rules[$state][$token];
}

if (!in_array($state, $accept_states)) {
    throw new \RuntimeException("Reached EOF but ended in state $state which is not an accept state.");
}

echo "The provided input has been accepted by accept state $state\n";
