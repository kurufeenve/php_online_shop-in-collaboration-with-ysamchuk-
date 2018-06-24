<?php
if ($_POST['login'] && $_POST['passwd'] && $_POST['submit'] === "OK")
{
	$account['login'] = $_POST['login'];
	$account['passwd'] = hash('whirlpool', $_POST['passwd']);
	if (!file_exists('../private/passwd'))
	{
		$accounts[] = $account;
		mkdir('../private');
		file_put_contents('../private/passwd', serialize($accounts));
		echo "OK\n";
	}
	else
	{
		$check_acc = unserialize(file_get_contents('../private/passwd'));
		foreach ($check_acc as $acc)
			if (array_search($account['login'], $acc) != FALSE)
			{
				echo "ERROR\n";
				exit();
			}
			else
			{
				$check_acc[] = $account;
				file_put_contents('../private/passwd', serialize($check_acc));
				echo "OK\n";
			}
	}
}
else
	echo "ERROR\n";
?>