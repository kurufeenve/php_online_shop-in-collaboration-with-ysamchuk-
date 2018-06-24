<?php
function install()
{
	if (!file_exists('data/data'))
	{
		$admin['login'] = 'root';
		$admin['passwd'] = hash('whirlpool', 'root');
		$users['root'] = $admin;
		$admin['login'] = 'adnim';
		$adm['passwd'] = hash('whirlpool', 'admin');
		$users['admin'] = $adm;
		$data['users'] = $users;
		$data['orders'] = array();
		$data['basket'] = array();
		$categories = array('all', '18+', 'for children');
		$data['categories'] = $categories;
		$good['url'] = 'https://sugarfactory.com/wp-content/uploads/2016/10/Rubber-Duck-Large-A.jpg';
		$good['price'] = 20.0;
		$cat = array('18+', 'for children');
		$good['categories'] = $cat;
		$goods['Duck'] = $good;
		$good['url'] = 'https://static.carrefour.com.br/medias/sys_master/images/images/h96/hb7/h00/h00/8952671010846.jpg';
		$good['price'] = 100.0;
		$cat = array('18+');
		$good['categories'] = $cat;
		$goods['My Little Pony'] = $good;
		$data['goods'] = $goods;
		mkdir('data');
		file_put_contents('data/data', serialize($data));
	}
}
?>