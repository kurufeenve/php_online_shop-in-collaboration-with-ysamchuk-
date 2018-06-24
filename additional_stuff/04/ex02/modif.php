<?php
if ($_POST['login'] && $_POST['oldpw'] && $_POST['submit'] === "OK")
{
	if ($_POST['oldpw'] == $_POST['newpw'] || $_POST['newpw'] == NULL)
	{
		echo "ERROR\n";
		exit();
	}
	$check_acc = unserialize(file_get_contents('../private/passwd'));
	foreach ($check_acc as $key => $acc)
	{
		if (array_search($_POST['login'], $acc) != FALSE && array_search(hash('whirlpool', $_POST['oldpw']), $acc) != FALSE)
		{
			$acc[passwd] = hash('whirlpool', $_POST['newpw']);
			$check_acc[$key] = $acc;
			echo "OK\n";
		}
		else
		{
			echo "ERROR\n";
			exit();
		}
	}
	file_put_contents('../private/passwd', serialize($check_acc));
}
else
	echo "ERROR\n";
?>