<?php
require_once __DIR__ . '/vendor/autoload.php';

use Goutte\Client;

try {
	$cli = new Client();
	$topUrl = 'サインインのURL';
	$top = $cli->request('GET', $topUrl);
	$loginForm = $top->filter('form')->form();
	$value = $loginForm->getValues();
	$value['user[email]'] = '#######';
	$value['user[password]'] = 'saibaiman';
	$method = $loginForm->getMethod();
	$url = $loginForm->getUri();
	$crawler = $cli->request($method, $url, $value);
	$cookies = $cli->getCookieJar()->all();
	sleep(2);

	$cli = new Client();
	$cli->getCookieJar()->updateFromSetCookie($cookies);
	$crawler = $cli->request('GET', 'https://jeek.jp/mypage');
	$text = $crawler->filter('a');
	if ($text->count() === 0) {
		echo 'empty';
	}
	$text->each(function($info) {
		echo $info->text() ."<br>";
	});
	sleep(2);
} catch(Exception $e) {
	echo "error;" . $e->getMessage();
}






