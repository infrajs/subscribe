<?php

$ans = array();
$ans['popup'] = true;
if (empty($_REQUEST['email'])) {
	$conf=infra_config();
	return infra_err($ans, $conf['subscribe']['msg']);
}
if (strlen($_REQUEST['email']) > 1000) {
	return infra_err($ans, 'Слишком много данных. '.$conf['subscribe']['msg']);
}
$email = strip_tags($_REQUEST['email']);
$email = trim($email);
$email = infra_forFS($email);
$agent = $_SERVER['HTTP_USER_AGENT'];
$ip = $_SERVER['REMOTE_ADDR'];

session_start();
if (empty($_SESSION['submit_time'])) $_SESSION['submit_time'] = 0;			
if (time() - $_SESSION['submit_time'] < 60) return infra_err($ans, 'Письмо уже отправлено! Новое сообщение можно будет отправить через 1 минуту!');
$_SESSION['submit_time'] = time();


$data=array('email' => $email, 'agent' => $agent, 'ip' => $ip, 'host' => $_SERVER['HTTP_HOST']);
$body = infra_template_parse('*order.tpl', $data);
infra_mail_toAdmin('Запрос '.$data['host'].' '.$email, 'noreplay@'.$data['host'], $body);

$dirs=infra_dirs();
$src=$dirs['data'].'.subscribe.json';
$subs=infra_loadJSON($src);
if(!$subs)$subs=array();
$subs[$email]=date('d.m.Y');
file_put_contents($src, infra_json_encode($subs));

return infra_ret($ans, 'Ваша заявка принята');
