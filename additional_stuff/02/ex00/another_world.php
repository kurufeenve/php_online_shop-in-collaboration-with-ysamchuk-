#!/usr/bin/php
<?php
if (isset($argv) && isset(argv[1]))
	print(trim(preg_replace('/\s+/', ' ', $argv[1]))."\n");
?>