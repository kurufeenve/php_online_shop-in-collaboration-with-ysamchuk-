<?php
function auth($login, $passwd)
{
    $check_acc = unserialize(file_get_contents('../private/passwd'));
    foreach ($check_acc as $acc)
        if (array_search($login, $acc) != FALSE && array_search(hash('whirlpool', $passwd), $acc) != FALSE)
            return (TRUE);
        else
            return (FALSE);   
}
?>