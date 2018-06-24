<?php
function auth($login, $passwd)
{
	$data = unserialize(file_get_contents('../data/data'));
	$users = $data['users'];
	if (array_key_exists($login, $users) != FALSE)
		return (TRUE);
	else
		return (FALSE);
}
?>