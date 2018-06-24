#!/usr/bin/php
<?php
if ($argc != 2)
{
	echo "Incorrect Parameters\n";
	exit ;
}
$arr = array_diff(array_diff(explode(' ', $argv[1]), array("")), array(" "));
if ($arr[1] == NULL)
{
    if (($pos = strpos($arr[0], '*')) != false)
    {
        $num1 = substr($arr[0], 0, -$pos);
        echo "$num1\n";
    }
}
print_r($arr);
switch (ord($arr[1][0]))
{
    case 42:
        $result = $arr[0] * $arr[2];
		break ;
	case 43:
        $result = $arr[0] + $arr[2];
		break ;
	case 45:
        $result = $arr[0] - $arr[2];
		break ;
	case 47:
        $result = $arr[0] / $arr[2];
		break ;
	case 37:
        $result = $arr[0] % $arr[2];
        break ;
}
echo "$result\n";
?>