#!/usr/bin/php
<?php
$arr = array_diff(array_diff(explode(' ', $argv[1]), array("")), array(" "));
for ($j = 1; $arr[$j]; $j++)
    echo $arr[$j]." ";
echo $arr[0]."\n";
?>