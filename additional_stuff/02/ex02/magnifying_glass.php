#!/usr/bin/php
<?php
$str = '<html>
<head><title>Nice page</title></head>
<body>
   Hello World
<a href=http://cyan.com title="un lien">
               Ceci est un lien
</a>
<br />
<a href=http://www.riven.com> Et ca aussi <img src=wrong.image title="et encore ca">
   <span>Et meme ca.<div title="pareil">Tout comme ca.</div></span>
</a>
</body>
</html>';
function arrtoupper($arr)
{
    print_r($arr);
    foreach ($arr as $val)
        $arr2[] = strtoupper($val);
    return ($arr2[0]);
}
preg_replace_callback('/<a[^>]+>[\s\S]+<\/a>/', 'arrtoupper', $str);
?>
<a.+>(\s|\S)+<\/a>