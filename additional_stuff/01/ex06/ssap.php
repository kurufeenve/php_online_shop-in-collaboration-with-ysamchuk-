#!/usr/bin/php
<?php
for ($i = 1; $argv[$i]; $i++)
{
	$arr2 = explode(' ', $argv[$i]);
	foreach ($arr2 as $val)
		$arr[] = $val;
}
sort($arr);
foreach ($arr as $val)
	echo $val."\n";
?>