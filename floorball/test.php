<?php

echo '<a href="pass.php?myNumber=1&myFruit=orange">Send variables via URL!</a>';
echo '<br />';

$a='Link1';
$b='Link2';

echo '<a href="pass.php?link=' . $a . '">Link 1</a>';
echo '<br />';

echo '<a href="pass.php?link=' . $b . '">Link 2</a>';
echo '<br />';

$userid = mt_rand(1000000,9999999);

function randNum($length)
{
    $str = mt_rand(1, 9); // first number (0 not allowed)
    for ($i = 1; $i < $length; $i++)
        $str .= mt_rand(0, 9);

    return $str;
}

echo randNum(15); echo "<br />";
$userid = randNum(14);
echo $userid . "\n";
?>
