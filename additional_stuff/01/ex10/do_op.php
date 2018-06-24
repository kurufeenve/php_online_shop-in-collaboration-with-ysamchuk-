#!/usr/bin/php
<?php
if ($argc != 4)
{
	echo "Incorrect Parameters\n";
	exit ;
}
for ($i = 1; $argv[$i]; $i++)
{
	$arr2 = explode(' ', trim($argv[$i]));
	foreach ($arr2 as $val)
		$arr[] = $val;
}
if ($arr[1] == "do_op.php")
	$arr[1] = "*";
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