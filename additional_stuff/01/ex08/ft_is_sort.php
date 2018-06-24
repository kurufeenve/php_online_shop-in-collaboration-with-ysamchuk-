#!/usr/bin/php
<?php
function ft_is_sort($arr)
{
	$buff = $arr;
	sort($buff);
	for($i = 0; $arr[$i]; $i++)
		if ($arr[$i] != $buff[$i])
			return (false);
	return (true);
}
?>