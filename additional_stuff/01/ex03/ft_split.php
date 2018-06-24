#!/usr/bin/php
<?php
function ft_split($str)
{
    $arr = array_diff(array_diff(explode(' ', $str), array("")), array(" "));
    sort($arr);
    return ($arr);
}
?>