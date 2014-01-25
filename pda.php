<?php

$rules = [
    [0, '(',   '_', 0, ['_', 'x']],
    [0, '(',   'x', 0, ['x', 'x']],
    [0, ')',   'x', 0, []],
    [0, 'EOF', '_', 1, []],
];

$state = 0;
$accept_states = [1];
$init_stack = '_';

$input = '(((()))())';

$tokens = array_merge(
    str_split($input),
    ['EOF']
);

function match(array $rules, $state, $token, $top) {
    foreach ($rules as $rule) {
        list($init_state, $match_input, $match_stack, $new_state, $push_stack) = $rule;

        if ($state === $init_state
            && $token === $match_input
            && $top === $match_stack) {

            return $rule;
        }
    }

    $token = var_export($token, true);
    throw new \RuntimeException("No rule found for state $state, token $token");
}

$stack = new \SplStack();
$stack->push($init_stack);

foreach ($tokens as $token) {
    $top = $stack->pop();
    $rule = match($rules, $state, $token, $top);

    list($init_state, $match_input, $match_stack, $new_state, $push_stack) = $rule;

    $state = $new_state;
    foreach ($push_stack as $push_token) {
        $stack->push($push_token);
    }
}

if (!in_array($state, $accept_states)) {
    throw new \RuntimeException("Reached EOF but ended in state $state which is not an accept state.");
}

echo "The provided input has been accepted by accept state $state\n";
echo sprintf("Stack: %s\n", json_encode(iterator_to_array($stack)));
