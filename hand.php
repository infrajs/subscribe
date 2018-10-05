<?php
use infrajs\config\Config;
use infrajs\ans\Ans;
use infrajs\path\Path;
use infrajs\load\Load;
use infrajs\access\Access;
use infrajs\template\Template;
use infrajs\mail\Mail;
use akiyatkin\recaptcha\Recaptcha;


$ans = array();
$ans['popup'] = true;
$conf = Config::get('subscribe');

$r = Recaptcha::check();
if (!$r) return Ans::err($ans, 'Не пройдена защита Антибот');

if (empty($_REQUEST['emailphone'])) {
	return Ans::err($ans, $conf['msg']);
}
if (strlen($_REQUEST['emailphone']) > 1000) {
	return Ans::err($ans, 'Слишком много данных. '.$conf['msg']);
}
$email = strip_tags($_REQUEST['emailphone']);
$email = trim($email);
$email = Path::encode($email);
$agent = $_SERVER['HTTP_USER_AGENT'];
$ip = $_SERVER['REMOTE_ADDR'];

session_start();
if (empty($_SESSION['submit_time'])) $_SESSION['submit_time'] = 0;			
if (time() - $_SESSION['submit_time'] < 60) return Ans::err($ans, 'Письмо уже отправлено! Новое сообщение можно будет отправить через 1 минуту!');
$_SESSION['submit_time'] = time();


$data = array('email' => $email, 'agent' => $agent, 'ip' => $ip, 'host' => $_SERVER['HTTP_HOST']);
$data['date'] = date('d-m-Y', time());
$data['time'] = date('H:i:s', time());
$body = Template::parse('-subscribe/subscribe.mail.tpl', $data);
Mail::toAdmin('Запрос '.$data['host'].' '.$email, 'noreplay@'.$data['host'], $body);

$src = Path::resolve('~.subscribe.json');
$subs = Load::loadJSON($src);
if (!$subs) $subs=array();
$subs[$email]=date('d.m.Y');
file_put_contents($src, Load::json_encode($subs));

return Ans::ret($ans, 'Ваша заявка принята');
