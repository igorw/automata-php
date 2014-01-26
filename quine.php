<?php
$data = <<<'DATA'
$program = <<<PROGRAM
<?php
\$data = <<<'DATA'\n$data\nDATA;
$data

PROGRAM;
echo $program;
DATA;
$program = <<<PROGRAM
<?php
\$data = <<<'DATA'\n$data\nDATA;
$data

PROGRAM;
echo $program;
