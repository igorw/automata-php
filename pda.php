<?php

$rules = [
    0 => [
        '('   => ['e' => [0, ['e', 'x']],
                  'x' => [0, ['x', 'x']]],
        ')'   => ['x' => [0, []]],
        'EOF' => ['e' => [1, ['e']]],
    ],
];

$state = 0;
$accept_states = [1];
$init_stack = 'e';

$input = '(((()))())';

$tokens = array_merge(
    str_split($input),
    ['EOF']
);

$stack = new \SplStack();
$stack->push($init_stack);

foreach ($tokens as $token) {
    $top = $stack->pop();

    if (!isset($rules[$state][$token][$top])) {
        $token = var_export($token, true);
        $top = var_export($top, true);
        throw new \RuntimeException("No rule found for state $state, token $token, top $top");
    }

    list($state, $push_tokens) = $rules[$state][$token][$top];

    foreach ($push_tokens as $push_token) {
        $stack->push($push_token);
    }
}

if (!in_array($state, $accept_states)) {
    throw new \RuntimeException("Reached EOF but ended in state $state which is not an accept state.");
}

echo "The provided input has been accepted by accept state $state\n";
echo sprintf("Stack: %s\n", json_encode(iterator_to_array($stack)));
