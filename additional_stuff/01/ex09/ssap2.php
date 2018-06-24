#!/usr/bin/php
<?php
function cmp($a, $b)
{
	$i = 0;
	while ($a[$i] && $b[$i])
	{
		$ca = ord($a[$i]);
		$cb = ord($b[$i]);
		if ($ca > 64 && $ca < 91)
			$ca -= 168;
		if ($ca > 96 && $ca < 123)
			$ca -= 200;
		if ($cb > 64 && $cb < 91)
			$cb -= 168;
		if ($cb > 96 && $cb < 123)
			$cb -= 200;
		if ($ca > 47 && $ca < 58)
			$ca -= 100;
		if ($cb > 47 && $cb < 58)
			$cb -= 100;
		if ($ca != $cb)
			return ($ca < $cb ? -1 : 1);
		$i++;
	}
	return (0);
}

for ($i = 1; $argv[$i]; $i++)
{
	$buf = explode(' ', $argv[$i]);
	foreach ($buf as $val)
		$arr[] = $val;
}
usort($arr, 'cmp');
print_r($arr);
?>