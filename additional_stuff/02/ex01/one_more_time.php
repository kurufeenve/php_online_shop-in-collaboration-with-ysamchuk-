#!/usr/bin/php
<?php
if ($argc != 2)
	exit ;
if (!preg_match('/^[A-Z]?[a-z]{4,8} [1-31]{1,2} [A-Z]?[a-z]{2,9} [\d]{4} [\d]{2}:[\d]{2}:[\d]{2}/', $argv[1]))
{
	echo "Wrong Format\n";
	exit ;
}
date_default_timezone_set('Europe/Paris');
for ($i = 1; $argv[$i]; $i++)
{
	$arr2 = explode(' ', $argv[$i]);
	foreach ($arr2 as $val)
		$arr[] = $val;
}
$days = array("dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi");
$months = array("janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
if (array_search(strtolower($arr[0]), $days) && array_search(strtolower($arr[2]), $months) && $arr[3] >= 1970)
{
	foreach ($months as $key => $val)
		if (strcasecmp($arr[2], $val) == 0)
			$month = $key;
	$hms = explode(':', $arr[4]);
	echo mktime($hms[0], $hms[1], $hms[2], $month + 1, $arr[1], $arr[3])."\n";
}
else
	echo "Wrong Format\n";
?>